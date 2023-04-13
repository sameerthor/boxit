@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('js/lightbox/dist/css/lightbox.min.css')}}">
<script src="{{asset('js/lightbox/dist/js/lightbox.js')}}"></script>
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
      <div class="row d-flex pb-40">
        <div class="col-md-2">
          <div class="inp-relv">
            <img src="img/frame-2@2x.svg">
            <input type="seach" name="search" id="search" placeholder="Search">
          </div>
        </div>
        <div class="col-md-4">
          <div class="add-new-c">
            <img src="img/plus.png"><span id="add_product">Add New Product</span>
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
        <div class="col-md-12" id="products">
          @if(count($products)>0)
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
              @foreach($products as $product)
              <tr>
                <td><b>{{$product->title}}</b></td>
                <td><b>{{$product->description}}</b></td>
                <td><b>{!! !empty($product->image)?"<a class='demo' href='/images/$product->image' data-lightbox='example-$product->id'><img class='example-image' width='200' src='/images/$product->image' ></a>":"" !!}</b></td>
                @if(Auth::user()->hasRole('Admin'))
                <td><img src="img/dots.png" id="dropdownMenuButton" data-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false">
                  <div class="dropdown-menu">
                    <a href="javascript:void(0)" data-id='{{$product->id}}' class="edit dropdown-item">Edit</a>
                    <a href="javascript:void(0)" data-id='{{$product->id}}' class="delete dropdown-item">Delete</a>
                  </div>
                </td>
                @endif
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
@if(Auth::user()->hasRole('Admin'))

<div class="modal fade" tabindex="-1" role="dialog" id="product_form">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><span id="modal_title"></span> product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="update_form">
          <input type="hidden" name="id" id="modal_product_id">
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
        <button type="button" id="submit_product" class="save_button btn btn-secondary">Save</button>
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
      url: "{{ route('products.get') }}",
      data: {
        search: search,
        department: department
      },
      success: function(data) {
        $("#products").html(data)
      }
    });
  }

  $(document).on("click", "#add_product", function() {
    $(".save_button").attr("id", "submit_product")
    $("#modal_product_id").val("");
    $("#modal_title").html("Add");
    $("#title").val("");
    $('#image').val("")
    $("#description").val("");
    $("#product_form").modal('show');
  });

  $(document).on("click", ".close", function() {
    $("#product_form").modal('hide');
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
        $("#modal_product_id").val(data.id);
        $("#title").val(data.title);
        $("#description").val(data.description);

        $(".save_button").attr("id", "update_product")
        $("#product_form").modal('show');

      }
    })
  });


  $(document).on("click", ".close", function() {
    $("#product_form").modal('hide');
  });

  $(document).on('click', "#submit_product", function() {
    var form = $('#update_form')[0];
    var formData = new FormData(form);
   formData.append("department_id", $("#department").val())
    jQuery.ajax({
      type: 'POST',
      url: "{{ route('product.add') }}",
      processData: false,
      contentType: false,
      data: formData,
      success: function(data) {
        $("#product_form").modal('hide');
        $("#title").val("");
        $('#image').val("")
        $("#description").val("");
        Toast.fire({
                    icon: 'success',
                    title: "Product has been saved successfuly."
                }).then(function(result) {
                  refreshtable();
                });
      }
    });
  });

  $(document).on('click', "#update_product", function() {
    var form = $('#update_form')[0];
    var formData = new FormData(form);
    jQuery.ajax({
      type: 'POST',
      url: "{{ route('products.update') }}",
      processData: false,
      contentType: false,
      data: formData,
      success: function(data) {
        $("#product_form").modal('hide');
        $("#title").val("");
        $('#image').val("")
        $("#description").val("");
        Toast.fire({
                    icon: 'success',
                    title: "Product has been saved successfuly."
                }).then(function(result) {
                  refreshtable();
                });
      }
    });
  });

  $(document).on("click", ".delete", function() {
    let id = $(this).data('id');
    swal.fire({
      title: "Confirmation!",
      text: "Do you want to delete this product ?.",
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
          url: "{{ route('product.delete') }}",
          data: {
            id: id,
          },
          success: function(data) {
            Swal.fire({
              icon: 'success',
              title: 'Product has been deleted successfully',
              showConfirmButton: false,
            })
            refreshtable();
          }
        })
      }
    });

  });

  lightbox.option({
  albumLabel: 'Image %1 of %2',
  alwaysShowNavOnTouchDevices: false,
  fadeDuration: 600,
  fitImagesInViewport: true,
  imageFadeDuration: 600,
  maxWidth: 900,
  maxHeight: 700,
  positionFromTop: 50,
  resizeDuration: 700,
  showImageNumberLabel: true,
  wrapAround: false, // If true, when a user reaches the last image in a set, the right navigation arrow will appear and they will be to continue moving forward which will take them back to the first image in the set.
  sanitizeTitle: false
})
</script>
@endif
@endsection