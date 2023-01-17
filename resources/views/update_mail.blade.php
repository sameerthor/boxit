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
						$product_html='';
						if(!empty($res->products))
						{
						$product_html="<br>";
						foreach($res->products as $product)
						{
						$product_html.="<p class='product'>$product- <input style='border-left: none;border-right: none;border-top: none;border-bottom:0.5px solid black;' type='text'></p>";
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
							<textarea id="textArea{{$loop->iteration}}">{{$res->body}}</textarea>
						    <?php echo $product_html; ?>
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
							Thank You</br><br>
							Jules</br>
							Boxit Foundations</br>
						
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
		$(this).text("Sending...");
		var mail_data = [];
		$("#myTabContent").find("input").each(function() {
			if ($(this).val() == '' || $(this).val() == '0') {
				$(this).parents(".product").remove();
			} else {
				$(this).replaceWith($(this).val());
			}
		});
		$("#myTabContent").find("textarea").each(function() {
				$(this).replaceWith(tinymce.get($(this).attr('id')).getContent());
				tinymce.get($(this).attr('id')).remove();
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