@extends('layouts.app')

@section('content')

<style>
	input:focus {
		outline: none;
	}
</style>
<div id="content">
	<div class="container">
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
						@if($booking_data->department_id==$res->department_id)
						<li class="nav-item" role="presentation">
							<button style="color:#172b4d" class="nav-link <?php if ($loop->iteration == 1) echo 'active'; ?>" id="tab{{$res->id}}" data-bs-toggle="tab" data-bs-target="#c_{{$booking_data->id}}" type="button" role="tab" aria-controls="{{$res->department->title}}" aria-selected="true">{{$res->department->title}} {{$booking_data->service!=''?'('.$booking_data->service.')':''}}</button>
						</li>
						@endif
						@endforeach
					</ul>
					<div class="tab-content" id="myTabContent">
						@foreach($mail as $res)
						@php
						$booking_date=$booking_data->date;
						$id=$booking_data->id;
						$booking_id=$booking_data->booking_id;
						$product_html='<p></p>';
						if(!empty($res->products))
						{
						foreach($res->products as $product)
						{
						$product_html.="<p class='product'>$product x <input style='border-left: none;color:red;border-right: none;border-top: none;border-bottom:0.5px solid black;' type='text'></p>";
						}
						}

						$date=date("d-m-Y",strtotime($booking_date));
						$time=date("h:i A",strtotime($booking_date));
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
						<div style="padding:5%" data-subject="{{$res->subject}}" data-id="{{$id}}" class="tab-pane fade <?php if ($loop->iteration == 1) echo 'show active'; ?> " id="c_{{$booking_data->id}}" role="tabpanel" aria-labelledby="{{$res->department->title}}-tab">
							<div>
								<h5>Attachements</h5>
								<input type="file" class="form-control col-md-4" multiple>
							</div>
							<br>
							<div>
								<h5>SMS</h5>
								<textarea class="form-control sms_text" rows="13" placeholder="Please place text message (SMS) content here">
@if($booking_data->department_id!='2') 
Boxit Foundations &#013;	
{{$booking->address}} &#013;
{{$date}} {{$time}}
@if($booking_data->department_id=='8' || $booking_data->department_id=='9' || $booking_data->department_id=='10')
Placer: {{$booking->BookingData->contains('department_id', '9')?$booking->BookingData->firstWhere('department_id', '9')->contact->title:'N/A'}} &#013;
Pump: {{$booking->BookingData->contains('department_id', '10')?$booking->BookingData->firstWhere('department_id', '10')->contact->title:'N/A'}} &#013;
Concrete: {{$booking->BookingData->contains('department_id', '8')?$booking->BookingData->firstWhere('department_id', '8')->contact->title:'N/A'}}
@endif
{{$booking->floor_area}} M2 
{{$booking->floor_type}} Floor&#013; 
Please click on link below to confirm 
{{$url}} 
@else
Boxit Foundations	&#013;				
We would like to book your service for the project below -
{{$booking->address}} &#013;
{{$date}} {{$time}}    &#013;&#013;
Please click on link below to confirm this booking
{{$url}}
@endif 	
							</textarea>
							</div>
							<br>
							<div class="email_content" data-subject="{{$res->subject}}" data-id="{{$id}}">
								<textarea id="textArea{{$loop->iteration}}" class="email_body">{{$res->body}}</textarea>
								<?php echo @$product_html; ?>
								<br>
								@if(!empty($booking_data->service))
								Inspection Type - {{$booking_data->service}} <br>
								@endif
								@if($booking_data->department_id=='6' || $booking_data->department_id=='7' || $booking_data->department_id=='5')
								BCN- {{$booking->bcn!=''?$booking->bcn:'NA'}} <br>
								@endif
								Address: {{$booking->address}}<br>
								Date and Time: {{$date}} {{$time}}
								<br><br>
								<?php echo $reply_link . "<br>" ?>
								<br>
								Thank You,<br>
								Jules<br><br>
								<p style="display:none">Project ID #{{$booking_data->booking_id}}</p>
								<img src="https://boxit.staging.app/img/logo2581-1.png" style="width:75px;height:30px" class="mail-logo" alt="Boxit Logo">
							</div>
						</div>
						@endforeach
					</div>
				</div>
				<div class="col-md-2"><button id="send_email" class="btn btn-secondary">Send email</button>
				</div>

			</div>

		</div>

	</div>

