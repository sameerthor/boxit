@extends('layouts.app')

@section('content')
<style>
  .fa-trash:before {
    content: "\f1f8";
    color: #69768c;
  }
</style>
<div id="content">
  <div class="container main">
    <div class="card-new ptb-50">
      <div class="row">
        <div class="col-md-12">
          <div class="form-head">
            <span>Projects</span>
          </div>
        </div>
      </div>
      @foreach($projects as $project)
      <div class="row w-50">
        <div class="col-md-12">
          <div class="bdr-btm project-flex ptb-25">
            <div class="p-name">
              <span>{{$project->address}}</span>
            </div>
            <div class="v-name details" data-id="{{$project->id}}">
              <span>View</span>
              <img src="img/edit.png">
            </div>
            <div class="v-name delete" data-id="{{$project->id}}">
              <span>Delete</span>
              <i class="fa fa-trash" aria-hidden="true"></i>
            </div>
          </div>
        </div>
      </div>
      @endforeach
      <div class="row w-50">
        <div class="col-md-12">
          <div class="project-flex ptb-25">
            <div class="v-name">
              <img src="img/plus-new.png">
              <span>Add New Project</span>
            </div>
          </div>
        </div>
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
  $(document).on("click", ".details", function() {
    var id = $(this).data('id');

    jQuery.ajax({
      url: "{{ url('/single-project') }}",
      method: 'post',
      data: {
        id: id,
      },
      success: function(result) {
        jQuery('.main').html(result);
      }
    });
  })

  $(document).on("click", ".delete", function() {
    var id = $(this).data('id');
    Swal.fire({
      title: "Do you want to delete ?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: 'Yes',
      confirmButtonColor: '#28a745',
      cancelButtonColor: '#dc3545',
      cancelButtonText: 'No',
      dangerMode: true,
    }).then(function(result) {
      if (result.isConfirmed) {
        jQuery.ajax({
      url: "{{ url('/delete-project') }}",
      method: 'post',
      data: {
        id: id,
      },
      success: function(result) {
        //window.location.reload();
      }
    });
      }
    });
    
  })
</script>
@endsection