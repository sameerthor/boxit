<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="MNU29ELuyS35yv4esX3C1ECZ6CYZfRLb8baPuVk6">

    <title>Laravel</title>

    <!-- Scripts -->
    <script src="https://boxit.staging.app/js/app.js" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="https://boxit.staging.app/css/app.css" rel="stylesheet">
    <link href="https://boxit.staging.app/css/responsive.css" rel="stylesheet">
    <link href="https://boxit.staging.app/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.33/dist/sweetalert2.all.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>

<body>
    <div id="app">
                        <main class="py-4">
            <div class="container-fluid">
    <div class="row no-flex">
        <div class="col-md-4 wd-100"></div>
        <div class="col-md-4 mtb-100 wd-100">
            <div class="card p-50">
                <div class="text-center mb-40">
                    <img src="/img/logo2581-1.png">
                </div>

                <div style="text-align: center;">
                   @if($status==1) <img src="/img/checkmark.png" style="width:200px">
                   <br></br>
                   <a href="/vendor-download/{{$booking_data_id}}?type=google" style="font-size: 0.7rem;" target="_blank" class="btn float-left btn-sm btn-info draft btn-color">Download to Google Calender</a>
                   <a href="/vendor-download/{{$booking_data_id}}?type=outlook" style="font-size: 0.7rem;" target="_blank" class="btn float-right btn-sm btn-info draft btn-color">Download to Outlook Calendar</a>
 
                   <br/>  <br/>
                Thank you for confirming your booking.
                @endif
                @if($status==2) <img src="/img/hold.png" style="width:200px">
                   
                   <br/> <h4>Change Request Pending</h4> <br/>
                   We have received your date/time change request and will get back to you soon.
                @endif
                <br/><br/>If there are any changes please feel free to reach out to Jules at <a href="mailto:admin@boxitfoundations.co.nz">admin@boxitfoundations.co.nz</a>
            </div>

            </div>
        </div>
        <div class="col-md-4 wd-100"></div>
    </div>
</div>
        </main>
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
</script>
</html>