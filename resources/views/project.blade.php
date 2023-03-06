@extends('layouts.app')

@section('content')
<style>

  .fa.fa-trash {
    position: inherit !important;
  }
  .fa.fa-times:before {
    color: red;
  }
  #completed_button{
   
    border: 2px solid #182a4e;
    background-color: #fff;
    color: #182a4e;
    border-radius: 3px;
    padding: 5px;
    padding-left: 7%;
    text-decoration: none;
  }
  .active_completed_button{
    background-color: #182a4e !important;
    color: white !important;
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
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
          </div>
          <div class="col-md-6">
            <form method="get" id="filterForm" action="{{url('projects')}}">
              <div class="row">
                <div class="col-md-4">
                 <a href="{{url('projects')}}?completed_projects=<?php echo request()->get('completed_projects') == 1?0:1 ;?>" class="form-control {{request()->get('completed_projects') == 1? 'active_completed_button' : ''}}" id="completed_button">Completed Projects</a>
                 <input type="text" style="display:none" name="completed_projects" value="{{request()->get('completed_projects')}}" >
                </div>
                <div class="col-md-3">
                  <select class="form-control" name="month" id="month">
                    <option value="">Month</option>
                    @foreach($months as $key=>$val)
                    <option <?php if (request()->get('month') == $key + 1) {
                              echo "selected";
                            } ?> value="{{$key+1}}">{{$val}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-2">
                  <select class="form-control" name="year" id="year">
                    <option value="">Year</option>
                    @for($i=date("Y");$i>=2022;$i--)
                    <option <?php if (request()->get('year') == $i) {
                              echo "selected";
                            } ?> value="{{$i}}">{{$i}}</option>
                    @endfor
                  </select>
                </div>
                <div class="col-md-3">
                  <button type="submit" id="filter_button" class="btn btn-info btn-color">FILTER</button>
                  @if(!empty(request()->get('completed_projects')) || !empty(request()->get('month')) || !empty(request()->get('year')))
                  <span onclick="window.location.href=window.location.pathname"><i class="fa fa-times fa-lg" aria-hidden="true"></i></span>
                 @endif
                </div>
              </div>
            </form>
          </div>
        </div>
        @if(count($projects)>0)
        <table class="table table-stripped">
          <thead>
            <tr>
              <th>Title</th>
              <th class="t-center">Action</th>

            </tr>
          </thead>
          <tbody>
            @foreach($projects as $project)
            <tr>
              <td>{{$project->address}}</td>
              <td class="t-center">
                <a href="javascript:void(0)" data-id="{{$project->id}}" class="btn btn-sm btn-outline-success details"><i class='fa fa-edit'></i></a>
                <a href="javascript:void(0)" data-id="{{$project->id}}" class="btn btn-sm btn-outline-danger delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
              </td>
            </tr>
            @endforeach
            @else
            <p>No Project is available.</p>
          </tbody>
        </table>
        @endif
        <div class="row">
          <div class="col-md-12">
            <div class=" ptb-25">
              <div class="v-name">
                <img src="img/plus-new.png">
                <a href="/bookings"><span>Add New Project</span></a>
              </div>
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


          }
        });
        Toast.fire({
          icon: 'success',
          title: "Project Deleted Successfuly."
        }).then(() => {
          window.location.reload();
        });
      }
    });

  })

  $("#filterForm").on("submit",function(e){
    if($("select[name='month']").val()!='' && $("select[name='year']").val()=='')
    {
      alert("Please select year.")
      e.preventDefault();
    }
  })
</script>
@endsection