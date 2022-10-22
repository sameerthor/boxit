<style>
    input[type="range"] {
        width: 30px;
    }


    .screen-reader-only {
        position: absolute;
        top: -9999px;
        left: -9999px;
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
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div style="padding:5%" d class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="1-tab">
                        <form>
                            <div class="row">
                                <div>
                                    <table class="table">
                                        
                                        <tbody>
                                            
                                            <tr>
                                                <td>Marked out</td>
                                                <td>
                                                    <div id="file1" class="btn-group" data-toggle="buttons">
                                                        <label class="btn btn-success btn-sm"><input type="radio" name="radioGroup2" value="yes">Yes</label>
                                                        <label class="btn btn-danger btn-sm"><input type="radio" name="radioGroup2" onclick="$('#mandatory1').val('no');">No</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Digout complete</td>
                                                <td>
                                                <div id="file2" class="btn-group" data-toggle="buttons">
                                                        <label class="btn btn-success btn-sm"><input type="radio" name="radioGroup2" value="yes">Yes</label>
                                                        <label class="btn btn-danger btn-sm"><input type="radio" name="radioGroup2" onclick="$('#mandatory1').val('no');">No</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Pods delivered</td>
                                                <td>
                                                <div id="file3" class="btn-group" data-toggle="buttons">
                                                        <label class="btn btn-success btn-sm"><input type="radio" name="radioGroup2" value="yes">Yes</label>
                                                        <label class="btn btn-danger btn-sm"><input type="radio" name="radioGroup2" onclick="$('#mandatory1').val('no');">No</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Steel delivered</td>
                                                <td>
                                                <div id="file3" class="btn-group" data-toggle="buttons">
                                                        <label class="btn btn-success btn-sm"><input type="radio" name="radioGroup2" value="yes">Yes</label>
                                                        <label class="btn btn-danger btn-sm"><input type="radio" name="radioGroup2" onclick="$('#mandatory1').val('no');">No</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Plumber complete</td>
                                                <td>
                                                <div id="file3" class="btn-group" data-toggle="buttons">
                                                        <label class="btn btn-success btn-sm"><input type="radio" name="radioGroup2" value="yes">Yes</label>
                                                        <label class="btn btn-danger btn-sm"><input type="radio" name="radioGroup2" onclick="$('#mandatory1').val('no');">No</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Mark</td>
                                                <td>
                                                <div id="file3" class="btn-group" data-toggle="buttons">
                                                        <label class="btn btn-success btn-sm"><input type="radio" name="radioGroup2" value="yes">Yes</label>
                                                        <label class="btn btn-danger btn-sm"><input type="radio" name="radioGroup2" onclick="$('#mandatory1').val('no');">No</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Ready to inspect</td>
                                                <td>
                                                <div id="file3" class="btn-group" data-toggle="buttons">
                                                        <label class="btn btn-success btn-sm"><input type="radio" name="radioGroup2" value="yes">Yes</label>
                                                        <label class="btn btn-danger btn-sm"><input type="radio" name="radioGroup2" onclick="$('#mandatory1').val('no');">No</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Engineer inspection passed</td>
                                                <td>
                                                <div id="file3" class="btn-group" data-toggle="buttons">
                                                        <label class="btn btn-success btn-sm"><input type="radio" name="radioGroup2" value="yes">Yes</label>
                                                        <label class="btn btn-danger btn-sm"><input type="radio" name="radioGroup2" onclick="$('#mandatory1').val('no');">No</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>BLC passed</td>
                                                <td>
                                                <div id="file3" class="btn-group" data-toggle="buttons">
                                                        <label class="btn btn-success btn-sm"><input type="radio" name="radioGroup2" value="yes">Yes</label>
                                                        <label class="btn btn-danger btn-sm"><input type="radio" name="radioGroup2" onclick="$('#mandatory1').val('no');">No</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Council inspection</td>
                                                <td>
                                                <div id="file3" class="btn-group" data-toggle="buttons">
                                                        <label class="btn btn-success btn-sm"><input type="radio" name="radioGroup2" value="yes">Yes</label>
                                                        <label class="btn btn-danger btn-sm"><input type="radio" name="radioGroup2" onclick="$('#mandatory1').val('no');">No</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Concrete poured</td>
                                                <td>
                                                <div id="file3" class="btn-group" data-toggle="buttons">
                                                        <label class="btn btn-success btn-sm"><input type="radio" name="radioGroup2" value="yes">Yes</label>
                                                        <label class="btn btn-danger btn-sm"><input type="radio" name="radioGroup2" onclick="$('#mandatory1').val('no');">No</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Strip the boxing</td>
                                                <td>
                                                <div id="file3" class="btn-group" data-toggle="buttons">
                                                        <label class="btn btn-success btn-sm"><input type="radio" name="radioGroup2" value="yes">Yes</label>
                                                        <label class="btn btn-danger btn-sm"><input type="radio" name="radioGroup2" onclick="$('#mandatory1').val('no');">No</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                            <div style="float:right"><button type="submit" class="btn btn-secondary">Save</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
</div>
<script>
    $(document).on("click", "#back", function() {
        var id = $(this).data('id');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: "{{ url('/check-list') }}",
            method: 'get',
            success: function(result) {
                var ele = $(result);

                jQuery('.container .main').html(ele.find(".container .main").html());
            }
        });
    })
</script>