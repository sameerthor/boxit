@extends('layouts.app')

@section('content')
<script src="/js/tinymce/js/tinymce/tinymce.min.js"></script>

<script src="https://cdn.tiny.cloud/1/jq9mby0hzla0mq6byj05yjmflbj55i7tl74g9v8w8no32jb6/tinymce/6/plugins.min.js" referrerpolicy="origin"></script>

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
						@php
						$booking_datas=$booking->BookingData->where('id','=',$id);
						if(empty($booking_datas))
						{
						continue;
						}
						foreach($booking_datas as $booking_data)
						{
						if($booking_data->status==2){
						continue;
						}
						@endphp
						<li class="nav-item" role="presentation">
							<button style="color:#172b4d" class="nav-link <?php if ($loop->iteration == 1) echo 'active'; ?>" id="tab{{$res->id}}" data-bs-toggle="tab" data-bs-target="#c_{{$booking_data->id}}" type="button" role="tab" aria-controls="{{$res->department->title}}" aria-selected="true">{{$res->department->title}} {{$booking_data->service!=''?'('.$booking_data->service.')':''}}</button>
						</li>
						@php } @endphp
						@endforeach
					</ul>
					<div class="tab-content" id="myTabContent">
						@foreach($mail as $res)
						@php
						$bookings=$booking->BookingData->where('department_id','=',$res->department_id);
						if(empty($bookings))
						{
						continue;
						}
						foreach($bookings as $booking_data)
						{
						if($booking_data->status==2){
						continue;
						}
					
						$booking_date=$booking_data->date;
						$id=$booking_data->id;
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
							<div class="email_content" data-subject="{{$res->subject}}" data-id="{{$id}}">
								<textarea id="textArea{{$loop->iteration}}">{{$res->body}}</textarea>
								<?php echo @$product_html; ?>
								@if($booking_data->department_id=='6' || $booking_data->department_id=='7' || $booking_data->department_id=='5')
								<br> BCN- {{$booking->bcn!=''?$booking->bcn:'NA'}} <br>
								@endif
								Address: {{$booking->address}}<br>
								Date and Time: {{$date}} {{$time}}
								<br><br>
								@if($booking_data->department_id != '2')
								<?php echo $reply_link . "<br>" ?>
								@endif
								<br>
								Thank You,<br>
								Jules<br><br>
								<p style="display:none">#{{$booking_data->booking_id}}</p>
								<img src="https://boxit.staging.app/img/logo2581-1.png" style="width:75px;height:30px" class="mail-logo" alt="Boxit Logo">
							</div>
						</div>
						@php } @endphp
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
	tinymce.init({
		selector: "textarea",
		plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
		menubar: 'file edit view insert format tools table tc help',
		toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media pageembed template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
		autosave_ask_before_unload: true,
		image_advtab: true,
		height: 300,
		image_caption: true,
		toolbar_mode: 'sliding',
		contextmenu: 'link image imagetools table configurepermanentpen',

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
					$(this).replaceWith(tinymce.get($(this).attr('id')).getContent({
						format: 'raw'
					}));
					tinymce.get($(this).attr('id')).remove();
				});

				var formdata = new FormData();
				$(".email_content").each(function(index) {
					formdata.append('mail_data[' + index + '][booking_id]', $(this).data('id'));
					formdata.append('mail_data[' + index + '][subject]', $(this).data('subject'));
					formdata.append('mail_data[' + index + '][body]', $(this).html());
					$.each($("input[type='file']")[index].files, function(i, file) {
						formdata.append('mail_data[' + index + '][files][]', file);
					});

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
						window.location.href = "/";
					});
				}, 3000);


			}
		});
	})
</script>

@endsection