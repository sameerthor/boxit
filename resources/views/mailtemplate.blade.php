@extends('layouts.app')

@section('content')
<div id="content">
  <div class="container">
    <div class="card-new ptb-50">
      <div class="row">
        <div class="col-md-12">
          <div class="form-head">
            <span>Email Templates</span>
          </div>
        </div>
      </div>
      <table class="table table-stripped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Department</th>
                            <th>Title</th>
                            <th>Subject</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($templates as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{$item->department->title}}</td>
                                <td>{{$item->title}}</td>
                                <td>{{$item->subject}}</td>
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
  </div>

</div>

@endsection