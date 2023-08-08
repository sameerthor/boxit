<form action="{{URL('/accident-investigation')}}" method="post">
                            @csrf
                            <h5>Accident/Incident Investigation ({{$form->date}})</h5>
                            <br>
<button class="btn btn-primary btn-color float-right back-form" type="button">Back</button>
<br>
                            <input type="hidden" name="form_id" value="{{$form->id}}">
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
                                            <th colspan="2">Attendees Names<textarea name="incident_data[attendees]">{{ $incident_data!=null ? $incident_data->attendees : '' }}</textarea></th>
                                        </tr>
                                        <tr style="height: 70px;">
                                            <th style="width:60%;">Actions to follow up from last week:</th>
                                            <th style="width:40%;">Action Required Who / When</th>
                                        </tr>
                                        <tr style="height: 70px;">
                                            <th style="width:60%;">Site Inspection:</th>
                                            <th style="width:40%;"><textarea name="incident_data[site_inspection]">{{ $incident_data!=null ? $incident_data->site_inspection : '' }}</textarea></th>
                                            <td>
                                            {!! ($form->images()->form('accident', '1')->count()>0)
                                        ?
                                        "<div class='image_container'><span class='file-remover' data-id='".$form->images()->form('accident', '1' )->pluck('id')[0]."'><i class='fa fa-times'></i></span><a class='demo' href='/images/".$form->images()->form('accident', '1' )->pluck('image')[0]."' data-lightbox='example-".$form->images()->form('accident', '1')->pluck('image')[0]."'><img class='example-image' width='125' src='/images/".$form->images()->form('accident', '1' )->pluck('image')[0]."'></a></div>"
                                        :
                                        "<div class='image-upload'><label for='accident1'><img src='/img/upload-image.svg' /></label><input id='accident1' class='form_image' data-project='$project->id' data-formid='$form->id' data-field='1' data-form='accident' type='file' /></div>"
                                        !!}   
                                        </td>
                                        </tr>
                                        <tr style="height: 70px;">
                                            <th style="width:60%;">Upcoming Work:</th>
                                            <th style="width:40%;"><textarea name="incident_data[upcoming_work]">{{ $incident_data!=null ? $incident_data->upcoming_work : '' }}</textarea></th>
                                            <td>
                                            {!! ($form->images()->form('accident', '2')->count()>0)
                                        ?
                                        "<div class='image_container'><span class='file-remover' data-id='".$form->images()->form('accident', '2' )->pluck('id')[0]."'><i class='fa fa-times'></i></span><a class='demo' href='/images/".$form->images()->form('accident', '2' )->pluck('image')[0]."' data-lightbox='example-".$form->images()->form('accident', '2')->pluck('image')[0]."'><img class='example-image' width='125' src='/images/".$form->images()->form('accident', '2' )->pluck('image')[0]."'></a></div>"
                                        :
                                        "<div class='image-upload'><label for='accident2'><img src='/img/upload-image.svg' /></label><input id='accident2' class='form_image' data-project='$project->id' data-formid='$form->id' data-field='2' data-form='accident' type='file' /></div>"
                                        !!}   
                                        </td>
                                        </tr>
                                        <tr style="height: 70px;">
                                            <th style="width:60%;">Incidents / Near Misses / Injury Events:</th>
                                            <th style="width:40%;"><textarea name="incident_data[incidents]">{{ $incident_data!=null ? $incident_data->incidents : '' }}</textarea></th>
                                            <td>
                                            {!! ($form->images()->form('accident', '3')->count()>0)
                                        ?
                                        "<div class='image_container'><span class='file-remover' data-id='".$form->images()->form('accident', '3' )->pluck('id')[0]."'><i class='fa fa-times'></i></span><a class='demo' href='/images/".$form->images()->form('accident', '3' )->pluck('image')[0]."' data-lightbox='example-".$form->images()->form('accident', '3')->pluck('image')[0]."'><img class='example-image' width='125' src='/images/".$form->images()->form('accident', '3' )->pluck('image')[0]."'></a></div>"
                                        :
                                        "<div class='image-upload'><label for='accident3'><img src='/img/upload-image.svg' /></label><input id='accident3' class='form_image' data-project='$project->id' data-formid='$form->id' data-field='3' data-form='accident' type='file' /></div>"
                                        !!}   
                                        </td>
                                        </tr>
                                        <tr style="height: 70px;">
                                            <th style="width:60%;">Equipment Maintenance / Issues</th>
                                            <th style="width:40%;"><textarea name="incident_data[equipment_issues]">{{ $incident_data!=null ? $incident_data->equipment_issues : '' }}</textarea></th>
                                            <td>
                                            {!! ($form->images()->form('accident', '4')->count()>0)
                                        ?
                                        "<div class='image_container'><span class='file-remover' data-id='".$form->images()->form('accident', '4' )->pluck('id')[0]."'><i class='fa fa-times'></i></span><a class='demo' href='/images/".$form->images()->form('accident', '4' )->pluck('image')[0]."' data-lightbox='example-".$form->images()->form('accident', '4')->pluck('image')[0]."'><img class='example-image' width='125' src='/images/".$form->images()->form('accident', '4' )->pluck('image')[0]."'></a></div>"
                                        :
                                        "<div class='image-upload'><label for='accident4'><img src='/img/upload-image.svg' /></label><input id='accident4' class='form_image' data-project='$project->id' data-formid='$form->id' data-field='4' data-form='accident' type='file' /></div>"
                                        !!}   
                                        </td>
                                        </tr>
                                        <tr style="height: 70px;">
                                            <th style="width:60%;">Employee issues raised:</th>
                                            <th style="width:40%;"><textarea name="incident_data[employee_issues]">{{ $incident_data!=null ? $incident_data->employee_issues : '' }}</textarea></th>
                                            <td>
                                            {!! ($form->images()->form('accident', '5')->count()>0)
                                        ?
                                        "<div class='image_container'><span class='file-remover' data-id='".$form->images()->form('accident', '5' )->pluck('id')[0]."'><i class='fa fa-times'></i></span><a class='demo' href='/images/".$form->images()->form('accident', '5' )->pluck('image')[0]."' data-lightbox='example-".$form->images()->form('accident', '5')->pluck('image')[0]."'><img class='example-image' width='125' src='/images/".$form->images()->form('accident', '5' )->pluck('image')[0]."'></a></div>"
                                        :
                                        "<div class='image-upload'><label for='accident5'><img src='/img/upload-image.svg' /></label><input id='accident5' class='form_image' data-project='$project->id' data-formid='$form->id' data-field='5' data-form='accident' type='file' /></div>"
                                        !!}   
                                        </td>
                                        </tr>
                                        <tr style="height: 70px;">
                                            <th style="width:60%;">Safe observations reviewed/discussed</th>
                                            <th style="width:40%;"><textarea name="incident_data[safe_reviewed]">{{ $incident_data!=null ? $incident_data->safe_reviewed : '' }}</textarea></th>
                                            <td>
                                            {!! ($form->images()->form('accident', '6')->count()>0)
                                        ?
                                        "<div class='image_container'><span class='file-remover' data-id='".$form->images()->form('accident', '6' )->pluck('id')[0]."'><i class='fa fa-times'></i></span><a class='demo' href='/images/".$form->images()->form('accident', '6' )->pluck('image')[0]."' data-lightbox='example-".$form->images()->form('accident', '6')->pluck('image')[0]."'><img class='example-image' width='125' src='/images/".$form->images()->form('accident', '6' )->pluck('image')[0]."'></a></div>"
                                        :
                                        "<div class='image-upload'><label for='accident6'><img src='/img/upload-image.svg' /></label><input id='accident6' class='form_image' data-project='$project->id' data-formid='$form->id' data-field='6' data-form='accident' type='file' /></div>"
                                        !!}   
                                        </td>
                                        </tr>
                                        <tr style="height: 70px;">
                                            <th style="width:60%;">Task Analysis completed/reviewed:</th>
                                            <th style="width:40%;"><textarea name="incident_data[task_reviewed]">{{ $incident_data!=null ? $incident_data->task_reviewed : '' }}</textarea></th>
                                            <td>
                                            {!! ($form->images()->form('accident', '7')->count()>0)
                                        ?
                                        "<div class='image_container'><span class='file-remover' data-id='".$form->images()->form('accident', '7' )->pluck('id')[0]."'><i class='fa fa-times'></i></span><a class='demo' href='/images/".$form->images()->form('accident', '7' )->pluck('image')[0]."' data-lightbox='example-".$form->images()->form('accident', '7')->pluck('image')[0]."'><img class='example-image' width='125' src='/images/".$form->images()->form('accident', '7' )->pluck('image')[0]."'></a></div>"
                                        :
                                        "<div class='image-upload'><label for='accident7'><img src='/img/upload-image.svg' /></label><input id='accident7' class='form_image' data-project='$project->id' data-formid='$form->id' data-field='7' data-form='accident' type='file' /></div>"
                                        !!}   
                                        </td>
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
                                            <td width=""><input name="incident_data[bruiding_checkbox]" <?php if ($incident_data != null) {
                                                                                                            if ($incident_data->bruiding_checkbox == 'yes') {
                                                                                                                echo "checked";
                                                                                                            }
                                                                                                        } ?> value="yes" type="checkbox"> Bruising</td>
                                            <td width=""><input name="incident_data[disclotion_checkbox]" <?php if ($incident_data != null) {
                                                                                                                if ($incident_data->disclotion_checkbox == 'yes') {
                                                                                                                    echo "checked";
                                                                                                                }
                                                                                                            } ?> value="yes" type="checkbox"> Dislocation</td>
                                            <td width=""><input name="incident_data[other_checkbox]" <?php if ($incident_data != null) {
                                                                                                            if ($incident_data->other_checkbox == 'yes') {
                                                                                                                echo "checked";
                                                                                                            }
                                                                                                        } ?> value="yes" type="checkbox"> Other (specify)</td>
                                            <td width="" rowspan="2">Injured part of body<textarea name="incident_data[injured_part]">{{ $incident_data!=null ? $incident_data->injured_part : '' }}</textarea></td>
                                        </tr>
                                        <tr>
                                            <td width=""><input name="incident_data[strain_checkbox]" <?php if ($incident_data != null) {
                                                                                                            if ($incident_data->strain_checkbox == 'yes') {
                                                                                                                echo "checked";
                                                                                                            }
                                                                                                        } ?> value="yes" type="checkbox"> Strain/sprain</td>
                                            <td width=""><input name="incident_data[scratch_checkbox]" <?php if ($incident_data != null) {
                                                                                                            if ($incident_data->scratch_checkbox == 'yes') {
                                                                                                                echo "checked";
                                                                                                            }
                                                                                                        } ?> value="yes" type="checkbox"> Scratch/abrasion</td>
                                            <td width=""><input name="incident_data[internal_checkbox]" <?php if ($incident_data != null) {
                                                                                                            if ($incident_data->internal_checkbox == 'yes') {
                                                                                                                echo "checked";
                                                                                                            }
                                                                                                        } ?> value="yes" type="checkbox"> Internal</td>
                                            <td width=""></td>
                                        </tr>
                                        <tr>
                                            <td width=""><input name="incident_data[fracture_checkbox]" <?php if ($incident_data != null) {
                                                                                                            if ($incident_data->fracture_checkbox == 'yes') {
                                                                                                                echo "checked";
                                                                                                            }
                                                                                                        } ?> value="yes" type="checkbox"> Fracture</td>
                                            <td width=""><input name="incident_data[amputation_checkbox]" <?php if ($incident_data != null) {
                                                                                                                if ($incident_data->amputation_checkbox == 'yes') {
                                                                                                                    echo "checked";
                                                                                                                }
                                                                                                            } ?> value="yes" type="checkbox"> Amputation</td>
                                            <td width=""><input name="incident_data[foreign_checkbox]" <?php if ($incident_data != null) {
                                                                                                            if ($incident_data->foreign_checkbox == 'yes') {
                                                                                                                echo "checked";
                                                                                                            }
                                                                                                        } ?> value="yes" type="checkbox"> Foreign body</td>
                                            <td width="" rowspan="2" colspan="2">Remarks<textarea name="incident_data[remarks]">{{ $incident_data!=null ? $incident_data->remarks : '' }}</textarea></td>
                                        </tr>
                                        <tr>
                                            <td width=""><input name="incident_data[cut_checkbox]" <?php if ($incident_data != null) {
                                                                                                        if ($incident_data->cut_checkbox == 'yes') {
                                                                                                            echo "checked";
                                                                                                        }
                                                                                                    } ?> value="yes" type="checkbox"> Laceration/cut</td>
                                            <td width=""><input name="incident_data[burn_checkbox]" <?php if ($incident_data != null) {
                                                                                                        if ($incident_data->burn_checkbox == 'yes') {
                                                                                                            echo "checked";
                                                                                                        }
                                                                                                    } ?> value="yes" type="checkbox"> Burn scald</td>
                                            <td width=""><input name="incident_data[chemical_checkbox]" <?php if ($incident_data != null) {
                                                                                                            if ($incident_data->chemical_checkbox == 'yes') {
                                                                                                                echo "checked";
                                                                                                            }
                                                                                                        } ?> value="yes" type="checkbox"> Chemical reaction</td>
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
                                            <td colspan="8">Property/ material damaged<textarea name="incident_data[property_damaged]">{{ $incident_data!=null ? $incident_data->property_damaged : '' }}</textarea></td>
                                        </tr>
                                        <tr>
                                            <th colspan="8" style="background-color:#c9ced6;">THE ACCIDENT
                                            </th>
                                        </tr>
                                        <tr>
                                            <td colspan="8">Description - Describe what happened (space overleaf for diagram □ essential for all vehicle accidents)<textarea name="incident_data[desciption]">{{ $incident_data!=null ? $incident_data->desciption : '' }}</textarea></td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">Analysis - What were the causes of the accident?<textarea name="incident_data[analysis]">{{ $incident_data!=null ? $incident_data->analysis : '' }}</textarea></td>
                                        </tr>
                                        <tr>
                                            <td width="50%">HOW BAD COULD IT HAVE BEEN?
                                                <br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" <?php if ($incident_data != null) {
                                                                                                        if ($incident_data->bad_radio == "1") {
                                                                                                            echo 'checked';
                                                                                                        }
                                                                                                    } ?> name="incident_data[bad_radio]" id="inlineRadio1" value="1">
                                                    <label class="form-check-label">Very</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" <?php if ($incident_data != null) {
                                                                                                        if ($incident_data->bad_radio == "2") {
                                                                                                            echo 'checked';
                                                                                                        }
                                                                                                    } ?> name="incident_data[bad_radio]" id="inlineRadio2" value="2">
                                                    <label class="form-check-label">Serious</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" <?php if ($incident_data != null) {
                                                                                                        if ($incident_data->bad_radio == "3") {
                                                                                                            echo 'checked';
                                                                                                        }
                                                                                                    } ?> name="incident_data[bad_radio]" id="inlineRadio3" value="3">
                                                    <label class="form-check-label">Minor Serious</label>
                                                </div>
                                            </td>
                                            <td width="50%">WHAT IS THE CHANCE OF IT HAPPENING AGAIN?
                                                <br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" <?php if ($incident_data != null) {
                                                                                                        if ($incident_data->chance_radio == "1") {
                                                                                                            echo 'checked';
                                                                                                        }
                                                                                                    } ?> name="incident_data[chance_radio]" id="inlineRadio1" value="1">
                                                    <label class="form-check-label">Minor</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" <?php if ($incident_data != null) {
                                                                                                        if ($incident_data->chance_radio == "2") {
                                                                                                            echo 'checked';
                                                                                                        }
                                                                                                    } ?> name="incident_data[chance_radio]" id="inlineRadio2" value="2">
                                                    <label class="form-check-label">Occasional</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" <?php if ($incident_data != null) {
                                                                                                        if ($incident_data->chance_radio == "3") {
                                                                                                            echo 'checked';
                                                                                                        }
                                                                                                    } ?> name="incident_data[chance_radio]" id="inlineRadio3" value="3">
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