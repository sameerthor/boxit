<h5>Onsite & QA Checklist</h5>
<br>
<button class="btn btn-primary btn-color float-right back-form" type="button">Back</button>
<br>
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
                  <td class="table-w"><input type="text" readonly value="{{$initial}}" name="initial[{{$res->id}}]"></td>
                  <td class="table-w"><input type="text" readonly value="{{$office_use}}" name="office_use[{{$res->id}}]"></td>
                </tr>
                @endforeach
              </table>
            </div>
            <br>
            @if(!empty($form->qasign->foreman_sign))
            <h5>Signature</h5>
            <img src="{{$form->qasign->foreman_sign}}" id="m_sign" width="200">
            @endif