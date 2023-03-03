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
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">

<style>
   .modal {
  text-align: center;
}

@media screen and (min-width: 768px) { 
  .modal:before {
    display: inline-block;
    vertical-align: middle;
    content: " ";
    height: 100%;
  }
}

.modal-dialog {
  display: inline-block;
  text-align: left;
  vertical-align: middle;
}
</style>
</head>

<body>

  <div class="container">
  <div id="overlay">
  <div class="cv-spinner">
    <span class="spinner"></span>
  </div>
</div>
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
              <p>Date : <strong><u>{{date("d-m-Y h:i A",strtotime($booking_data->date))}}</u></strong></p>
            
              <h5>Do you want to confirm this booking ?</h5>
            </div>
            <div id="deny_text" style="display:none">
              <p>‘If you would like to make a date/time change request, please select up to three time options below. Alternatively please contact admin@boxitfoundations.co.nz with any queries</p>
              <input type="text" class="example" placeholder="Choose Date & Time" name="date1">
              <input type="text" class="example" placeholder="Choose Date & Time" name="date2">
              <input type="text" class="example" placeholder="Choose Date & Time" name="date3">
            </div>
          </div>
          <div class="modal-footer">
            <div id="confirm_button">
              <button type="button" class="btn btn-success yes" data-id="1">Yes</button>
              <button type="button" class="btn btn-danger no">No</button>
            </div>
            <div id="cancel_button" style="display:none">
              <button type="button" class="btn btn-success submit" data-id="2">Submit</button>
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
    $(".modal-title").hide();
    $("#confirm_button").hide();
    $("#cancel_button").show();
    $("#confirm_text").hide();
    $("#deny_text").show();
  })
  $(".yes,.submit").click(function() {
    var confirm = $(this).data('id');
    if(confirm==2)
    {
      
      if($("input[name='date1']").val()=="" && $("input[name='date2']").val()=="" && $("input[name='date3']").val()=="")
      {
      alert("please select any date.");
      return false;
      }
    }
    jQuery.ajax({
      type: 'POST',
      url: "{{ route('mail.reply') }}",
      data: {
        booking_data_id: "{{$booking_data->id}}",
        confirm: confirm,
        date1: $("input[name='date1']").val(),
        date2: $("input[name='date2']").val(),
        date3: $("input[name='date3']").val()
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

  $(document).ajaxSend(function() {
    $("#overlay").show();　
  });
  $( document ).ajaxComplete(function() {
    $("#overlay").hide();　
});
</script>

</html>