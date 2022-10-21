@extends('layouts.app')

@section('content')
<style>
	input:focus {
		outline: none;
	}
</style>
<div id="content">
	<div class="container">
		@if($booking->mail_sent==0)
		<div class="card ptb-50">
			<div class="row">
				<div class="col-md-12">
					<div class="form-head">
						<span>Update Mail Data</span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						@foreach($mail as $res)
						<li class="nav-item" role="presentation">
							<button style="color:#172b4d" class="nav-link <?php if ($loop->iteration == 1) echo 'active'; ?>" id="tab{{$res->id}}" data-bs-toggle="tab" data-bs-target="#{{$res->department->title}}" type="button" role="tab" aria-controls="{{$res->department->title}}" aria-selected="true">{{$res->department->title}}</button>
						</li>
						@endforeach
					</ul>
					<div class="tab-content" id="myTabContent">
						@foreach($mail as $res)
						@php
						$booking_data=$booking->BookingData->where('department_id','=',$res->department_id)->first();
						$date=$booking_data->date;
						$id=$booking_data->id;
						$res->body=str_replace('[address]',$booking->address,$res->body);
						$res->body=str_replace('[date]',date("d-m-Y",strtotime($date)),$res->body);
						$res->body=str_replace('[time]',date("h:i:s",strtotime($date)),$res->body);
						$enc_key=base64_encode($booking_data->id);
						$url=URL("reply/$enc_key");
						$res->body=str_replace('[link]',"<a href='".$url."' style='border: 1px solid transparent;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
	user-select: none;
	text-decoration: none !important;
    line-height: 1.5;
    border-radius: 0.25rem;color:#fff;background-color: #172b4d;border-color: #172b4d;'>CLICK HERE TO CONFIRM OR DENY BOOKING</a>",$res->body);
						$res->body=preg_replace('/[\[{\(].*?[\]}\)]/' ,"<input style='border-left: none;border-right: none;border-top: none;border-bottom:0.5px solid black;' type='text'>", $res->body);
						@endphp
						<div style="padding:5%" data-subject="{{$res->subject}}" data-id="{{$id}}" class="tab-pane fade <?php if ($loop->iteration == 1) echo 'show active'; ?> email_content" id="{{$res->department->title}}" role="tabpanel" aria-labelledby="{{$res->department->title}}-tab"><?php echo $res->body ?></div>
						@endforeach
					</div>
				</div>
				<div class="col-md-2"><button id="send_email" class="btn btn-secondary">Send Email</button>
				</div>

			</div>

		</div>
		@else
		<p style="margin-top:20%">Mail sent already</p>
		@endif
	</div>

</div>
<script>
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$("#send_email").click(function() {
		var mail_data = [];
		$("#myTabContent").find("input").each(function() {
			$(this).replaceWith($(this).val());
		});
		$(".email_content").each(function() {

			mail_data.push({
				booking_id: $(this).data('id'),
				subject: $(this).data('subject'),
				'body': $(this).html()
			});
		});
		jQuery.ajax({
			type: 'POST',
			url: "{{ route('send_mail') }}",
			data: {
				mail_data: mail_data,
			},
			success: function(data) {
				Toast.fire({
					icon: 'success',
					title: "Mail Sent successfuly."
				}).then(() => {
					window.location.href = "/";
				});
			}
		});
	})
</script>

@endsection