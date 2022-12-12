<style>
  .green_box {
    background: #F1FFE9;
    color: #16DB65 !important;
    text-align: center;
  }

  .orange_box {
    background: #FCF0E4;
    color: #F79256 !important;
    text-align: center;
  }

  .red_box {
    background: #FCEEEC;
    color: #FF5A5F;
    text-align: center;
  }
</style>
<div class="card-new">
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <div class="form-head">
          <span>Project</span>
        </div>
      </div>
    </div>
    <button style="float:right" type="button" id="back" class="save_button btn btn-secondary">Back</button>
    <br />
    <br />

    <div class="row">
      <div class="form-group col-md-6 l-font-s">
        <label>Address</label>
        <p>{{$project->address}}</p>
      </div>
      <div class="form-group col-md-6 l-font-s">
        <label>Building Company</label>
        <p>{{$project->BookingData[0]->contact->title}}</p>
      </div>
      <div class="form-group col-md-6 l-font-s">
        <label>Floor Type</label>
        <p>{{$project->floor_type}}</p>
      </div>
      <div class="form-group col-md-6 l-font-s">
        <label>Floor Area</label>
        <p>{{$project->floor_area}}</p>
      </div>
      <div class="form-group col-md-6 l-font-s">
        <label>Foreman</label>
        <p>{{ucfirst($project->foreman->name)}}</p>
      </div>
      <div class="form-group col-md-6 l-font-s">
        <label>Notes</label>
        <p>{{$project->notes}}</p>
      </div>
      @if(!empty($project->file))
      <div class="form-group col-md-12 l-font-s">
        <label>File</label>
        <br />
        @foreach($project->file as $f)
        <a href="/images/{{$f}}" target="_blank" style="padding:5px"><embed src="/images/{{$f}}"></embed></a>
        @endforeach
      </div>
      @endif
    </div>
    <h4>Booking Status</h4>
    <table class="table table-stripped">
      <thead>
        <tr>
          <th>#</th>
          <th>Department</th>
          <th>Contact</th>
          <th>Date</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($project->BookingData->slice(1) as $res)
        <tr>
          <td>{{$loop->iteration}}</td>
          <td>{{$res->department->title}}</td>
          <td>{{$res->contact->title}}</td>
          <td>{{date("d-m-Y h:i",strtotime($res->date))}}</td>
          <td>@if($res->status=='0')
            <div class="orange_box">Pending</div>
            @elseif($res->status=='1')
            <div class="green_box">Confirmed</div>
            @else
            <div class="red_box">Pending</div>
            @endif
          </td>
          <td><button type="button" data-id="{{$res->id}}" class="btn btn-sm change_date" style="background-color: #172b4d;color:#fff" data-id="1">Change date</button></td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <h4>Project Status</h4>
    <table class="table table-stripped">
      <thead>
        <tr>
          <th>#</th>
          <th>Title</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        @foreach($ProjectStatusLabel as $label)
        @php
        $project_status= $label->ProjectStatus($project->id)->get();
        if(count($project_status)>0)
        {
        $stat=$project_status[0]->status==1?'<div class="green_box">Yes</div>':'<div class="red_box">No</div>';
        }else
        {
        $stat='<div class="orange_box">Pending</div>';
        }
        @endphp
        <tr>
          <td>{{$loop->iteration}}</td>
          <td>{{$label->label}}</td>
          <td>
            @php echo $stat @endphp
          </td>
        </tr>
        @endforeach
    </table>
  </div>
</div>
<div class="container">

  <!-- Modal -->
  <div class="modal" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Revised Date</h4>
        </div>
        <div class="modal-body">

          <div id="deny_text">
            <p>Please suggest an alternate option below:</p>
            <div class="row flex-d">
              <input type="text" placeholder="date/time" class="example form-control col-md-5" name="date">
              <div class="col-md-1"></div>
              <div class="col-md-6"><input class="check-b-size" type="checkbox" name="confirm" value="1"> <label style="font-size: 10px;font-weight: bold;">Do not send a change request email</label></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm save_date" data-id="1">Save</button>
          <button type="button" class="btn btn-secondary btn-sm cancel">Cancel</button>
        </div>
      </div>

    </div>
  </div>

</div>
<script>
  $(function() {
    $.datetimepicker.setDateFormatter('moment');
    $('.example').datetimepicker({
      format: 'DD-MM-YYYY HH:mm'
    });
  });

  $(".change_date").click(function() {
    var id = $(this).data('id');
    $(".save_date").attr('data-id', id);
    $("#myModal").show();
  })

  $(".save_date").click(function() {
    var id = $(this).data('id');
    jQuery.ajax({
      type: 'POST',
      url: "/revised-date",
      data: {
        booking_data_id: id,
        date: $("input[name='date']").val(),
        confirm: $("input[name='confirm']").is(":checked")
      },
      success: function(data) {
        window.location.reload();
      }
    });
  });

  $(".cancel").click(function() {
    $("#myModal").hide();
  })
  $(document).on("click", "#back", function() {
    var id = $(this).data('id');
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    jQuery.ajax({
      url: "{{ url('/projects') }}",
      method: 'get',
      success: function(result) {
        var ele = $(result);

        jQuery('.container .main').html(ele.find(".container .main").html());
      }
    });
  })
</script>