<style>
  iframe {
            display: block;
            width: 100%;
            border: none;
            overflow-y: auto;
            overflow-x: hidden;
        }
        #tab5{
            height: 100vh;
        }

  .increment {
    padding: 2px 8px 2px 14px;
    border: 1px solid black;
    border-radius: 11px;
    margin: 3px 2px 3px 2px;

  }

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
    width: 95px;
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

  .switch[style*='display: none']~span.status_notes {
    position: absolute;
    margin-top: -26px !important;
    margin-left: -50px;
  }

  .switch input[type="radio"].pending:checked~label[for^="pending_"] {
    background-color: #172b4d;
    color: #fff
  }

  .switch input[type="radio"].pending~label[for^="pending_"] {
    width: 220px;
  }

  input[type="range"] {
    width: 30px;
  }


  .screen-reader-only {
    position: absolute;
    top: -9999px;
    left: -9999px;
  }

  .checkbox-inline {
    position: relative;
    padding-left: 30px !important;
    margin-right: 40px;

  }

  .check {
    position: absolute;
    top: 0;
    left: 0;
    display: block;
    width: 1.4rem;
    height: 1.4rem;
  }

  .form-horizontal .checkbox-inline .check,
  .form-horizontal .radio-inline .check {
    top: 7px;
  }

  .checked_type {
    display: none;
  }

  .checked_type~.check:before {
    -webkit-transition: -webkit-transform 0.4s cubic-bezier(0.45, 1.8, 0.5, 0.75);
    -moz-transition: -moz-transform 0.4s cubic-bezier(0.45, 1.8, 0.5, 0.75);
    transition: transform 0.4s cubic-bezier(0.45, 1.8, 0.5, 0.75);
    -webkit-transform: rotate(-45deg) scale(0, 0);
    -moz-transform: rotate(-45deg) scale(0, 0);
    -ms-transform: rotate(-45deg) scale(0, 0);
    -o-transform: rotate(-45deg) scale(0, 0);
    transform: rotate(-45deg) scale(0, 0);
    content: "";
    position: absolute;
    margin-left: 0.1rem;
    left: 2px;
    top: 0.15rem;
    z-index: 1;
    width: 0.9rem;
    height: 0.5rem;
    border: 2px solid #172b4d;
    border-top-style: none;
    border-right-style: none;
  }

  .checked_type:checked~.check:before {
    -webkit-transform: rotate(-45deg) scale(1, 1);
    -moz-transform: rotate(-45deg) scale(1, 1);
    -ms-transform: rotate(-45deg) scale(1, 1);
    -o-transform: rotate(-45deg) scale(1, 1);
    transform: rotate(-45deg) scale(1, 1);
  }

  .checked_type~.check:after {
    content: "";
    position: absolute;
    top: -2px;
    left: 0;
    width: 1.4rem;
    height: 1.4rem;
    background: #fff;
    border: 2px solid #ccc;
    cursor: pointer;
  }

  .checked_type:checked~.check:after {
    border: 2px solid #172b4d;
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
        <label>BCN <span class="edit_icon"><i class="fa fa-edit fa-lg" aria-hidden="true"></i></span><span style="display:none" data-id="<?php echo $project->id; ?>" class="save_icon" data-field="bcn"><i class="fa fa-save fa-lg"></i></span></label>
        <p class="view_item">{{$project->bcn==''?'NA':$project->bcn}}</p><input type="text" class="form-control edit_item" style="display:none" value="{{$project->bcn}}">
      </div>
      <div class="form-group col-md-4 l-font-s">
        <label>Address <span class="edit_icon"><i class="fa fa-edit fa-lg" aria-hidden="true"></i></span><span style="display:none" data-id="<?php echo $project->id; ?>" class="save_icon" data-field="address"><i class="fa fa-save fa-lg"></i></span></label>
        <p class="view_item">{{$project->address}}</p><input type="text" class="form-control edit_item" style="display:none" value="{{$project->address}}">
      </div>
      <div class="form-group col-md-4 l-font-s">
        <label>Building Company <span class="edit_icon"><i class="fa fa-edit fa-lg" aria-hidden="true"></i></span><span style="display:none" data-id="<?php echo $project->BookingData[0]->id; ?>" class="save_icon" data-field="building_company"><i class="fa fa-save fa-lg"></i></span></label></label>
        <p class="view_item">{{$project->BookingData[0]->contact->title}}</p>
        <select class="form-control edit_item " style="display:none;">
          @foreach($contacts as $contact)
          @if($contact->department_id=='1')
          <option value="{{$contact->id}}" <?php if ($contact->id == $project->BookingData[0]->contact_id) echo "selected"; ?>>{{ucfirst($contact->title)}}</option>
          @endif
          @endforeach
        </select>
      </div>
      <div class="form-group col-md-6 l-font-s">
        <label>Floor Type <span class="edit_icon"><i class="fa fa-edit fa-lg" aria-hidden="true"></i></span><span style="display:none" data-id="<?php echo $project->id; ?>" class="save_icon" data-field="floor_type"><i class="fa fa-save fa-lg"></i></span></label>
        <p class="view_item">{{$project->floor_type}}</p><input type="text" class="form-control edit_item" style="display:none" value="{{$project->floor_type}}">
      </div>
      <div class="form-group col-md-6 l-font-s">
        <label>Floor Area <span class="edit_icon"><i class="fa fa-edit fa-lg" aria-hidden="true"></i></span><span style="display:none" data-id="<?php echo $project->id; ?>" class="save_icon" data-field="floor_area"><i class="fa fa-save fa-lg"></i></span></label>
        <p class="view_item">{{$project->floor_area}}</p><input type="text" class="form-control edit_item" style="display:none" value="{{$project->floor_area}}">
      </div>
      <div class="form-group col-md-12">
        <label><b>Status</b></label>
        <br>
        <label class="checkbox-inline" for="status-1">
          <input type="checkbox" class="checked_type" {{in_array('1',$checked_checkbox_status)?'checked':''}} name="checkbox_status[]" id="status-1" value="1">Request Consent Conditions
          <span class="check"></span>
        </label>
        <label class="checkbox-inline" for="status-2">
          <input type="checkbox" class="checked_type" {{in_array('2',$checked_checkbox_status)?'checked':''}} name="checkbox_status[]" id="status-2" value="2">Add to Alpha One
          <span class="check"></span>
        </label>
        <label class="checkbox-inline" for="status-3">
          <input type="checkbox" class="checked_type" {{in_array('3',$checked_checkbox_status)?'checked':''}} name="checkbox_status[]" id="status-3" value="3">Upload Plumber details to Alpha One
          <span class="check"></span>
        </label>
        <label class="checkbox-inline" for="status-4">
          <input type="checkbox" class="checked_type" {{in_array('4',$checked_checkbox_status)?'checked':''}} name="checkbox_status[]" id="status-4" value="4">Upload Redacted Concrete Invoice to Alpha One
          <span class="check"></span>
        </label>
        <label class="checkbox-inline" for="status-5">
          <input type="checkbox" class="checked_type" {{in_array('5',$checked_checkbox_status)?'checked':''}} name="checkbox_status[]" id="status-5" value="5">Quote Accepted
          <span class="check"></span>
        </label>
        <label class="checkbox-inline" for="status-6">
          <input type="checkbox" class="checked_type" {{in_array('6',$checked_checkbox_status)?'checked':''}} name="checkbox_status[]" id="status-6" value="6">Project Added and Consumables Loaded
          <span class="check"></span>
        </label>
        <label class="checkbox-inline" for="status-7">
          <input type="checkbox" class="checked_type" {{in_array('7',$checked_checkbox_status)?'checked':''}} name="checkbox_status[]" id="status-7" value="7">FRU Spreadsheet
          <span class="check"></span>
        </label>
      </div>
      <div class="form-group col-md-6 l-font-s">
        <label>Foreman <span class="edit_icon"><i class="fa fa-edit fa-lg" aria-hidden="true"></i></span><span style="display:none" data-id="<?php echo $project->id; ?>" class="save_icon" data-field="foreman_id"><i class="fa fa-save fa-lg"></i></span></label>
        <p class="view_item">{{ucfirst($project->foreman->name)}}</p>
        <select class="form-control edit_item col-md-3" style="display:none;">
          @foreach($foremans as $f)
          <option value="{{$f->id}}" <?php if ($f->id == $project->foreman_id) echo "selected"; ?>>{{ucfirst($f->name)}}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group col-md-6 l-font-s">
        <label>Notes <span class="edit_icon" data-field="notes"><i class="fa fa-edit fa-lg" aria-hidden="true"></i></span><span style="display:none" data-id="<?php echo $project->id; ?>" class="save_icon" data-field="notes"><i class="fa fa-save fa-lg"></i></span></label>
        <pre class="view_item">{{ $project->notes }}</pre><textarea class="form-control edit_item"  style="display:none">{{$project->notes}}</textarea>
      </div>
      <div class="form-group col-md-12 l-font-s">
        <label>File</label> <span class="save_file" data-id="{{$project->id}}"><i class="fa fa-upload fa-lg" aria-hidden="true"></i></span>
        <br />
        <div class="row file-listing">
          @foreach($project->file as $f)
          <div class="form-group increment col-md-6 bg-shadow ">
            <label>{{$f}}</label>
            <div style="float: right;"><i class="fa fa-trash fa-lg delete_image" data-id="{{$project->id}}" data-name="{{$f}}" aria-hidden="true"></i><a href="/images/{{$f}}" target="_blank" style="color:black;position: absolute;right: 38px;top: 4px;"><i class="fa fa-external-link fa-lg" aria-hidden="true"></i></a></div>

          </div>
          @endforeach
        </div>
      </div>
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
          <td>{{$res->department->title}} {{$res->service!=''?'('.$res->service.')':''}}</td>
          <td>
            <span class="contact_label"> {{$res->contact?->title}}</span>
            @if($res->department_id!=7)
            <select class="form-control contact_dropdown" data-id="{{$res->id}}" style="display:none">
              @foreach($contacts as $contact)
              @if($contact->department_id==$res->department_id)
              <option value="{{$contact->id}}" @php if($contact->id==$res->contact_id) echo 'selected'; @endphp>{{$contact->title}}</option>
              @endif
              @endforeach
            </select>
            <span class="edit_contact"><i class="fa fa-edit fa-lg" aria-hidden="true"></i></span>
            @endif
          </td>
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
            <span data-notes="{{$res->notes}}" data-id="{{$res->id}}" class="department_notes"><i class="fa fa-sticky-note-o fa-lg" aria-hidden="true"></i></span>
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
          <li class="nav-item" role="presentation">
            <button style="color:#172b4d" class="nav-link" data-bs-toggle="tab" data-bs-target="#tab5" type="button" role="tab" aria-controls="tab5" aria-selected="true">Email log
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
                  if($project_status[0]->status==0)
                  {
                  $stat='<div class="red_box status_label">'.($label->id=="10" || $label->id=="9" || $label->id=="8"?"Failed":"No").'</div>';
                  }elseif($project_status[0]->status==1)
                  {
                  $stat='<div class="green_box status_label">'.($label->id=="10" || $label->id=="9" || $label->id=="8"?"Passed":"Yes").'</div>';
                  }else{
                  $stat='<div class="green_box status_label">PASSED WITH CONDITIONS</div>';
                  }
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
                      $pending_checked=$project_status[0]->status==3?'checked':'';
                      $notes=$project_status[0]->notes;
                      }else
                      {
                      $yes_checked="";
                      $no_checked="";
                      $pending_checked="";
                      $notes="";
                      }
                      @endphp
                      <div class="switch" style="display: none;">
                        <input type="radio" {{$yes_checked}} class="project_status yes" id="yes_{{$label->id}}" data-id="{{$label->id}}" data-project="{{$project->id}}" name="status[{{$label->id}}]" value="1">
                        <label class="radio_label" for="yes_{{$label->id}}">{{$label->id=="10" || $label->id=="9" || $label->id=="8"?"Passed":"Yes"}}</label>
                        <input type="radio" {{$no_checked}} id="no_{{$label->id}}" class="project_status no" data-id="{{$label->id}}" data-project="{{$project->id}}" name="status[{{$label->id}}]" value="0">
                        <label class="radio_label" for="no_{{$label->id}}">{{$label->id=="10" || $label->id=="9" || $label->id=="8" ?"Failed":"No"}}</label>
                        @if($label->id=="10" || $label->id=="8" || $label->id=="9")
                        <input type="radio" {{$pending_checked}} data-notes="{{$notes}}" id="pending_{{$label->id}}" class="project_status pending" data-id="{{$label->id}}" data-project="{{$project->id}}" name="status[{{$label->id}}]" value="3">
                        <label class="radio_label" for="pending_{{$label->id}}">PASSED WITH CONDITIONS</label>
                        @endif
                        @if(count($project_status)>0)
                        {!!$project_status[0]->reason!=''?'<a href="#" data-toggle="tooltip" title="'.$project_status[0]->reason.'"><i class="fa fa-eye"></i></a>':''!!}
                        @endif
                      </div>
                      @if($pending_checked == 'checked')
                      <span data-notes="{{$notes}}" data-label="{{$label->id}}" data-id="{{$project->id}}" class="status_notes"><i class="fa fa-sticky-note{{empty($notes)?'-o':''}} fa-lg" aria-hidden="true"></i></span>
                      @endif
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
            <h5>Onsite & QA Checklist</h5>
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
          </div>
          <div class="tab-pane fade paid-three paid-l-n" id="tab3" role="tabpanel" aria-labelledby="3-tab">
            <h5>Mark Out Checklist</h5>
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
                <div class="col-md-1">
                                        {!! ($markout_checklist!=null && $markout_checklist->power_image !=null) 
                                        ? 
                                        "<a class='demo' href='/images/$markout_checklist->power_image' data-lightbox='example-$markout_checklist->power_image'><img class='example-image' width='125' src='/images/$markout_checklist->power_image'></a>"
                                        :
                                        ""
                                        !!}
                                    </div>
              </div>
              <div class="row mb-3">
                <label for="name" class="col-md-6 col-form-label ">Site fenced</label>
                <div class="col-md-4">
                  <input type="text" readonly class="form-control" name="markout_data[site_fenced]" value="{{ $markout_checklist!=null ? $markout_checklist->site_fenced : '' }}">
                </div>
                <div class="col-md-1">
                                        {!! ($markout_checklist!=null && $markout_checklist->site_fenced_image !=null) 
                                        ? 
                                        "<a class='demo' href='/images/$markout_checklist->site_fenced_image' data-lightbox='example-$markout_checklist->site_fenced_image'><img class='example-image' width='125' src='/images/$markout_checklist->site_fenced_image'></a>"
                                        :
                                        ""
                                        !!}
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
          </div>
          <div class="tab-pane fade paid-three paid-l-n" id="tab4" role="tabpanel" aria-labelledby="4-tab">
            <h5 class="paid-r-l">Safety plan</h5>
            <br>
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
                      M Ensure all electrical is tagged and made safe
                      <br>
                      M - Check guards are in place
                    </td>
                    <td>
                      <input type="checkbox" disabled value="1" <?php if (!empty($safety)) {
                                                                  if ($safety->foundation == '1') {
                                                                    echo "checked";
                                                                  }
                                                                }  ?> name="safety_plan[foundation]">
                      <br>
                      <input type="checkbox" disabled value="1" <?php if (!empty($safety)) {
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
                <div class="col-md-8"></div>
                <div class="col-md-3">
                  <br>
                  <h5>Foreman Sign</h5>
                  @if(!empty($safety->foreman_sign))
                  <img src="{{$safety->foreman_sign}}" id="safetyplan_sign" width="200">
                  @endif
                </div>
                <div class="col-md-1"></div>
              </div>
            </div>
          </div>  
            <div class="tab-pane fade  paid-three paid-l-n" id="tab5" role="tabpanel" aria-labelledby="5-tab">
            <iframe src="/_mail-viewer?project_id={{$project->id}}" id="iframe" frameborder="0" marginheight="0" marginwidth="0" width="100%" height="100%" scrolling="auto">Browser not compatible.</iframe>
            </div>
          </div>
        </div>
      </div>

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
      <div class="modal" id="notePopup" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add Note</h4>
            </div>
            <div class="modal-body">
              <div class="">
                <textarea name="note" rows="8" class="form-control" id="department_note" placeholder="Please enter note here..."></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-sm" id="save_department_note" data-id="1">Save</button>
              <button type="button" class="btn btn-secondary btn-sm cancel">Cancel</button>
            </div>
          </div>

        </div>
      </div>
      <div class="modal" id="passedPopup" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add Note</h4>
            </div>
            <div class="modal-body">
              <div class="">
                <textarea name="note" rows="8" class="form-control" id="passed_note" placeholder="Please enter note here..."></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn condition_note btn-secondary btn-sm" data-label="" id="save_passed_note" data-id="1">Save</button>
              <button type="button" data-note="" id="unsave_passed_note" class="btn condition_note btn-secondary btn-sm">Cancel</button>
            </div>
          </div>

        </div>
      </div>
      <div class="modal" id="filePopup" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Upload Files</h4>
            </div>
            <div class="modal-body">
              <form method="post" id="fileUploadForm">
                <input type="hidden" name="id" value="{{$project->id}}">
                <div class="row">
                  <div class="form-group increment col-md-12 bg-shadow">
                    <input type="file" style="padding-top: 6px !important; padding-left:10px !important;" name="file_upload[]" class="myfrm form-control">
                    <div class="add_html" style="float: right;"><i class="fa fa-plus" aria-hidden="true"></i></div>
                  </div>
                  <div class="clone hide" style="display:none">
                    <div class="hdtuto control-group lst input-group" style="margin-top:10px">
                      <input type="file" name="file_upload[]" style="padding-top: 6px !important; padding-left:10px !important; " class="myfrm form-control">
                      <div class="remove" style="float: right;"><i class="fa fa-trash" aria-hidden="true"></i>
                      </div>
                    </div>
                  </div>

                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-sm update_file">Save</button>
              <button type="button" class="btn btn-secondary btn-sm cancel">Cancel</button>
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
        function refreshpage() {
          $(".modal").modal('hide');
          var id = "<?php echo $project->id; ?>";
          $(".modal").modal('hide');

          jQuery.ajax({
            url: "{{ url('/single-project') }}",
            method: 'post',
            data: {
              id: id,
            },
            success: function(result) {
              jQuery('.main').html(result);
            }
          });
        }

        $(".delete_image").on('click', function() {
          var id = $(this).data('id');
          var file = $(this).data('name');
          Swal.fire({
            title: "Are you sure you want to delete this file ?",
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
                url: "{{ url('/delete-file') }}",
                method: 'post',
                data: {
                  id: id,
                  file: file,
                },
                success: function(result) {
                  Toast.fire({
                    icon: 'success',
                    title: "File deleted successfuly."
                  }).then(function(result) {
                    refreshpage();
                  });

                }
              });
            }
          })
        });


        $(".edit_icon").on('click', function() {
          $(this).hide();
          $(this).parents(".form-group").find(".save_icon").show();
          $(this).parents(".form-group").find(".view_item").hide();
          var field = $(this).data('field');
          $(this).parents(".form-group").find(".edit_item").show();
        });

        $(document).on('click', '.save_icon', function() {
          var id = $(this).data('id');
          var field = $(this).data('field');
          var val = $(this).parents(".form-group").find(".edit_item").val();
                  
          jQuery.ajax({
            url: "{{ url('/update-project') }}",
            method: 'post',
            data: {
              id: id,
              field: field,
              val: val
            },
            success: function(result) {
              Toast.fire({
                icon: 'success',
                title: "Project updated successfuly."
              }).then(function(result) {
                refreshpage();
              });
            }
          });
        });

        $(".edit_contact").on('click', function() {
          $(this).hide();
          $(this).parents("td").find(".contact_label").hide();
          $(this).parents("td").find(".contact_dropdown").show();
        });

        $(".contact_dropdown").on("change", function() {
          var id = $(this).data('id');
          var contact_id = $(this).val();
          var obj = {
            id: id,
            contact_id: contact_id,
          };;
          var encoded = btoa(JSON.stringify(obj))
          Swal.fire({
            title: "Are you sure you want to change the contact?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: 'Yes',
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#dc3545',
            cancelButtonText: 'No',
            dangerMode: true,
          }).then(function(result) {
            if (result.isConfirmed) {
              window.location.href = '/new-email/' + encoded;
            } else {
              refreshpage();
            }
          })
        })

        $(".project_status").on("change", function() {
          var status = $(this).val();
          var status_label_id = $(this).data('id');
          var project_id = $(this).data('project');
          var ele = $(this);
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
              if (status == 3) {
                console.log(ele.data('notes'));
                $("#passedPopup").modal("show");
                $("#passed_note").val(ele.data('notes'));
                $("#unsave_passed_note").data('note', ele.data('notes'));
                $(".condition_note").data('id', project_id);
                $(".condition_note").data('label', status_label_id);
                return false;
              }
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
                    refreshpage();
                  });
                }
              });
            } else {
              refreshpage();

            }
          })

        })

        $(".edit_status").click(function() {
          $(".status_label").toggle();
          $(".switch").toggle();
          if ($(this).html() == "Edit Project Status") {
            $(this).html('Close');
          } else {
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
            formatTime: "h:mm A",
            step: 15
          });

          $(".example").attr("autocomplete", "off");
        });

        $(".change_date").click(function() {
          $("#holdPopup").modal('hide');
          $("#filePopup").modal('hide');
          $("#notePopup").modal('hide');
          var id = $(this).data('id');
          $(".save_date").attr('data-id', id);
          $(".new_email").attr('data-id', id);
          $("#myModal").modal('show');
        })

        $(".department_notes").click(function() {
          $("#myModal").modal('hide');
          $("#filePopup").modal('hide');
          $("#holdPopup").modal('hide');
          var id = $(this).data('id');
          var note = $(this).data('notes');
          $("#department_note").val(note);
          $("#save_department_note").attr('data-id', id);
          $('#notePopup').modal('show');
        });

        $(".hold_project").click(function() {
          $("#myModal").modal('hide');
          $("#filePopup").modal('hide');
          $("#notePopup").modal('hide');
          var id = $(this).data('id');
          $(".confirm_hold").attr('data-id', id);
          $("#holdPopup").modal('show');
        })

        $(".save_file").click(function() {
          $("#myModal").modal('hide');
          $("#holdPopup").modal('hide');
          $("#notePopup").modal('hide');
          var id = $(this).data('id');
          $(".update_file").attr('data-id', id);
          $("#filePopup").modal('show');
        })


        $(".add_html").click(function() {
          var lsthmtl = $(".clone").html();
          $(".increment").append(lsthmtl);
        });
        $("body").on("click", ".remove", function() {
          $(this).parents(".hdtuto").remove();
        });

        $(".new_email").click(function() {
          var date = $("input[name='date']").val();
          if (date == '') {
            alert("Please select date");
            return false;
          }
          var id = $(this).data('id');
          var obj = {
            id: id,
            date: date
          };;
          var encoded = btoa(JSON.stringify(obj))
          window.location.href = '/new-email/' + encoded;

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

              Toast.fire({
                icon: 'success',
                title: "Date revised successfuly."
              }).then(function(result) {
                refreshpage();
              });
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
              Toast.fire({
                icon: 'success',
                title: "Project onhold successfuly."
              }).then(function(result) {
                refreshpage();
              });
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
              Toast.fire({
                icon: 'success',
                title: "Color changed successfuly."
              }).then(function(result) {
                refreshpage();
              });
            }
          });
        });

        $(".cancel").click(function() {
          $("#myModal").modal('hide');
          $("#holdPopup").modal('hide');
          $("#filePopup").modal('hide');
          $("#notePopup").modal('hide');

        })

        $(document).on("click", "#back", function() {
          var id = $(this).data('id');
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          jQuery.ajax({
            url: window.location.href,
            method: 'get',
            success: function(result) {
              var ele = $(result);

              jQuery('.container .main').html(ele.find(".container .main").html());
            }
          });
        })
        $(".update_file").on("click", function() {
          var id = $(this).data('id');
          var form = $('#fileUploadForm')[0];
          var formData = new FormData(form);

          $.ajax({
            url: "{{ url('/save-image') }}",
            method: "post",
            processData: false,
            contentType: false,
            data: formData,
            success: function(id) {
              Toast.fire({
                icon: 'success',
                title: "File saved successfuly."
              }).then(function(result) {
                refreshpage();
              });
            }
          });
        })

        $("#save_department_note").on("click", function() {
          var note = $("#department_note").val();
          var id = $(this).data('id')
          $.ajax({
            url: "{{ url('/save-note') }}",
            method: "post",
            data: {
              note: note,
              id: id
            },
            success: function(id) {
              Toast.fire({
                icon: 'success',
                title: "Note saved successfuly."
              }).then(function(result) {
                refreshpage();
              });
            }
          });
        })

        $("#save_passed_note,#unsave_passed_note").click(function() {
          var msg = true;
          var status = 3;
          var project_id = $(this).data('id');
          var status_label_id = $(this).data('label');;
          var notes = $("#passed_note").val();
          if ($(this).is("#unsave_passed_note")) {
            msg = false;
            var notes = $(this).data('note');;
            $(this).modal("hide")
          }
          jQuery.ajax({
            url: "{{ url('/change-project-status') }}",
            method: 'post',
            data: {
              project_id: project_id,
              status: status,
              status_label_id: status_label_id,
              notes: notes
            },
            success: function(result) {
              if (msg === true) {
                Toast.fire({
                  icon: 'success',
                  title: 'Note saved successfuly'
                }).then(function(result) {
                  refreshpage();
                });
              } else {
                refreshpage();
              }
            }
          });
        });
        $(".status_notes").click(function() {
          $("#passedPopup").modal("show");
          $("#passed_note").val($(this).data('notes'));
          $("#unsave_passed_note").data('note', $(this).data('notes'));
          $(".condition_note").data('id', $(this).data('id'));
          $(".condition_note").data('label', $(this).data('label'));
        })

        $(".checked_type").on("change", function() {
          var val = [];
          $("input:checkbox[name='checkbox_status[]']:checked").each(function() {
            val.push($(this).val());
          });
          var id = "{{$project->id}}";
          jQuery.ajax({
            type: 'POST',
            url: "/change-checkbox-status",
            data: {
              project_id: id,
              status: val,
            },
            success: function(data) {

            }
          });
        })

        lightbox.option({
        albumLabel: 'Image %1 of %2',
        alwaysShowNavOnTouchDevices: false,
        fadeDuration: 600,
        fitImagesInViewport: true,
        imageFadeDuration: 600,
        maxWidth: 900,
        maxHeight: 700,
        positionFromTop: 50,
        resizeDuration: 700,
        showImageNumberLabel: true,
        wrapAround: false, // If true, when a user reaches the last image in a set, the right navigation arrow will appear and they will be to continue moving forward which will take them back to the first image in the set.
        sanitizeTitle: false
    })
    
      </script>