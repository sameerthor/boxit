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
        <br/>
        <br/>

        <div class="row">
        <div class="form-group col-md-6">
         <label >Address</label>
         <p>{{$project->address}}</p>
        </div>
        <div class="form-group col-md-6">
        <label >Building Company</label>
         <p>{{$project->BookingData[0]->contact->title}}</p>
        </div>
        <div class="form-group col-md-6">
        <label >Floor Type</label>
         <p>{{$project->floor_type}}</p>
        </div>
        <div class="form-group col-md-6">
        <label >Floor Area</label>
         <p>{{$project->floor_area}}</p>
        </div>
        <div class="form-group col-md-6">
        <label >foreman</label>
         <p>{{$project->foreman->name}}</p>
        </div>
        <div class="form-group col-md-6">
        <label >Notes</label>
         <p>{{$project->notes}}</p>
        </div>
        @if(!empty($project->file))
        <div class="form-group col-md-6">
        <label >File</label>
        <br/>
        @foreach($project->file as $f)
         <a href="/images/{{$f}}"><embed style="width:200px;height:200px" src="/images/{{$f}}"></embed><a>
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
                </tr>
            </thead>
            <tbody>
                @foreach($project->BookingData->slice(1) as $res)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$res->department->title}}</td>
                    <td>{{$res->contact->title}}</td>
                    <td>{{$res->date}}</td>
                    <td>@if($res->status=='0')
                        <div class="orange_box">Pending</div>
                        @elseif($res->status=='1')
                        <div class="green_box">Confirmed</div>
                        @else
                        <div class="red_box">Cancelled</div>
                        @endif
                    </td>
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
<script>
   $(document).on("click","#back",function(){
        var id=$(this).data('id');
               $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
               jQuery.ajax({
                  url: "{{ url('/projects') }}",
                  method: 'get',
                  success: function(result){
                    var ele= $(result);
                    
                     jQuery('.container .main').html(ele.find(".container .main").html());
                  }});      })
</script>