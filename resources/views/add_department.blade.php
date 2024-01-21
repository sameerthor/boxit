<div class="modal" id="addDepartmentModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <form id="booking" method="post" action="{{route('add.bookingData')}}">
            @csrf
            <!-- Modal content-->
            <input type="hidden" name="project_id" value="{{$project->id}}">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Add Departments</h4>
                </div>
                <div class="modal-body">
                    @foreach($departments->slice(1) as $department)
                    @if(!in_array($department->id,$department_ids->toArray()))
                    <div class="col-md-12">
                        <div class="row department_group">
                            <div class="col-md-6 form-group p-none bg-shadow">
                                <div class="input-group input-group-xs">
                                    <i class="fa fa-angle-down"></i> <select class="form-control contacts koma"
                                        style="width: 100%;" name="department[{{$department->id}}]" required>
                                        <option value="">{{$department->title}}*</option>
                                        @foreach($department->contacts as $res)
                                        <option value="{{$res->id}}">{{$res->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5 form-group paid-none-r bg-shadow">
                                <i class="fa fa-angle-down"></i> <input name="date[{{$department->id}}]"
                                    class="example dates" type="text" placeholder="Choose Date & Time" required />
                            </div>
                            <div class="col-md-1">
                                <div class="input-group input-group-xs">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input customSwitch" checked
                                            name="status[{{$department->id}}]" value="1"
                                            id="customSwitch{{$department->id}}">
                                        <label class="custom-control-label"
                                            for="customSwitch{{$department->id}}"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($department->id==7)
                        <div class=" row council_36 council_services" style="display:none">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input council-checkboxes"
                                        name="department[{{$department->id}}][Compact Hardfill]" value="36">
                                    <label class="form-check-label">Compact Hardfill</label>
                                </div>
                            </div>
                            <div class="col-md-5 form-group paid-none-r bg-shadow">
                                <i class="fa fa-angle-down"></i> <input
                                    name="date[{{$department->id}}][Compact Hardfill]" class="example dates" type="text"
                                    placeholder="Choose Date & Time" />
                            </div>
                            <br>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input council-checkboxes"
                                        name="department[{{$department->id}}][Pre Pour]" value="36">
                                    <label class="form-check-label">Pre Pour</label>
                                </div>
                            </div>
                            <div class="col-md-5 form-group paid-none-r bg-shadow">
                                <i class="fa fa-angle-down"></i> <input name="date[{{$department->id}}][Pre Pour]"
                                    class="example dates" type="text" placeholder="Choose Date & Time" />
                            </div>
                            <br>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input council-checkboxes"
                                        name="department[{{$department->id}}][Blockwork Inspection]" value="36">
                                    <label class="form-check-label">Blockwork Inspection</label>
                                </div>
                            </div>
                            <div class="col-md-5 form-group paid-none-r bg-shadow">
                                <i class="fa fa-angle-down"></i> <input
                                    name="date[{{$department->id}}][Blockwork Inspection]" class="example dates"
                                    type="text" placeholder="Choose Date & Time" />
                            </div>
                            <br>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input council-checkboxes"
                                        name="department[{{$department->id}}][Waste Pipe Inspection]" value="36">
                                    <label class="form-check-label">Waste Pipe Inspection</label>
                                </div>
                            </div>
                            <div class="col-md-5 form-group paid-none-r bg-shadow">
                                <i class="fa fa-angle-down"></i> <input
                                    name="date[{{$department->id}}][Waste Pipe Inspection]" class="example dates"
                                    type="text" placeholder="Choose Date & Time" />
                            </div>
                            <br>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input council-checkboxes"
                                        name="department[{{$department->id}}][Underslab Drainage Inspection]"
                                        value="36">
                                    <label class="form-check-label">Underslab Drainage Inspection</label>
                                </div>
                            </div>
                            <div class="col-md-5 form-group paid-none-r bg-shadow">
                                <i class="fa fa-angle-down"></i> <input
                                    name="date[{{$department->id}}][Underslab Drainage Inspection]"
                                    class="example dates" type="text" placeholder="Choose Date & Time" />
                            </div>
                            <br>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input council-checkboxes"
                                        name="department[{{$department->id}}][Other]" value="36">
                                    <label class="form-check-label">Other</label>
                                </div>
                            </div>
                            <div class="col-md-5 form-group paid-none-r bg-shadow">
                                <i class="fa fa-angle-down"></i> <input name="date[{{$department->id}}][Other]"
                                    class="example dates" type="text" placeholder="Choose Date & Time" />
                            </div>

                        </div>
                        <div class=" row council_37 council_services" style="display:none">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input council-checkboxes"
                                        name="department[{{$department->id}}][Compact Hardfill]" value="37">
                                    <label class="form-check-label">Compact Hardfill</label>
                                </div>
                            </div>
                            <div class="col-md-5 form-group paid-none-r bg-shadow">
                                <i class="fa fa-angle-down"></i> <input
                                    name="date[{{$department->id}}][Compact Hardfill]" class="example dates" type="text"
                                    placeholder="Choose Date & Time" />
                            </div>
                            <br>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input council-checkboxes"
                                        name="department[{{$department->id}}][Pre Pour]" value="37">
                                    <label class="form-check-label">Pre Pour</label>
                                </div>
                            </div>
                            <div class="col-md-5 form-group paid-none-r bg-shadow">
                                <i class="fa fa-angle-down"></i> <input name="date[{{$department->id}}][Pre Pour]"
                                    class="example dates" type="text" placeholder="Choose Date & Time" />
                            </div>
                            <br>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input council-checkboxes"
                                        name="department[{{$department->id}}][Blockwork Inspection]" value="37">
                                    <label class="form-check-label">Blockwork Inspection</label>
                                </div>
                            </div>
                            <div class="col-md-5 form-group paid-none-r bg-shadow">
                                <i class="fa fa-angle-down"></i> <input
                                    name="date[{{$department->id}}][Blockwork Inspection]" class="example dates"
                                    type="text" placeholder="Choose Date & Time" />
                            </div>
                            <br>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input council-checkboxes"
                                        name="department[{{$department->id}}][Waste Pipe Inspection]" value="37">
                                    <label class="form-check-label">Waste Pipe Inspection</label>
                                </div>
                            </div>
                            <div class="col-md-5 form-group paid-none-r bg-shadow">
                                <i class="fa fa-angle-down"></i> <input
                                    name="date[{{$department->id}}][Waste Pipe Inspection]" class="example dates"
                                    type="text" placeholder="Choose Date & Time" />
                            </div>
                            <br>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input council-checkboxes"
                                        name="department[{{$department->id}}][Underslab Drainage Inspection]"
                                        value="37">
                                    <label class="form-check-label">Underslab Drainage Inspection</label>
                                </div>
                            </div>
                            <div class="col-md-5 form-group paid-none-r bg-shadow">
                                <i class="fa fa-angle-down"></i> <input
                                    name="date[{{$department->id}}][Underslab Drainage Inspection]"
                                    class="example dates" type="text" placeholder="Choose Date & Time" />
                            </div>
                            <br>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input council-checkboxes"
                                        name="department[{{$department->id}}][Other]" value="37">
                                    <label class="form-check-label">Other</label>
                                </div>
                            </div>
                            <div class="col-md-5 form-group paid-none-r bg-shadow">
                                <i class="fa fa-angle-down"></i> <input name="date[{{$department->id}}][Other]"
                                    class="example dates" type="text" placeholder="Choose Date & Time" />
                            </div>

                        </div>
                        <div class=" row council_38 council_services" style="display:none">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input council-checkboxes"
                                        name="department[{{$department->id}}][Compact Hardfill]" value="38">
                                    <label class="form-check-label">Compact Hardfill</label>
                                </div>
                            </div>
                            <div class="col-md-5 form-group paid-none-r bg-shadow">
                                <i class="fa fa-angle-down"></i> <input
                                    name="date[{{$department->id}}][Compact Hardfill]" class="example dates" type="text"
                                    placeholder="Choose Date & Time" />
                            </div>
                            <br>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input council-checkboxes"
                                        name="department[{{$department->id}}][Pre Pour]" value="38">
                                    <label class="form-check-label">Pre Pour</label>
                                </div>
                            </div>
                            <div class="col-md-5 form-group paid-none-r bg-shadow">
                                <i class="fa fa-angle-down"></i> <input name="date[{{$department->id}}][Pre Pour]"
                                    class="example dates" type="text" placeholder="Choose Date & Time" />
                            </div>
                            <br>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input council-checkboxes"
                                        name="department[{{$department->id}}][Blockwork Inspection]" value="38">
                                    <label class="form-check-label">Blockwork Inspection</label>
                                </div>
                            </div>
                            <div class="col-md-5 form-group paid-none-r bg-shadow">
                                <i class="fa fa-angle-down"></i> <input
                                    name="date[{{$department->id}}][Blockwork Inspection]" class="example dates"
                                    type="text" placeholder="Choose Date & Time" />
                            </div>
                            <br>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input council-checkboxes"
                                        name="department[{{$department->id}}][Waste Pipe Inspection]" value="38">
                                    <label class="form-check-label">Waste Pipe Inspection</label>
                                </div>
                            </div>
                            <div class="col-md-5 form-group paid-none-r bg-shadow">
                                <i class="fa fa-angle-down"></i> <input
                                    name="date[{{$department->id}}][Waste Pipe Inspection]" class="example dates"
                                    type="text" placeholder="Choose Date & Time" />
                            </div>
                            <br>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input council-checkboxes"
                                        name="department[{{$department->id}}][Underslab Drainage Inspection]"
                                        value="38">
                                    <label class="form-check-label">Underslab Drainage Inspection</label>
                                </div>
                            </div>
                            <div class="col-md-5 form-group paid-none-r bg-shadow">
                                <i class="fa fa-angle-down"></i> <input
                                    name="date[{{$department->id}}][Underslab Drainage Inspection]"
                                    class="example dates" type="text" placeholder="Choose Date & Time" />
                            </div>
                            <br>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input council-checkboxes"
                                        name="department[{{$department->id}}][Other]" value="38">
                                    <label class="form-check-label">Other</label>
                                </div>
                            </div>
                            <div class="col-md-5 form-group paid-none-r bg-shadow">
                                <i class="fa fa-angle-down"></i> <input name="date[{{$department->id}}][Other]"
                                    class="example dates" type="text" placeholder="Choose Date & Time" />
                            </div>

                        </div>
                        <div class=" row council_39 council_services" style="display:none">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input council-checkboxes"
                                        name="department[{{$department->id}}][Underslab Drainage]" value="39">
                                    <label class="form-check-label">Underslab Drainage</label>
                                </div>
                            </div>
                            <div class="col-md-5 form-group paid-none-r bg-shadow">
                                <i class="fa fa-angle-down"></i> <input
                                    name="date[{{$department->id}}][Underslab Drainage]" class="example dates"
                                    type="text" placeholder="Choose Date & Time" />
                            </div>
                            <br>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input council-checkboxes"
                                        name="department[{{$department->id}}][Pre Pour]" value="39">
                                    <label class="form-check-label">Pre Pour</label>
                                </div>
                            </div>
                            <div class="col-md-5 form-group paid-none-r bg-shadow">
                                <i class="fa fa-angle-down"></i> <input name="date[{{$department->id}}][Pre Pour]"
                                    class="example dates" type="text" placeholder="Choose Date & Time" />
                            </div>
                            <br>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input council-checkboxes"
                                        name="department[{{$department->id}}][Blockwork Inspection]" value="39">
                                    <label class="form-check-label">Blockwork Inspection</label>
                                </div>
                            </div>
                            <div class="col-md-5 form-group paid-none-r bg-shadow">
                                <i class="fa fa-angle-down"></i> <input
                                    name="date[{{$department->id}}][Blockwork Inspection]" class="example dates"
                                    type="text" placeholder="Choose Date & Time" />
                            </div>
                            <br>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input council-checkboxes"
                                        name="department[{{$department->id}}][Waste Pipe Inspection]" value="39">
                                    <label class="form-check-label">Waste Pipe Inspection</label>
                                </div>
                            </div>
                            <div class="col-md-5 form-group paid-none-r bg-shadow">
                                <i class="fa fa-angle-down"></i> <input
                                    name="date[{{$department->id}}][Waste Pipe Inspection]" class="example dates"
                                    type="text" placeholder="Choose Date & Time" />
                            </div>
                            <br>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input council-checkboxes"
                                        name="department[{{$department->id}}][Underslab Drainage Inspection]"
                                        value="39">
                                    <label class="form-check-label">Underslab Drainage Inspection</label>
                                </div>
                            </div>
                            <div class="col-md-5 form-group paid-none-r bg-shadow">
                                <i class="fa fa-angle-down"></i> <input
                                    name="date[{{$department->id}}][Underslab Drainage Inspection]"
                                    class="example dates" type="text" placeholder="Choose Date & Time" />
                            </div>
                            <br>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input council-checkboxes"
                                        name="department[{{$department->id}}][Other]" value="39">
                                    <label class="form-check-label">Other</label>
                                </div>
                            </div>
                            <div class="col-md-5 form-group paid-none-r bg-shadow">
                                <i class="fa fa-angle-down"></i> <input name="date[{{$department->id}}][Other]"
                                    class="example dates" type="text" placeholder="Choose Date & Time" />
                            </div>

                        </div>
                        @endif
                    </div>
                    @endif
                    @endforeach
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
    $("#booking").validate();
    $("#booking").on("submit", function () {
        if ($("#booking").valid()) {
            if ($(".council-checkboxes:checked").length == 0) {
                $('.council_services').remove();
            }
            $('.council_services:hidden').remove();
            if ($(".council-checkboxes:checked").length == 0) {
                $('.council_services').remove();
            }
            $(".contacts").each(function () {
                var text = $(this).find('option:selected').text();
                if (text == 'N/A' || text=='') {
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