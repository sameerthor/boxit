<style>
    input[type="range"] {
        width: 30px;
    }


    .screen-reader-only {
        position: absolute;
        top: -9999px;
        left: -9999px;
    }

    .qa_checklist table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    .qa_checklist td,
    th {
        border: 1px solid #c9ced6;
        text-align: left;
        padding: 8px;
    }

    .qa_checklist tr:nth-child(even) {
        background-color: #c9ced6;
    }

    .qa_checklist {
        margin: 20px 10px;
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
            <div class="col-md-12">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button style="color:#172b4d" class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1" aria-selected="true">Project Status</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button style="color:#172b4d" class="nav-link" data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2" aria-selected="true">Onsite & QA Checklist</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button style="color:#172b4d" class="nav-link" data-bs-toggle="tab" data-bs-target="#tab3" type="button" role="tab" aria-controls="tab3" aria-selected="true">Mark Out Checklist</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button style="color:#172b4d" class="nav-link" data-bs-toggle="tab" data-bs-target="#tab4" type="button" role="tab" aria-controls="tab4" aria-selected="true">Safety Plan
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div style="padding:5%" d class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="1-tab">
                        
                            <div class="row">
                                <div>
                                    <table class="table">

                                        <tbody>
                                         @foreach($ProjectStatusLabel as $label)
                                         @php
                                    $project_status= $label->ProjectStatus($project->id)->get();
                                    if(count($project_status)>0)
                                    {
                                        $yes_checked=$project_status[0]->status==1?'checked':'';
                                        $no_checked=$project_status[0]->status==0?'checked':'';;
                                    }else
                                    {
                                    $yes_checked="";
                                    $no_checked="";
                                    }
                                    @endphp
                                            <tr>
                                                <td>{{$label->label}}</td>
                                                <td>
                                                    <div id="file1" class="btn-group" data-toggle="buttons">
                                                        <label class="btn btn-success btn-sm"><input type="radio" {{$yes_checked}} class="project_status" data-id="{{$label->id}}" data-project="{{$project->id}}" name="status[{{$label->id}}]" value="1">Yes</label>
                                                        <label class="btn btn-danger btn-sm"><input type="radio" {{$no_checked}} class="project_status" data-id="{{$label->id}}" data-project="{{$project->id}}" name="status[{{$label->id}}]" value="0">No</label>
                                                    </div>
                                                </td>
                                            </tr>
                                         @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        
                    </div>
                <div style="padding:5%" d class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="2-tab">
                    <form action="{{URL('/qa_checklist')}}" method="post">
                        @csrf
                        <h5>Onsite & QA Checklist</h5>
                        <input type="hidden" name="project_id" value="{{$project->id}}">
                        <div class="qa_checklist">
                            <table style="width:100%">
                                @foreach($qaChecklist as $res)
                                <tr>
                                    <td>{{$res->subject}}</td>
                                    @php
                                    $project_qa= $res->ProjectQaChecklist($project->id)->get();
                                    if(count($project_qa)>0)
                                    {

                                    $initial=$project_qa[0]->initial;
                                    $office_use=$project_qa[0]->office_use;
                                    }else
                                    {
                                    $initial="";
                                    $office_use="";
                                    }
                                    @endphp
                                    <td style="width: 15% !important;"><input type="text" value="{{$initial}}" name="initial[{{$res->id}}]"></td>
                                    <td style="width: 15% !important; "><input type="text" value="{{$office_use}}" name="office_use[{{$res->id}}]"></td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        <div style="float:right"><button type="submit" class="btn btn-secondary">Save</button>

                    </form>
                </div>
            </div>
            <div style="padding:5%" d class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="3-tab">
                <form action="{{URL('/markout_checklist')}}" method="post">
                    @csrf
                    <h5>Mark Out Checklist</h5>
                    <input type="hidden" name="project_id" value="{{$project->id}}">
                    <div style="margin:5%">
                        <div class="row mb-3">
                            <label for="name" class="col-md-6 col-form-label "><strong>Date:</strong></label>
                            <div class="col-md-4">
                                <input  type="date" class="form-control" name="markout_data[date]" value="{{ $markout_checklist!=null ? $markout_checklist->date : '' }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-md-6 col-form-label "><strong>Address:</strong></label>
                            <div class="col-md-4">
                                <input  type="text" class="form-control" name="markout_data[address]" value="{{ $markout_checklist!=null ? $markout_checklist->address : '' }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-md-6 col-form-label "><strong>Housing Company:</strong></label>
                            <div class="col-md-4">
                                <input  type="text" class="form-control" name="markout_data[housing_company]" value="{{ $markout_checklist!=null ? $markout_checklist->housing_company : '' }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-md-6 col-form-label ">Power</label>
                            <div class="col-md-4">
                                <input  type="text" class="form-control" name="markout_data[power]" value="{{ $markout_checklist!=null ? $markout_checklist->power : '' }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-md-6 col-form-label ">Site fenced</label>
                            <div class="col-md-4">
                                <input  type="text" class="form-control" name="markout_data[site_fenced]" value="{{ $markout_checklist!=null ? $markout_checklist->site_fenced : '' }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-md-6 col-form-label ">Toilet</label>
                            <div class="col-md-4">
                                <input  type="text" class="form-control" name="markout_data[toilet]" value="{{ $markout_checklist!=null ? $markout_checklist->toilet : '' }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-md-6 col-form-label ">Water</label>
                            <div class="col-md-4">
                                <input  type="text" class="form-control" name="markout_data[water]" value="{{ $markout_checklist!=null ? $markout_checklist->water : '' }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-md-6 col-form-label ">Boundary Pegs all in Place</label>
                            <div class="col-md-4">
                                <input  type="text" class="form-control" name="markout_data[boundary_pegs]" value="{{ $markout_checklist!=null ? $markout_checklist->boundary_pegs : '' }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-10">
                                <textarea style="min-height: 150px;" name="markout_data[draw_in]" class="form-control" placeholder="Draw in here what’s missing">{{ $markout_checklist!=null ? $markout_checklist->draw_in : '' }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-md-6 col-form-label ">Boundary Dimensions Back Checked - are they Correct</label>
                            <div class="col-md-4">
                                <input  type="text" class="form-control" name="markout_data[boundary_dimension]" value="{{ $markout_checklist!=null ? $markout_checklist->boundary_dimension : '' }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-md-6 col-form-label ">FFL Set and Marked on Fence
                            </label>
                            <div class="col-md-4">
                                <input  type="text" class="form-control" name="markout_data[ffl_set]" value="{{ $markout_checklist!=null ? $markout_checklist->ffl_set : '' }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-md-6 col-form-label ">FFL Height out of Ground 
                            </label>
                            <div class="col-md-2">
                                <input  placeholder="min" type="number" class="form-control" name="markout_data[ffl_height_min]" value="{{ $markout_checklist!=null ? $markout_checklist->ffl_height_min : '' }}">
                            </div>
                            <div class="col-md-2">
                                <input  placeholder="max" type="number" class="form-control" name="markout_data[ffl_height_max]" value="{{ $markout_checklist!=null ? $markout_checklist->ffl_height_max : '' }}">
                            </div>
                        </div>
                    </div>
                    <div style="float:right"><button type="submit" class="btn btn-secondary">Save</button>

                </form>
            </div>
            </div>
            <div style="padding:5%" d class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="4-tab">
            <h5>Safety plan</h5>
            <br>
            <div class="row safety_plan">
            <p>This plan is to be completed with all workers prior to works beginning. All personnel must complete a site induction</p>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th colspan="2">Site / Address:</th>
                            <th colspan="2">Client:</th>
                        </tr>
                        <tr>
                            <th colspan="">Completed By:</th>
                            <th colspan="">Date:</th>
                            <th colspan="">Time In:</th>
                            <th colspan="">Time Out:</th>
                        </tr>
                    </tbody>
                </table>
            <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th colspan="6" style="text-align:center;background-color:#c9ced6;">EMERGENCY INFORMATION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <th rowspan="2" scope="rowgroup">Locations of
                            Emergency
                            Provisions:</th>
                            <th>First Aid Kit
                            </th>
                            <th>Extinguisher
                            </th>
                            <th>Evacuation Assembly Point
                            </th>
                        </tr>
                        <tr>
                            <td>
                                Site Vehicle
                            </td>
                            <td>
                                Site Vehicle
                            </td>
                            <td>
                                At Site Entrance
                            </td>
                        </tr>
                        <tr>
                        <th rowspan="2" scope="rowgroup">Key Emergency
                            Contacts:</th>
                            <td>
                                Emergency Response Dial: 111
                            </td>
                            <td>
                                Ch Hospital 03 364 0270
                            </td>
                            <td>
                                Andy Knight 027 702 1055
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Moorhouse Medical: 03 365 7900
                            </td>
                            <td>
                                24 Hr Medical: 03 365 7777
                            </td>
                            <td>
                                Hayden Vessey 027 672 1812
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th colspan="8" style="background-color:#c9ced6;">1.0 SITE SET UP / FACILITIES
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="col">#
                            </th>
                            <th>ITEM
                            </th>
                            <th>&#10004 / &#x2717
                            </th>
                            <th>
                                NOTES / ACTIONS
                            </th>
                        </tr>
                        <tr>
                           <td>1.1</td>
                            <td >
                                Is there safe access to the site? (clear / level / no overhead lines)
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                            
                        </tr>
                        <tr>
                            <td>1.2</td>
                            <td>
                                Have you read the site hazards board?
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                            
                        </tr>
                        <tr>
                            <td>1.3</td>
                            <td>
                                Do you have adequate PPE? Hi vis / steel caps
                            </td>
                            <td>
                                
                            </td>
                            <td>
                            </td>
                            
                        </tr>
                        <tr>
                            <td>1.4</td>
                            <td>
                                Have you completed the Client safety documentation on site?
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                            
                        </tr>
                        <tr>
                            <td>1.5</td>
                            <td>
                                Are there others on site we need to communicate with?
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                            
                        </tr>
                        <tr>
                            <td>1.6</td>
                            <td>
                                Is the site tidy and clear for you work activity?
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                           
                        </tr>
                        <tr>
                            <td>1.7</td>
                            <td>
                                Is the site secure, i.e. fenced / gate closed?
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                            
                        </tr>
                        <tr>
                            <td>1.8</td>
                            <td>
                                Are site hazards adequately controlled?
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                            
                        </tr>
                        <tr>
                            <td>1.9</td>
                            <td>
                                Do you have access to Power / Water / Toilet?
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                            
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th colspan="8" style="background-color:#c9ced6;">3.0 JOB SAFETY ANALYSIS AND HAZARD MANAGEMENT
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th  colspan="2" scope="colgroup">&#10004 JOB STEP
                            </th>
                            <th>RISK IDENTIFIED
                            </th>
                            <th>HAZARD CONTROL METHOD
                                E Eliminate / M - Minimise
                            </th>
                            <th>
                                &#10004
                            </th>
                        </tr>
                        <tr>
                           <td>1</td>
                            <td >
                                Foundation
Install / Strip
                            </td>
                            <td>
                                Power Tools
                            </td>
                            <td>
                                M Ensure all electrical is tagged and made safeM - Check guards are in place   
                            </td>
                            <td>
                            </td>
                            
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                            </td>
                            <td>
                                Noise
                            </td>
                            <td>
                                M Ear muffs to be worn  
                            </td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                            </td>
                            <td>
                                Dust
                            </td>
                            <td>
                                M Dust masks to be worn   
                            </td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                            </td>
                            <td>
                                Hit by Plant
                            </td>
                            <td>
                                M Hi Vis to be worn
                            </td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                            </td>
                            <td>
                                Poor Housekeeping
                            </td>
                            <td>
                                M Keep the site tidy, stack materials in designated areas 
                            </td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                            </td>
                            <td>
                                Exposed Steel
                            </td>
                            <td>
                                M Ensure exposed steel is identified / capped
                            </td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                            </td>
                            <td>
                                Loose Materials
                            </td>
                            <td>
                                M Ensure materials are secured
                            </td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                            </td>
                            <td>
                                Services
                            </td>
                            <td>
                                M Check for overhead and underground services
                            </td>
                            <td>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p>All personnel and visitors have been shown and advised of all of the hazards and controls identified.
                    All workers must be involved in completing this Site Safety Plan. All persons signed below fully
                    understand and acknowledge their requirements</p>
            
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="6" style="text-align:center;background-color:#c9ced6;">SIGN IN / INDUCTION</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">Date
                        </th>
                        <th>Name
                        </th>
                        <th>Signature
                        </th>
                    </tr>
                    <tr>
                        <td scope="row">
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row">
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row">
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row">
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row">
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
            </div>           
        </div>
    </div>
</div>

</div>

</div>
</div>
<script>
     $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    $(document).on("click", "#back", function() {
        var id = $(this).data('id');
       
        jQuery.ajax({
            url: "{{ url('/check-list') }}",
            method: 'get',
            success: function(result) {
                var ele = $(result);

                jQuery('.container .main').html(ele.find(".container .main").html());
            }
        });
    })
    $(".project_status").on("change",function(){
        var status=$(this).val();
        var status_label_id = $(this).data('id');
        var project_id = $(this).data('project');

        Swal.fire({
      title: "Do you want to change ?",
      icon: "warning",
      showCancelButton: true,
  confirmButtonText: 'Yes',
  confirmButtonColor: '#28a745',
  cancelButtonColor: '#dc3545',
  cancelButtonText: 'No',
      dangerMode: true,
    }).then(function(result) {
      if (result.isConfirmed) {
       
        jQuery.ajax({
            url: "{{ url('/change-project-status') }}",
            method: 'post',
            data:{
              project_id:project_id,
              status:status,
              status_label_id:status_label_id
            },
            success: function(result) {
                Toast.fire({
  icon: 'success',
  title: "Status changed successfuly."
})
            }
        });
      }
    })
    })
</script>