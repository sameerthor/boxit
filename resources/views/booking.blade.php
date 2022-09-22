@extends('layouts.app')

@section('content')
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
					<form id="booking">
						  <div class="center_div">
      <div class="row">
        <div class="form-group col-md-6">
          <input name="fName" type="text" placeholder="Address*" />
        </div>
        <div class="form-group col-md-6">
          <select class="form-control" style="width: 100%;" name="{{$departments[0]->id}}">
            <option value="">Building Company*</option>
            @foreach($departments[0]->contacts as $res)
            <option value="{{$res->id}}">{{$res->title}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="row">
        <div class="form-group col-md-6">
        <input name="compName" type="text" placeholder="Floor Type*" />
        </div>
        <div class="form-group col-md-6">
          <input name="compName" type="text" placeholder="Floor Area*" />
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12 col-md-6 form-group">
          <div class="input-group input-group-xs">
          <select class="form-control" style="width: 100%;" name="businessNeeds">
            <option value="">Foreman*</option>
            @foreach($departments[1]->contacts as $res)
            <option value="{{$res->id}}">{{$res->title}}</option>
            @endforeach
          </select>

          </div>
        </div>
        <div class="col-md-6">
        	 <div class="row">
        	 	<div class="col-md-7 form-group p-none">
        	 		<div class="input-group input-group-xs">
          <select class="form-control" style="width: 100%;" name="businessNeeds">
            <option value="">Plumber*</option>
            @foreach($departments[2]->contacts as $res)
            <option value="{{$res->id}}">{{$res->title}}</option>
            @endforeach
          </select>
      </div>
        	 	</div>
        	 	<div class="col-md-5 form-group">
        	 		<input name="compName" type="date" placeholder="" />
        	 	</div>
          
          </div>
        </div>
      </div>
      <div class="row">
        @foreach($departments->slice(3) as $department)
        <div class="col-md-6">
        	 <div class="row">
        	 	<div class="col-md-7 form-group p-none">
        	 		<div class="input-group input-group-xs">
          <select class="form-control" style="width: 100%;" name="businessNeeds">
            <option value="">{{$department->title}}*</option>
            @foreach($department->contacts as $res)
            <option value="{{$res->id}}">{{$res->title}}</option>
            @endforeach
          </select>
      </div>
        	 	</div>
        	 	<div class="col-md-5 form-group">
        	 		<input name="compName" type="date" placeholder="" />
        	 	</div>
          
          </div>
        </div>
        @endforeach
      </div>
      
      <div class="row">
      <div class="form-group col-md-6">
      <textarea placeholder="Notes"></textarea>
       <div class="form-btn">
       	<button>SUBMIT</button>
       </div>
      </div>
      <div class="form-group col-md-6">
      <input name="compName" type="text" placeholder="Upload" />

      </div>
      </form>
				</div>
			</div>
			
 
		</div>
@endsection