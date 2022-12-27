<!DOCTYPE html>
<html lang="en">

<head>
  <title>Boxit</title>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
  <script src="{{ asset('js/timepicker/jquery.datetimepicker.js') }}" defer></script>
  <link rel="stylesheet" href="{{ asset('js/timepicker/jquery.datetimepicker.css') }}" />
</head>

<body>

  <div class="container">

    <!-- Modal -->
    <div class="modal fade show" id="myModal" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Confirmation</h4>
          </div>
          <div class="modal-body">
            <div id="confirm_text">
              <p>Address : <strong><u>{{$booking_data->booking->address}}</u></strong></p>
              <p>Department : <strong><u>{{$booking_data->department->title}}</u></strong></p>
              <p>Contact : <strong><u>{{$booking_data->contact->title}}</u></strong></p>
              <p>Date : <strong><u>{{date("d-m-Y h:i",strtotime($booking_data->date))}}</u></strong></p>
              <br>
              <h5>Do you want confirm  alternate datetime for this booking ?</h5>
               @foreach($booking_data->new_date as $key=>$val)
               <input type="radio" value="{{$key}}" id="{{$key}}_id" name="alternate_date" checked>
               <label for="html">{{$val}}</label><br>
               @endforeach
            </div>
            <div id="deny_text" style="display:none">
              <p>Sorry to hear that. Please suggest  alternate option below:</p>
              <input type="text" class="example" name="date">
            </div>
          </div>
          <div class="modal-footer">
            <div id="confirm_button">
              <button type="button" class="btn btn-success yes" data-id="1">Yes</button>
              <button type="button" class="btn btn-danger no">No</button>
            </div>
            <div id="cancel_button" style="display:none">
              <button type="button" class="btn btn-success submit" data-id="0">Submit</button>
            </div>
          </div>
        </div>

      </div>
    </div>

  </div>

</body>
<script type="text/javascript">
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $(window).on('load', function() {
    $('#myModal').modal('show');
  });
  $(".no").click(function() {
    $("#confirm_button").hide();
    $("#cancel_button").show();
    $("#confirm_text").hide();
    $("#deny_text").show();
  })
  $(".yes,.submit").click(function() {
    var confirm = $(this).data('id');
    jQuery.ajax({
      type: 'POST',
      url: "{{ route('admin.reply') }}",
      data: {
        booking_data_id: "{{$booking_data->id}}",
        alternate_date: $("input[name='alternate_date']:checked").val(),
        confirm: confirm,
        date: $("input[name='date']").val(),
      },
      success: function(data) {
        window.location.reload();
      }
    });
  });

  $(function() {
    $.datetimepicker.setDateFormatter('moment');
    $('.example').datetimepicker({
      format: 'DD-MM-YYYY h:mm A',
      formatTime:"h:mm A",
      step: 15
    });

    $(".example").attr("autocomplete", "off");
  });
</script>

</html>