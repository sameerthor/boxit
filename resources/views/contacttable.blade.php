@if(count($departments->contacts)>0)
          <table class="table table-w-80">
            <thead class="border-n">
              <tr>
                <th>Company</th>
                <th>Email ID</th>
                <th>Contact No.</th>
              </tr>
            </thead>
            <tbody class="tr-border td-styles tr-hover">
              @foreach($departments->contacts as $contact)
              <tr>
                <td><b>{{$contact->title}}</b></td>
                <td>{{$contact->email}}</td>
                <td>{{$contact->contact}}</td>
                <td><img src="img/dots.png"></td>
              </tr>
              @endforeach
            </tbody>
          </table>
          @else
          <p>No record found for this department</p>
          @endif