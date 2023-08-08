<h5 class="paid-r-l">Safety plan</h5>
<br>
<button class="btn btn-primary btn-color float-right back-form" type="button">Back</button>
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
