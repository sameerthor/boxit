<form action="{{URL('/qa_checklist')}}" method="post" id="qa_form">
                            @csrf
                            <h5>Onsite & QA Checklist ({{$form->date}})</h5>
                            <br>
<button class="btn btn-primary btn-color float-right back-form" type="button">Back</button>
<br>
                            <input type="hidden" name="form_id" value="{{$form->id}}">
                            <div class="qa_checklist marg-lr-none">
                                <!-- <div class="rowonsite_label">
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
                                        @php $form_qa=$qaChecklist[0]->ProjectQaChecklist($form->id)->get(); @endphp
                                        <td class="table-w"><input type="date" value="{{count($form_qa)>0?$form_qa[0]->initial:''}}" name="initial[1]"></td>
                                        <td class="table-w"><input type="date" value="{{count($form_qa)>0?$form_qa[0]->office_use:''}}" name="office_use[1]"></td>
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
                                        $form_qa= $res->ProjectQaChecklist($form->id)->get();
                                        if(count($form_qa)>0)
                                        {

                                        $initial=$form_qa[0]->initial;
                                        $office_use=$form_qa[0]->office_use;
                                        }else
                                        {
                                        $initial="";
                                        $office_use="";
                                        }
                                        @endphp
                                        <td class="table-w"><input type="text" value="{{$initial}}" name="initial[{{$res->id}}]"></td>
                                        <td class="table-w"><input type="text" value="{{$office_use}}" name="office_use[{{$res->id}}]"></td>
                                        <td>
                                            {!! ($form->images()->form('onsite', $loop->iteration)->count()>0)
                                            ?
                                            "<div class='image_container'><span class='file-remover' data-id='".$form->images()->form('onsite', $loop->iteration )->pluck('id')[0]."'><i class='fa fa-times'></i></span><a class='demo' href='/images/".$form->images()->form('onsite', $loop->iteration)->pluck('image')[0]."' data-lightbox='example-".$form->images()->form('onsite', $loop->iteration)->pluck('image')[0]."'><img class='example-image' width='125' src='/images/".$form->images()->form('onsite', $loop->iteration)->pluck('image')[0]."'></a></div>"
                                            :
                                            "<div class='image-upload'><label for='onsite$loop->iteration'><img src='/img/upload-image.svg' /></label><input id='onsite$loop->iteration' class='form_image' data-project='$project->id' data-formid='$form->id' data-field='$loop->iteration' data-form='onsite' type='file' /></div>"
                                            !!}
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                            @if(!empty($form->qasign->foreman_sign))
                            <img src="{{$form->qasign->foreman_sign}}" id="m_sign" width="200">
                            @else
                            <canvas id="onsite_canvas" class="canvas-size" style="border: 1px solid black;"></canvas>
                            <button type="button" data-id="onsite_signature" class="btn btn-sm clear" style="color:#fff;background-color:#172b4d">Clear</button>
                            @endif
                            <div style="float:right"><button type="submit" class="btn btn-secondary">Save</button></div>
                        </form>