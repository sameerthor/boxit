<style>
    @import "bourbon";
    .increment{
    padding: 2px 8px 2px 14px;
    border: 1px solid black;
    border-radius: 11px;
    margin: 3px 2px 3px 2px;

  }

    .cd-switch {
        padding: 50px 0;
        text-align: center;
    }

    .radio_label {
        cursor: pointer;
        text-transform: uppercase;
        border: 1px solid #3d4349;
        width: 80px;
        padding: 10px 0;
        text-align: center;
        display: inline-block;
        transition: all 0.4s;
        margin-right: 10px;
    }

    .switch {
        display: inline-block;
        z-index: 1;
    }

    .switch input[type="radio"] {
        visibility: hidden;
        position: absolute;
    }

    .switch input[type="radio"].yes:checked~label[for^="yes_"] {
        background-color: #172b4d;
        color: #fff
    }

    .switch input[type="radio"].no:checked~label[for^="no_"] {
        background-color: #172b4d;
        color: #fff
    }


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



    .qa_checklist {
        margin: 20px 10px;
    }

    .safety_plan input {
        border-left: none;
        border-right: none;
        border-top: none;
        border-bottom: 0.5px solid black;
        outline: none;
    }

    .marg-lr-none {
        margin: 20px 0px;
    }

    .bor-none td {
        border: none;
        text-align: center;
    }

    .canvas-size {
        height: 150px;
    }

    @media screen and (min-width:768px) {
        .table .paid-t {
            padding-top: 38px !important;
        }
    }

    .incident_form input {
        border-left: none;
        border-right: none;
        border-top: none;
        border-bottom: 0.5px solid black;
        outline: none;
    }

    .incident_form textarea {
        width: 100%;
        height: 100px;
    }

    .single-table {
        margin: 0;
        padding: 0;
    }
