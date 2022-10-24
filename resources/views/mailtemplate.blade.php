@extends('layouts.app')

@section('content')
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
      </ul>
      <div class="tab-content" id="myTabContent">
        <div style="padding:5%" d="" class="tab-pane fade active show" id="tab1" role="tabpanel" aria-labelledby="1-tab">
          <table class="table table-stripped">
            <thead>
              <tr>
                <th>#</th>
                <th>Department</th>
                <th>Subject</th>
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
                <td>{{$item->subject}}</td>
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
        <div style="padding:5%" d="" class="tab-pane fade active show" id="tab2" role="tabpanel" aria-labelledby="2-tab">
        <table class="table table-stripped">
            <thead>
              <tr>
                <th>#</th>
                <th>Department</th>
                <th>Subject</th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @forelse($foreman_templates as $item)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{$item->ProjectStatusLabel->label}}</td>
                <td>{{$item->subject}}</td>
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
@endsection