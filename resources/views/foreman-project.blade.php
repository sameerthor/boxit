@extends('layouts.app')

@section('content')
<style>
  .fa-trash:before {
    content: "\f1f8";
    color: #69768c;
  }

  .fa.fa-trash {
    position: inherit !important;
  }
  div.completed_button {
    min-width: 225px !important;
    text-align: center;
}

div.year, div.month {
    padding-right: 0px;
}

.completed_button a {
    border: 2px solid #182a4e;
    background-color: #fff;
    color: #182a4e;
    border-radius: 3px;
    padding: 5px;
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
      <div class="row">
        <div class="col-md-5">
        </div>
        <div class="col-md-7">
        <form method="get" id="filterForm" action="{{url('check-list')}}">
        <div class="row">
                <div class="col-md-3 completed_button">
                 <a href="{{url('projects')}}?completed_projects=<?php echo request()->get('completed_projects') == 1?0:1 ;echo request()->get('q') != '' ? '&q='.request()->get('q'):'';?>" class="form-control {{request()->get('completed_projects') == 1? 'active_completed_button' : ''}}" >Completed Projects</a>
                 <input type="text" style="display:none" name="completed_projects" value="{{request()->get('completed_projects')}}" >
                </div>
                <div class="col-md-3 completed_button">
                 <a href="{{url('projects')}}?passed_with_cond=<?php echo request()->get('passed_with_cond') == 1?0:1 ;echo request()->get('q') != '' ? '&q='.request()->get('q'):'';?>" class="form-control {{request()->get('passed_with_cond') == 1? 'active_completed_button' : ''}}" >Passed With Conditions</a>
                 <input type="text" style="display:none" name="completed_projects" value="{{request()->get('passed_with_cond')}}" >
                </div>
                <div class="col-md-2 month">
                  <select class="form-control" name="month">
                    <option value="">Month</option>
                    @foreach($months as $key=>$val)
                    <option <?php if (request()->get('month') == $key + 1) {
                              echo "selected";
                            } ?> value="{{$key+1}}">{{$val}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-2 year">
                  <select class="form-control" name="year">
                    <option value="">Year</option>
                    @for($i=date("Y");$i>=2022;$i--)
                    <option <?php if (request()->get('year') == $i) {
                              echo "selected";
                            } ?> value="{{$i}}">{{$i}}</option>
                    @endfor
                  </select>
                </div>
                <div class="col-md-1 filter_button">
                  <button type="submit" class="btn btn-info btn-color">FILTER</button>
                  @if(!empty(request()->get('completed_projects')) || !empty(request()->get('month')) || !empty(request()->get('year')))
                  <span onclick="window.location.href=window.location.pathname"><i class="fa fa-times fa-lg" aria-hidden="true"></i></span>
                 @endif
                </div>
              </div>
            </form>
        </div>
      </div>
      <div class="card-body">
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
              </td>
            </tr>
            @endforeach
            @else
            <p>No Project is available.</p>
          </tbody>
        </table>
        @endif
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
  
    
  $(document).ready(function(){
    var urlParams = new  URLSearchParams(window.location.search);
     if(urlParams.has('project_id'))
     {  
     var id =  urlParams.get('project_id');
    jQuery.ajax({
      url: "{{ url('/foreman-single-project') }}",
      method: 'post',
      data: {
        id: id,
      },
      success: function(result) {
        jQuery('.main').html(result);
      }
    });

     }
  });
  $(document).on("click", ".details", function() {
    var id = $(this).data('id');
   
    jQuery.ajax({
      url: "{{ url('/foreman-single-project') }}",
      method: 'post',
      data: {
        id: id,
      },
      success: function(result) {
        jQuery('.main').html(result);
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