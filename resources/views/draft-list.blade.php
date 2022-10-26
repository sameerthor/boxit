@extends('layouts.app')

@section('content')

<div id="content">
  <div class="container">
<div class="card-new">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-head">
                    <span>Drafts</span>
                </div>
            </div>
        </div>
        <br/>
        <table class="table table-stripped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Action</th>
                   
                </tr>
            </thead>
            <tbody>
                @foreach($drafts as $res)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$res->address}}</td>
                    <td>
                        <a href="/draft/{{$res->id}}" target="_blank" class="btn btn-sm btn-outline-success"><i class="fa fa-camera"></i>View</a>
                        <a href="#" target="_blank" class="btn btn-sm btn-outline-warning"><i class="fa fa-trash"></i>Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
  </div>
</div>
@endsection