</div>
<script>
	$(".email_body").each(function() {
		var id = $(this).attr('id');

		CKEDITOR.replace(id, {
			// Make the editing area bigger than default.
			height: 450,
			// Allow pasting any content.
			allowedContent: true,
			fillEmptyBlocks: false,
			// Fit toolbar buttons inside 3 rows.
			toolbarGroups: [{
					name: 'document',
					groups: ['mode', 'document', 'doctools']
				},
				{
					name: 'clipboard',
					groups: ['clipboard', 'undo']
				},
				{
					name: 'editing',
					groups: ['find', 'selection', 'spellchecker', 'editing']
				},
				{
					name: 'forms',
					groups: ['forms']
				},
				'/',
				{
					name: 'paragraph',
					groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']
				},
				{
					name: 'links',
					groups: ['links']
				},
				{
					name: 'insert',
					groups: ['insert']
				},
				'/',
				{
					name: 'styles',
					groups: ['styles']
				},
				{
					name: 'basicstyles',
					groups: ['basicstyles', 'cleanup']
				},
				{
					name: 'colors',
					groups: ['colors']
				},
				{
					name: 'tools',
					groups: ['tools']
				},
				{
					name: 'others',
					groups: ['others']
				},
				{
					name: 'about',
					groups: ['about']
				}
			],

			// Remove buttons irrelevant for pasting from external sources.
			removeButtons: 'ExportPdf,Form,Checkbox,Radio,TextField,Select,Textarea,Button,ImageButton,HiddenField,NewPage,CreateDiv,Flash,Iframe,About,ShowBlocks,Maximize',
		});
	});
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$("#send_email").click(function() {
		Swal.fire({
			title: "Do you want to send all mails ?",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: 'Yes',
			confirmButtonColor: '#28a745',
			cancelButtonColor: '#dc3545',
			cancelButtonText: 'No',
			dangerMode: true,
		}).then(function(result) {
			if (result.isConfirmed) {
				$(this).text("Sending...");
				var mail_data = [];
				$(".email_content").find("input").each(function() {
					if ($(this).val() == '' || $(this).val() == '0') {
						$(this).parents(".product").remove();
					} else {
						$(this).replaceWith('<span style="color:red">' + $(this).val() + '</span>');
					}
				});
				$(".email_content").find("textarea").each(function() {
					$(this).replaceWith(CKEDITOR.instances[$(this).attr('id')].getData().trim());
					CKEDITOR.instances[$(this).attr('id')].destroy();
				});

				var formdata = new FormData();
				$(".email_content").each(function(index) {
					formdata.append('mail_data[' + index + '][booking_id]', $(this).data('id'));
					formdata.append('mail_data[' + index + '][subject]', $(this).data('subject'));
					formdata.append('mail_data[' + index + '][body]', $(this).html());
					$.each($("input[type='file']")[index].files, function(i, file) {
						formdata.append('mail_data[' + index + '][files][]', file);
					});
					formdata.append('mail_data[' + index + '][sms_text]', $(".sms_text").eq(index).val());
				});
				jQuery.ajax({
					type: 'POST',
					dataType: 'json',
					cache: false,
					contentType: false,
					processData: false,
					url: "{{ route('send_mail') }}",
					data: formdata,
					success: function(data) {

					}
				});
				setTimeout(function() {
					$("#send_email").text("Sent");
					Toast.fire({
						icon: 'success',
						title: "Mail Sent successfuly."
					}).then(() => {
						window.location.href = "/projects?project_id={{$booking_id}}";
					});
				}, 3000);


			}
		});
	})
</script>

@endsection