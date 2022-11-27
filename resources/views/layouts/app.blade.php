<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Scripts -->
	<script src="{{ asset('js/app.js') }}" defer></script>

	<!-- Fonts -->
	<link rel="dns-prefetch" href="//fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

	<!-- Styles -->
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('css/responsive.css') }}" rel="stylesheet">
	<link href="{{ asset('css/style.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('js/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.33/dist/sweetalert2.all.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
	<script src="{{ asset('js/timepicker/jquery.datetimepicker.js') }}" defer></script>
	<script src="{{ asset('js/repeater/repeater.js') }}" defer></script>
	<link rel="stylesheet" href="{{ asset('js/timepicker/jquery.datetimepicker.css') }}" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>

<body>
	<div id="app">
		@auth
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-2 blue-bg pos-rel p-none z-in1">
					<div id="sidebar">
						<div class="logo-sec">
							<img src="/img/logo2581-1.png">
						</div>
						<ul class="li-flex li-styles p-none list-none">
							<li class="{{ request()->routeIs('home') ? 'active' : '' }}"><a href="{{url('/')}}" class="nav_link"><img src="/img/calendar.png">Calendar</a></li>
							@if(Auth::user()->hasRole('Admin'))
							<li class="{{ request()->routeIs('booking') ? 'active' : '' }}"><a href="{{url('/bookings')}}" class="nav_link"><img src="/img/booking.png">Bookings</a>
							<li class="{{ request()->routeIs('drafts') || request()->routeIs('draft') ? 'active' : '' }}"><a href="{{url('/drafts')}}" style="margin-left:20px" class="nav_link"><img src="/img/booking.png">Drafts</a>
							<li class="{{ request()->routeIs('contact') ? 'active' : '' }}"><a href="{{url('/contacts')}}" class="nav_link"><img src="/img/contacts.png">Contacts</a></li>
							<li class="{{ request()->routeIs('project') ? 'active' : '' }}"><a href="{{url('/projects/')}}" class="nav_link"><img src="/img/projects.png">Projects</a></li>
							<li class="{{ request()->routeIs('mail_template') ? 'active' : '' }}"><a href="{{url('/mail-template')}}" class="nav_link"><img src="/img/job.png">Settings</a></li>
							@endif
							@if(Auth::user()->hasRole('Foreman'))
							<li class="{{ request()->routeIs('check-list') ? 'active' : '' }}"><a href="{{url('/check-list')}}" class="nav_link"><img src="/img/booking.png">Check List</a></li>
							@endif
						</ul>

					</div>
				</div>
				<div class="col-md-10 mt-40 mb-100 p-none">
					<div class="container pl-none pr-60">
						<div id="header" class="mb-40 prl-30">
							<div class="row d-flex">
								<div class="col-md-8">
									<form method="get" action="/projects">
									<div class="search-wrapper <?php if (request('q')) echo 'active';?>">
										<div class="input-holder">
											<input type="text" name="q" class="search-input submit_on_enter" value="{{ Request::get('q') }}" placeholder="Type & Press Enter to Search " />
											<button class="search-icon" type="button" onclick="searchToggle(this, event);"><img src="/img/search.png"></button>
										</div>
										<span class="close" onclick="searchToggle(this, event);"></span>
									
									</div>
									</form>
								</div>
								<div class="col-md-1 pr-none text-right">
								
										
								
									<div class = "notification">
  <a href = "#">
  <div class = "notBtn" href = "#">
    <!--Number supports double digets and automaticly hides itself when there is nothing between divs -->
    <div class = "number">{!! Helper::notificationCount() !!}</div>
    <img src="/img/notification.png">
      <div class = "box">
        <div class = "display">
          <div class = "nothing"> 
            <i class="fa fa-child stick"></i> 
            <div class = "cent">Looks Like your all caught up!</div>
          </div>
          <!-- <div class = "cont">
		  <div class = "sec new">
               <div class = "txt">Brie liked your post: "Pure css notification box"</div>
              <div class = "txt sub">11/6 - 9:35 pm</div>
            </div>
			<div class = "sec new">
               <div class = "txt">Brie liked your post: "Pure css notification box"</div>
              <div class = "txt sub">11/6 - 9:35 pm</div>
            </div>
			<div class = "sec new">
               <div class = "txt">Brie liked your post: "Pure css notification box"</div>
              <div class = "txt sub">11/6 - 9:35 pm</div>
            </div>
			<div class = "sec new">
               <div class = "txt">Brie liked your post: "Pure css notification box"</div>
              <div class = "txt sub">11/6 - 9:35 pm</div>
            </div>
			<div class = "sec new">
               <div class = "txt">Brie liked your post: "Pure css notification box"</div>
              <div class = "txt sub">11/6 - 9:35 pm</div>
            </div>
			<div class = "sec new">
               <div class = "txt">Brie liked your post: "Pure css notification box"</div>
              <div class = "txt sub">11/6 - 9:35 pm</div>
            </div>
         </div> -->
        </div>
     </div>
  </div>
    </a>
</div>
								</div>
								<div class="col-md-1 text-right">
									<div>
										<span class="profile_letter">{{mb_substr(strtoupper(Auth::user()->name), 0, 1)}}</span>
									</div>
								</div>
								<div class="col-md-1 p-none">
									<div>
										<p class="admin-s">{{ucfirst(Auth::user()->name)}}<br>
											<span>{{Auth::user()->email}}</span>
										</p>
									</div>
								</div>
								<div class="col-md-1">
									<div>
										<img src="/img/arrow.png" data-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false">
										<div class="dropdown-menu">
											<!-- <a href="javascript:void(0)"  class="dropdown-item">Edit</a> -->
											<a href="javascript:void(0)" class=" dropdown-item" onclick="event.preventDefault();document.getElementById('frm-logout').submit();">Logout</a>
											<form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
												{{ csrf_field() }}
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
						@yield('content')
					</div>
				</div>
			</div>
		</div>
		@endauth
		@guest
		<main class="py-4">
			@yield('content')
		</main>
		@endguest
	</div>
</body>
<script>
	const Toast = Swal.mixin({
		toast: true,
		position: 'bottom-end',
		showConfirmButton: false,
		timer: 3000,
		timerProgressBar: true,
		didOpen: (toast) => {
			toast.addEventListener('mouseenter', Swal.stopTimer)
			toast.addEventListener('mouseleave', Swal.resumeTimer)
		}
	})
	<?php
	if (session('succes_msg')) { ?>
		Toast.fire({
			icon: 'success',
			title: "<?php echo session('succes_msg'); ?>"
		})
	<?php } ?>

	function searchToggle(obj, evt){
    var container = $(obj).closest('.search-wrapper');
        if(!container.hasClass('active')){
            container.addClass('active');
            evt.preventDefault();
        }
        else if(container.hasClass('active') && $(obj).closest('.input-holder').length == 0){
            container.removeClass('active');
            // clear input
            container.find('.search-input').val('');
        }
}

$(document).ready(function() {

$('.submit_on_enter').keydown(function(event) {
  // enter has keyCode = 13, change it if you want to use another button
  if (event.keyCode == 13) {
	this.form.submit();
	return false;
  }
});

});
</script>

</html>