@extends('layouts.app')

@section('content')
<div id="content">
  <div class="container">
    <div class="card-new ptb-50">
      <div class="row">
        <div class="col-md-12">
          <div class="form-head">
            <span>User Management</span>
          </div>
        </div>
      </div>
      <div class="row d-flex pb-40">
        <div class="col-md-3">
          <div class="inp-relv">
            <img src="img/frame-2@2x.svg">
            <input type="seach" name="search" id="search" placeholder="Search">
          </div>
        </div>
        <div class="col-md-3">
          <div class="add-new-c">
            <img src="img/plus.png"><span id="add_contact">Add New User</span>
          </div>
        </div>
        <div class="col-md-6 text-r select-style">
      
        </div>
      </div>
      <div class="row">
        <div class="col-md-12" id="contacts">
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
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          @else
          <p>No user found here.</p>
          @endif
        </div>
      </div>
    </div>
  </div>

</div>
<div class="modal fade" tabindex="-1" role="dialog" id="user_form">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><span id="modal_title"></span> User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div style="display:none" id="modal_user_id"></div>
          <div class="form-group">
            <label for="name" class="col-form-label">Name:</label>
            <input type="text" name="name" class="form-control" id="name">
          </div>
          <div class="form-group">
            <label for="email" class="col-form-label">Email:</label>
            <input type="email" name="email" class="form-control" id="email">
          </div>
          <div class="form-group">
            <label for="password" class="col-form-label">Password:</label>
            <input type="password" name="password" class="form-control" id="password">
          </div>
          <div class="form-group">
            <label for="user_type" class="col-form-label">User Type:</label>
            <select name="user_type" class="form-control" id="user_type">
                <option>Admin</option>
                <option>Foreman</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="submit_contact" class="save_button btn btn-secondary">Save</button>
      </div>
    </div>
  </div>
</div>
<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $('#search,#department').on('keyup change', function() {
    refreshtable();
  });

  function refreshtable() {
    var search = $("#search").val();
    var department = $("#department").val();
    $.ajax({
      type: 'POST',
      url: "{{ route('contact.get') }}",
      data: {
        search: search,
        department: department
      },
      success: function(data) {
        $("#contacts").html(data)
      }
    });
  }

  $(document).on("click", ".edit", function() {
    let id = $(this).data('id');
        $("#modal_title").html("Edit");

        $(".save_button").attr("id","update_user")
        $("#user_form").modal('show');
  });

  $(document).on("click", "#add_contact", function() {
    $(".save_button").attr("id","submit_contact")
    $("#modal_contact_id").text("");
    $("#modal_title").html("Add");
    $("#title").val("");
    $("#contact").val("");
    $("#company").val("");
    $("#email").val("");
    $('#sms_enabled').prop('checked', false); 
    $("#user_form").modal('show');
  });

  $(document).on("click", ".close", function() {
    $("#user_form").modal('hide');
  });




  $(document).ready(function() {

    $(document).on('click',"#submit_contact",function() {
      var title = $("#title").val();
      var email = $("#email").val();
      var contact = $("#contact").val();
      var company = $("#company").val();
      var department = $("#department").val();

      jQuery.ajax({
        type: 'POST',
        url: "{{ route('contact.add') }}",
        data: {
          title: title,
          email: email,
          company:company,
          contact: contact,
          department_id: department
        },
        success: function(data) {
          $("#user_form").modal('hide');
          $("#title").val("");
          $("#contact").val("");
          $("#company").val("");
          $("#email").val("");
          Swal.fire({
            icon: 'success',
            title: 'Contact has been saved successfully',
            showConfirmButton: false,
          })
          refreshtable();
        }
      });
    });
    $(document).on('click',"#update_contact",function() {
      console.log("yes");
      var title = $("#title").val();
      var email = $("#email").val();
      var contact = $("#contact").val();
      var company = $("#company").val();
      var sms_enabled = $("#sms_enabled").prop('checked')===true?'1':'0';
      var department = $("#department").val();
      var id = $("#modal_contact_id").text();

      jQuery.ajax({
        type: 'POST',
        url: "{{ route('contact.update') }}",
        data: {
          id:id,
          title: title,
          email: email,
          company:company,
          contact: contact,
          sms_enabled:sms_enabled,
          department_id: department
        },
        success: function(data) {
          $("#user_form").modal('hide');
          $("#title").val("");
          $("#contact").val("");
          $("#company").val("");
          $("#email").val("");
          $("#modal_contact_id").text("");
          Swal.fire({
            icon: 'success',
            title: 'Contact has been updated successfully',
            showConfirmButton: false,
          })
          refreshtable();
        }
      });
    });
  });
</script>
@endsection