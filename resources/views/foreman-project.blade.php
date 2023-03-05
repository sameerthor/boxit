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
        <div class="col-md-6">
        </div>
        <div class="col-md-6">
          <form method="get" action="{{url('projects')}}">
            <div class="row">
              <div class="col-md-4">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" <?php if (request()->get('completed_projects') == 1) {
                                                                    echo "checked";
                                                                  } ?> name="completed_projects" value="1" id="completedProject">
                  <label class="form-check-label" for="completedProject">
                    Completed Projects
                  </label>
                </div>
              </div>
              <div class="col-md-3">
                <select class="form-control" name="month">
                  <option value="">Month</option>
                  @foreach($months as $key=>$val)
                  <option <?php if (request()->get('month') == $key + 1) {
                            echo "selected";
                          } ?> value="{{$key+1}}">{{$val}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <select class="form-control" name="year">
                  <option value="">Year</option>
                  @for($i=date("Y");$i>=1970;$i--)
                  <option <?php if (request()->get('year') == $i) {
                            echo "selected";
                          } ?> value="{{$i}}">{{$i}}</option>
                  @endfor
                </select>
              </div>
              <div class="col-md-2">
                <button type="submit" class="btn btn-info btn-color">FILTER</button>
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
  $(document).on("click", ".details", function() {
    var id = $(this).data('id');
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
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
</script>
@endsection