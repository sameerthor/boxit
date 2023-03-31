@extends('layouts.app')

@section('content')
<div id="content">
  <div class="container">
    <div class="card-new ptb-50">
      <div class="row">
        <div class="col-md-12">
          <div class="form-head">
            <span>Products</span>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12" id="departments">
          <table class="table table-w-80">
            <thead class="border-n">
              <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Image</th>
                @if(Auth::user()->hasRole('Admin'))
                <th>Action</th>
                @endif
              </tr>
            </thead>
            <tbody class="tr-border td-styles tr-hover">
              @foreach($departments as $department)
              <tr>
                <td><b>{{$department->title}}</b></td>
                <td><b>{{$department->description}}</b></td>
                <td><b>{!! !empty($department->image)?"<img width='200' src='/images/$department->image'><br><a target='_blank' href='/images/$department->image'>View</a>":'' !!}</b></td>
                @if(Auth::user()->hasRole('Admin'))
                <td><img src="img/dots.png" id="dropdownMenuButton" data-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false">
                  <div class="dropdown-menu">
                    <a href="javascript:void(0)" data-id='{{$department->id}}' class="edit dropdown-item">Edit</a>
                  </div>
                </td>
                @endif
              </tr>
              @endforeach
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>

</div>
@if(Auth::user()->hasRole('Admin'))

<div class="modal fade" tabindex="-1" role="dialog" id="department_form">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><span id="modal_title"></span> department</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="update_form">
          <input type="hidden" name="id" id="modal_department_id">
          <div class="form-group">
            <label for="title" class="col-form-label">Title:</label>
            <input type="text" name="title" class="form-control" id="title">
          </div>
          <div class="form-group">
            <label for="description" class="col-form-label">Description:</label>
            <textarea name="description" class="form-control" id="description"></textarea>
          </div>
          <div class="form-group">
            <label for="image" class="col-form-label">Image:</label>
            <input type="file" name="image" class="form-control" id="image">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="submit_department" class="save_button btn btn-secondary">Save</button>
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
  $(document).on("click", ".edit", function() {
    let id = $(this).data('id');
    jQuery.ajax({
      type: 'POST',
      url: "{{ route('products.edit') }}",
      data: {
        id: id,
      },
      success: function(data) {
        $("#modal_title").html("Edit");
        $("#modal_department_id").val(data.id);
        $("#title").val(data.product_name);
        $("#description").val(data.description);

        $(".save_button").attr("id", "update_department")
        $("#department_form").modal('show');

      }
    })
  });


  $(document).on("click", ".close", function() {
    $("#department_form").modal('hide');
  });



  $(document).ready(function() {

    $(document).on('click', "#update_department", function() {
      var form = $('#update_form')[0];
      var formData = new FormData(form);
      jQuery.ajax({
        type: 'POST',
        url: "{{ route('products.update') }}",
        processData: false,
        contentType: false,
        data: formData,
        success: function(data) {
          window.location.reload();
        }
      });
    });
  });
</script>
@endif
@endsection