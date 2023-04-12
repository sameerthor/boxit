@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
            <img src="img/plus.png"><span id="add_user">Add New User</span>
          </div>
        </div>
        <div class="col-md-4 text-r select-style">

        </div>
        <div class="col-md-2 text-r select-style">
          <button data-toggle="modal" class="btn btn-secondary btn-color" data-target="#email_form">Send mail</button>  
        </div>
      </div>
      <div class="row">
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
                <td class="user_type">{{@$user->roles->pluck('name')[0]}}</td>
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
<div class="modal fade" tabindex="-1" role="dialog" id="email_form">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Send Mail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{ url('user-mail')  }}">
          @csrf
          <div class="form-group">
            <label for="mail" class="col-form-label">Body</label>
            <textarea name="mail" required class="form-control" id="mail"></textarea>
          </div>
          <div class="form-group">
            <label for="emails" class="col-form-label">Users (Mail will send to all users if not selected)</label>
            <br>
            <select  name="emails[]" id="emails" multiple="multiple">
            @foreach($users as $user)  
            <option value="{{$user->email}}">{{ucfirst($user->name)}}</option>
            @endforeach
            </select>
          </div>
         
      </div>
      <div class="modal-footer">
        <button type="submit"  class="save_button btn btn-secondary">Send</button>
      </div>
      </form>

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
            <label for="contact" class="col-form-label">Contact No:</label>
            <input type="text" name="contact" class="form-control" id="contact">
          </div>
          <div class="form-group">
            <label for="password" class="col-form-label">Password:</label>
            <input type="password" name="new_password" autocomplete="off" class="form-control" id="password">
          </div>
          <div class="form-group">
            <label for="user_type" class="col-form-label">User Type:</label>
            <select name="user_type" class="form-control" id="user_type">
              <option value="Admin">Admin</option>
              <option value="Foreman">Foreman</option>
              <option value="Project Manager">Project Manager</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="submit_user" class="save_button btn btn-secondary">Save</button>
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
  $('#email_form').on('shown.bs.modal', function (e) {
    $('#emails').select2();

})

  CKEDITOR.replace('mail', {
			// Make the editing area bigger than default.
			height: 450,
			// Allow pasting any content.
			allowedContent: true,
			fillEmptyBlocks: false,

			// Fit toolbar buttons inside 3 rows.
			toolbarGroups: [{
					name: 'document',
					groups: ['mode', 'document', 'doctools']
				},
				{
					name: 'clipboard',
					groups: ['clipboard', 'undo']
				},
				{
					name: 'editing',
					groups: ['find', 'selection', 'spellchecker', 'editing']
				},
				{
					name: 'forms',
					groups: ['forms']
				},
				'/',
				{
					name: 'paragraph',
					groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']
				},
				{
					name: 'links',
					groups: ['links']
				},
				{
					name: 'insert',
					groups: ['insert']
				},
				'/',
				{
					name: 'styles',
					groups: ['styles']
				},
				{
					name: 'basicstyles',
					groups: ['basicstyles', 'cleanup']
				},
				{
					name: 'colors',
					groups: ['colors']
				},
				{
					name: 'tools',
					groups: ['tools']
				},
				{
					name: 'others',
					groups: ['others']
				},
				{
					name: 'about',
					groups: ['about']
				}
			],

			// Remove buttons irrelevant for pasting from external sources.
			removeButtons: 'ExportPdf,Form,Checkbox,Radio,TextField,Select,Textarea,Button,ImageButton,HiddenField,NewPage,CreateDiv,Flash,Iframe,About,ShowBlocks,Maximize',
		});

  $('#search').on('keyup change', function() {
    refreshtable();
  });

  function refreshtable() {
    var search = $("#search").val();
    $.ajax({
      type: 'POST',
      url: "{{ route('user.get') }}",
      data: {
        search: search,
      },
      success: function(data) {
        $("#users").html(data)
      }
    });
  }

  $(document).on("click", ".edit", function() {
    $("#email").attr('readonly',true);
    $("#user_type").attr('readonly',true);
    let id = $(this).data('id');
    var user_type = $(this).parents('tr').find(".user_type").html();
    jQuery.ajax({
      type: 'POST',
      url: "{{ route('user.edit') }}",
      data: {
        id: id,
      },
      success: function(data) {
        $("#modal_title").html("Edit");
        $("#modal_user_id").text(data.id);
        $("#name").val(data.name);
        $("#contact").val(data.contact);
        $("#email").val(data.email);

        $("#password").val("");
        $("#user_type option").each(function() {
          if ($(this).text() == user_type) {
            $(this).attr('selected', 'selected');
          }
        });

        $(".save_button").attr("id", "update_user")
        $("#user_form").modal('show');

      }
    })

  });

  $(document).on("click", "#add_user", function() {
    $("#user_type").show();
    $(".save_button").attr("id", "submit_user")
    $("#modal_user_id").text("");
    $("#modal_title").html("Add");
    $("#email").attr('readonly',false);
    $("#user_type").attr('readonly',false);
    $("#name").val("");
    $("#email").val("");
    $("#contact").val("");
    $("#password").val("");
    $('#sms_enabled').prop('checked', false);
    $("#user_form").modal('show');
  });

  $(document).on("click", ".close", function() {
    $("#user_form").modal('hide');
  });




  $(document).ready(function() {

    $(document).on('click', "#submit_user", function() {
      var name = $("#name").val();
      var email = $("#email").val();
      var contact = $("#contact").val();
      var password = $("#password").val();
      var user_type = $("#user_type").val();

      jQuery.ajax({
        type: 'POST',
        url: "{{ route('user.add') }}",
        data: {
          name: name,
          email: email,
          contact:contact,
          password: password,
          user_type: user_type,
        },
        success: function(data) {
          $("#user_form").modal('hide');
          $("#name").val("");
          $("#email").val("");
          $("#contact").val("");
          $("#password").val("");
          $("#user_type").val("");
          Toast.fire({
			icon: 'success',
			title: 'User has been saved successfully'
		}).then((res) => {
            window.location.href();
          });
          refreshtable();

        }
      });
    });
    $(document).on('click', "#update_user", function() {
      console.log("yes");
      var name = $("#name").val();
      var email = $("#email").val();
      var contact = $("#contact").val();
      var password = $("#password").val();
      var user_type = $("#user_type").val();
      var sms_enabled = $("#sms_enabled").prop('checked') === true ? '1' : '0';
      var department = $("#department").val();
      var id = $("#modal_user_id").text();

      jQuery.ajax({
        type: 'POST',
        url: "{{ route('user.update') }}",
        data: {
          id: id,
          name: name,
          email: email,
          contact:contact,
          password: password,
          user_type: user_type,
        },
        success: function(data) {
          $("#user_form").modal('hide');
          $("#name").val("");
          $("#email").val("");
          $("#contact").val("");
          $("#password").val("");
          $("#user_type").val("");
          $("#modal_user_id").text("");
          Toast.fire({
			icon: 'success',
			title: 'User has been updated successfully'
		}).then((res) => {
            window.location.href();
          });
          refreshtable();
        }
      });
    });
  });
</script>
@endsection