</style>
<div class="modal fade" role="dialog" id="reason_form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Council Inspection</h5>
                <button type="button" class="close" data-bs-dismiss="modal" onclick="window.location.reload()" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div style="display:none" id="modal_contact_id"></div>
                    <div class="form-group">
                        <label for="reason" class="col-form-label">Reason:</label>
                        <textarea placeholder="Please provide details about inspection failure here." class="form-control" id="reason"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" data-project="{{$project->id}}" id="submit_reason" class="btn btn-secondary">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="card-new">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-head">
                    <span>Project: <u>{{$project->address}}</u></span>
                </div>
            </div>
        </div>
        <div class="project-back-btn">

            <button type="button" id="back" class="save_button btn btn-secondary">Back</button>
        </div>

        <br />
        @if(!empty($project->file))
        <div class="form-group col-md-12 l-font-s">
        <label>Files</label> 
        <br />
        <div class="row">
        @foreach($project->file as $f)
        <div class="form-group increment col-md-6 bg-shadow">
          <label>{{$f}}</label>
          <div style="float: right;"><a href="/images/{{$f}}" target="_blank" style="color:black;position: absolute;right: 10px;top: 4px;"><i class="fa fa-external-link fa-lg" aria-hidden="true"></i></a></div>
  
            </div>
        @endforeach
        </div>
      </div>
      @endif
        <br />
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs center-contain" id="myTab" role="tablist">
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
                    <li class="nav-item" role="presentation">
                        <button style="color:#172b4d" class="nav-link" data-bs-toggle="tab" data-bs-target="#tab5" type="button" role="tab" aria-controls="tab5" aria-selected="true">Startup Checklist
                    </li>
                    <li class="nav-item" role="presentation">
                        <button style="color:#172b4d" class="nav-link" data-bs-toggle="tab" data-bs-target="#tab6" type="button" role="tab" aria-controls="tab6" aria-selected="true">Boxing
                    </li>
                    <li class="nav-item" role="presentation">
                        <button style="color:#172b4d" class="nav-link" data-bs-toggle="tab" data-bs-target="#tab7" type="button" role="tab" aria-controls="tab7" aria-selected="true">Stripping
                    </li>
                    <li class="nav-item" role="presentation">
                        <button style="color:#172b4d" class="nav-link" data-bs-toggle="tab" data-bs-target="#tab8" type="button" role="tab" aria-controls="tab8" aria-selected="true">PODS & Steel
                    </li>
                    <li class="nav-item" role="presentation">
                        <button style="color:#172b4d" class="nav-link" data-bs-toggle="tab" data-bs-target="#tab9" type="button" role="tab" aria-controls="tab9" aria-selected="true">Accident/Incident Investigation
                    </li>

                </ul>
                <div class="tab-content" id="myTabContent">
                    <div style="padding:2%" d class="tab-pane fade show active paid-l-none" id="tab1" role="tabpanel" aria-labelledby="1-tab">

                        <div class="row">

                            <table class="table">

                                <tbody>
                                    @foreach($ProjectStatusLabel as $label)
                                    @if($label->department_id != '5' && $label->department_id != '6' && $label->department_id != '7')
                                    @php
                                    $project_status= $label->ProjectStatus($project->id)->get();
                                    if(count($project_status)>0)
                                    {
                                    $yes_checked=$project_status[0]->status==1?'checked':'';
                                    $no_checked=$project_status[0]->status==0?'checked':'';
                                    }else
                                    {
                                    $yes_checked="";
                                    $no_checked="";
                                    }
                                    @endphp
                                    <tr>
                                        <td>{{$label->label}}</td>
                                        <td>
                                            <div class="switch">
                                                <input type="radio" {{$yes_checked}} class="project_status yes" id="yes_{{$label->id}}" data-id="{{$label->id}}" data-project="{{$project->id}}" name="status[{{$label->id}}]" value="1">
                                                <label class="radio_label" for="yes_{{$label->id}}">{{$label->id=="10"?"Passed":"Yes"}}</label>
                                                <input type="radio" {{$no_checked}} id="no_{{$label->id}}" class="project_status no" data-id="{{$label->id}}" data-project="{{$project->id}}" name="status[{{$label->id}}]" value="0">
                                                <label class="radio_label" for="no_{{$label->id}}">{{$label->id=="10" || $label->id=="9" ? $label->id=="10"?"Failed":"NA":"No"}}</label>
                                                @if(count($project_status)>0)
                                                {!!$project_status[0]->reason!=''?'<a href="#" data-toggle="tooltip" title="'.$project_status[0]->reason.'"><i class="fa fa-eye"></i></a>':''!!}
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>

                            </table>

                        </div>

                    </div>
                    <div style="padding:15px;" d class="tab-pane fade paid-l-none" id="tab2" role="tabpanel" aria-labelledby="2-tab">
                        <form action="{{URL('/qa_checklist')}}" method="post" id="qa_form">
                            @csrf
                            <h5>Onsite & QA Checklist</h5>
                            <input type="hidden" name="project_id" value="{{$project->id}}">
                            <div class="qa_checklist marg-lr-none">
                                <!-- <div class="row onsite_label">
                                   <div class="col-md-6"></div>
                                   <div class="col-md-3">Initial</div>
                                   <div class="col-md-3">Office Use</div> 
                                </div> -->
                                <table style="width:100%">
                                    <tr class="bor-none">
                                        <td></td>
                                        <td>Initial</td>
                                        <td>Office Use</td>


                                    </tr>
                                    <tr>
                                        <td>Date:</td>
                                        @php $project_qa=$qaChecklist[0]->ProjectQaChecklist($project->id)->get(); @endphp
                                        <td class="table-w"><input type="date" value="{{count($project_qa)>0?$project_qa[0]->initial:''}}" name="initial[1]"></td>
                                        <td class="table-w"><input type="date" value="{{count($project_qa)>0?$project_qa[0]->office_use:''}}" name="office_use[1]"></td>
                                    </tr>
                                    <tr>
                                        <td>Address:</td>
                                        <td class="table-w"><input type="text" readonly value="{{$project->address}}" name="initial[2]"></td>
                                        <td class="table-w"><input type="text" readonly value="{{$project->address}}" name="office_use[2]"></td>
                                    </tr>
                                    <tr>
                                        <td>Housing Company:</td>
                                        <td class="table-w"><input type="text" readonly value="{{$project->BookingData[0]->contact->title}}" name="initial[3]"></td>
                                        <td class="table-w"><input type="text" readonly value="{{$project->BookingData[0]->contact->title}}" name="office_use[3]"></td>
                                    </tr>
                                    @foreach($qaChecklist->slice(3) as $res)
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
                                        <td class="table-w"><input type="text" value="{{$initial}}" name="initial[{{$res->id}}]"></td>
                                        <td class="table-w"><input type="text" value="{{$office_use}}" name="office_use[{{$res->id}}]"></td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                            @if(!empty($project->qasign->foreman_sign))
                            <img src="{{$project->qasign->foreman_sign}}" id="m_sign" width="200">
                            @else
                            <canvas id="onsite_canvas" class="canvas-size" style="border: 1px solid black;"></canvas>
                            <button type="button" data-id="onsite_signature" class="btn btn-sm clear" style="color:#fff;background-color:#172b4d">Clear</button>
                            @endif
                            <div style="float:right"><button type="submit" class="btn btn-secondary">Save</button></div>
                        </form>
                    </div>
                    <div style="padding:2%" d class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="3-tab">
                        <form action="{{URL('/markout_checklist')}}" method="post" id="markout_form">
                            @csrf
                            <h5>Mark Out Checklist</h5>
                            <input type="hidden" name="project_id" value="{{$project->id}}">
                            <div class="moc-form">
                                <div class="row mb-3">
                                    <label for="name" class="col-md-6 col-form-label "><strong>Date:</strong></label>
                                    <div class="col-md-4">
                                        <input type="date" class="form-control" name="markout_data[date]" value="{{ $markout_checklist!=null ? $markout_checklist->date : '' }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="name" class="col-md-6 col-form-label "><strong>Address:</strong></label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="markout_data[address]" value="{{ $markout_checklist!=null ? $markout_checklist->address : '' }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="name" class="col-md-6 col-form-label "><strong>Housing Company:</strong></label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="markout_data[housing_company]" value="{{ $markout_checklist!=null ? $markout_checklist->housing_company : '' }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="name" class="col-md-6 col-form-label ">Power</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="markout_data[power]" value="{{ $markout_checklist!=null ? $markout_checklist->power : '' }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="name" class="col-md-6 col-form-label ">Site fenced</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="markout_data[site_fenced]" value="{{ $markout_checklist!=null ? $markout_checklist->site_fenced : '' }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="name" class="col-md-6 col-form-label ">Toilet</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="markout_data[toilet]" value="{{ $markout_checklist!=null ? $markout_checklist->toilet : '' }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="name" class="col-md-6 col-form-label ">Water</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="markout_data[water]" value="{{ $markout_checklist!=null ? $markout_checklist->water : '' }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="name" class="col-md-6 col-form-label ">Boundary Pegs all in Place (Mark On Site Plan)</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="markout_data[boundary_pegs]" value="{{ $markout_checklist!=null ? $markout_checklist->boundary_pegs : '' }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="name" class="col-md-6 col-form-label ">Boundary Dimensions Back Checked - are they Correct (Mark On Site Plan)</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="markout_data[boundary_dimension]" value="{{ $markout_checklist!=null ? $markout_checklist->boundary_dimension : '' }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="name" class="col-md-6 col-form-label ">FFL Set and Marked on Fence
                                    </label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="markout_data[ffl_set]" value="{{ $markout_checklist!=null ? $markout_checklist->ffl_set : '' }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="name" class="col-md-6 col-form-label ">FFL Height out of Ground (Mark On Site Plan)
                                    </label>
                                    <div class="col-md-2">
                                        <input placeholder="min" type="number" class="form-control" name="markout_data[ffl_height_min]" value="{{ $markout_checklist!=null ? $markout_checklist->ffl_height_min : '' }}">
                                    </div>
                                    <div class="col-md-2">
                                        <input placeholder="max" type="number" class="form-control" name="markout_data[ffl_height_max]" value="{{ $markout_checklist!=null ? $markout_checklist->ffl_height_max : '' }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="name" class="col-md-6 col-form-label ">Markout Past Building Line
                                    </label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="markout_data[past_building_line]" value="{{ $markout_checklist!=null ? $markout_checklist->past_building_line : '' }}">
                                    </div>
                                </div>
                            </div>

                            @if(!empty($markout_checklist->foreman_sign))
                            <img src="{{$markout_checklist->foreman_sign}}" id="markout_sign" width="200">
                            @else
                            <canvas id="markout_canvas" style="border: 1px solid black;"></canvas>
                            <button type="button" data-id="markout_signature" class="btn btn-sm clear" style="color:#fff;background-color:#172b4d">Clear</button>
                            @endif
                            <div style="float:right"><button type="submit" class="btn btn-secondary">Save</button></div>
                        </form>
                    </div>
                    <div style="padding:3%" d class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="4-tab">
                        <h5>Safety plan</h5>
                        <br>
                        <form action="{{URL('/safety-plan')}}" id="safety_form" method="post">
                            @csrf
                            <input type="hidden" name="project_id" value="{{$project->id}}">
                            <div class="row safety_plan">
                                <p>This plan is to be completed with all workers prior to works beginning. All personnel must complete a site induction</p>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th colspan="2">Site / Address: {{$project->address}}</th>
                                            <th colspan="2">Client: <input type="text" style="width:70%" name="safety_plan[client]" value="{{ $safety!=null ? $safety->client : '' }}"></th>
                                        </tr>
                                        <tr>
                                            <th style="width:25%">Completed By: Jimmy</th>
                                            <th style="width:35%">Date: <input type="date" style="width:70%" name="safety_plan[date]" value="{{ $safety!=null ? $safety->date : '' }}"></th>
                                            <th style="width:20%">Time In: <input type="text" style="width:40%" name="safety_plan[time_in]" value="{{ $safety!=null ? $safety->time_in : '' }}"></th>
                                            <th style="width:20%">Time Out: <input type="text" style="width:40%" name="safety_plan[time_out]" value="{{ $safety!=null ? $safety->time_out : '' }}"></th>
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
                                                Emergency Response Dial: <br>111
                                            </td>
                                            <td>
                                                Ch Hospital:<br> 03 364 0270
                                            </td>
                                            <td>
                                                Andy Knight:<br> 027 702 1055
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Moorhouse Medical:<br> 03 365 7900
                                            </td>
                                            <td>
                                                24 Hr Medical:<br> 03 365 7777
                                            </td>
                                            <td>
                                                Hayden Vessey:<br> 027 672 1812
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
                                            <th scope="col" style="width: 10%">#
                                            </th>
                                            <th style="width: 50%">ITEM
                                            </th>
                                            <th style="width: 10%">&#10004/&#x2717
                                            </th>
                                            <th style="width: 30%">
                                                NOTES / ACTIONS
                                            </th>
                                        </tr>
                                        <tr>
                                            <td>1.1</td>
                                            <td>
                                                Is there safe access to the site? (clear / level / no overhead lines)
                                            </td>
                                            <td class="paid-t">
                                                <input type="radio" <?php if (!empty($safety)) {
                                                                        if ($safety->safe_access_tick == '1') {
                                                                            echo "checked";
                                                                        }
                                                                    }  ?> value="1" name="safety_plan[safe_access_tick]"><label>&#10004</label>
                                                <input class="marg-l" type="radio" <?php if (!empty($safety)) {
                                                                                        if ($safety->safe_access_tick == '0') {
                                                                                            echo "checked";
                                                                                        }
                                                                                    }  ?> value="0" name="safety_plan[safe_access_tick]"><label>&#x2717</label>
                                            </td>
                                            <td>
                                                <textarea name="safety_plan[safe_access]">{{ $safety!=null ? $safety->safe_access : '' }}</textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>1.2</td>
                                            <td>
                                                Have you read the site hazards board?
                                            </td>
                                            <td class="paid-t">
                                                <input type="radio" value="1" <?php if (!empty($safety)) {
                                                                                    if ($safety->site_board_tick == '1') {
                                                                                        echo "checked";
                                                                                    }
                                                                                }  ?> name="safety_plan[site_board_tick]"><label>&#10004</label>
                                                <input class="marg-l" type="radio" value="0" <?php if (!empty($safety)) {
                                                                                                    if ($safety->site_board_tick == '0') {
                                                                                                        echo "checked";
                                                                                                    }
                                                                                                }  ?> name="safety_plan[site_board_tick]"><label>&#x2717</label>
                                            </td>
                                            <td>
                                                <textarea name="safety_plan[site_board]">{{ $safety!=null ? $safety->site_board : '' }}</textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>1.3</td>
                                            <td>
                                                Do you have adequate PPE? Hi vis / steel caps
                                            </td>
                                            <td class="paid-t">
                                                <input type="radio" value="1" <?php if (!empty($safety)) {
                                                                                    if ($safety->ppe_tick == '1') {
                                                                                        echo "checked";
                                                                                    }
                                                                                }  ?> name="safety_plan[ppe_tick]"><label>&#10004</label>
                                                <input class="marg-l" type="radio" value="0" <?php if (!empty($safety)) {
                                                                                                    if ($safety->ppe_tick == '0') {
                                                                                                        echo "checked";
                                                                                                    }
                                                                                                }  ?> name="safety_plan[ppe_tick]"><label>&#x2717</label>
                                            </td>
                                            <td>
                                                <textarea name="safety_plan[ppe]">{{ $safety!=null ? $safety->ppe : '' }}</textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>1.4</td>
                                            <td>
                                                Have you completed the Client safety documentation on site?
                                            </td>
                                            <td class="paid-t">
                                                <input type="radio" value="1" <?php if (!empty($safety)) {
                                                                                    if ($safety->safety_documentation_tick == '1') {
                                                                                        echo "checked";
                                                                                    }
                                                                                }  ?> name="safety_plan[safety_documentation_tick]"><label>&#10004</label>
                                                <input class="marg-l" type="radio" value="0" <?php if (!empty($safety)) {
                                                                                                    if ($safety->safety_documentation_tick == '0') {
                                                                                                        echo "checked";
                                                                                                    }
                                                                                                }  ?> name="safety_plan[safety_documentation_tick]"><label>&#x2717</label>
                                            </td>
                                            <td>
                                                <textarea name="safety_plan[safety_documentation]">{{ $safety!=null ? $safety->safety_documentation : '' }}</textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>1.5</td>
                                            <td>
                                                Are there others on site we need to communicate with?
                                            </td>
                                            <td class="paid-t">
                                                <input type="radio" value="1" <?php if (!empty($safety)) {
                                                                                    if ($safety->communicate_tick == '1') {
                                                                                        echo "checked";
                                                                                    }
                                                                                }  ?> name="safety_plan[communicate_tick]"><label>&#10004</label>
                                                <input class="marg-l" type="radio" value="0" <?php if (!empty($safety)) {
                                                                                                    if ($safety->communicate_tick == '0') {
                                                                                                        echo "checked";
                                                                                                    }
                                                                                                }  ?> name="safety_plan[communicate_tick]"><label>&#x2717</label>
                                            </td>
                                            <td>
                                                <textarea name="safety_plan[communicate]">{{ $safety!=null ? $safety->communicate : '' }}</textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>1.6</td>
                                            <td>
                                                Is the site tidy and clear for you work activity?
                                            </td>
                                            <td class="paid-t">
                                                <input type="radio" value="1" <?php if (!empty($safety)) {
                                                                                    if ($safety->work_activity_tick == '1') {
                                                                                        echo "checked";
                                                                                    }
                                                                                }  ?> name="safety_plan[work_activity_tick]"><label>&#10004</label>
                                                <input class="marg-l" type="radio" value="0" <?php if (!empty($safety)) {
                                                                                                    if ($safety->work_activity_tick == '0') {
                                                                                                        echo "checked";
                                                                                                    }
                                                                                                }  ?> name="safety_plan[work_activity_tick]"><label>&#x2717</label>
                                            </td>
                                            <td>
                                                <textarea name="safety_plan[work_activity]">{{ $safety!=null ? $safety->work_activity : '' }}</textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>1.7</td>
                                            <td>
                                                Is the site secure, i.e. fenced / gate closed?
                                            </td>
                                            <td class="paid-t">
                                                <input type="radio" value="1" <?php if (!empty($safety)) {
                                                                                    if ($safety->gate_closed_tick == '1') {
                                                                                        echo "checked";
                                                                                    }
                                                                                }  ?> name="safety_plan[gate_closed_tick]"><label>&#10004</label>
                                                <input class="marg-l" type="radio" value="0" <?php if (!empty($safety)) {
                                                                                                    if ($safety->gate_closed_tick == '0') {
                                                                                                        echo "checked";
                                                                                                    }
                                                                                                }  ?> name="safety_plan[gate_closed_tick]"><label>&#x2717</label>
                                            </td>
                                            <td>
                                                <textarea name="safety_plan[gate_closed]">{{ $safety!=null ? $safety->gate_closed : '' }}</textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>1.8</td>
                                            <td>
                                                Are site hazards adequately controlled?
                                            </td>
                                            <td class="paid-t">
                                                <input type="radio" value="1" <?php if (!empty($safety)) {
                                                                                    if ($safety->hazard_controlled_tick == '1') {
                                                                                        echo "checked";
                                                                                    }
                                                                                }  ?> name="safety_plan[hazard_controlled_tick]"><label>&#10004</label>
                                                <input class="marg-l" type="radio" value="0" <?php if (!empty($safety)) {
                                                                                                    if ($safety->hazard_controlled_tick == '0') {
                                                                                                        echo "checked";
                                                                                                    }
                                                                                                }  ?> name="safety_plan[hazard_controlled_tick]"><label>&#x2717</label>
                                            </td>
                                            <td>
                                                <textarea name="safety_plan[hazard_controlled]">{{ $safety!=null ? $safety->hazard_controlled : '' }}</textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>1.9</td>
                                            <td>
                                                Do you have access to Power / Water / Toilet?
                                            </td>
                                            <td class="paid-t">
                                                <input type="radio" value="1" <?php if (!empty($safety)) {
                                                                                    if ($safety->power_access_tick == '1') {
                                                                                        echo "checked";
                                                                                    }
                                                                                }  ?> name="safety_plan[power_access_tick]"><label>&#10004</label>
                                                <input class="marg-l" type="radio" value="0" <?php if (!empty($safety)) {
                                                                                                    if ($safety->power_access_tick == '0') {
                                                                                                        echo "checked";
                                                                                                    }
                                                                                                }  ?> name="safety_plan[power_access_tick]"><label>&#x2717</label>
                                            </td>
                                            <td>
                                                <textarea name="safety_plan[power_access]">{{ $safety!=null ? $safety->power_access : '' }}</textarea>
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
                                            <th colspan="2" scope="colgroup">&#10004 JOB STEP
                                            </th>
                                            <th>RISK IDENTIFIED
                                            </th>
                                            <th>HAZARD CONTROL METHOD<br>
                                                E Eliminate / M - Minimise
                                            </th>
                                            <th>
                                                &#10004
                                            </th>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>
                                                Foundation
                                                Install / Strip
                                            </td>
                                            <td>
                                                Power Tools
                                            </td>
                                            <td>
                                                M Ensure all electrical is tagged and made safe
                                                <br>
                                                M - Check guards are in place
                                            </td>
                                            <td>
                                                <input type="checkbox" value="1" <?php if (!empty($safety)) {
                                                                                        if ($safety->foundation == '1') {
                                                                                            echo "checked";
                                                                                        }
                                                                                    }  ?> name="safety_plan[foundation]">
                                                                                    <br>
                                                 <input type="checkbox" value="1" <?php if (!empty($safety)) {
                                                                                        if ($safety->foundation_guard == '1') {
                                                                                            echo "checked";
                                                                                        }
                                                                                    }  ?> name="safety_plan[foundation_guard]">                                   
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
                                                <input type="checkbox" value="1" <?php if (!empty($safety)) {
                                                                                        if ($safety->noise == '1') {
                                                                                            echo "checked";
                                                                                        }
                                                                                    }  ?> name="safety_plan[noise]">
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
                                                <input type="checkbox" value="1" name="safety_plan[dust]" <?php if (!empty($safety)) {
                                                                                                                if ($safety->dust == '1') {
                                                                                                                    echo "checked";
                                                                                                                }
                                                                                                            }  ?>>
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
                                                <input type="checkbox" value="1" name="safety_plan[hit_plant]" <?php if (!empty($safety)) {
                                                                                                                    if ($safety->hit_plant == '1') {
                                                                                                                        echo "checked";
                                                                                                                    }
                                                                                                                }  ?>>
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
                                                <input type="checkbox" value="1" name="safety_plan[poor_housekeeping]" <?php if (!empty($safety)) {
                                                                                                                            if ($safety->poor_housekeeping == '1') {
                                                                                                                                echo "checked";
                                                                                                                            }
                                                                                                                        }  ?>>
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
                                                <input type="checkbox" value="1" name="safety_plan[exposed_steel]" <?php if (!empty($safety)) {
                                                                                                                        if ($safety->exposed_steel == '1') {
                                                                                                                            echo "checked";
                                                                                                                        }
                                                                                                                    }  ?>>
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
                                                <input type="checkbox" value="1" name="safety_plan[loose_material]" <?php if (!empty($safety)) {
                                                                                                                        if ($safety->loose_material == '1') {
                                                                                                                            echo "checked";
                                                                                                                        }
                                                                                                                    }  ?>>
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
                                                <input type="checkbox" value="1" name="safety_plan[services]" <?php if (!empty($safety)) {
                                                                                                                    if ($safety->services == '1') {
                                                                                                                        echo "checked";
                                                                                                                    }
                                                                                                                }  ?>>
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
                                    <tbody id="induction_body">
                                        <tr>
                                            <th scope="row">Date
                                            </th>
                                            <th>Name
                                            </th>
                                            <th>Signature
                                            </th>
                                        </tr>
                                        @if(!empty($safety->induction_date))
                                        @for($key=1;$key<=count($safety->induction_date);$key++)
                                            <tr>
                                                <td scope="row">
                                                    <input type="date" readonly value="{{ $safety!=null ? $safety->induction_date['date'.$key] : '' }}" name="safety_plan[induction_date][date{{$key}}]">
                                                </td>
                                                <td>
                                                    <input type="text" readonly value="{{ $safety!=null ? $safety->induction_name['name'.$key] : '' }}" name="safety_plan[induction_name][name{{$key}}]">
                                                </td>
                                                <td>
                                                    @if(!empty($safety->sign['sign'.$key]))
                                                    <img src="{{$safety->sign['sign'.$key]}}" id="induction_sign{{$key}}" width="200">
                                                    @else
                                                    <canvas id="induction_canvas{{$key}}" style="border: 1px solid black;"></canvas>
                                                    <button type="button" data-id="indunction_signaturePad{{$key}}" class="btn btn-sm clear" style="color:#fff;background-color:#172b4d">Clear</button>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endfor
                                            @endif
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-10"></div>
                                    <div class="col-md-2"><button type="button" onclick="addsignaturepad();" class="btn" style="color:#fff;background-color:#172b4d">Add Signaturepad</button></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8"></div>
                                    <div class="col-md-3" style="display: none;">
                                        @if(!empty($safety->foreman_sign))
                                        <img src="{{$safety->foreman_sign}}" id="safetyplan_sign" width="200">
                                        @else
                                        <canvas id="safetyplan_canvas" style="border: 1px solid black;"></canvas>
                                        <button type="button" data-id="safetyplan_signature" class="btn btn-sm clear" style="color:#fff;background-color:#172b4d">Clear</button>
                                        @endif
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                                <div style="float:right"><button type="submit" class="btn btn-secondary">Save</button></div>
                            </div>
                        </form>
                    </div>
                    <div style="padding:3%" d="" class="tab-pane fade" id="tab5" role="tabpanel" aria-labelledby="5-tab">
                        <form action="{{URL('/startup_checklist')}}" method="post" id="startup_form">
                            @csrf
                            <h5>Startup Checklist</h5>
                            <input type="hidden" name="project_id" value="{{$project->id}}">
                            <div style="margin:5%">
                                <div class="row mb-3">
                                    <label for="name" class="col-md-6 col-form-label ">Height of floor:</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="startup_data[height_floor]" value="{{ $startup_data!=null ? $startup_data->height_floor : '' }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="name" class="col-md-6 col-form-label ">Bracket spacing:</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="startup_data[bracket_spacing]" value="{{ $startup_data!=null ? $startup_data->bracket_spacing : '' }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="name" class="col-md-6 col-form-label ">Mesh size</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="startup_data[mesh_size]" value="{{ $startup_data!=null ? $startup_data->mesh_size : '' }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="name" class="col-md-6 col-form-label ">Main beam detail</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="startup_data[main_beam]" value="{{ $startup_data!=null ? $startup_data->main_beam : '' }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="name" class="col-md-6 col-form-label ">Rib detail</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="startup_data[rib_detail]" value="{{ $startup_data!=null ? $startup_data->rib_detail : '' }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="name" class="col-md-6 col-form-label ">Columns</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="startup_data[columns]" value="{{ $startup_data!=null ? $startup_data->columns : '' }}">
                                    </div>
                                </div>

                            </div>

                            <div style="float:right"><button type="submit" class="btn btn-secondary">Save</button></div>


                        </form>
                    </div>
                    <div style="padding:3%" d="" class="tab-pane fade" id="tab6" role="tabpanel" aria-labelledby="6-tab">
                        <form action="{{URL('/boxing')}}" method="post" id="boxing_form">
                            @csrf
                            <h5>Boxing</h5>
                            <input type="hidden" name="project_id" value="{{$project->id}}">
                            <div class="qa_checklist marg-lr-none">
                                <!-- <div class="row onsite_label"><div class="col-md-6"></div><div class="col-md-3">Initial</div><div class="col-md-3">Office Use</div></div> -->
                                <table style="width:100%">
                                    <tbody>
                                        <tr>
                                            <td rowspan="2">FFL Nail & Sand Checked to plan</td>
                                            <td class="">
                                                Done by <input type="text" class="form-control" value="{{ $boxing_data!=null ? $boxing_data->nail_doneby : '' }}" name="boxing[nail_doneby]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="">
                                                Supervisor <input type="text" class="form-control" value="{{ $boxing_data!=null ? $boxing_data->nail_supervisor : '' }}" name="boxing[nail_supervisor]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2">Profiles Hit In and Set 50mm Above FFL</td>
                                            <td class="">
                                                Done by <input type="text" class="form-control" value="{{ $boxing_data!=null ? $boxing_data->profiles_doneby : '' }}" name="boxing[profiles_doneby]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="">
                                                Supervisor <input type="text" class="form-control" value="{{ $boxing_data!=null ? $boxing_data->profiles_supervisor : '' }}" name="boxing[profiles_supervisor]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Boxing Cut including Backcuts</td>
                                            <td class="">
                                                Done by <input type="text" class="form-control" value="{{ $boxing_data!=null ? $boxing_data->cut_doneby : '' }}" name="boxing[cut_doneby]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2">Boxing Screwed Together</td>
                                            <td class="">
                                                Done by <input type="text" class="form-control" value="{{ $boxing_data!=null ? $boxing_data->screwed_doneby1 : '' }}" name="boxing[screwed_doneby1]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="">
                                                Done By <input type="text" class="form-control" value="{{ $boxing_data!=null ? $boxing_data->screwed_doneby2 : '' }}" name="boxing[screwed_doneby2]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2">Boxing Measurements Checked Including Backcuts in Place</td>
                                            <td class="">
                                                Done by <input type="text" class="form-control" value="{{ $boxing_data!=null ? $boxing_data->measure_doneby : '' }}" name="boxing[measure_doneby]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="">
                                                Supervisor <input type="text" class="form-control" value="{{ $boxing_data!=null ? $boxing_data->measure_supervisor : '' }}" name="boxing[measure_supervisor]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2">String Lines including Checking Boundary Setbacks and Marking Plan</td>
                                            <td class="">
                                                Done by <input type="text" class="form-control" value="{{ $boxing_data!=null ? $boxing_data->lines_doneby : '' }}" name="boxing[lines_doneby]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="">
                                                Supervisor <input type="text" class="form-control" value="{{ $boxing_data!=null ? $boxing_data->lines_supervisor : '' }}" name="boxing[lines_supervisor]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2">Pinned to Lines Correct Positions</td>
                                            <td class="">
                                                Done by <input type="text" class="form-control" value="{{ $boxing_data!=null ? $boxing_data->pinned_doneby : '' }}" name="boxing[pinned_doneby]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="">
                                                Supervisor <input type="text" class="form-control" value="{{ $boxing_data!=null ? $boxing_data->pinned_supervisor : '' }}" name="boxing[pinned_supervisor]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2">Lift to Height - Height Recorded</td>
                                            <td class="">
                                                Done by <input type="text" class="form-control" value="{{ $boxing_data!=null ? $boxing_data->lift_doneby : '' }}" name="boxing[lift_doneby]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="">
                                                Supervisor <input type="text" class="form-control" value="{{ $boxing_data!=null ? $boxing_data->lift_supervisor : '' }}" name="boxing[lift_supervisor]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2">Braced Straight including Checking Position Back to Lines</td>
                                            <td class="">
                                                Done by <input type="text" class="form-control" value="{{ $boxing_data!=null ? $boxing_data->braced_doneby : '' }}" name="boxing[braced_doneby]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="">
                                                Supervisor <input type="text" class="form-control" value="{{ $boxing_data!=null ? $boxing_data->braced_supervisor : '' }}" name="boxing[braced_supervisor]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Yellow Caps On</td>
                                            <td class="">
                                                Done by <input type="text" class="form-control" value="{{ $boxing_data!=null ? $boxing_data->yellow_doneby : '' }}" name="boxing[yellow_doneby]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2">Kick Stand</td>
                                            <td class="">
                                                Done by <input type="text" class="form-control" value="{{ $boxing_data!=null ? $boxing_data->kick_supervisor : '' }}" name="boxing[kick_supervisor]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="">
                                                Supervisor <input type="text" class="form-control" value="{{ $boxing_data!=null ? $boxing_data->kick_doneby : '' }}" name="boxing[kick_doneby]">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div style="float:right"><button type="submit" class="btn btn-secondary">Save</button></div>
                        </form>
                    </div>
                    <div style="padding:3%;" d class="tab-pane fade" id="tab7" role="tabpanel" aria-labelledby="7-tab">
                        <form action="{{URL('/stripping')}}" method="post" id="stripping">
                            @csrf
                            <h5>Stripping</h5>
                            <input type="hidden" name="project_id" value="{{$project->id}}">
                            <div class="qa_checklist marg-lr-none">
                                <table style="width:100%">
                                    <tr class="bor-none">
                                        <td></td>
                                        <td>Done By</td>
                                    </tr>
                                    <tr>
                                        <td>Pod Rubbish removed</td>
                                        <td class="table-w"><input type="text" class="form-control" value="{{ $stripping_data!=null ? $stripping_data->pod_rubbished : '' }}" name="stripping_data[pod_rubbished]"></td>
                                    </tr>
                                    <tr>
                                        <td>Boxing Scraped</td>
                                        <td class="table-w"><input type="text" class="form-control" value="{{ $stripping_data!=null ? $stripping_data->boxing_scraped : '' }}" name="stripping_data[boxing_scraped]"></td>
                                    </tr>
                                    <tr>
                                        <td>Boxing Tied On</td>
                                        <td class="table-w"><input type="text" class="form-control" value="{{ $stripping_data!=null ? $stripping_data->boxing_tied : '' }}" name="stripping_data[boxing_tied]"></td>
                                    </tr>
                                    <tr>
                                        <td>Trailer loaded</td>
                                        <td class="table-w"><input type="text" class="form-control" value="{{ $stripping_data!=null ? $stripping_data->trailer_loaded : '' }}" name="stripping_data[trailer_loaded]"></td>
                                    </tr>
                                    <tr>
                                        <td>Site Gate shut</td>
                                        <td class="table-w"><input type="text" class="form-control" value="{{ $stripping_data!=null ? $stripping_data->gate_shut : '' }}" name="stripping_data[gate_shut]"></td>
                                    </tr>
                                    <tr>
                                        <td>Site tidy and photos taken</td>
                                        <td class="table-w"><input type="text" class="form-control" value="{{ $stripping_data!=null ? $stripping_data->photos_taken : '' }}" name="stripping_data[photos_taken]"></td>
                                    </tr>
                                </table>
                            </div>

                            <div style="float:right"><button type="submit" class="btn btn-secondary">Save</button></div>
                        </form>
                    </div>
                    <div style="padding:3%;" d class="tab-pane fade" id="tab8" role="tabpanel" aria-labelledby="8-tab">
                        <form action="{{URL('/pods-steel')}}" method="post" id="pods_steel">
                            @csrf
                            <h5>PODS & Steel</h5>
                            <input type="hidden" name="project_id" value="{{$project->id}}">
                            <div class="qa_checklist marg-lr-none">
                                <table style="width:100%">
                                    <tr class="bor-none">
                                        <td></td>
                                        <td>Done By</td>
                                        <td>Done By</td>
                                        <td>Checked By</td>
                                    </tr>
                                    @foreach($pods_steel_label as $label)
                                    @php $l_value= $label->PodsSteelValue($project->id)->get(); @endphp
                                    <tr>
                                        <td>{{$label->label}}</td>
                                        <td class="table-w"><input type="text" class="form-control" value="{{count($l_value) > 0 ? $l_value[0]->done_by1 : ''}}" name="done_by1[{{$label->id}}]"></td>
                                        <td class="table-w"><input type="text" class="form-control" value="{{count($l_value) > 0 ? $l_value[0]->done_by2 : ''}}" name="done_by2[{{$label->id}}]"></td>
                                        <td class="table-w"><input type="text" class="form-control" value="{{count($l_value) > 0 ? $l_value[0]->checked_by : ''}}" name="checked_by[{{$label->id}}]"></td>

                                    </tr>
                                    @endforeach
                                </table>
                            </div>

                            <div style="float:right"><button type="submit" class="btn btn-secondary">Save</button></div>
                        </form>
                    </div>
                    <div style="padding:3%;" d class="tab-pane fade" id="tab9" role="tabpanel" aria-labelledby="9-tab">
                        <form action="{{URL('/accident-investigation')}}" method="post">
                            @csrf
                            <h5>Accident/Incident Investigation</h5>
                            <input type="hidden" name="project_id" value="{{$project->id}}">
                            <div class="row incident_form">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th colspan="2" style="background-color:#c9ced6;">PROJECT/SITE: {{$project->address}}</th>
                                        </tr>
                                        <tr style="height: 30px;">
                                            <th style="width:55%;background-color:#c9ced6;">FOREMAN/SUPERVISOR: {{$project->foreman->name}}</th>
                                            <th style="width:45%;background-color:#c9ced6;">Date: <input type="date" style="width:70%;background-color: #c9ced6;" value="{{ $incident_data!=null ? $incident_data->date : '' }}" name="incident_data[date]" value=""></th>
                                        </tr>
                                        <tr style="height: 130px;">
                                            <th colspan="2">Attendees Names<textarea  name="incident_data[attendees]">{{ $incident_data!=null ? $incident_data->attendees : '' }}</textarea></th>
                                        </tr>
                                        <tr style="height: 70px;">
                                            <th style="width:60%;">Actions to follow up from last week:</th>
                                            <th style="width:40%;">Action Required Who / When</th>
                                        </tr>
                                        <tr style="height: 70px;">
                                            <th style="width:60%;">Site Inspection:</th>
                                            <th style="width:40%;"><textarea  name="incident_data[site_inspection]">{{ $incident_data!=null ? $incident_data->site_inspection : '' }}</textarea></th>
                                        </tr>
                                        <tr style="height: 70px;">
                                            <th style="width:60%;">Upcoming Work:</th>
                                            <th style="width:40%;"><textarea  name="incident_data[upcoming_work]">{{ $incident_data!=null ? $incident_data->upcoming_work : '' }}</textarea></th>
                                        </tr>
                                        <tr style="height: 70px;">
                                            <th style="width:60%;">Incidents / Near Misses / Injury Events:</th>
                                            <th style="width:40%;"><textarea  name="incident_data[incidents]">{{ $incident_data!=null ? $incident_data->incidents : '' }}</textarea></th>
                                        </tr>
                                        <tr style="height: 70px;">
                                            <th style="width:60%;">Equipment Maintenance / Issues</th>
                                            <th style="width:40%;"><textarea  name="incident_data[equipment_issues]">{{ $incident_data!=null ? $incident_data->equipment_issues : '' }}</textarea></th>
                                        </tr>
                                        <tr style="height: 70px;">
                                            <th style="width:60%;">Employee issues raised:</th>
                                            <th style="width:40%;"><textarea  name="incident_data[employee_issues]">{{ $incident_data!=null ? $incident_data->employee_issues : '' }}</textarea></th>
                                        </tr>
                                        <tr style="height: 70px;">
                                            <th style="width:60%;">Safe observations reviewed/discussed</th>
                                            <th style="width:40%;"><textarea  name="incident_data[safe_reviewed]">{{ $incident_data!=null ? $incident_data->safe_reviewed : '' }}</textarea></th>
                                        </tr>
                                        <tr style="height: 70px;">
                                            <th style="width:60%;">Task Analysis completed/reviewed:</th>
                                            <th style="width:40%;"><textarea  name="incident_data[task_reviewed]">{{ $incident_data!=null ? $incident_data->task_reviewed : '' }}</textarea></th>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-bordered single-table">
                                    <tbody>

                                        <tr>
                                            <th colspan="8" style="background-color:#c9ced6;">PARTICULARS OF ACCIDENT
                                            </th>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%">Date of accident <input type="date" name="incident_data[date_accident]" value="{{ $incident_data!=null ? $incident_data->date_accident : '' }}"></td>
                                            <td style="width: 10%">Time <input type="text" name="incident_data[time]" value="{{ $incident_data!=null ? $incident_data->time : '' }}"></td>
                                            <td style="width: 30%">Location <input type="text" name="incident_data[location]" value="{{ $incident_data!=null ? $incident_data->location : '' }}"></td>
                                            <td style="width: 20%">Date reported <input type="date" name="incident_data[date_reported]" value="{{ $incident_data!=null ? $incident_data->date_reported : '' }}"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-bordered single-table">
                                    <tbody>
                                        <tr>
                                            <th colspan="8" style="background-color:#c9ced6;">THE INJURED PERSON
                                            </th>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Name <input type="text" name="incident_data[name]" value="{{ $incident_data!=null ? $incident_data->name : '' }}"></td>
                                            <td rowspan="2" colspan="2">Address <input type="text" name="incident_data[address]" value="{{ $incident_data!=null ? $incident_data->address : '' }}"></td>
                                        </tr>
                                        <tr>
                                            <td width="12%">Age <input type="number" name="incident_data[age]" value="{{ $incident_data!=null ? $incident_data->age : '' }}"></td>
                                            <td width="28%">Phone number <input type="number" name="incident_data[phone_number]" value="{{ $incident_data!=null ? $incident_data->phone_number : '' }}"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-bordered single-table">
                                    <tbody>
                                        <tr>
                                            <td width="">TYPE OF INJURY:</td>
                                            <td width=""><input name="incident_data[bruiding_checkbox]" <?php if($incident_data!=null){if($incident_data->bruiding_checkbox=='yes'){echo "checked";}} ?> value="yes" type="checkbox"> Bruising</td>
                                            <td width=""><input name="incident_data[disclotion_checkbox]" <?php if($incident_data!=null){if($incident_data->disclotion_checkbox=='yes'){echo "checked";}} ?> value="yes" type="checkbox"> Dislocation</td>
                                            <td width=""><input name="incident_data[other_checkbox]" <?php if($incident_data!=null){if($incident_data->other_checkbox=='yes'){echo "checked";}} ?> value="yes" type="checkbox"> Other (specify)</td>
                                            <td width="" rowspan="2">Injured part of body<textarea name="incident_data[injured_part]">{{ $incident_data!=null ? $incident_data->injured_part : '' }}</textarea></td>
                                        </tr>
                                        <tr>
                                            <td width=""><input name="incident_data[strain_checkbox]" <?php if($incident_data!=null){if($incident_data->strain_checkbox=='yes'){echo "checked";}} ?> value="yes" type="checkbox"> Strain/sprain</td>
                                            <td width=""><input name="incident_data[scratch_checkbox]" <?php if($incident_data!=null){if($incident_data->scratch_checkbox=='yes'){echo "checked";}} ?> value="yes" type="checkbox"> Scratch/abrasion</td>
                                            <td width=""><input name="incident_data[internal_checkbox]" <?php if($incident_data!=null){if($incident_data->internal_checkbox=='yes'){echo "checked";}} ?> value="yes" type="checkbox"> Internal</td>
                                            <td width=""></td>
                                        </tr>
                                        <tr>
                                            <td width=""><input name="incident_data[fracture_checkbox]" <?php if($incident_data!=null){if($incident_data->fracture_checkbox=='yes'){echo "checked";}} ?> value="yes" type="checkbox"> Fracture</td>
                                            <td width=""><input name="incident_data[amputation_checkbox]" <?php if($incident_data!=null){if($incident_data->amputation_checkbox=='yes'){echo "checked";}} ?> value="yes" type="checkbox"> Amputation</td>
                                            <td width=""><input name="incident_data[foreign_checkbox]" <?php if($incident_data!=null){if($incident_data->foreign_checkbox=='yes'){echo "checked";}} ?> value="yes" type="checkbox"> Foreign body</td>
                                            <td width="" rowspan="2" colspan="2">Remarks<textarea name="incident_data[remarks]">{{ $incident_data!=null ? $incident_data->remarks : '' }}</textarea></td>
                                        </tr>
                                        <tr>
                                            <td width=""><input name="incident_data[cut_checkbox]" <?php if($incident_data!=null){if($incident_data->cut_checkbox=='yes'){echo "checked";}} ?> value="yes" type="checkbox"> Laceration/cut</td>
                                            <td width=""><input name="incident_data[burn_checkbox]" <?php if($incident_data!=null){if($incident_data->burn_checkbox=='yes'){echo "checked";}} ?> value="yes" type="checkbox"> Burn scald</td>
                                            <td width=""><input name="incident_data[chemical_checkbox]" <?php if($incident_data!=null){if($incident_data->chemical_checkbox=='yes'){echo "checked";}} ?> value="yes" type="checkbox"> Chemical reaction</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-bordered single-table">
                                    <tbody>
                                        <tr>
                                            <th colspan="8" style="background-color:#c9ced6;">DAMAGED PROPERTY
                                            </th>
                                        </tr>
                                        <tr>
                                            <td colspan="8">Property/ material damaged<textarea  name="incident_data[property_damaged]">{{ $incident_data!=null ? $incident_data->property_damaged : '' }}</textarea></td>
                                        </tr>
                                        <tr>
                                            <th colspan="8" style="background-color:#c9ced6;">THE ACCIDENT
                                            </th>
                                        </tr>
                                        <tr>
                                            <td colspan="8">Description - Describe what happened (space overleaf for diagram □ essential for all vehicle accidents)<textarea  name="incident_data[desciption]">{{ $incident_data!=null ? $incident_data->desciption : '' }}</textarea></td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">Analysis - What were the causes of the accident?<textarea  name="incident_data[analysis]">{{ $incident_data!=null ? $incident_data->analysis : '' }}</textarea></td>
                                        </tr>
                                        <tr>
                                            <td width="50%">HOW BAD COULD IT HAVE BEEN?
                                                <br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" <?php if($incident_data!=null){if($incident_data->bad_radio=="1"){echo 'checked';}}?> name="incident_data[bad_radio]" id="inlineRadio1" value="1">
                                                    <label class="form-check-label">Very</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" <?php if($incident_data!=null){if($incident_data->bad_radio=="2"){echo 'checked';}}?> name="incident_data[bad_radio]" id="inlineRadio2" value="2">
                                                    <label class="form-check-label">Serious</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" <?php if($incident_data!=null){if($incident_data->bad_radio=="3"){echo 'checked';}}?> name="incident_data[bad_radio]" id="inlineRadio3" value="3">
                                                    <label class="form-check-label">Minor Serious</label>
                                                </div>
                                            </td>
                                            <td width="50%">WHAT IS THE CHANCE OF IT HAPPENING AGAIN?
                                                <br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" <?php if($incident_data!=null){if($incident_data->chance_radio=="1"){echo 'checked';}}?> name="incident_data[chance_radio]" id="inlineRadio1" value="1">
                                                    <label class="form-check-label">Minor</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" <?php if($incident_data!=null){if($incident_data->chance_radio=="2"){echo 'checked';}}?> name="incident_data[chance_radio]" id="inlineRadio2" value="2">
                                                    <label class="form-check-label">Occasional</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" <?php if($incident_data!=null){if($incident_data->chance_radio=="3"){echo 'checked';}}?> name="incident_data[chance_radio]" id="inlineRadio3" value="3">
                                                    <label class="form-check-label">Rare</label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-bordered single-table">
                                    <tbody>

                                        <tr>
                                            <th colspan="8">Prevention
                                            </th>
                                        </tr>
                                        <tr>
                                            <td style="width: 60%">What action has or will be taken to prevent a recurrence?</td>
                                            <td></td>
                                            <td style="width: 20%">By whom</td>
                                            <td style="width: 20%">When</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 60%"><textarea name="incident_data[action_1]">{{ $incident_data!=null ? $incident_data->action_1 : '' }}</textarea></td>
                                            <td></td>
                                            <td style="width: 20%"><input name="incident_data[whom_1]" value="{{ $incident_data!=null ? $incident_data->whom_1 : '' }}" type="text"></td>
                                            <td style="width: 20%"><input name="incident_data[when_1]" value="{{ $incident_data!=null ? $incident_data->when_1 : '' }}" type="date"></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 60%"><textarea name="incident_data[action_2]">{{ $incident_data!=null ? $incident_data->action_2 : '' }}</textarea></td>
                                            <td></td>
                                            <td style="width: 20%"><input name="incident_data[whom_2]" value="{{ $incident_data!=null ? $incident_data->whom_2 : '' }}" type="text"></td>
                                            <td style="width: 20%"><input name="incident_data[when_2]" value="{{ $incident_data!=null ? $incident_data->when_2 : '' }}" type="date"></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 60%"><textarea name="incident_data[action_3]">{{ $incident_data!=null ? $incident_data->action_3 : '' }}</textarea></td>
                                            <td></td>
                                            <td style="width: 20%"><input name="incident_data[whom_3]" value="{{ $incident_data!=null ? $incident_data->whom_3 : '' }}" type="text"></td>
                                            <td style="width: 20%"><input name="incident_data[when_3]" value="{{ $incident_data!=null ? $incident_data->when_3 : '' }}" type="date"></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 60%"><textarea name="incident_data[action_4]">{{ $incident_data!=null ? $incident_data->action_4 : '' }}</textarea></td>
                                            <td></td>
                                            <td style="width: 20%"><input name="incident_data[whom_4]" value="{{ $incident_data!=null ? $incident_data->whom_4 : '' }}" type="text"></td>
                                            <td style="width: 20%"><input name="incident_data[when_4]" value="{{ $incident_data!=null ? $incident_data->when_4 : '' }}" type="date"></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 60%"><textarea name="incident_data[action_5]">{{ $incident_data!=null ? $incident_data->action_5 : '' }}</textarea></td>
                                            <td></td>
                                            <td style="width: 20%"><input name="incident_data[whom_5]" value="{{ $incident_data!=null ? $incident_data->whom_5 : '' }}" type="text"></td>
                                            <td style="width: 20%"><input name="incident_data[when_5]" value="{{ $incident_data!=null ? $incident_data->when_5 : '' }}" type="date"></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 60%">Use space overleaf if required</td>
                                            <td></td>
                                            <td style="width: 20%"></td>
                                            <td style="width: 20%"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-bordered single-table">
                                    <tbody>

                                        <tr>
                                            <th colspan="8" style="background-color:#c9ced6;">TREATMENT AND INVESTIGATION OF ACCIDENT
                                            </th>
                                        </tr>
                                        <tr>
                                            <td>Type of treatment given <input type="text" name="incident_data[treatment_type]" value="{{ $incident_data!=null ? $incident_data->treatment_type : '' }}"></td>
                                            <td>Name of person giving first aid <input type="text" name="incident_data[person_name]" value="{{ $incident_data!=null ? $incident_data->person_name : '' }}"></td>
                                            <td>Doctor/Hospital <input type="text" name="incident_data[doctor]" value="{{ $incident_data!=null ? $incident_data->doctor : '' }}"></td>
                                        </tr>
                                        <tr>
                                            <td>Accident investigated by <input type="text" name="incident_data[investigated_by]" value="{{ $incident_data!=null ? $incident_data->investigated_by : '' }}"></td>
                                            <td>WorkSafe NZ advised YES / NO <input type="text" name="incident_data[worksafe]" value="{{ $incident_data!=null ? $incident_data->worksafe : '' }}"></td>
                                            <td>Date <input type="date" name="incident_data[treatment_date]" value="{{ $incident_data!=null ? $incident_data->treatment_date : '' }}"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3" style="float:right"><button type="submit" class="btn btn-secondary">Save</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

</div>
</div>
<style>
    .tooltip-inner {
        color: #172B4D;
        background-color: #ffffff;
        border: 1px solid #172B4D;
    }
</style>
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var i = "<?php if (!empty($safety->induction_date)) {
                    echo count($safety->induction_date) + 1;
                } else {
                    echo 1;
                } ?>";

    function addsignaturepad() {
        var html = '<tr><td scope="row"><input type="date" required value="" name="safety_plan[induction_date][date' + i + ']"></td><td><input type="text" required value="" name="safety_plan[induction_name][name' + i + ']"></td><td><canvas id="induction_canvas' + i + '" style="border: 1px solid black;"></canvas><button type="button" data-id="indunction_signaturePad' + i + '" class="btn btn-sm clear" style="color:#fff;background-color:#172b4d">Clear</button></td></tr>';
        $("#induction_body").append(html);
        window["indunction_signaturePad" + i] = new SignaturePad($("#induction_canvas" + i + "")[0]);
        console.log(indunction_signaturePad1);
        i++;
    }
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
    $(".project_status").on("change", function() {
        var status = $(this).val();
        var status_label_id = $(this).data('id');
        var project_id = $(this).data('project');

        if (!(status_label_id == 10 && status == 0)) {
            Swal.fire({
                title: "Are you sure you want to change the status?",
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
                        data: {
                            project_id: project_id,
                            status: status,
                            status_label_id: status_label_id
                        },
                        success: function(result) {
                            Toast.fire({
                                icon: 'success',
                                title: "Status changed successfuly."
                            }).then(function(result) {
                                window.location.reload();
                            });
                        }
                    });
                }else
                {
                    var id = "<?php echo $project->id; ?>";

    jQuery.ajax({
      url: "{{ url('/foreman-single-project') }}",
      method: 'post',
      data: {
        id: id,
      },
      success: function(result) {
        jQuery('.main').html(result);
      }});
                }
            })
        } else {

            $("#reason_form").modal('show');
        }
    })

    $("#submit_reason").click(function() {
        var project_id = $(this).data('project');
        var reason = $("#reason").val();

        jQuery.ajax({
            url: "{{ url('/change-project-status') }}",
            method: 'post',
            data: {
                project_id: project_id,
                status: 0,
                status_label_id: 10,
                reason: reason
            },
            success: function(result) {
                Toast.fire({
                    icon: 'success',
                    title: "Status changed successfuly."
                }).then(function(result) {
                    window.location.reload();
                });
            }
        });
    });

    if ($('#markout_canvas').length) {
        var markout_signature = new SignaturePad($("#markout_canvas")[0]);
    }

    if ($('#onsite_canvas').length) {
        var onsite_signature = new SignaturePad($("#onsite_canvas")[0]);
    }
    if ($('#safetyplan_canvas').length) {
        var safetyplan_signature = new SignaturePad($("#safetyplan_canvas")[0]);
    }

    $(document).on('click', '.clear', function() {
        var id = $(this).data('id');
        var pad = eval(id);
        pad.clear();
    });


    $(document).on('submit', '#qa_form', function(e) {
        if ($('#onsite_canvas').length > 0) {

            var signaturePad = eval("onsite_signature");
            if (!signaturePad.isEmpty()) {
                var image_str = signaturePad.toDataURL();
                $("<input />").attr("type", "hidden")
                    .attr("name", "onsite_sign")
                    .attr("value", image_str).appendTo("#qa_form");
            } else {
                $("<input />").attr("type", "hidden")
                    .attr("name", "onsite_sign")
                    .attr("value", "").appendTo("#qa_form");
            }
        } else {
            $("<input />").attr("type", "hidden")
                .attr("name", "onsite_sign")
                .attr("value", $("#markout_sign").attr("src")).appendTo("#qa_form");
        }
    });

    $(document).on('submit', '#markout_form', function(e) {
        if ($('#markout_canvas').length > 0) {

            var signaturePad = eval("markout_signature");
            if (!signaturePad.isEmpty()) {
                var image_str = signaturePad.toDataURL();
                $("<input />").attr("type", "hidden")
                    .attr("name", "markout_data[foreman_sign]")
                    .attr("value", image_str).appendTo("#markout_form");
            } else {
                $("<input />").attr("type", "hidden")
                    .attr("name", "markout_data[foreman_sign]")
                    .attr("value", "").appendTo("#markout_form");
            }
        } else {
            $("<input />").attr("type", "hidden")
                .attr("name", "markout_data[foreman_sign]")
                .attr("value", $("#markout_sign").attr("src")).appendTo("#markout_form");
        }

    });

    $(document).on('submit', '#safety_form', function(e) {
        for (var i = 1; i <= 5; i++) {
            if ($('#induction_canvas' + i).length > 0) {
                var signaturePad = eval("indunction_signaturePad" + i);
                if (!signaturePad.isEmpty()) {
                    var image_str = signaturePad.toDataURL();
                    $("<input />").attr("type", "hidden")
                        .attr("name", "safety_plan[sign][sign" + i + "]")
                        .attr("value", image_str).appendTo("#safety_form");
                } else {
                    $("<input />").attr("type", "hidden")
                        .attr("name", "safety_plan[sign][sign" + i + "]")
                        .attr("value", "").appendTo("#safety_form");
                }
            } else {
                $("<input />").attr("type", "hidden")
                    .attr("name", "safety_plan[sign][sign" + i + "]")
                    .attr("value", $("#induction_sign" + i).attr("src")).appendTo("#safety_form");
            }
        }
        if ($('#safetyplan_canvas').length > 0) {

            var signaturePad = eval("safetyplan_signature");
            if (!signaturePad.isEmpty()) {
                var image_str = signaturePad.toDataURL();
                $("<input />").attr("type", "hidden")
                    .attr("name", "safety_plan[foreman_sign]")
                    .attr("value", image_str).appendTo("#safety_form");
            } else {
                $("<input />").attr("type", "hidden")
                    .attr("name", "safety_plan[foreman_sign]")
                    .attr("value", "").appendTo("#safety_form");
            }
        } else {
            $("<input />").attr("type", "hidden")
                .attr("name", "safety_plan[foreman_sign]")
                .attr("value", $("#safetyplan_sign").attr("src")).appendTo("#safety_form");
        }
    });

    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {

        $("#qa_form tr:first-child").remove();
        $("#stripping tr:first-child").remove();
        $("#pods_steel tr:first-child").remove();

        $("#qa_form tr").each(function() {
        $(this).children("td:eq(1)").find("input").attr("placeholder","Initial");
        $(this).children("td:eq(2)").find("input").attr("placeholder","Office Use");
    });   

    $("#stripping tr").each(function() {
        $(this).children("td:eq(1)").find("input").attr("placeholder","Done by");
    });

    $("#pods_steel tr").each(function() {
        $(this).children("td:eq(1)").find("input").attr("placeholder","Done by");
        $(this).children("td:eq(2)").find("input").attr("placeholder","Done by");
        $(this).children("td:eq(3)").find("input").attr("placeholder","Checked by");

    });
    
}
    
</script>