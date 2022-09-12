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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
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
					<img src="img/logo2581-1.png">
				</div>
				<ul class="li-flex li-styles p-none list-none">
					<li class="active"><img src="img/calendar.png">Calendar</li>
					<li><img src="img/booking.png">Bookings</li>
					<li><img src="img/contacts.png">Contacts</li>
					<li><img src="img/projects.png">Projects</li>
					<li><img src="img/job.png">Job Status</li>
				</ul>

				</div>
			</div>
			<div class="col-md-10 mt-40 mb-100 p-none">
				<div class="container pl-none pr-60">
			<div id="header" class="mb-40 prl-30">
				<div class="row d-flex">
					<div class="col-md-8">
						<img src="img/search.png">
					</div>
					<div class="col-md-1 pr-none text-right">
						<div>
						<img src="img/notification.png">
					    </div>
				    </div>
				    <div class="col-md-1 text-right">
					    <div>
						<img width="34px" src="img/m.png">
					    </div>
				    </div>
				    <div class="col-md-1 p-none">
					    <div>
						<p class="admin-s">Michal<br>
                        <span>michal@gmail.com</span>
                        </p>
					    </div>
					</div>
					<div class="col-md-1">
					    <div>
						<img src="img/arrow.png">
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

</html>