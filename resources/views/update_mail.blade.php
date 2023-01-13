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
						<span>Review Email Content</span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						@foreach($mail as $res)
						@php
						$booking_data=$booking->BookingData->where('department_id','=',$res->department_id)->first();
						if(empty($booking_data))
						{
                          continue;
						}elseif($booking_data->status==2){
								continue;	
						}
						@endphp
						<li class="nav-item" role="presentation">
							<button style="color:#172b4d" class="nav-link <?php if ($loop->iteration == 1) echo 'active'; ?>" id="tab{{$res->id}}" data-bs-toggle="tab" data-bs-target="#{{$res->department->title}}" type="button" role="tab" aria-controls="{{$res->department->title}}" aria-selected="true">{{$res->department->title}}</button>
						</li>
						@endforeach
					</ul>
					<div class="tab-content" id="myTabContent">
						@foreach($mail as $res)
						@php
						$booking_data=$booking->BookingData->where('department_id','=',$res->department_id)->first();
						if(empty($booking_data))
						{
                          continue;
						}elseif($booking_data->status==2){
								continue;	
						}

						$date=$booking_data->date;
						$id=$booking_data->id;
						if(!empty($res->products))
						{
						$res->body.="<br>";
						foreach($res->products as $product)
						{
						$res->body.="<p class='product'>$product- <input style='border-left: none;border-right: none;border-top: none;border-bottom:0.5px solid black;' type='text'></p>";
						}
						}

						$date=date("d-m-Y",strtotime($date));
						$time=date("h:i:s A",strtotime($date));
						$enc_key=base64_encode($booking_data->id);
						$url=URL("reply/$enc_key");
						$reply_link="<a href='".$url."' style='border: 1px solid transparent;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
	user-select: none;
	text-decoration: none !important;
    line-height: 1.5;
    border-radius: 0.25rem;color:#fff;background-color: #172b4d;border-color: #172b4d;'>Click here to approve or make a change request</a>";
						@endphp
						<div style="padding:5%" data-subject="{{$res->subject}}" data-id="{{$id}}" class="tab-pane fade <?php if ($loop->iteration == 1) echo 'show active'; ?> email_content" id="{{$res->department->title}}" role="tabpanel" aria-labelledby="{{$res->department->title}}-tab">
							<?php echo $res->body; ?>
							<br>
							For<br>
							{{$booking->address}}
							<br>
							<br>
							At
							<br>{{$date}}
							<br>{{$time}}
							<br><br>
							@if($booking_data->department_id != '2')
							<?php echo $reply_link . "<br>" ?>
							@endif
							<br>
							Thank You</br>
							Jules</br>
							Box It Foundations</br>
						
						</div>
						@endforeach
					</div>
				</div>
				<div class="col-md-2"><button id="send_email" class="btn btn-secondary">Send all emails</button>
				</div>

			</div>

		</div>
		@else
		<p style="margin-top:20%">Mails sent already</p>
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
		$(this).text("Sending...");
		var mail_data = [];
		$("#myTabContent").find("input").each(function() {
			if ($(this).val() == '' || $(this).val() == '0') {
				$(this).parents(".product").remove();
			} else {
				$(this).replaceWith($(this).val());
			}
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
				
			}
		});
		setTimeout(function(){
			$("#send_email").text("Sent");
				Toast.fire({
					icon: 'success',
					title: "Mail Sent successfuly."
				}).then(() => {
					window.location.href = "/";
				});
		}, 3000);

	})
	
	
</script>

@endsection