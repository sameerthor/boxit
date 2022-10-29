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
                    <th>Booking Status</th>
                    <th>Project Status</th>
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
                        <a href="#" target="_blank" class="btn btn-sm btn-outline-warning"><i class="fa fa-camera"></i>Pending</a>
                        @elseif($res->status=='1')
                        <a href="#" target="_blank" class="btn btn-sm btn-outline-success"><i class="fa fa-camera"></i>Confirmed</a>
                        @else
                        <a href="#" target="_blank" class="btn btn-sm btn-outline-danger"><i class="fa fa-camera"></i>Cancelled</a>
                        @endif
                    </td>
                    <td>
                        @php 
                        $task_status='NA';
                        if(!empty($res->department->ProjectStatus))
                        {         
                                        $project_status= $res->department->ProjectStatus->ProjectStatus($project->id)->get();
                                        
                                        if(count($project_status)>0)
                                        {
                                        $task_status=$project_status[0]->status==1?'<a href="#" target="_blank" class="btn btn-sm btn-outline-success"><i class="fa fa-camera"></i>'.$res->department->ProjectStatus->label.'</a>':'<a href="#" target="_blank" class="btn btn-sm btn-outline-danger"><i class="fa fa-camera"></i>'.$res->department->ProjectStatus->label.'</a>';
                                        }
                                    }           
                        @endphp
                    @php echo $task_status; @endphp
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