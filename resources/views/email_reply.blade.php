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
          <p id="confirm_text">Do you want to confirm this booking ?</p>
          <div id="deny_text" style="display:none"><p>Sorry to hear that. Please suggest few alternate options below:</p>
          <input type="date" name="date1">
<input type="date" name="date2">
<input type="date" name="date3"></div>
        </div>
        <div class="modal-footer">
         <div id="confirm_button">   
        <button type="button" class="btn btn-success yes" data-id="1">Yes</button>
          <button type="button" class="btn btn-danger no" >No</button>
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
    $(".no").click(function(){
        $("#confirm_button").hide();
        $("#cancel_button").show();
        $("#confirm_text").hide();
        $("#deny_text").show();
    })
    $(".yes,.submit").click(function(){
    var confirm  = $(this).data('id');
    jQuery.ajax({
        type: 'POST',
        url: "{{ route('mail.reply') }}",
        data: {
          booking_data_id:"{{$booking_data->id}}",  
          confirm:confirm,
          date1:$("input[name='date1']").val(),
          date2:$("input[name='date2']").val(),
          date3:$("input[name='date3']").val()
        },
        success: function(data) {
  window.location.reload();
        }
      });
    });
</script>
</html>
