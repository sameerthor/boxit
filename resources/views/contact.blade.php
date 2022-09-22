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
        <div class="col-md-6 text-right select-style">
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
                <th>Company</th>
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
                <td><img src="img/dots.png"></td>
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
<div class="modal" tabindex="-1" role="dialog" id="contact_form">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Contact</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form>
          <div class="form-group">
            <label for="title" class="col-form-label">Company:</label>
            <input type="text" name="company" class="form-control" id="title">
          </div>
          <div class="form-group">
            <label for="email" class="col-form-label">Email:</label>
            <input type="email" name="email" class="form-control" id="email">
          </div>
          <div class="form-group">
            <label for="contact" class="col-form-label">Contact No:</label>
            <input type="number" name="contact" class="form-control" id="contact">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="submit_contact" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
  $(document).on("click", "#add_contact", function() {
    $("#contact_form").modal('show');
      })
$(document).ready(function(){
  $("#submit_contact").click(function(){
        var title = $("#title").val();
        var email = $("#email").val();
        var contact = $("#contact").val();
        var department = $("#department").val();
        
        jQuery.ajax({
      type: 'POST',
      url: "{{ route('contact.add') }}",
      data: {
        title: title,
        email: email,
        contact: contact,
        department_id: department
      },
      success: function(data) {
        $("#contact_form").modal('hide');
        $("#title").val();
        $("#contact").val();
        $("#email").val();
        Swal.fire({
  position: 'top-end',
  icon: 'success',
  title: 'Contact has been saved successfully',
  showConfirmButton: false,
  timer: 1500
})
refreshtable();
      }
    });
      }); 
});
     
</script>
@endsection