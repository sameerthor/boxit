@extends('layouts.app')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.js"></script>
<style>
  .remove_file {
    position: absolute;
    top: -15px;
    right: -5px;
  }

  .file_container {
    display: inline-block;
    position: relative;
    padding: 5px;
  }
</style>
<div id="content">
  <div class="container booking-form-w">
    <div class="row d-flex">
      <div class="col-md-10">
        <div class="form-head">
          <span>Draft</span>
        </div>
      </div>
      <div class="col-md-2 book-draft-btn">
        <button type="button" class="btn btn-info draft btn-color">Save as draft</button>
      </div>
    </div>
    <br>
    <div class="row">

      <form id="booking" method="post" action="{{ url('booking') }}" enctype="multipart/form-data">
        @csrf
        <input type="text" name="draft_id" value="{{$draft->id}}" style="display:none">
        <div class="center_div">
          <div class="row">
            <div class="form-group col-md-4">
              <input name="bcn" required value="{{$draft->bcn}}" type="text" placeholder="BCN" />
            </div>
            <div class="form-group col-md-4">
              <input name="address" required value="{{$draft->address}}" type="text" placeholder="Address*" required />
            </div>
            <div class="form-group col-md-4">
              <i id="pos-r" class="fa fa-angle-down"></i>
              <select class="form-control" style="width: 100%;" name="department[{{$departments[0]->id}}]" required>
                <option value="" disabled>Building Company*</option>
                @foreach($departments[0]->contacts as $res)
                <option value="{{$res->id}}" <?php if ($draft->DraftData[1][0]->contact_id == $res->id) {
                                                echo "selected";
                                              } ?>>{{$res->title}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-6">
              <input name="floor_type" required type="text" value="{{$draft->floor_type}}" placeholder="Floor Type*" />
            </div>
            <div class="form-group col-md-6">
              <input name="floor_area" required type="text" value="{{$draft->floor_area}}" placeholder="Floor Area*" />
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-md-6 form-group">
              <div class="input-group input-group-xs">
                <i class="fa fa-angle-down"></i> <select class="form-control" style="width: 100%;" name="foreman" required>
                  <option value="" disabled selected>Foreman*</option>
                  @foreach($foreman as $res)
                  <option value="{{$res->id}}" <?php if ($draft->foreman_id == $res->id) {
                                                  echo "selected";
                                                } ?>>{{ucfirst($res->name)}}</option>
                  @endforeach
                </select>

              </div>
            </div>
            @foreach($departments->slice(1) as $department)

            <div class="col-md-6">
              @if($department->id!='7')
              <div class="row department_group">
                <div class="col-md-6 form-group p-none">
                  <div class="input-group input-group-xs">
                    <i class="fa fa-angle-down"></i>
                    <select class="form-control contacts" style="width: 100%;" name="department[{{$department->id}}]" required>
                      <option value="">{{$department->title}}*</option>
                      @foreach($department->contacts as $res)
                      <option value="{{$res->id}}" <?php if (@$draft->DraftData[$department->id-1][0]->contact_id == $res->id) {
                                                      echo "selected";
                                                      $contact_name = $res->title;
                                                    } else {
                                                      $contact_name = '';
                                                    } ?>>{{$res->title}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-5 form-group paid-none-r">
                  <input name="date[{{$department->id}}]" <?php if (@$contact_name == 'N/A') {
                                                            echo "disabled";
                                                          } ?> class="example dates" value="<?php echo @$draft->DraftData[$department->id-1][0]->date; ?>" type="text" placeholder="Choose Date & Time" required /><i class="fa fa-angle-down"></i>
                </div>
                <div class="col-md-1">
                  <div class="input-group input-group-xs">
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input customSwitch" <?php if (@$draft->DraftData[$department->id-1][0]->status != 2) echo 'checked'; ?> name="status[{{$department->id}}]" value="1" id="customSwitch{{$department->id}}">
                      <label class="custom-control-label" for="customSwitch{{$department->id}}"></label>
                    </div>
                  </div>
                </div>
              </div>
              @else
              @php
              $council_id=$draft->DraftData[$department->id]->keys()->first();
              @endphp
              <div class="row department_group">
                <div class="col-md-6 form-group p-none">
                  <div class="input-group input-group-xs">
                    <i class="fa fa-angle-down"></i>
                    <select class="form-control contacts" style="width: 100%;" name="department[{{$department->id}}]" required>
                      <option value="">{{$department->title}}*</option>
                      @foreach($department->contacts as $res)
                      <option value="{{$res->id}}" <?php if ($council_id == $res->id) {
                                                      echo "selected";
                                                      $contact_name = $res->title;
                                                    } else {
                                                      $contact_name = '';
                                                    } ?>>{{$res->title}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-5 form-group paid-none-r">
                  <input name="date[{{$department->id}}]" <?php if (@$contact_name == 'N/A' || (!array_key_exists("",$draft->DraftData[$department->id][$council_id]))) {
                                                            echo "disabled";
                                                          } ?> class="example dates" value="<?php if(array_key_exists("",$draft->DraftData[$department->id][$council_id])){echo @$draft->DraftData[$department->id][$council_id][''];} ?>" type="text" placeholder="Choose Date & Time" required /><i class="fa fa-angle-down"></i>
                </div>
                <div class="col-md-1">
                  <div class="input-group input-group-xs">
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input customSwitch" <?php if ($draft->DraftData[$department->id]['status'] != 2) echo 'checked'; ?> name="status[{{$department->id}}]" value="1" id="customSwitch{{$department->id}}">
                      <label class="custom-control-label" for="customSwitch{{$department->id}}"></label>
                    </div>
                  </div>
                </div>
              </div>
              <div class=" row council_36 council_services" {{$council_id != '36'?'style=display:none':''}}>
                <div class="col-md-6">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input council-checkboxes" {{array_key_exists("Compact Hardfill",$draft->DraftData[$department->id][$council_id]) ?'checked':''}} name="department[{{$department->id}}][Compact Hardfill]" value="36">
                    <label class="form-check-label">Compact Hardfill</label>
                  </div>
                </div>
                <div class="col-md-5 form-group paid-none-r bg-shadow">
                  <i class="fa fa-angle-down"></i> <input name="date[{{$department->id}}][Compact Hardfill]" value="{{@$draft->DraftData[$department->id][$council_id]['Compact Hardfill']}}" class="example dates" type="text" placeholder="Choose Date & Time" />
                </div>
                <br>
                <div class="col-md-6">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input council-checkboxes" {{array_key_exists('Pre Pour',$draft->DraftData[$department->id][$council_id])?'checked':''}} name="department[{{$department->id}}][Pre Pour]" value="36">
                    <label class="form-check-label">Pre Pour</label>
                  </div>
                </div>
                <div class="col-md-5 form-group paid-none-r bg-shadow">
                  <i class="fa fa-angle-down"></i> <input name="date[{{$department->id}}][Pre Pour]" value="{{@$draft->DraftData[$department->id][$council_id]['Pre Pour']}}" class="example dates" type="text" placeholder="Choose Date & Time" />
                </div>
                <br>
                <div class="col-md-6">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input council-checkboxes" {{array_key_exists('Blockwork Inspection',$draft->DraftData[$department->id][$council_id])?'checked':''}} name="department[{{$department->id}}][Blockwork Inspection]" value="36">
                    <label class="form-check-label">Blockwork Inspection</label>
                  </div>
                </div>
                <div class="col-md-5 form-group paid-none-r bg-shadow">
                  <i class="fa fa-angle-down"></i> <input name="date[{{$department->id}}][Blockwork Inspection]" value="{{@$draft->DraftData[$department->id][$council_id]['Blockwork Inspection']}}"  class="example dates" type="text" placeholder="Choose Date & Time" />
                </div>
                <br>
                <div class="col-md-6">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input council-checkboxes" {{array_key_exists('Waste Pipe Inspection',$draft->DraftData[$department->id][$council_id])?'checked':''}} name="department[{{$department->id}}][Waste Pipe Inspection]" value="36">
                    <label class="form-check-label">Waste Pipe Inspection</label>
                  </div>
                </div>
                <div class="col-md-5 form-group paid-none-r bg-shadow">
                  <i class="fa fa-angle-down"></i> <input name="date[{{$department->id}}][Waste Pipe Inspection]" value="{{@$draft->DraftData[$department->id][$council_id]['Waste Pipe Inspection']}}" class="example dates" type="text" placeholder="Choose Date & Time" />
                </div>
                <br>
                <div class="col-md-6">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input council-checkboxes" {{array_key_exists('Other',$draft->DraftData[$department->id][$council_id])?'checked':''}} name="department[{{$department->id}}][Other]" value="36">
                    <label class="form-check-label">Other</label>
                  </div>
                </div>
                <div class="col-md-5 form-group paid-none-r bg-shadow">
                  <i class="fa fa-angle-down"></i> <input name="date[{{$department->id}}][Other]" value="{{@$draft->DraftData[$department->id][$council_id]['Other']}}" class="example dates" type="text" placeholder="Choose Date & Time" />
                </div>

              </div>
              <div class=" row council_37 council_services" {{$council_id != '37'?'style=display:none':''}}>
                <div class="col-md-6">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input council-checkboxes" {{array_key_exists("Compact Hardfill",$draft->DraftData[$department->id][$council_id]) ?'checked':''}} name="department[{{$department->id}}][Compact Hardfill]" value="37">
                    <label class="form-check-label">Compact Hardfill</label>
                  </div>
                </div>
                <div class="col-md-5 form-group paid-none-r bg-shadow">
                  <i class="fa fa-angle-down"></i> <input name="date[{{$department->id}}][Compact Hardfill]" value="{{@$draft->DraftData[$department->id][$council_id]['Compact Hardfill']}}" class="example dates" type="text" placeholder="Choose Date & Time" />
                </div>
                <br>
                <div class="col-md-6">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input council-checkboxes" {{array_key_exists('Pre Pour',$draft->DraftData[$department->id][$council_id])?'checked':''}} name="department[{{$department->id}}][Pre Pour]" value="37">
                    <label class="form-check-label">Pre Pour</label>
                  </div>
                </div>
                <div class="col-md-5 form-group paid-none-r bg-shadow">
                  <i class="fa fa-angle-down"></i> <input name="date[{{$department->id}}][Pre Pour]" value="{{@$draft->DraftData[$department->id][$council_id]['Pre Pour']}}" class="example dates" type="text" placeholder="Choose Date & Time" />
                </div>
                <br>
                <div class="col-md-6">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input council-checkboxes" {{array_key_exists('Blockwork Inspection',$draft->DraftData[$department->id][$council_id])?'checked':''}} name="department[{{$department->id}}][Blockwork Inspection]" value="37">
                    <label class="form-check-label">Blockwork Inspection</label>
                  </div>
                </div>
                <div class="col-md-5 form-group paid-none-r bg-shadow">
                  <i class="fa fa-angle-down"></i> <input name="date[{{$department->id}}][Blockwork Inspection]" value="{{@$draft->DraftData[$department->id][$council_id]['Blockwork Inspection']}}"  class="example dates" type="text" placeholder="Choose Date & Time" />
                </div>
                <br>
                <div class="col-md-6">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input council-checkboxes" {{array_key_exists('Waste Pipe Inspection',$draft->DraftData[$department->id][$council_id])?'checked':''}} name="department[{{$department->id}}][Waste Pipe Inspection]" value="37">
                    <label class="form-check-label">Waste Pipe Inspection</label>
                  </div>
                </div>
                <div class="col-md-5 form-group paid-none-r bg-shadow">
                  <i class="fa fa-angle-down"></i> <input name="date[{{$department->id}}][Waste Pipe Inspection]" value="{{@$draft->DraftData[$department->id][$council_id]['Waste Pipe Inspection']}}" class="example dates" type="text" placeholder="Choose Date & Time" />
                </div>
                <br>
                <div class="col-md-6">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input council-checkboxes" {{array_key_exists('Other',$draft->DraftData[$department->id][$council_id])?'checked':''}} name="department[{{$department->id}}][Other]" value="37">
                    <label class="form-check-label">Other</label>
                  </div>
                </div>
                <div class="col-md-5 form-group paid-none-r bg-shadow">
                  <i class="fa fa-angle-down"></i> <input name="date[{{$department->id}}][Other]" value="{{@$draft->DraftData[$department->id][$council_id]['Other']}}" class="example dates" type="text" placeholder="Choose Date & Time" />
                </div>

              </div>
              <div class=" row council_38 council_services" {{$council_id != '38'?'style=display:none':''}}>
                <div class="col-md-6">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input council-checkboxes" {{array_key_exists("Compact Hardfill",$draft->DraftData[$department->id][$council_id]) ?'checked':''}} name="department[{{$department->id}}][Compact Hardfill]" value="38">
                    <label class="form-check-label">Compact Hardfill</label>
                  </div>
                </div>
                <div class="col-md-5 form-group paid-none-r bg-shadow">
                  <i class="fa fa-angle-down"></i> <input name="date[{{$department->id}}][Compact Hardfill]" value="{{@$draft->DraftData[$department->id][$council_id]['Compact Hardfill']}}" class="example dates" type="text" placeholder="Choose Date & Time" />
                </div>
                <br>
                <div class="col-md-6">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input council-checkboxes" {{array_key_exists('Pre Pour',$draft->DraftData[$department->id][$council_id])?'checked':''}} name="department[{{$department->id}}][Pre Pour]" value="38">
                    <label class="form-check-label">Pre Pour</label>
                  </div>
                </div>
                <div class="col-md-5 form-group paid-none-r bg-shadow">
                  <i class="fa fa-angle-down"></i> <input name="date[{{$department->id}}][Pre Pour]" value="{{@$draft->DraftData[$department->id][$council_id]['Pre Pour']}}" class="example dates" type="text" placeholder="Choose Date & Time" />
                </div>
                <br>
                <div class="col-md-6">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input council-checkboxes" {{array_key_exists('Blockwork Inspection',$draft->DraftData[$department->id][$council_id])?'checked':''}} name="department[{{$department->id}}][Blockwork Inspection]" value="38">
                    <label class="form-check-label">Blockwork Inspection</label>
                  </div>
                </div>
                <div class="col-md-5 form-group paid-none-r bg-shadow">
                  <i class="fa fa-angle-down"></i> <input name="date[{{$department->id}}][Blockwork Inspection]" value="{{@$draft->DraftData[$department->id][$council_id]['Blockwork Inspection']}}"  class="example dates" type="text" placeholder="Choose Date & Time" />
                </div>
                <br>
                <div class="col-md-6">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input council-checkboxes" {{array_key_exists('Waste Pipe Inspection',$draft->DraftData[$department->id][$council_id])?'checked':''}} name="department[{{$department->id}}][Waste Pipe Inspection]" value="38">
                    <label class="form-check-label">Waste Pipe Inspection</label>
                  </div>
                </div>
                <div class="col-md-5 form-group paid-none-r bg-shadow">
                  <i class="fa fa-angle-down"></i> <input name="date[{{$department->id}}][Waste Pipe Inspection]" value="{{@$draft->DraftData[$department->id][$council_id]['Waste Pipe Inspection']}}" class="example dates" type="text" placeholder="Choose Date & Time" />
                </div>
                <br>
                <div class="col-md-6">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input council-checkboxes" {{array_key_exists('Other',$draft->DraftData[$department->id][$council_id])?'checked':''}} name="department[{{$department->id}}][Other]" value="38">
                    <label class="form-check-label">Other</label>
                  </div>
                </div>
                <div class="col-md-5 form-group paid-none-r bg-shadow">
                  <i class="fa fa-angle-down"></i> <input name="date[{{$department->id}}][Other]" value="{{@$draft->DraftData[$department->id][$council_id]['Other']}}" class="example dates" type="text" placeholder="Choose Date & Time" />
                </div>

              </div>
              <div class=" row council_39 council_services" {{$council_id != '39'?'style=display:none':''}}>
                <div class="col-md-6">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input council-checkboxes" {{array_key_exists("Underslab Drainage",$draft->DraftData[$department->id][$council_id]) ?'checked':''}} name="department[{{$department->id}}][Underslab Drainage]" value="39">
                    <label class="form-check-label">Underslab Drainage</label>
                  </div>
                </div>
                <div class="col-md-5 form-group paid-none-r bg-shadow">
                  <i class="fa fa-angle-down"></i> <input name="date[{{$department->id}}][Underslab Drainage]" value="{{@$draft->DraftData[$department->id][$council_id]['Underslab Drainage']}}" class="example dates" type="text" placeholder="Choose Date & Time" />
                </div>
                <br>
                <div class="col-md-6">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input council-checkboxes" {{array_key_exists('Pre Pour',$draft->DraftData[$department->id][$council_id])?'checked':''}} name="department[{{$department->id}}][Pre Pour]" value="39">
                    <label class="form-check-label">Pre Pour</label>
                  </div>
                </div>
                <div class="col-md-5 form-group paid-none-r bg-shadow">
                  <i class="fa fa-angle-down"></i> <input name="date[{{$department->id}}][Pre Pour]" value="{{@$draft->DraftData[$department->id][$council_id]['Pre Pour']}}" class="example dates" type="text" placeholder="Choose Date & Time" />
                </div>
                <br>
                <div class="col-md-6">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input council-checkboxes" {{array_key_exists('Blockwork Inspection',$draft->DraftData[$department->id][$council_id])?'checked':''}} name="department[{{$department->id}}][Blockwork Inspection]" value="39">
                    <label class="form-check-label">Blockwork Inspection</label>
                  </div>
                </div>
                <div class="col-md-5 form-group paid-none-r bg-shadow">
                  <i class="fa fa-angle-down"></i> <input name="date[{{$department->id}}][Blockwork Inspection]" value="{{@$draft->DraftData[$department->id][$council_id]['Blockwork Inspection']}}"  class="example dates" type="text" placeholder="Choose Date & Time" />
                </div>
                <br>
                <div class="col-md-6">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input council-checkboxes" {{array_key_exists('Waste Pipe Inspection',$draft->DraftData[$department->id][$council_id])?'checked':''}} name="department[{{$department->id}}][Waste Pipe Inspection]" value="39">
                    <label class="form-check-label">Waste Pipe Inspection</label>
                  </div>
                </div>
                <div class="col-md-5 form-group paid-none-r bg-shadow">
                  <i class="fa fa-angle-down"></i> <input name="date[{{$department->id}}][Waste Pipe Inspection]" value="{{@$draft->DraftData[$department->id][$council_id]['Waste Pipe Inspection']}}" class="example dates" type="text" placeholder="Choose Date & Time" />
                </div>
                <br>
                <div class="col-md-6">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input council-checkboxes" {{array_key_exists('Other',$draft->DraftData[$department->id][$council_id])?'checked':''}} name="department[{{$department->id}}][Other]" value="39">
                    <label class="form-check-label">Other</label>
                  </div>
                </div>
                <div class="col-md-5 form-group paid-none-r bg-shadow">
                  <i class="fa fa-angle-down"></i> <input name="date[{{$department->id}}][Other]" value="{{@$draft->DraftData[$department->id][$council_id]['Other']}}" class="example dates" type="text" placeholder="Choose Date & Time" />
                </div>

              </div>
              @endif
            </div>
            @endforeach
          </div>

          <div class="row">

            <div class="form-group increment col-md-12">
              <label>Files</label>
              <br>
              @if(!empty($draft->file))
              @foreach($draft->file as $f)
              <div class="file_container"><input type="hidden" name="existing_file[]" value="{{$f}}"><a href="/images/{{$f}}" target="_blank"><embed style="width:100px;height:100px" src="/images/{{$f}}"></embed></a>
                <div class="remove_file"><i class="fa fa-trash" aria-hidden="true"></i></div>
              </div>
              @endforeach
              @endif
              <input type="file" style="padding-top: 6px !important; padding-left:12px !important;" name="file_upload[]" class="myfrm form-control">
              <div class="add_html icon-pls" style="float: right;"><i class="fa fa-plus" aria-hidden="true"></i></div>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-12">
              <textarea placeholder="Notes" name="notes">{{$draft->notes}}</textarea>

            </div>
            <div class="col-md-2">
              <div class="form-btn">
                <input class="submit" type="submit" value="Submit">
              </div>
            </div>
          </div>

          <div class="clone hide" style="display:none">
            <div class="hdtuto control-group lst input-group" style="margin-top:10px">
              <input type="file" name="file_upload[]" style="padding-top: 6px !important; padding-left:12px !important;" class="myfrm form-control">
              <div class="remove" style="float: right;"><i class="fa fa-trash" aria-hidden="true"></i>
              </div>
            </div>
          </div>
      </form>
    </div>
  </div>


</div>
<script>
  $("select[name='department[7]']").on("change", function() {
    var val = $(this).val();
    $(".council_services").hide();
    if (val == 36 || val == 37 || val == 38 || val == 39) {
      $(".council_" + val).show();
    } else {
      $(".council-checkboxes").prop('checked', false);
    }
  });

  $(".council-checkboxes").on("change", function() {
    console.log("test");
    if ($(".council-checkboxes:checked").length > 0) {
      $("input[name='date[7]']").prop('disabled', true);
    } else {
      $("input[name='date[7]']").prop('disabled', false);
    }
  });


  $(".draft").click(function() {
    if ($('input[name="address"]').val() == '') {
      alert("Please enter address to save as draft.");
      return false;
    }
    $('.council_services:hidden').remove();
      if ($(".council-checkboxes:checked").length == 0) {
        $('.council_services').remove();
    }
    var form = $('#booking')[0];
    var formData = new FormData(form);
    $.ajax({
      url: "{{ url('/save-draft') }}",
      method: "post",
      processData: false,
      contentType: false,
      data: formData,
      success: function(id) {
        window.location.href = "/draft/" + id;
      }
    });
  });


  $("#booking").on("submit", function() {
    if ($("#booking").valid()) {
      $('.council_services:hidden').remove();
      if ($(".council-checkboxes:checked").length == 0) {
        $('.council_services').remove();
    }
      $(".contacts").each(function() {
        var text = $(this).find('option:selected').text();
        if (text == 'N/A') {
          $(this).parents('.department_group').remove();
        }
      });
      return false;
    } else {
      return false;
    }
  })
  $("#booking").validate();
  $(function() {
    $.datetimepicker.setDateFormatter('moment');
    $('.example').datetimepicker({
      format: 'DD-MM-YYYY h:mm A',
      formatTime: "h:mm A",
      step: 15
    });

    $(".example").attr("autocomplete", "off");
  });
  $(document).ready(function() {
    $(".add_html").click(function() {
      var lsthmtl = $(".clone").html();
      $(".increment").append(lsthmtl);
    });
    $("body").on("click", ".remove_file", function() {
      $(this).parents(".file_container").remove();
    });

    $("body").on("click", ".remove", function() {
      $(this).parents(".hdtuto").remove();
    });
  });


  $(".contacts").on("change", function() {
    var text = $(this).find('option:selected').text();
    if (text == 'N/A') {
      $(this).parents('.department_group').find('.dates').prop('disabled', true);
    } else {
      $(this).parents('.department_group').find('.dates').prop('disabled', false);

    }
  });
</script>
@endsection