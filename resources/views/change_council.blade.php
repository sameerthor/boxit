<div class="modal" id="changeCouncil" role="dialog">
    <div class="modal-dialog modal-lg">
        <form id="councilForm" method="post" action="{{route('changeCouncil')}}">
            @csrf
            <!-- Modal content-->
            <input type="hidden" name="project_id" value="{{$project->id}}">
            <div class=" modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Change Council Department</h4>
                </div>
                <div class="modal-body">

                    @php
                    $council_data = $project->CouncilData->toArray();
                    $council_id=$council_data[0]['contact_id'];
                    $project->CouncilData = collect();
                    foreach ($council_data as $res) {
                    $array[$res['service']] = $res['date'];
                    $project->CouncilData[$res['contact_id']] = $array;
                    $project->CouncilData['status'] = $res['status'];
                    }


                    @endphp
                    <div class="row department_group">
                        <div class="col-md-6 form-group p-none">
                            <div class="input-group input-group-xs">
                                <i class="fa fa-angle-down"></i>
                                <select class="form-control contacts" style="width: 100%;" name="department[7]"
                                    required>
                                    <option value="">Council*</option>
                                    @foreach($contacts->where('department_id', 7)->all() as $res)
                                    <option value="{{$res->id}}" <?php if ($council_id==$res->id) {
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
                            <input name="date[7]" <?php if (@$contact_name=='N/A' || (!array_key_exists("",
                                $project->CouncilData[$council_id]))) {
                            echo "disabled";
                            } ?> class="example dates" value="
                            <?php if (array_key_exists("", $project->CouncilData[$council_id])) {
                                                                                              echo @$project->CouncilData[$council_id][''];
                                                                                            } ?>" type="text"
                            placeholder="Choose Date & Time" required /><i class="fa fa-angle-down"></i>
                        </div>
                        <div class="col-md-1">
                            <div class="input-group input-group-xs">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input customSwitch" <?php if
                                        ($project->CouncilData['status'] != 2) echo 'checked'; ?> name="status[7]"
                                    value="1" id="customSwitch7">
                                    <label class="custom-control-label" for="customSwitch7"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" row council_36 council_services" {{$council_id !='36' ?'style=display:none':''}}>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input council-checkboxes"
                                    {{array_key_exists("Compact Hardfill",$project->CouncilData[$council_id])
                                ?'checked':''}} name="department[7][Compact Hardfill]" value="36">
                                <label class="form-check-label">Compact Hardfill</label>
                            </div>
                        </div>
                        <div class="col-md-5 form-group paid-none-r bg-shadow">
                            <i class="fa fa-angle-down"></i> <input name="date[7][Compact Hardfill]"
                                value="{{@$project->CouncilData[$council_id]['Compact Hardfill']}}"
                                class="example dates" type="text" placeholder="Choose Date & Time" />
                        </div>
                        <br>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input council-checkboxes"
                                    {{array_key_exists('Pre Pour',$project->CouncilData[$council_id])?'checked':''}}
                                name="department[7][Pre Pour]" value="36">
                                <label class="form-check-label">Pre Pour</label>
                            </div>
                        </div>
                        <div class="col-md-5 form-group paid-none-r bg-shadow">
                            <i class="fa fa-angle-down"></i> <input name="date[7][Pre Pour]"
                                value="{{@$project->CouncilData[$council_id]['Pre Pour']}}" class="example dates"
                                type="text" placeholder="Choose Date & Time" />
                        </div>
                        <br>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input council-checkboxes"
                                    {{array_key_exists('Blockwork Inspection',$project->CouncilData[$council_id])?'checked':''}}
                                name="department[7][Blockwork Inspection]" value="36">
                                <label class="form-check-label">Blockwork Inspection</label>
                            </div>
                        </div>
                        <div class="col-md-5 form-group paid-none-r bg-shadow">
                            <i class="fa fa-angle-down"></i> <input name="date[7][Blockwork Inspection]"
                                value="{{@$project->CouncilData[$council_id]['Blockwork Inspection']}}"
                                class="example dates" type="text" placeholder="Choose Date & Time" />
                        </div>
                        <br>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input council-checkboxes"
                                    {{array_key_exists('Waste Pipe Inspection',$project->CouncilData[$council_id])?'checked':''}}
                                    name="department[7][Waste Pipe Inspection]" value="36">
                                <label class="form-check-label">Waste Pipe Inspection</label>
                            </div>
                        </div>
                        <div class="col-md-5 form-group paid-none-r bg-shadow">
                            <i class="fa fa-angle-down"></i> <input name="date[7][Waste Pipe Inspection]"
                                value="{{@$project->CouncilData[$council_id]['Waste Pipe Inspection']}}"
                                class="example dates" type="text" placeholder="Choose Date & Time" />
                        </div>`
                        <br>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input council-checkboxes"
                                    {{array_key_exists('Underslab Drainage Inspection',$project->CouncilData[$council_id])?'checked':''}}
                                name="department[7][Underslab Drainage Inspection]" value="36">
                                <label class="form-check-label">Underslab Drainage Inspection</label>
                            </div>
                        </div>
                        <div class="col-md-5 form-group paid-none-r bg-shadow">
                            <i class="fa fa-angle-down"></i> <input name="date[7][Underslab Drainage Inspection]"
                                value="{{@$project->CouncilData[$council_id]['Underslab Drainage Inspection']}}"
                                class="example dates" type="text" placeholder="Choose Date & Time" />
                        </div>`
                        <br>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input council-checkboxes"
                                    {{array_key_exists('Other',$project->CouncilData[$council_id])?'checked':''}} name="department[7][Other]" value="36">
                                <label class="form-check-label">Other</label>
                            </div>
                        </div>
                        <div class="col-md-5 form-group paid-none-r bg-shadow">
                            <i class="fa fa-angle-down"></i> <input name="date[7][Other]"
                                value="{{@$project->CouncilData[$council_id]['Other']}}" class="example dates"
                                type="text" placeholder="Choose Date & Time" />
                        </div>

                    </div>
                    <div class=" row council_37 council_services" {{$council_id !='37' ?'style=display:none':''}}>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input council-checkboxes"
                                    {{array_key_exists("Compact Hardfill",$project->CouncilData[$council_id])
                                ?'checked':''}} name="department[7][Compact Hardfill]" value="37">
                                <label class="form-check-label">Compact Hardfill</label>
                            </div>
                        </div>
                        <div class="col-md-5 form-group paid-none-r bg-shadow">
                            <i class="fa fa-angle-down"></i> <input name="date[7][Compact Hardfill]"
                                value="{{@$project->CouncilData[$council_id]['Compact Hardfill']}}"
                                class="example dates" type="text" placeholder="Choose Date & Time" />
                        </div>
                        <br>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input council-checkboxes"
                                    {{array_key_exists('Pre Pour',$project->CouncilData[$council_id])?'checked':''}}
                                name="department[7][Pre Pour]" value="37">
                                <label class="form-check-label">Pre Pour</label>
                            </div>
                        </div>
                        <div class="col-md-5 form-group paid-none-r bg-shadow">
                            <i class="fa fa-angle-down"></i> <input name="date[7][Pre Pour]"
                                value="{{@$project->CouncilData[$council_id]['Pre Pour']}}" class="example dates"
                                type="text" placeholder="Choose Date & Time" />
                        </div>
                        <br>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input council-checkboxes"
                                    {{array_key_exists('Blockwork Inspection',$project->CouncilData[$council_id])?'checked':''}}
                                name="department[7][Blockwork Inspection]" value="37">
                                <label class="form-check-label">Blockwork Inspection</label>
                            </div>
                        </div>
                        <div class="col-md-5 form-group paid-none-r bg-shadow">
                            <i class="fa fa-angle-down"></i> <input name="date[7][Blockwork Inspection]"
                                value="{{@$project->CouncilData[$council_id]['Blockwork Inspection']}}"
                                class="example dates" type="text" placeholder="Choose Date & Time" />
                        </div>
                        <br>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input council-checkboxes"
                                    {{array_key_exists('Waste Pipe Inspection',$project->CouncilData[$council_id])?'checked':''}}
                                name="department[7][Waste Pipe Inspection]" value="37">
                                <label class="form-check-label">Waste Pipe Inspection</label>
                            </div>
                        </div>
                        <div class="col-md-5 form-group paid-none-r bg-shadow">
                            <i class="fa fa-angle-down"></i> <input name="date[7][Waste Pipe Inspection]"
                                value="{{@$project->CouncilData[$council_id]['Waste Pipe Inspection']}}"
                                class="example dates" type="text" placeholder="Choose Date & Time" />
                        </div>
                        <br>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input council-checkboxes"
                                    {{array_key_exists('Underslab Drainage Inspection',$project->CouncilData[$council_id])?'checked':''}}
                                name="department[7][Underslab Drainage Inspection]" value="37">
                                <label class="form-check-label">Underslab Drainage Inspection</label>
                            </div>
                        </div>
                        <div class="col-md-5 form-group paid-none-r bg-shadow">
                            <i class="fa fa-angle-down"></i> <input name="date[7][Underslab Drainage Inspection]"
                                value="{{@$project->CouncilData[$council_id]['Underslab Drainage Inspection']}}"
                                class="example dates" type="text" placeholder="Choose Date & Time" />
                        </div>
                        <br>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input council-checkboxes"
                                    {{array_key_exists('Other',$project->CouncilData[$council_id])?'checked':''}}
                                name="department[7][Other]" value="37">
                                <label class="form-check-label">Other</label>
                            </div>
                        </div>
                        <div class="col-md-5 form-group paid-none-r bg-shadow">
                            <i class="fa fa-angle-down"></i> <input name="date[7][Other]"
                                value="{{@$project->CouncilData[$council_id]['Other']}}" class="example dates"
                                type="text" placeholder="Choose Date & Time" />
                        </div>

                    </div>
                    <div class=" row council_38 council_services" {{$council_id !='38' ?'style=display:none':''}}>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input council-checkboxes"
                                    {{array_key_exists("Compact Hardfill",$project->CouncilData[$council_id])
                                ?'checked':''}} name="department[7][Compact Hardfill]" value="38">
                                <label class="form-check-label">Compact Hardfill</label>
                            </div>
                        </div>
                        <div class="col-md-5 form-group paid-none-r bg-shadow">
                            <i class="fa fa-angle-down"></i> <input name="date[7][Compact Hardfill]"
                                value="{{@$project->CouncilData[$council_id]['Compact Hardfill']}}"
                                class="example dates" type="text" placeholder="Choose Date & Time" />
                        </div>
                        <br>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input council-checkboxes"
                                    {{array_key_exists('Pre Pour',$project->CouncilData[$council_id])?'checked':''}}
                                name="department[7][Pre Pour]" value="38">
                                <label class="form-check-label">Pre Pour</label>
                            </div>
                        </div>
                        <div class="col-md-5 form-group paid-none-r bg-shadow">
                            <i class="fa fa-angle-down"></i> <input name="date[7][Pre Pour]"
                                value="{{@$project->CouncilData[$council_id]['Pre Pour']}}" class="example dates"
                                type="text" placeholder="Choose Date & Time" />
                        </div>
                        <br>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input council-checkboxes"
                                    {{array_key_exists('Blockwork Inspection',$project->CouncilData[$council_id])?'checked':''}}
                                name="department[7][Blockwork Inspection]" value="38">
                                <label class="form-check-label">Blockwork Inspection</label>
                            </div>
                        </div>
                        <div class="col-md-5 form-group paid-none-r bg-shadow">
                            <i class="fa fa-angle-down"></i> <input name="date[7][Blockwork Inspection]"
                                value="{{@$project->CouncilData[$council_id]['Blockwork Inspection']}}"
                                class="example dates" type="text" placeholder="Choose Date & Time" />
                        </div>
                        <br>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input council-checkboxes"
                                    {{array_key_exists('Waste Pipe Inspection',$project->CouncilData[$council_id])?'checked':''}}
                                name="department[7][Waste Pipe Inspection]" value="38">
                                <label class="form-check-label">Waste Pipe Inspection</label>
                            </div>
                        </div>
                        <div class="col-md-5 form-group paid-none-r bg-shadow">
                            <i class="fa fa-angle-down"></i> <input name="date[7][Waste Pipe Inspection]"
                                value="{{@$project->CouncilData[$council_id]['Waste Pipe Inspection']}}"
                                class="example dates" type="text" placeholder="Choose Date & Time" />
                        </div>
                        <br>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input council-checkboxes"
                                    {{array_key_exists('Underslab Drainage Inspection',$project->CouncilData[$council_id])?'checked':''}}
                                name="department[7][Underslab Drainage Inspection]" value="38">
                                <label class="form-check-label">Underslab Drainage Inspection</label>
                            </div>
                        </div>
                        <div class="col-md-5 form-group paid-none-r bg-shadow">
                            <i class="fa fa-angle-down"></i> <input name="date[7][Underslab Drainage Inspection]"
                                value="{{@$project->CouncilData[$council_id]['Underslab Drainage Inspection']}}"
                                class="example dates" type="text" placeholder="Choose Date & Time" />
                        </div>
                        <br>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input council-checkboxes"
                                    {{array_key_exists('Other',$project->CouncilData[$council_id])?'checked':''}}
                                name="department[7][Other]" value="38">
                                <label class="form-check-label">Other</label>
                            </div>
                        </div>
                        <div class="col-md-5 form-group paid-none-r bg-shadow">
                            <i class="fa fa-angle-down"></i> <input name="date[7][Other]"
                                value="{{@$project->CouncilData[$council_id]['Other']}}" class="example dates"
                                type="text" placeholder="Choose Date & Time" />
                        </div>

                    </div>
                    <div class=" row council_39 council_services" {{$council_id !='39' ?'style=display:none':''}}>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input council-checkboxes"
                                    {{array_key_exists("Underslab Drainage",$project->CouncilData[$council_id])
                                ?'checked':''}} name="department[7][Underslab Drainage]" value="39">
                                <label class="form-check-label">Underslab Drainage</label>
                            </div>
                        </div>
                        <div class="col-md-5 form-group paid-none-r bg-shadow">
                            <i class="fa fa-angle-down"></i> <input name="date[7][Underslab Drainage]"
                                value="{{@$project->CouncilData[$council_id]['Underslab Drainage']}}"
                                class="example dates" type="text" placeholder="Choose Date & Time" />
                        </div>
                        <br>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input council-checkboxes"
                                    {{array_key_exists('Pre Pour',$project->CouncilData[$council_id])?'checked':''}}
                                name="department[7][Pre Pour]" value="39">
                                <label class="form-check-label">Pre Pour</label>
                            </div>
                        </div>
                        <div class="col-md-5 form-group paid-none-r bg-shadow">
                            <i class="fa fa-angle-down"></i> <input name="date[7][Pre Pour]"
                                value="{{@$project->CouncilData[$council_id]['Pre Pour']}}" class="example dates"
                                type="text" placeholder="Choose Date & Time" />
                        </div>
                        <br>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input council-checkboxes"
                                    {{array_key_exists('Blockwork Inspection',$project->CouncilData[$council_id])?'checked':''}}
                                name="department[7][Blockwork Inspection]" value="39">
                                <label class="form-check-label">Blockwork Inspection</label>
                            </div>
                        </div>
                        <div class="col-md-5 form-group paid-none-r bg-shadow">
                            <i class="fa fa-angle-down"></i> <input name="date[7][Blockwork Inspection]"
                                value="{{@$project->CouncilData[$council_id]['Blockwork Inspection']}}"
                                class="example dates" type="text" placeholder="Choose Date & Time" />
                        </div>
                        <br>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input council-checkboxes"
                                    {{array_key_exists('Waste Pipe Inspection',$project->CouncilData[$council_id])?'checked':''}}
                                name="department[7][Waste Pipe Inspection]" value="39">
                                <label class="form-check-label">Waste Pipe Inspection</label>
                            </div>
                        </div>
                        <div class="col-md-5 form-group paid-none-r bg-shadow">
                            <i class="fa fa-angle-down"></i> <input name="date[7][Waste Pipe Inspection]"
                                value="{{@$project->CouncilData[$council_id]['Waste Pipe Inspection']}}"
                                class="example dates" type="text" placeholder="Choose Date & Time" />
                        </div>
                        <br>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input council-checkboxes"
                                    {{array_key_exists('Underslab Drainage Inspection',$project->CouncilData[$council_id])?'checked':''}}
                                name="department[7][Underslab Drainage Inspection]" value="39">
                                <label class="form-check-label">Underslab Drainage Inspection</label>
                            </div>
                        </div>
                        <div class="col-md-5 form-group paid-none-r bg-shadow">
                            <i class="fa fa-angle-down"></i> <input name="date[7][Underslab Drainage Inspection]"
                                value="{{@$project->CouncilData[$council_id]['Underslab Drainage Inspection']}}"
                                class="example dates" type="text" placeholder="Choose Date & Time" />
                        </div>`
                        <br>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input council-checkboxes"
                                    {{array_key_exists('Other',$project->CouncilData[$council_id])?'checked':''}}
                                name="department[7][Other]" value="39">
                                <label class="form-check-label">Other</label>
                            </div>
                        </div>
                        <div class="col-md-5 form-group paid-none-r bg-shadow">
                            <i class="fa fa-angle-down"></i> <input name="date[7][Other]"
                                value="{{@$project->CouncilData[$council_id]['Other']}}" class="example dates"
                                type="text" placeholder="Choose Date & Time" />
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary btn-sm">Save</button>
                    <button type="button" class="btn btn-secondary btn-sm cancel">Cancel</button>
                </div>
            </div>

        </form>

    </div>
</div>
<script>
    $(".council_services").each(function () {
        $(this).find("input:checkbox:checked").attr("disabled", true)
        $(this).find("input:checkbox:checked").removeAttr("name");
        $(this).find('input:text[value!=""]').removeAttr("name");
        $(this).find('input:text[value!=""]').attr("readonly",true);
        $(this).find('input:text[value!=""]').attr("disabled",true);
    });


    $("select[name='department[7]']").on("change", function () {
        var val = $(this).val();
        $(".council_services").hide();
        if (val == 36 || val == 37 || val == 38 || val == 39) {
            $(".council_" + val).show();
        } else {
            $(".council-checkboxes").prop('checked', false);
        }
    });

    $(".council-checkboxes").on("change", function () {
        console.log("test");
        if ($(".council-checkboxes:checked").length > 0) {
            $("input[name='date[7]']").prop('disabled', true);
        } else {
            $("input[name='date[7]']").prop('disabled', false);
        }
    });
    $("#councilForm").validate();
    $("#councilForm").on("submit", function () {
        if ($("#councilForm").valid()) {
            if ($(".council-checkboxes:checked").length == 0) {
                $('.council_services').remove();
            }
            $('.council_services:hidden').remove();
            if ($(".council-checkboxes:checked").length == 0) {
                $('.council_services').remove();
            }
            $(".contacts").each(function () {
                var text = $(this).find('option:selected').text();
                if (text == 'N/A') {
                    $(this).parents('.department_group').remove();
                }
            });
            return true;
        } else {
            return false;
        }
    })

    $(".contacts").on("change", function () {
        var text = $(this).find('option:selected').text();
        if (text == 'N/A') {
            $(this).parents('.department_group').find('.dates').prop('disabled', true);
        } else {
            $(this).parents('.department_group').find('.dates').prop('disabled', false);

        }
    });

</script>