@extends('layouts.app')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.js" ></script>

<div id="content">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="form-head">
				<span>Booking Form</span>
			</div>
					</div>
				</div>
				<div class="row">
					<form id="booking" method="post" action="{{ url('booking') }}" enctype="multipart/form-data">
            @csrf
						  <div class="center_div">
      <div class="row">
        <div class="form-group col-md-6">
          <input name="address" required type="text" placeholder="Address*" required />
        </div>
        <div class="form-group col-md-6">
          <select class="form-control"  style="width: 100%;"  name="department[{{$departments[0]->id}}]" required>
            <option value="" disabled selected>Building Company*</option>
            @foreach($departments[0]->contacts as $res)
            <option value="{{$res->id}}">{{$res->title}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="row">
        <div class="form-group col-md-6">
        <input name="floor_type" required type="text" placeholder="Floor Type*" />
        </div>
        <div class="form-group col-md-6">
          <input name="floor_area" required type="text" placeholder="Floor Area*" />
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12 col-md-6 form-group">
          <div class="input-group input-group-xs">
          <select class="form-control" style="width: 100%;" name="foreman" required>
            <option value="" disabled selected>Foreman*</option>
            @foreach($foreman as $res)
            <option value="{{$res->id}}">{{$res->name}}</option>
            @endforeach
          </select>

          </div>
        </div>
        @foreach($departments->slice(1) as $department)
        <div class="col-md-6">
        	 <div class="row">
        	 	<div class="col-md-7 form-group p-none">
        	 		<div class="input-group input-group-xs">
          <select class="form-control" style="width: 100%;" name="department[{{$department->id}}]" required>
            <option value="">{{$department->title}}*</option>
            @foreach($department->contacts as $res)
            <option value="{{$res->id}}">{{$res->title}}</option>
            @endforeach
          </select>
      </div>
        	 	</div>
        	 	<div class="col-md-5 form-group">
        	 		<input name="date[{{$department->id}}]" class="example" type="text" placeholder="" required />
        	 	</div>
          
          </div>
        </div>
        @endforeach
      </div>
      
      
      <div class="row">
      <div class="form-group col-md-6">
      <textarea placeholder="Notes" name="notes"></textarea>
       <div class="form-btn">
       <input class="submit" type="submit" value="Submit">
       </div>
      </div>
      <div class="form-group col-md-6">
      <input name="file_upload" type="file"  />

      </div>
      </form>
				</div>
			</div>
			
 
		</div>
    <script>
$("#booking").validate();
$(function(){
  $.datetimepicker.setDateFormatter('moment');
  $('.example').datetimepicker({
});
});

    </script>
@endsection