@extends('layouts.app')

@section('content')
<link href="/js/calender/css/mobiscroll.javascript.min.css" rel="stylesheet" />
<script src="/js/calender/js/mobiscroll.javascript.min.js"></script>
<div class="container-fluid">
    <div class="row no-flex">
        <div class="col-md-2 wd-100"></div>
        <div class="col-md-8 mtb-100 wd-100">
            <div class="card p-50">
                <div class="text-center mb-40">
                    <img src="img/logo2581-1.png">
                </div>
                <label>
                    Calender
                </label>
                <div id="demo-init-inline"></div>
            </div>
        </div>
        <div class="col-md-2 wd-100"></div>
    </div>
</div>
<script>
mobiscroll.setOptions({
    theme: 'ios',
    themeVariant: 'light'
});

mobiscroll.datepicker('#demo-one-input', {
    controls: ['calendar'],
    showRangeLabels: true,
    display: 'anchored'
});

mobiscroll.datepicker('#demo-init-inline', {
    controls: ['calendar'],
    showRangeLabels: true,
    display: 'inline'
});
</script>
@endsection