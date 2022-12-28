@extends('layouts.app')

@section('content')
<style>
   iframe {
            display: block;
            width: 100%;
            border: none;
            overflow-y: auto;
            overflow-x: hidden;
        }
        #tab3{
            height: 100vh;
        }
</style>
<div id="content">
  <div class="container">
    <div class="card-new ptb-50">
      <div class="row">
        <div class="col-md-12">
          <div class="form-head">
            <span>Settings</span>
          </div>
        </div>
      </div>
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button style="color:#172b4d" class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1" aria-selected="true">Booking Email Templates</button>
        </li>
        <li class="nav-item" role="presentation">
          <button style="color:#172b4d" class="nav-link" data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2" aria-selected="false">Foreman Email Templates</button>
        </li>
        <li class="nav-item" role="presentation">
          <button style="color:#172b4d" class="nav-link" data-bs-toggle="tab" data-bs-target="#tab3" type="button" role="tab" aria-controls="tab3" aria-selected="false"> Email Logs</button>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent">
        <div style="padding:2% 1%" d="" class="tab-pane fade active show" id="tab1" role="tabpanel" aria-labelledby="1-tab">
          <table class="table table-stripped">
            <thead>
              <tr>
                <th>#</th>
                <th>Department</th>
                <th>Status</th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @forelse($templates as $item)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{$item->department->title}}</td>
                <td>
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input customSwitch" data-id="{{$item->id}}" id="customSwitch{{ $loop->iteration }}" @if($item->status==1) checked @endif>
                    <label class="custom-control-label" for="customSwitch{{ $loop->iteration }}"></label>
                  </div>
                </td>
                <td>
                  <a href="{{url('mail-template/' . $item->id)}}" class="btn btn-sm btn-outline-info btn-edit"><i class="fa fa-edit"></i> Edit</a>
                </td>
                <td>
                  <a href="{{url('mail-template/preview/' . $item->id)}}" target="_blank" class="btn btn-sm btn-outline-success"><i class="fa fa-camera"></i> Preview</a>

              </tr>
              @empty
              <tr>
                <td colspan="4">No mail templates</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div style="padding:2% 1%" d="" class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="2-tab">
        <table class="table table-stripped">
            <thead>
              <tr>
                <th>#</th>
                <th>Department</th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @forelse($foreman_templates as $item)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{$item->ProjectStatusLabel->label}}({{$item->status==1?'Yes':'No'}})</td>
                <td>
                  <a href="{{url('foreman-template/' . $item->id)}}" class="btn btn-sm btn-outline-info btn-edit"><i class="fa fa-edit"></i> Edit</a>
                </td>
                <td>
                  <a href="{{url('foreman-template/preview/' . $item->id)}}" target="_blank" class="btn btn-sm btn-outline-success"><i class="fa fa-camera"></i> Preview</a>

              </tr>
              @empty
              <tr>
                <td colspan="4">No mail templates</td>
              </tr>
              @endforelse
            </tbody>
          </table>
      </div>
      <div style="padding:2% 1%"  d="" class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="3-tab">
      <iframe src="/_mail-viewer" id="iframe" frameborder="0" marginheight="0" marginwidth="0" width="100%" height="100%" scrolling="auto">Browser not compatible.</iframe>
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
  $(".customSwitch").change(function() {
    var checked = $(this).is(':checked');
    var id = $(this).data('id');
    jQuery.ajax({
      type: 'POST',
      url: "{{ route('mail.update') }}",
      data: {
        status: checked,
        id: id
      },
      success: function(data) {
        var text = checked === true ? 'activated' : 'deactivated';
        Toast.fire({
          icon: 'success',
          title: "Mail template " + text + " successfuly."
        })
      }
    });
  });
 
</script>
<script type="text/javascript">
var frameListener;
$(window).load(function () {
    frameListener = setInterval("frameLoaded()", 50);
});
function frameLoaded() {
    var frame = $('iframe').get(0);
    if (frame != null) {
        var frmHead = $(frame).contents().find('head');
        if (frmHead != null) {
          var css = '<style type="text/css">div#app header {display: none;} </style>';
jQuery(frmHead).append(css);  }
    }
}
</script>
@endsection