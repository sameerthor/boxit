
<form action="/test-msg" method="get">
<div class="row">   
<div class="col-md-3"><input type="text" placeholder="from" name="from" required></div>
<br>
<div class="col-md-3"><input type="text" placeholder="to" name="to" required></div>
<br>
<div class="col-md-3"><button type="submit">submit</button></div>
</div>
@if(!empty($msg))
<br>
<p>Response- {{$msg}}</p>
@endif
</form>
