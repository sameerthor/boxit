@extends('layouts.app')

@section('content')
<div id="content">
  <div class="container">
    <div class="card-new ptb-50">
      <div class="row">
        <div class="col-md-12">
          <div class="form-head">
            <span>Contact</span>
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
            <img src="img/plus.png"><span id="add_contact">Add New Contact</span>
          </div>
        </div>
        <div class="col-md-6 text-r select-style">
          <select id="department">
            @foreach($departments as $department)
            <option value="{{$department->id}}">{{$department->title}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12" id="contacts">
          @if(count($departments[0]->contacts)>0)
          <table class="table table-w-80">
            <thead class="border-n">
              <tr>
                <th>Company Name</th>
                <th>Email ID</th>
                <th>Contact No.</th>
              </tr>
            </thead>
            <tbody class="tr-border td-styles tr-hover">
              @foreach($departments[0]->contacts as $contact)
              <tr>
                <td><b>{{$contact->title}}</b></td>
                <td>{{$contact->email}}</td>
                <td>{{$contact->contact}}</td>
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
        </div>
      </div>
    </div>
  </div>

</div>
<div class="modal fade" tabindex="-1" role="dialog" id="contact_form">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><span id="modal_title"></span> Contact</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div style="display:none" id="modal_contact_id"></div>
          <div class="form-group">
            <label for="company" class="col-form-label">Name:</label>
            <input type="text" name="company" class="form-control" id="company">
          </div>
          <div class="form-group">
            <label for="title" class="col-form-label">Company Name:</label>
            <input type="text" name="title" class="form-control" id="title">
          </div>
          <div class="form-group">
            <label for="email" class="col-form-label">Email:</label>
            <input type="email" name="email" class="form-control" id="email">
          </div>
          <div class="form-group">
            <label for="contact" class="col-form-label">Contact No:</label>
            <input type="tel" name="contact" class="form-control" id="contact">
          </div>
          <div class="form-group">
            <label for="sms_enabled" class="col-form-label">SMS Notification Enabled:</label>
            <input type="checkbox" name="sms_enabled" value="1" id="sms_enabled">
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
    jQuery.ajax({
      type: 'POST',
      url: "{{ route('contact.edit') }}",
      data: {
        id: id,
      },
      success: function(data) {
        $("#modal_title").html("Edit");
        $("#modal_contact_id").text(data.id);
        $("#title").val(data.title);
        $("#contact").val(data.contact);
        $("#company").val(data.company);
        $("#email").val(data.email);
        if(data.sms_enabled=='1')
        $('#sms_enabled').prop('checked', true); 
        else
        $('#sms_enabled').prop('checked', false); 

        $(".save_button").attr("id","update_contact")
        $("#contact_form").modal('show');

      }
    })
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
    $("#contact_form").modal('show');
  });

  $(document).on("click", ".close", function() {
    $("#contact_form").modal('hide');
  });


  $(document).on("click", ".delete", function() {
    let id = $(this).data('id');
    swal.fire({
      title: "Confirmation!",
      text: "Do you want to delete this contact ?.",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "No, cancel please!",
      closeOnConfirm: false,
      closeOnCancel: false
    }).then((result) => {
      if (result.value) {
        jQuery.ajax({
          type: 'POST',
          url: "{{ route('contact.delete') }}",
          data: {
            id: id,
          },
          success: function(data) {
            Swal.fire({
              icon: 'success',
              title: 'Contact has been deleted successfully',
              showConfirmButton: false,
            })
            refreshtable();
          }
        })
      }
    });

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
          $("#contact_form").modal('hide');
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
          $("#contact_form").modal('hide');
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

  function copyToClipboard(textToCopy){
  navigator.clipboard.writeText(textToCopy).then(
    function() {
      /* clipboard successfully set */
      window.alert('Success! The Link was copied to your clipboard') 
    }, 
    function() {
      /* clipboard write failed */
      window.alert('Opps! Your browser does not support the Clipboard API')
    }
  )
  }
</script>
@endsection