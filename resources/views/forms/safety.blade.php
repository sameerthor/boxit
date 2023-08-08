<form action="{{URL('/safety-plan')}}" id="safety_form" method="post">
                            @csrf
                            <h5>Safety plan ({{$form->date}})</h5>
                            <br>
<button class="btn btn-primary btn-color float-right back-form" type="button">Back</button>
<br>
                            <input type="hidden" name="form_id" value="{{$form->id}}">
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
                                            <td>
                                                {!! ($form->images()->form('safety', '1')->count()>0)
                                                ?
                                                "<div class='image_container'><span class='file-remover' data-id='".$form->images()->form('safety', '1' )->pluck('id')[0]."'><i class='fa fa-times'></i></span><a class='demo' href='/images/".$form->images()->form('safety', '1' )->pluck('image')[0]."' data-lightbox='example-".$form->images()->form('safety', '1')->pluck('image')[0]."'><img class='example-image' width='125' src='/images/".$form->images()->form('safety', '1' )->pluck('image')[0]."'></a></div>"
                                                :
                                                "<div class='image-upload'><label for='safety1'><img src='/img/upload-image.svg' /></label><input id='safety1' class='form_image' data-project='$project->id' data-formid='$form->id'  data-field='1' data-form='safety' type='file' /></div>"
                                                !!}
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
                                            <td>
                                                {!! ($form->images()->form('safety', '2')->count()>0)
                                                ?
                                                "<div class='image_container'><span class='file-remover' data-id='".$form->images()->form('safety', '2' )->pluck('id')[0]."'><i class='fa fa-times'></i></span><a class='demo' href='/images/".$form->images()->form('safety', '2' )->pluck('image')[0]."' data-lightbox='example-".$form->images()->form('safety', '2')->pluck('image')[0]."'><img class='example-image' width='125' src='/images/".$form->images()->form('safety', '2' )->pluck('image')[0]."'></a></div>"
                                                :
                                                "<div class='image-upload'><label for='safety2'><img src='/img/upload-image.svg' /></label><input id='safety2' class='form_image' data-project='$project->id' data-formid='$form->id'  data-field='2' data-form='safety' type='file' /></div>"
                                                !!}
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
                                            <td>
                                                {!! ($form->images()->form('safety', '3')->count()>0)
                                                ?
                                                "<div class='image_container'><span class='file-remover' data-id='".$form->images()->form('safety', '3' )->pluck('id')[0]."'><i class='fa fa-times'></i></span><a class='demo' href='/images/".$form->images()->form('safety', '3' )->pluck('image')[0]."' data-lightbox='example-".$form->images()->form('safety', '3')->pluck('image')[0]."'><img class='example-image' width='125' src='/images/".$form->images()->form('safety', '3' )->pluck('image')[0]."'></a></div>"
                                                :
                                                "<div class='image-upload'><label for='safety3'><img src='/img/upload-image.svg' /></label><input id='safety3' class='form_image' data-project='$project->id' data-formid='$form->id'  data-field='3' data-form='safety' type='file' /></div>"
                                                !!}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>1.4</td>
                                            <td>
                                                Have you completed the Clientsafety documentation on site?
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
                                            <td>
                                                {!! ($form->images()->form('safety', '4')->count()>0)
                                                ?
                                                "<div class='image_container'><span class='file-remover' data-id='".$form->images()->form('safety', '4' )->pluck('id')[0]."'><i class='fa fa-times'></i></span><a class='demo' href='/images/".$form->images()->form('safety', '4' )->pluck('image')[0]."' data-lightbox='example-".$form->images()->form('safety', '4')->pluck('image')[0]."'><img class='example-image' width='125' src='/images/".$form->images()->form('safety', '4' )->pluck('image')[0]."'></a></div>"
                                                :
                                                "<div class='image-upload'><label for='safety4'><img src='/img/upload-image.svg' /></label><input id='safety4' class='form_image' data-project='$project->id' data-formid='$form->id'  data-field='4' data-form='safety' type='file' /></div>"
                                                !!}
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
                                            <td>
                                                {!! ($form->images()->form('safety', '5')->count()>0)
                                                ?
                                                "<div class='image_container'><span class='file-remover' data-id='".$form->images()->form('safety', '5' )->pluck('id')[0]."'><i class='fa fa-times'></i></span><a class='demo' href='/images/".$form->images()->form('safety', '5' )->pluck('image')[0]."' data-lightbox='example-".$form->images()->form('safety', '5')->pluck('image')[0]."'><img class='example-image' width='125' src='/images/".$form->images()->form('safety', '5' )->pluck('image')[0]."'></a></div>"
                                                :
                                                "<div class='image-upload'><label for='safety5'><img src='/img/upload-image.svg' /></label><input id='safety5' class='form_image' data-project='$project->id' data-formid='$form->id'  data-field='5' data-form='safety' type='file' /></div>"
                                                !!}
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
                                            <td>
                                                {!! ($form->images()->form('safety', '6')->count()>0)
                                                ?
                                                "<div class='image_container'><span class='file-remover' data-id='".$form->images()->form('safety', '6' )->pluck('id')[0]."'><i class='fa fa-times'></i></span><a class='demo' href='/images/".$form->images()->form('safety', '6' )->pluck('image')[0]."' data-lightbox='example-".$form->images()->form('safety', '6')->pluck('image')[0]."'><img class='example-image' width='125' src='/images/".$form->images()->form('safety', '6' )->pluck('image')[0]."'></a></div>"
                                                :
                                                "<div class='image-upload'><label for='safety6'><img src='/img/upload-image.svg' /></label><input id='safety6' class='form_image' data-project='$project->id' data-formid='$form->id'  data-field='6' data-form='safety' type='file' /></div>"
                                                !!}
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
                                            <td>
                                                {!! ($form->images()->form('safety', '7')->count()>0)
                                                ?
                                                "<div class='image_container'><span class='file-remover' data-id='".$form->images()->form('safety', '7' )->pluck('id')[0]."'><i class='fa fa-times'></i></span><a class='demo' href='/images/".$form->images()->form('safety', '7' )->pluck('image')[0]."' data-lightbox='example-".$form->images()->form('safety', '7')->pluck('image')[0]."'><img class='example-image' width='125' src='/images/".$form->images()->form('safety', '7' )->pluck('image')[0]."'></a></div>"
                                                :
                                                "<div class='image-upload'><label for='safety7'><img src='/img/upload-image.svg' /></label><input id='safety7' class='form_image' data-project='$project->id' data-formid='$form->id'  data-field='7' data-form='safety' type='file' /></div>"
                                                !!}
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
                                            <td>
                                                {!! ($form->images()->form('safety', '8')->count()>0)
                                                ?
                                                "<div class='image_container'><span class='file-remover' data-id='".$form->images()->form('safety', '8' )->pluck('id')[0]."'><i class='fa fa-times'></i></span><a class='demo' href='/images/".$form->images()->form('safety', '8' )->pluck('image')[0]."' data-lightbox='example-".$form->images()->form('safety', '8')->pluck('image')[0]."'><img class='example-image' width='125' src='/images/".$form->images()->form('safety', '8' )->pluck('image')[0]."'></a></div>"
                                                :
                                                "<div class='image-upload'><label for='safety8'><img src='/img/upload-image.svg' /></label><input id='safety8' class='form_image' data-project='$project->id' data-formid='$form->id'  data-field='8' data-form='safety' type='file' /></div>"
                                                !!}
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
                                            <td>
                                                {!! ($form->images()->form('safety', '9')->count()>0)
                                                ?
                                                "<div class='image_container'><span class='file-remover' data-id='".$form->images()->form('safety', '9' )->pluck('id')[0]."'><i class='fa fa-times'></i></span><a class='demo' href='/images/".$form->images()->form('safety', '9' )->pluck('image')[0]."' data-lightbox='example-".$form->images()->form('safety', '9')->pluck('image')[0]."'><img class='example-image' width='125' src='/images/".$form->images()->form('safety', '9' )->pluck('image')[0]."'></a></div>"
                                                :
                                                "<div class='image-upload'><label for='safety9'><img src='/img/upload-image.svg' /></label><input id='safety9' class='form_image' data-project='$project->id' data-formid='$form->id'  data-field='9' data-form='safety' type='file' /></div>"
                                                !!}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="8" style="background-color:#c9ced6;">3.0 JOBsafety ANALYSIS AND HAZARD MANAGEMENT
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
                                            <td>
                                                {!! ($form->images()->form('safety', '10')->count()>0)
                                                ?
                                                "<div class='image_container'><span class='file-remover' data-id='".$form->images()->form('safety', '10' )->pluck('id')[0]."'><i class='fa fa-times'></i></span><a class='demo' href='/images/".$form->images()->form('safety', '10' )->pluck('image')[0]."' data-lightbox='example-".$form->images()->form('safety', '10')->pluck('image')[0]."'><img class='example-image' width='125' src='/images/".$form->images()->form('safety', '10' )->pluck('image')[0]."'></a></div>"
                                                :
                                                "<div class='image-upload'><label for='safety10'><img src='/img/upload-image.svg' /></label><input id='safety10' class='form_image' data-project='$project->id' data-formid='$form->id'  data-field='10' data-form='safety' type='file' /></div>"
                                                !!}
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
                                            <td>
                                                {!! ($form->images()->form('safety', '11')->count()>0)
                                                ?
                                                "<div class='image_container'><span class='file-remover' data-id='".$form->images()->form('safety', '11' )->pluck('id')[0]."'><i class='fa fa-times'></i></span><a class='demo' href='/images/".$form->images()->form('safety', '11' )->pluck('image')[0]."' data-lightbox='example-".$form->images()->form('safety', '11')->pluck('image')[0]."'><img class='example-image' width='125' src='/images/".$form->images()->form('safety', '11' )->pluck('image')[0]."'></a></div>"
                                                :
                                                "<div class='image-upload'><label for='safety11'><img src='/img/upload-image.svg' /></label><input id='safety11' class='form_image' data-project='$project->id' data-formid='$form->id'  data-field='11' data-form='safety' type='file' /></div>"
                                                !!}
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
                                            <td>
                                                {!! ($form->images()->form('safety', '12')->count()>0)
                                                ?
                                                "<div class='image_container'><span class='file-remover' data-id='".$form->images()->form('safety', '12' )->pluck('id')[0]."'><i class='fa fa-times'></i></span><a class='demo' href='/images/".$form->images()->form('safety', '12' )->pluck('image')[0]."' data-lightbox='example-".$form->images()->form('safety', '12')->pluck('image')[0]."'><img class='example-image' width='125' src='/images/".$form->images()->form('safety', '12' )->pluck('image')[0]."'></a></div>"
                                                :
                                                "<div class='image-upload'><label for='safety12'><img src='/img/upload-image.svg' /></label><input id='safety12' class='form_image' data-project='$project->id' data-formid='$form->id'  data-field='12' data-form='safety' type='file' /></div>"
                                                !!}
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
                                            <td>
                                                {!! ($form->images()->form('safety', '13')->count()>0)
                                                ?
                                                "<div class='image_container'><span class='file-remover' data-id='".$form->images()->form('safety', '13' )->pluck('id')[0]."'><i class='fa fa-times'></i></span><a class='demo' href='/images/".$form->images()->form('safety', '13' )->pluck('image')[0]."' data-lightbox='example-".$form->images()->form('safety', '13')->pluck('image')[0]."'><img class='example-image' width='125' src='/images/".$form->images()->form('safety', '13' )->pluck('image')[0]."'></a></div>"
                                                :
                                                "<div class='image-upload'><label for='safety13'><img src='/img/upload-image.svg' /></label><input id='safety13' class='form_image' data-project='$project->id' data-formid='$form->id'  data-field='13' data-form='safety' type='file' /></div>"
                                                !!}
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
                                            <td>
                                                {!! ($form->images()->form('safety', '14')->count()>0)
                                                ?
                                                "<div class='image_container'><span class='file-remover' data-id='".$form->images()->form('safety', '14' )->pluck('id')[0]."'><i class='fa fa-times'></i></span><a class='demo' href='/images/".$form->images()->form('safety', '14' )->pluck('image')[0]."' data-lightbox='example-".$form->images()->form('safety', '14')->pluck('image')[0]."'><img class='example-image' width='125' src='/images/".$form->images()->form('safety', '14' )->pluck('image')[0]."'></a></div>"
                                                :
                                                "<div class='image-upload'><label for='safety14'><img src='/img/upload-image.svg' /></label><input id='safety14' class='form_image' data-project='$project->id' data-formid='$form->id'  data-field='14' data-form='safety' type='file' /></div>"
                                                !!}
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
                                            <td>
                                                {!! ($form->images()->form('safety', '15')->count()>0)
                                                ?
                                                "<div class='image_container'><span class='file-remover' data-id='".$form->images()->form('safety', '15' )->pluck('id')[0]."'><i class='fa fa-times'></i></span><a class='demo' href='/images/".$form->images()->form('safety', '15' )->pluck('image')[0]."' data-lightbox='example-".$form->images()->form('safety', '15')->pluck('image')[0]."'><img class='example-image' width='125' src='/images/".$form->images()->form('safety', '15' )->pluck('image')[0]."'></a></div>"
                                                :
                                                "<div class='image-upload'><label for='safety15'><img src='/img/upload-image.svg' /></label><input id='safety15' class='form_image' data-project='$project->id' data-formid='$form->id'  data-field='15' data-form='safety' type='file' /></div>"
                                                !!}
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
                                            <td>
                                                {!! ($form->images()->form('safety', '16')->count()>0)
                                                ?
                                                "<div class='image_container'><span class='file-remover' data-id='".$form->images()->form('safety', '16' )->pluck('id')[0]."'><i class='fa fa-times'></i></span><a class='demo' href='/images/".$form->images()->form('safety', '16' )->pluck('image')[0]."' data-lightbox='example-".$form->images()->form('safety', '16')->pluck('image')[0]."'><img class='example-image' width='125' src='/images/".$form->images()->form('safety', '16' )->pluck('image')[0]."'></a></div>"
                                                :
                                                "<div class='image-upload'><label for='safety16'><img src='/img/upload-image.svg' /></label><input id='safety16' class='form_image' data-project='$project->id' data-formid='$form->id'  data-field='16' data-form='safety' type='file' /></div>"
                                                !!}
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
                                            <td>
                                                {!! ($form->images()->form('safety', '17')->count()>0)
                                                ?
                                                "<div class='image_container'><span class='file-remover' data-id='".$form->images()->form('safety', '17' )->pluck('id')[0]."'><i class='fa fa-times'></i></span><a class='demo' href='/images/".$form->images()->form('safety', '17' )->pluck('image')[0]."' data-lightbox='example-".$form->images()->form('safety', '17')->pluck('image')[0]."'><img class='example-image' width='125' src='/images/".$form->images()->form('safety', '17' )->pluck('image')[0]."'></a></div>"
                                                :
                                                "<div class='image-upload'><label for='safety17'><img src='/img/upload-image.svg' /></label><input id='safety17' class='form_image' data-project='$project->id' data-formid='$form->id'  data-field='17' data-form='safety' type='file' /></div>"
                                                !!}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p>All personnel and visitors have been shown and advised of all of the hazards and controls identified.
                                    All workers must be involved in completing this Sitesafety Plan. All persons signed below fully
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