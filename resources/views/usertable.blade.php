<div class="col-md-12" id="users">
          @if(count($users)>0)
          <table class="table table-w-80">
            <thead class="border-n">
              <tr>
                <th>Name</th>
                <th>Email ID</th>
                <th>User Type</th>
              </tr>
            </thead>
            <tbody class="tr-border td-styles tr-hover">
              @foreach($users as $user)
              <tr>
                <td><b>{{ucfirst($user->name)}}</b></td>
                <td>{{$user->email}}</td>
                <td>{{@$user->roles->pluck('name')[0]}}</td>
                <td><img src="img/dots.png" id="dropdownMenuButton" data-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false">
                  <div class="dropdown-menu">
                  <a href="javascript:void(0)" data-id='{{$user->id}}' class="edit dropdown-item">Edit</a>
                    <a href="javascript:void(0)" data-id='{{$user->id}}' class="delete dropdown-item">Delete</a>
                    @if(@$user->roles->pluck('name')[0]=='Foreman')
                    <a href="javascript:void(0)" data-id='{{$user->id}}' class="leaves dropdown-item">Leaves</a>
                    @endif                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          @else
          <p>No user found here.</p>
          @endif
        </div>