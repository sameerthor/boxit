@extends('layouts.app')

@section('content')
<div id="content">
    <div class="container">
        <div class="card-new ptb-50">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-head">
                        <span>Concrete Email</span>
                    </div>
                </div>
            </div>
            <div class="row d-flex pb-40">
                <div class="col-md-3 select-style">
                    <select id="concrete_contacts">
                        <option value="0">All Concrete</option>
                        @foreach($concrete_contacts as $contact)
                        <option value="{{$contact->id}}">{{$contact->title}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-9 text-r">
                    <button type="button" data-toggle="modal" data-target="#contact_form"  class="btn btn-lg btn-info btn-color">Download/Email Sheet</button>
                </div>
            </div>
            <div class=" row">
                <div class="col-md-12">
                    <table class="table table-w-80">
                        <thead class="border-n">

                            <tr>
                                <th>Date</th>
                                <th>Project Name</th>
                                <th>Order Items</th>
                                <th>Supplier Name.</th>
                            </tr>

                        </thead>
                        <tbody class="tr-border td-styles tr-hover" id="concrete_table">
                            @foreach($concrete_bookings as $res)
                            <tr>
                                <th>{{$res->date}}</th>
                                <th>{{$res->booking->address}}</th>
                                <th></th>
                                <th>{{$res->contact->title}}</th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

</div>
<div class="modal fade" tabindex="-1" role="dialog" id="contact_form">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span id="modal_title"></span>Download/Email Sheet</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <table class="table table-w-80">
                        <thead class="border-n">

                            <tr>
                                <th>Supplier</th>
                                <th>Action</th>
                            </tr>

                        </thead>
                        <tbody class="tr-border td-styles tr-hover" id="concrete_table">
                        @foreach($concrete_contacts as $contact)
                            <tr>
                                <th>{{$contact->title}}</th>
                                <th><a href="/concrete-download/{{$contact->id}}" class="btn btn-sm btn-info btn-color">Download</a> <a href="/concrete-email/{{$contact->id}}" class="btn btn-sm btn-info btn-color">Email</a></th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
            <div class="modal-footer">
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
        $('#concrete_contacts').on('change', function () {
            refreshtable();
        });

        function refreshtable() {
            var contact_id = $("#concrete_contacts").val();
            $.ajax({
                type: 'POST',
                url: "{{ route('concrete.table') }}",
                data: {
                    contact_id: contact_id,
                },
                success: function (data) {
                    $("#concrete_table").html(data)
                }
            });
        }
    


</script>
@endsection