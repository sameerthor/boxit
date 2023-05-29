@if(count($departments->contacts)>0)
          <table class="table table-w-80">
            <thead class="border-n">
              <tr>
                <th>Company Name</th>
                <th>Name</th>
                <th>Email ID</th>
                <th>Contact No.</th>
               @if($departments->id != 1)
                <th>Calender Link</th>
               @endif 
               <th>Actions</th>
              </tr>
            </thead>
            <tbody class="tr-border td-styles tr-hover">
              @foreach($departments->contacts as $contact)
              <tr>
                <td><b>{{$contact->title}}</b></td>
                <td><b>{{$contact->company}}</b></td>
                <td><a href = "mailto:{{$contact->email}}">{{$contact->email}}</a></td>
                <td><a href = "tel:{{$contact->contact}}">{{$contact->contact}}</a></td>
                @if($departments->id != 1)
                <th><button class="btn btn-sm btn-info btn-color"  onclick="copyToClipboard('<?= URL::to('/vendors/').'/'.base64_encode($contact->id); ?>')">Copy Link</button></th>
               @endif 
                <td><img src="img/dots.png" id="dropdownMenuButton" data-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false">
                  <div class="dropdown-menu">
                    <a href="javascript:void(0)" data-id='{{$contact->id}}' class="edit dropdown-item">Edit</a>
                    <a href="javascript:void(0)" data-id='{{$contact->id}}' class="delete dropdown-item">Delete</a>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          @else
          <p>No record found for this department</p>
          @endif