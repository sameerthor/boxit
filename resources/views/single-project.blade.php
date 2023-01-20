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

  .red_box a {
    color: #FF5A5F;
  }

  td.status_pause span {
    margin-top: 2px;
    margin-right: -10px;
    margin-left: 10px;
  }

  td.status_pause {
    display: flex;
  }

  #project-form-d .orange_box,
  .red_box,
  .green_box {
    padding: 4px;
    width: 80%;
  }

  @import "bourbon";

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
        float: right;
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

</style>
<div id="project-form-d" class="card-new">
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
      <div class="form-group col-md-4 l-font-s">
        <label>BCN</label>
        <p>{{$project->bcn==''?'NA':$project->bcn}}</p>
      </div>
      <div class="form-group col-md-4 l-font-s">
        <label>Address</label>
        <p>{{$project->address}}</p>
      </div>
      <div class="form-group col-md-4 l-font-s">
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
        <select class="form-control foreman-project col-md-3">
          @foreach($foremans as $f)
          <option value="{{$f->id}}" <?php if($f->id==$project->foreman_id) echo "selected"; ?> >{{$f->name}}</option>
          @endforeach
        </select>
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
    <h4 class="paid-left">Booking Status</h4>
    <table class="table table-stripped">
      <thead>
        <tr>
          <th>#</th>
          <th>Department</th>
          <th>Contact</th>
          <th>Date</th>
          <th>Status</th>
          <th class="text-right">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($project->BookingData->slice(1) as $res)
        <tr>
          <td>{{$loop->iteration}}</td>
          <td>{{$res->department->title}}</td>
          <td>{{$res->contact->title}}</td>
          <td>{{date("d-m-Y h:i A",strtotime($res->date))}}</td>
          <td class="status_pause">@if($res->status=='0')
            <div class="orange_box">Pending</div>
            @elseif($res->status=='1')
            <div class="green_box">Confirmed</div>
            @elseif($res->status=='2')
            <div class="red_box"><a href="#" @if(!empty($res->onhold_reason)) data-toggle="tooltip" title="Reason : {{$res->onhold_reason}}" @endif style="text-decoration:none">On hold</a></div>
            @else
            <div class="orange_box">Pending</div>
            @endif
            @if($res->status!='2')<span><a href="javascript:void(0)" class="hold_project" data-id="{{$res->id}}"><img style="width: 65%;" src="/img/project_hold.png"></a></span>@endif
          </td>
          <td class="text-right"><button type="button" data-id="{{$res->id}}" class="btn btn-sm change_date" style="background-color: #172b4d;color:#fff" data-id="1">Change date</button></td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <br>
    <h4 class="paid-left">Choose Colors</h4>
    <table class="table table-stripped">
      <thead>
        <tr>
          <th>Status</th>
          <th>Background Color</th>
          <th>Text Color</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Pending</td>
          <td><input type="color" name="pending_background_color" value="{{$project->pending_background_color}}"></td>
          <td><input type="color" name="pending_text_color" value="{{$project->pending_text_color}}"></td>
        </tr>
        <tr>
          <td>Confirmed</td>
          <td><input type="color" name="confirm_background_color" value="{{$project->confirm_background_color}}"></td>
          <td><input type="color" name="confirm_text_color" value="{{$project->confirm_text_color}}"></td>
        </tr>
      </tbody>
      <tr>
        <td></td>
        <td></td>
        <td><button class="btn btn-sm change_colors" data-id="{{$project->id}}" style="background-color: #172b4d;color:#fff">Change colors</button></td>
      </tr>
    </table>
    <h4 class="paid-left marg-t">Foreman Forms</h4>
    <div class="row">
      <div class="col-md-12 paid-n paid-l-n">
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
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active paid-three paid-l-n" id="tab1" role="tabpanel" aria-labelledby="1-tab">

            <div class="row">

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

                  $stat=($project_status[0]->status==1)?'<div class="green_box status_label">'.($label->id=="10"?"Passed":"Yes").'</div>':'<div class="red_box status_label">'.($label->id=="10" || $label->id=="9" ?$label->id=="10"?"Failed":"NA":"No").'</div>';
                  }else
                  {
                  $stat='<div class="orange_box status_label">Pending</div>';
                  }
                  @endphp
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$label->label}}</td>
                    <td class="text-right">
                      @if(count($project_status)>0)
                      {!!$project_status[0]->reason!=''?'<a href="#" data-toggle="tooltip" title="'.$project_status[0]->reason.'"><i class="fa fa-eye"></i></a>':''!!}
                      @endif
                      @php echo $stat @endphp
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
                      <div class="switch" style="display: none;">
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
                  @endforeach
                </tbody>
                <tfoot>
                <tr>
        <td></td>
        <td></td>
        <td class="text-right"><button class="btn btn-sm edit_status" style="background-color: #172b4d;color:#fff">Edit Project Status</button></td>
      </tr>
                </tfoot>
              </table>
            </div>

          </div>
          <div class="tab-pane fade paid-three paid-l-n" id="tab2" role="tabpanel" aria-labelledby="2-tab">
            <form action="{{URL('/qa_checklist')}}" method="post" id="qa_form">
              @csrf
              <h5>Onsite & QA Checklist</h5>
              <input type="hidden" name="project_id" value="{{$project->id}}">
              <div class="qa_checklist">
                <!-- <div class="row onsite_label">
                  <div class="col-md-6"></div>
                  <div class="col-md-3 cntr-t ">Initial</div>
                  <div class="col-md-3 cntr-t">Office Use</div>
                </div> -->
                <table style="width:100%">
                  <tr>
                    <td></td>
                    <td class="table-w t-cntr">Initial</td>
                    <td class="table-w t-cntr">Office Use</td>
                  </tr>
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
                    <td class="table-w"><input type="text" readonly value="{{$initial}}" name="initial[{{$res->id}}]"></td>
                    <td class="table-w"><input type="text" readonly value="{{$office_use}}" name="office_use[{{$res->id}}]"></td>
                  </tr>
                  @endforeach
                </table>
              </div>
              <br>
              @if(!empty($project->qasign->foreman_sign))
              <h5>Signature</h5> 
              <img src="{{$project->qasign->foreman_sign}}" id="m_sign" width="200">
            @endif
              <div style="float:right">
            </form>
          </div>
        </div>
        <div class="tab-pane fade paid-three paid-l-n" id="tab3" role="tabpanel" aria-labelledby="3-tab">
          <form action="{{URL('/markout_checklist')}}" method="post" id="markout_form">
            @csrf
            <h5>Mark Out Checklist</h5>
            <input type="hidden" name="project_id" value="{{$project->id}}">
            <div style="margin:5%">
              <div class="row mb-3">
                <label for="name" class="col-md-6 col-form-label ">Date:</label>
                <div class="col-md-4">
                  <input type="date" readonly class="form-control" name="markout_data[date]" value="{{ $markout_checklist!=null ? $markout_checklist->date : '' }}">
                </div>
              </div>
              <div class="row mb-3">
                <label for="name" class="col-md-6 col-form-label ">Address:</label>
                <div class="col-md-4">
                  <input type="text" readonly class="form-control" name="markout_data[address]" value="{{ $markout_checklist!=null ? $markout_checklist->address : '' }}">
                </div>
              </div>
              <div class="row mb-3">
                <label for="name" class="col-md-6 col-form-label ">Housing Company:</label>
                <div class="col-md-4">
                  <input type="text" readonly class="form-control" name="markout_data[housing_company]" value="{{ $markout_checklist!=null ? $markout_checklist->housing_company : '' }}">
                </div>
              </div>
              <div class="row mb-3">
                <label for="name" class="col-md-6 col-form-label ">Power</label>
                <div class="col-md-4">
                  <input type="text" readonly class="form-control" name="markout_data[power]" value="{{ $markout_checklist!=null ? $markout_checklist->power : '' }}">
                </div>
              </div>
              <div class="row mb-3">
                <label for="name" class="col-md-6 col-form-label ">Site fenced</label>
                <div class="col-md-4">
                  <input type="text" readonly class="form-control" name="markout_data[site_fenced]" value="{{ $markout_checklist!=null ? $markout_checklist->site_fenced : '' }}">
                </div>
              </div>
              <div class="row mb-3">
                <label for="name" class="col-md-6 col-form-label ">Toilet</label>
                <div class="col-md-4">
                  <input type="text" readonly class="form-control" name="markout_data[toilet]" value="{{ $markout_checklist!=null ? $markout_checklist->toilet : '' }}">
                </div>
              </div>
              <div class="row mb-3">
                <label for="name" class="col-md-6 col-form-label ">Water</label>
                <div class="col-md-4">
                  <input type="text" readonly class="form-control" name="markout_data[water]" value="{{ $markout_checklist!=null ? $markout_checklist->water : '' }}">
                </div>
              </div>
              <div class="row mb-3">
                <label for="name" class="col-md-6 col-form-label ">Boundary Pegs all in Place</label>
                <div class="col-md-4">
                  <input type="text" readonly class="form-control" name="markout_data[boundary_pegs]" value="{{ $markout_checklist!=null ? $markout_checklist->boundary_pegs : '' }}">
                </div>
              </div>
              <div class="row mb-3">
                <label for="name" class="col-md-12 col-form-label col-form-label ">Draw in here what’s missing</label>

                <div class="col-md-10">
                  @if(!empty($markout_checklist->draw_in))
                  <img src="{{$markout_checklist->draw_in}}" id="drawin_sign" width="400">
                  @endif
                </div>
              </div>
              <div class="row mb-3">
                <label for="name" class="col-md-6 col-form-label ">Boundary Dimensions Back Checked - are they Correct</label>
                <div class="col-md-4">
                  <input type="text" readonly class="form-control" name="markout_data[boundary_dimension]" value="{{ $markout_checklist!=null ? $markout_checklist->boundary_dimension : '' }}">
                </div>
              </div>
              <div class="row mb-3">
                <label for="name" class="col-md-6 col-form-label ">FFL Set and Marked on Fence
                </label>
                <div class="col-md-4">
                  <input type="text" readonly class="form-control" name="markout_data[ffl_set]" value="{{ $markout_checklist!=null ? $markout_checklist->ffl_set : '' }}">
                </div>
              </div>
              <div class="row mb-3">
                <label for="name" class="col-md-6 col-form-label ">FFL Height out of Ground
                </label>
                <div class="col-md-2">
                  <input placeholder="min" readonly type="number" class="form-control" name="markout_data[ffl_height_min]" value="{{ $markout_checklist!=null ? $markout_checklist->ffl_height_min : '' }}">
                </div>
                <div class="col-md-2">
                  <input placeholder="max" readonly type="number" class="form-control" name="markout_data[ffl_height_max]" value="{{ $markout_checklist!=null ? $markout_checklist->ffl_height_max : '' }}">
                </div>
              </div>
            </div>

            @if(!empty($markout_checklist->foreman_sign))
            <img src="{{$markout_checklist->foreman_sign}}" id="markout_sign" width="200">
            @endif
            <div style="float:right">
          </form>
        </div>
      </div>
      <div class="tab-pane fade paid-three paid-l-n" id="tab4" role="tabpanel" aria-labelledby="4-tab">
        <h5 class="paid-r-l">Safety plan</h5>
        <br>
        <form class="paid-r-l" action="{{URL('/safety-plan')}}" id="safety_form" method="post">
          @csrf
          <input type="hidden" name="project_id" value="{{$project->id}}">
          <div class="row safety_plan">
            <p>This plan is to be completed with all workers prior to works beginning. All personnel must complete a site induction</p>
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <th colspan="2">Site / Address: {{$project->address}}</th>
                  <th colspan="2">Client: <input type="text" readonly style="width:70%" name="safety_plan[client]" value="{{ $safety!=null ? $safety->client : '' }}"></th>
                </tr>
                <tr>
                  <th style="width:25%">Completed By: Jimmy</th>
                  <th style="width:35%">Date: <input type="date" readonly style="width:70%" name="safety_plan[date]" value="{{ $safety!=null ? $safety->date : '' }}"></th>
                  <th style="width:20%">Time In: <input type="text" readonly style="width:40%" name="safety_plan[time_in]" value="{{ $safety!=null ? $safety->time_in : '' }}"></th>
                  <th style="width:20%">Time Out: <input type="text" readonly style="width:40%" name="safety_plan[time_out]" value="{{ $safety!=null ? $safety->time_out : '' }}"></th>
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
                                        }  ?> value="1" onclick="return false;" name="safety_plan[safe_access_tick]"><label>&#10004</label>
                    <input class="marg-l" type="radio" <?php if (!empty($safety)) {
                                                          if ($safety->safe_access_tick == '0') {
                                                            echo "checked";
                                                          }
                                                        }  ?> value="0" onclick="return false;" name="safety_plan[safe_access_tick]"><label>&#x2717</label>
                  </td>
                  <td>
                    <textarea readonly name="safety_plan[safe_access]">{{ $safety!=null ? $safety->safe_access : '' }}</textarea>
                  </td>
                </tr>
                <tr>
                  <td>1.2</td>
                  <td>
                    Have you read the site hazards board?
                  </td>
                  <td class="paid-t">
                    <input type="radio" onclick="return false;" value="1" <?php if (!empty($safety)) {
                                                                            if ($safety->site_board_tick == '1') {
                                                                              echo "checked";
                                                                            }
                                                                          }  ?> name="safety_plan[site_board_tick]"><label>&#10004</label>
                    <input class="marg-l" type="radio" onclick="return false;" value="0" <?php if (!empty($safety)) {
                                                                                            if ($safety->site_board_tick == '0') {
                                                                                              echo "checked";
                                                                                            }
                                                                                          }  ?> name="safety_plan[site_board_tick]"><label>&#x2717</label>
                  </td>
                  <td>
                    <textarea readonly name="safety_plan[site_board]">{{ $safety!=null ? $safety->site_board : '' }}</textarea>
                  </td>
                </tr>
                <tr>
                  <td>1.3</td>
                  <td>
                    Do you have adequate PPE? Hi vis / steel caps
                  </td>
                  <td class="paid-t">
                    <input type="radio" value="1" onclick="return false;" <?php if (!empty($safety)) {
                                                                            if ($safety->ppe_tick == '1') {
                                                                              echo "checked";
                                                                            }
                                                                          }  ?> name="safety_plan[ppe_tick]"><label>&#10004</label>
                    <input class="marg-l" type="radio" value="0" onclick="return false;" <?php if (!empty($safety)) {
                                                                                            if ($safety->ppe_tick == '0') {
                                                                                              echo "checked";
                                                                                            }
                                                                                          }  ?> name="safety_plan[ppe_tick]"><label>&#x2717</label>
                  </td>
                  <td>
                    <textarea readonly name="safety_plan[ppe]">{{ $safety!=null ? $safety->ppe : '' }}</textarea>
                  </td>
                </tr>
                <tr>
                  <td>1.4</td>
                  <td>
                    Have you completed the Client safety documentation on site?
                  </td>
                  <td class="paid-t">
                    <input type="radio" value="1" onclick="return false;" <?php if (!empty($safety)) {
                                                                            if ($safety->safety_documentation_tick == '1') {
                                                                              echo "checked";
                                                                            }
                                                                          }  ?> name="safety_plan[safety_documentation_tick]"><label>&#10004</label>
                    <input class="marg-l" type="radio" value="0" onclick="return false;" <?php if (!empty($safety)) {
                                                                                            if ($safety->safety_documentation_tick == '0') {
                                                                                              echo "checked";
                                                                                            }
                                                                                          }  ?> name="safety_plan[safety_documentation_tick]"><label>&#x2717</label>
                  </td>
                  <td>
                    <textarea readonly name="safety_plan[safety_documentation]">{{ $safety!=null ? $safety->safety_documentation : '' }}</textarea>
                  </td>
                </tr>
                <tr>
                  <td>1.5</td>
                  <td>
                    Are there others on site we need to communicate with?
                  </td>
                  <td class="paid-t">
                    <input type="radio" value="1" onclick="return false;" <?php if (!empty($safety)) {
                                                                            if ($safety->communicate_tick == '1') {
                                                                              echo "checked";
                                                                            }
                                                                          }  ?> name="safety_plan[communicate_tick]"><label>&#10004</label>
                    <input class="marg-l" type="radio" value="0" onclick="return false;" <?php if (!empty($safety)) {
                                                                                            if ($safety->communicate_tick == '0') {
                                                                                              echo "checked";
                                                                                            }
                                                                                          }  ?> name="safety_plan[communicate_tick]"><label>&#x2717</label>
                  </td>
                  <td>
                    <textarea readonly name="safety_plan[communicate]">{{ $safety!=null ? $safety->communicate : '' }}</textarea>
                  </td>
                </tr>
                <tr>
                  <td>1.6</td>
                  <td>
                    Is the site tidy and clear for you work activity?
                  </td>
                  <td class="paid-t">
                    <input type="radio" value="1" onclick="return false;" <?php if (!empty($safety)) {
                                                                            if ($safety->work_activity_tick == '1') {
                                                                              echo "checked";
                                                                            }
                                                                          }  ?> name="safety_plan[work_activity_tick]"><label>&#10004</label>
                    <input class="marg-l" type="radio" value="0" onclick="return false;" <?php if (!empty($safety)) {
                                                                                            if ($safety->work_activity_tick == '0') {
                                                                                              echo "checked";
                                                                                            }
                                                                                          }  ?> name="safety_plan[work_activity_tick]"><label>&#x2717</label>
                  </td>
                  <td>
                    <textarea readonly name="safety_plan[work_activity]">{{ $safety!=null ? $safety->work_activity : '' }}</textarea>
                  </td>
                </tr>
                <tr>
                  <td>1.7</td>
                  <td>
                    Is the site secure, i.e. fenced / gate closed?
                  </td>
                  <td class="paid-t">
                    <input type="radio" value="1" onclick="return false;" <?php if (!empty($safety)) {
                                                                            if ($safety->gate_closed_tick == '1') {
                                                                              echo "checked";
                                                                            }
                                                                          }  ?> name="safety_plan[gate_closed_tick]"><label>&#10004</label>
                    <input class="marg-l" type="radio" onclick="return false;" value="0" <?php if (!empty($safety)) {
                                                                                            if ($safety->gate_closed_tick == '0') {
                                                                                              echo "checked";
                                                                                            }
                                                                                          }  ?> name="safety_plan[gate_closed_tick]"><label>&#x2717</label>
                  </td>
                  <td>
                    <textarea readonly name="safety_plan[gate_closed]">{{ $safety!=null ? $safety->gate_closed : '' }}</textarea>
                  </td>
                </tr>
                <tr>
                  <td>1.8</td>
                  <td>
                    Are site hazards adequately controlled?
                  </td>
                  <td class="paid-t">
                    <input type="radio" value="1" onclick="return false;" <?php if (!empty($safety)) {
                                                                            if ($safety->hazard_controlled_tick == '1') {
                                                                              echo "checked";
                                                                            }
                                                                          }  ?> name="safety_plan[hazard_controlled_tick]"><label>&#10004</label>
                    <input class="marg-l" type="radio" value="0" onclick="return false;" <?php if (!empty($safety)) {
                                                                                            if ($safety->hazard_controlled_tick == '0') {
                                                                                              echo "checked";
                                                                                            }
                                                                                          }  ?> name="safety_plan[hazard_controlled_tick]"><label>&#x2717</label>
                  </td>
                  <td>
                    <textarea readonly name="safety_plan[hazard_controlled]">{{ $safety!=null ? $safety->hazard_controlled : '' }}</textarea>
                  </td>
                </tr>
                <tr>
                  <td>1.9</td>
                  <td>
                    Do you have access to Power / Water / Toilet?
                  </td>
                  <td class="paid-t">
                    <input type="radio" value="1" onclick="return false;" <?php if (!empty($safety)) {
                                                                            if ($safety->power_access_tick == '1') {
                                                                              echo "checked";
                                                                            }
                                                                          }  ?> name="safety_plan[power_access_tick]"><label>&#10004</label>
                    <input class="marg-l" type="radio" onclick="return false;" value="0" <?php if (!empty($safety)) {
                                                                                            if ($safety->power_access_tick == '0') {
                                                                                              echo "checked";
                                                                                            }
                                                                                          }  ?> name="safety_plan[power_access_tick]"><label>&#x2717</label>
                  </td>
                  <td>
                    <textarea readonly name="safety_plan[power_access]">{{ $safety!=null ? $safety->power_access : '' }}</textarea>
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
                  <th>HAZARD CONTROL METHOD
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
                    M Ensure all electrical is tagged and made safeM - Check guards are in place
                  </td>
                  <td>
                    <input type="checkbox" disabled value="1" <?php if (!empty($safety)) {
                                                                if ($safety->foundation == '1') {
                                                                  echo "checked";
                                                                }
                                                              }  ?> name="safety_plan[foundation]">
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
                    <input type="checkbox" disabled readonly value="1" <?php if (!empty($safety)) {
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
                    <input type="checkbox" disabled value="1" name="safety_plan[dust]" <?php if (!empty($safety)) {
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
                    <input type="checkbox" disabled value="1" name="safety_plan[hit_plant]" <?php if (!empty($safety)) {
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
                    <input type="checkbox" disabled value="1" name="safety_plan[poor_housekeeping]" <?php if (!empty($safety)) {
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
                    <input type="checkbox" disabled value="1" name="safety_plan[exposed_steel]" <?php if (!empty($safety)) {
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
                    <input type="checkbox" disabled value="1" name="safety_plan[loose_material]" <?php if (!empty($safety)) {
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
                    <input type="checkbox" disabled value="1" name="safety_plan[services]" <?php if (!empty($safety)) {
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
              <tbody>
                <tr>
                  <th scope="row">Date
                  </th>
                  <th>Name
                  </th>
                  <th>Signature
                  </th>
                </tr>
                @if(!empty($safety))
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
              <div class="col-md-8"></div>
              <div class="col-md-3">
                <br>
                <h5>Foreman Sign</h5>
                @if(!empty($safety->foreman_sign))
                <img src="{{$safety->foreman_sign}}" id="safetyplan_sign" width="200">
                @endif
              </div>
              <div class="col-md-1"></div>
              <div style="float:right">

        </form>
      </div>
    </div>

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
        <button type="button" class="btn mr-auto btn-secondary btn-sm new_email" data-id="1">New Mail</button>
          <button type="button" class="btn btn-secondary btn-sm save_date" data-id="1">Save</button>
          <button type="button" class="btn btn-secondary btn-sm cancel">Cancel</button>
        </div>
      </div>

    </div>
  </div>
  <div class="modal" id="holdPopup" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Hold Project</h4>
        </div>
        <div class="modal-body">

          <div id="deny_text">
            <p>Are you sure you want to change the status for this department to “On Hold”?</p>
            <div class="row flex-d">
              <textarea name="hold" placeholder="Reason"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm confirm_hold" data-id="1">Save</button>
          <button type="button" class="btn btn-secondary btn-sm cancel">Cancel</button>
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

$(".foreman-project").on("change", function() {
        var foreman_id = $(this).val();
        var project_id = "<?php echo $project->id; ?>";
        var before_change = $(this).data('pre')
        Swal.fire({
            title: "Are you sure you want to change the foreman?",
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
                    url: "{{ url('/change-project-foreman') }}",
                    method: 'post',
                    data: {
                      foreman_id: foreman_id,
                      project_id: project_id,
                    },
                    success: function(result) {
                        Toast.fire({
                            icon: 'success',
                            title: "Foreman changed successfuly."
                        }).then(function(result) {
                            window.location.reload();
                        });
                    }
                });
            }else
            {
              $(".foreman-project").val(before_change);

            }
        })
        
    })


$(".project_status").on("change", function() {
        var status = $(this).val();
        var status_label_id = $(this).data('id');
        var project_id = $(this).data('project');
        
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
            }
        })
        
    })

$(".edit_status").click(function(){
$(".status_label").toggle();
$(".switch").toggle();
if($(this).html()=="Edit Project Status"){
  $(this).html('Close');
}else{
  $(this).html('Edit Project Status');
}
});



  $(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
  });

  $(function() {
    $.datetimepicker.setDateFormatter('moment');

    $('.example').datetimepicker({
      format: 'DD-MM-YYYY h:mm A',
      formatTime:"h:mm A",
      step: 15
    });

    $(".example").attr("autocomplete", "off");
  });

  $(".change_date").click(function() {
    $("#holdPopup").hide();
    var id = $(this).data('id');
    $(".save_date").attr('data-id', id);
    $(".new_email").attr('data-id', id);
    $("#myModal").show();
  })

  $(".hold_project").click(function() {
    $("#myModal").hide();
    var id = $(this).data('id');
    $(".confirm_hold").attr('data-id', id);
    $("#holdPopup").show();
  })

  $(".new_email").click(function() {
    var date=$("input[name='date']").val();
    if(date=='')
    {
      alert("Please select date");
      return false;
    }
    var id = $(this).data('id');
    var obj = {id: id, date: date};;
    var encoded = btoa(JSON.stringify(obj))
    window.location.href='/new-email/'+encoded;

  });

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

  $(".confirm_hold").click(function() {
    var id = $(this).data('id');
    jQuery.ajax({
      type: 'POST',
      url: "/hold-project",
      data: {
        booking_data_id: id,
        reason: $("textarea[name='hold']").val(),
      },
      success: function(data) {
        window.location.reload();
      }
    });
  });
  $(".change_colors").click(function() {
    var id = $(this).data('id');
    jQuery.ajax({
      type: 'POST',
      url: "/change-calender-colors",
      data: {
        booking_id: id,
        pending_background_color: $("input[name='pending_background_color']").val(),
        pending_text_color: $("input[name='pending_text_color']").val(),
        confirm_background_color: $("input[name='confirm_background_color']").val(),
        confirm_text_color: $("input[name='confirm_text_color']").val(),
      },
      success: function(data) {
        window.location.reload();
      }
    });
  });

  $(".cancel").click(function() {
    $("#myModal").hide();
    $("#holdPopup").hide();
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