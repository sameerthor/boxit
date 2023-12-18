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
        @if(count($drafts)>0)
        <table class="table table-stripped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th class="t-center">Action</th>
                   
                </tr>
            </thead>
            <tbody>
                @foreach($drafts as $res)
                <tr>
                    <td>{{$res->address}}</td>
                    <td class="t-center">
                        <a href="/draft/{{$res->id}}"  class="btn btn-sm btn-outline-success"><i class='fa fa-edit'></i></a>
                        @if(!Auth::user()->hasRole('Foreman'))
                        <a href="javascript:void(0)" data-url="/delete-draft/{{$res->id}}"  class="btn btn-sm btn-outline-danger delete-draft"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        @endif
                    </td>
                </tr>
                @endforeach
                @else
                <p>No draft is available.</p>
            </tbody>
        </table>
        @endif

    </div>
</div>
  </div>
</div>
<script>
    $(".delete-draft").click(function(){
        var url=$(this).data('url');
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
                window.location.href=url;
            }});
    })
</script>
@endsection