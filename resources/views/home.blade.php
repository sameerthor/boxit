@extends('layouts.app')

@section('content')
<div id="content">
			
				<div class="row p-15 prl-30 border-all">
					<div class="col-md-3 cal-flex">
						<div class="arrow-l-style">
							<img src="img/arrow-l.png">
						</div>
						<div class="mnth-style">
							August 2022 
						</div>
						<div>
							<img src="img/arrow-r.png">
						</div>
					</div>
				<div class="col-md-2 text-right">
					<select class="select-styles bgc-new">
						<option>
							Week
						</option>
						<option>
							1 Week
						</option>
						<option>
							2 Week
						</option>
					</select>
				</div>
				<div class="col-md-7 text-right">
					<select class="select-styles">
						<option>
							Admin
						</option>
						<option>
							Admin 1
						</option>
						<option>
							Admin 2
						</option>
					</select>
				</div>
				</div>
				<div class="row ptb-30 bd-btm">
					<div class="col-md-1"></div>
					<div class="col-md-11">
						<ul class="names-style">
							<li><span>Foreman</span><br>Nick</li>
							<li><span>Foreman</span><br>Dan</li>
							<li><span>Foreman</span><br>Nick</li>
							<li><span>Foreman</span><br>Dan</li>
							<li>Plumber</li>
							<li>PODS</li>
							<li>Steel</li>
							<li>BLC</li>
							<li>Engineer</li>
							<li>Council</li>
							<li>Concrete</li>
							<li>Placer</li>
							<li>Pump</li>
						</ul>
				</div>
			</div>
			<div class="row">
				<div class="col-md-1 ptb-30 border-rb">
					<div class="text-center arrow-u-style">
						<img src="img/arrow-u.png">
					</div>
					<div>
						<ul class="cal-days">
							<li><span>SUN</span><br>21</li>
							<li><span>MON</span><br>22</li>
							<li class="active-day"><span>TUE</span><br>23</li>
							<li><span>WED</span><br>24</li>
							<li><span>THU</span><br>25</li>
							<li><span>FRI</span><br>26</li>
							<li><span>SAT</span><br>27</li>
						</ul>
					</div>
					<div class="text-center">
						<img src="img/arrow-d.png">
					</div>
				</div>
				<div class="col-md-11 mt-100">
					<div class="row mt-50">
						<div class="col-md-12 text-center">
							<div class="red-box pd-boxes">
								<p class="margin-center">99 Wembley</p>
							</div>
						</div>
					</div>
					<div class="row mt-50">
						<div class="col-md-12">
							<div class="green-box pd-boxes">
								<p>99 Wembley</p>
							</div>
						</div>
					</div>
					<div class="row mt-50">
						<div class="col-md-12">
							<div class="green-box empty">
								
							</div>
						</div>
					</div>
					<div class="row mt-50">
						<div class="col-md-12">
							<div class="yellow-box pd-boxes">
								<p class="margin-center">99 Wembley</p>
							</div>
						</div> 
					</div>
					<div class="row mt-50"></div>
					<div class="row mt-50"></div>
					<div class="row mt-50"></div>

				</div>
			</div>
		</div>
@endsection
