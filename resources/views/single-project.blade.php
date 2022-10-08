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
         <a href="/images/{{$project->file}}"><img style="width:200px" src="/images/{{$project->file}}"><a>
        </div>
        @endif
      </div>
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
                    <td>
                        <a href="#" target="_blank" class="btn btn-sm btn-outline-info"><i class="fa fa-camera"></i>Pending</a>

                    </td>
                </tr>
                @endforeach
            </tbody>
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