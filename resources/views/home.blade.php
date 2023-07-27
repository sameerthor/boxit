@extends('layouts.app')

@section('content')
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script src="/js/tinymce/js/tinymce/tinymce.min.js"></script>
<script src="https://cdn.tiny.cloud/1/jq9mby0hzla0mq6byj05yjmflbj55i7tl74g9v8w8no32jb6/tinymce/6/plugins.min.js" referrerpolicy="origin"></script>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog home_modal" role="document">
		<div class="modal-content">
			<div class="modal-header  no-border">
				<!-- <span class="modal-title" id="exampleModalLabel">Project Name</span> -->
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-4">
						<div class="info-txt">
							<span>BCN</span>
							<p id="bcn">NA</p>
						</div>
					</div>
					<div class="col-md-4">
						<div class="info-txt">
							<span>Address</span>
							<p id="booking_address" style="text-decoration:underline;cursor:pointer">NA</p>
						</div>
					</div>
					<div class="col-md-4">
						<div class="info-txt">
							<span>Building Company</span>
							<p id="building_company">NA</p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="info-txt">
							<span>Floor Type</span>
							<p id="floor_type">NA</p>
						</div>
					</div>
					<div class="col-md-6">
						<div class="info-txt">
							<span>Floor Area</span>
							<p id="floor_area">NA</p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="info-txt">
							<span>Notes</span>
							<p id="booking_notes">NA</p>
						</div>
					</div>
				</div>
				<div class="status-txt">
					<span>Status</span>
					<div class="card-new " style="margin-top: 12px;">

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="foremanModal" tabindex="-1" role="dialog" aria-labelledby="foremanModalLabel" aria-hidden="true">
	<div class="modal-dialog home_modal" role="document">
		<div class="modal-content">
			<div class="modal-header  no-border">
				<span class="modal-title" id="foremanModalLabel">
					<h5>Foreman Notes: <span>3 Mar 2023</span></h5>
				</span>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="notes_list">
					<table class="table able-striped">
						<thead>
							<th>S.No</th>
							<th>Foreman</th>
							<th>Action</th>
						</thead>
						<tbody>
							@foreach($foremans as $foreman)
							<tr>
								<th scope="row">{{$loop->iteration}}</th>
								<td>{{$foreman->name}}</td>
								<td><span data-id="{{$foreman->id}}" class="foreman_notes_edit"><img src="{{asset('img/edit-box-fill.png')}}"></span></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<div id="single_note" style="display:none">
					<br>
					<textarea id="note_editor"></textarea>
					<br>
					<button type="button" class="btn btn-secondary btn-color show_note_list">Back</button>
					<button type="button" class="btn btn-secondary btn-color save_note" data-id="1">Save</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="leaveModal" tabindex="-1" role="dialog" aria-labelledby="leaveModalLabel" aria-hidden="true">
	<div class="modal-dialog home_modal" role="document">
		<div class="modal-content">
			<div class="modal-header  no-border">
				<span class="modal-title" id="leaveModalLabel">
					<h5>Leave Note: </h5>
				</span>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="leave_note">
				</div>
			</div>
		</div>
	</div>
</div>
@mobile
<style>
	div#daily_calender .col-md-12.cal-flex.bookings {
		flex-wrap: wrap;
	}

	div#daily_calender .show_booking {
		margin-top: 10px !important;
	}

	.list-enter-active {
		animation: fade-in 0.20s ease-in-out;
	}

	.list-leave-active {
		animation: fade-in 0.20s ease-in-out reverse;
	}

	@keyframes fade-in {
		0% {
			opacity: 0;
			transform: translateY(30px);
		}

		100% {
			transform: translateY(0px);
		}
	}

	.cal-trans {
		list-style: none;
		padding: 0;
		margin: 0;
	}

	.show_booking {
		padding: 3px;
	}

	div#weekly_calender li:nth-child(odd) {
		background-color: #E5E9F3;
	}

	#weekly_calender {
		margin-left: 2%;
	}

	.mnth-style {
		padding: 0 20%;
	}
</style>
@verbatim
<div id="content">
	<div class="row p-15 prl-30 border-all">
		<div class="col-md-3 cal-flex month_div" style="display:none">
			<div class="arrow-l-style" v-on:click="daily_nav(-1)">
				<img src="img/arrow-l.png">
			</div>
			<div class="mnth-style">
				{{months[month_index]}} {{year}}
			</div>
			<div class="arrow-l-style" v-on:click="daily_nav(+1)">
				<img src="img/arrow-r.png">
			</div>
		</div>
		<div class="col-md-3 cal-flex date_div">
			<div class="mnth-style">
				{{today_date}}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-6 p-1 text-left">
			<select class="select-styles bgc-new" id="calender_type">
				<option selected value="daily">
					Daily
				</option>
				<option value="week">
					Weekly
				</option>
			</select>
		</div>
		<div class="col-6 p-2 text-right">
			<select class="select-styles bgc-new" @change="changeforeman($event)">
				<option value="">All Foreman</option>
				<?php foreach ($foremans as $foreman) { ?>
					<option value="<?= $foreman->id ?>">
						<?= ucfirst($foreman->name); ?>
					</option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div id="daily_calender" class="calenders">
		<div class="row p-15">
			<div class="col-md-12 cal-flex bookings" style="justify-content:center">

			</div>
		</div>
	</div>
	<div id="weekly_calender" class="calenders" style="display:none">
		<div v-if="activeStep>0" v-on:click="remove" class=" arrow-u-style">
			<img src="img/arrow-u.png">
		</div>

		<transition-group name="list" tag="ul" class="cal-trans">
			<li v-for="step in currentitem" :key="step.day">
				<div class="d-flex mobile_calender_strip show_notes">
					<div class="p-1  align-items-center" v-bind:class="[step.today=='yes' ? 'active-day':'']" style="width:20%"><span>{{step.name}}</span><br>{{step.day}}</div>
					<div class="p-1  d-flex flex-column" v-if="mobile_calender.length-1 > 0" style="width:100%">
						<div class="p-2" v-for="booking in mobile_calender[step.day]" :key="date.day" v-html='booking'></div>
					</div>
				</div>
			</li>
		</transition-group>
		<div v-if="activeStep<items.length-1" class=" arrow-u-style" v-on:click="add">
			<img src="img/arrow-d.png">
		</div>
	</div>

</div>
@endverbatim

@elsemobile
<style>
	.modal-dialog {
		max-width: 50%;
	}

	.list-enter-active {
		animation: fade-in 0.20s ease-in-out;
	}

	.list-leave-active {
		animation: fade-in 0.20s ease-in-out reverse;
	}

	@keyframes fade-in {
		0% {
			opacity: 0;
			transform: translateY(30px);
		}

		100% {
			transform: translateY(0px);
		}
	}

	.foo {
		display: flex;
		margin-left: 5%;
		width: 94%;
		min-height: 12.5%;
	}

	.foo:first-child {
		margin-top: 2%;
	}

	.foo_monthly {
		display: flex;
		margin-left: 7%;
		width: 92%;
	}

	.week_div {
		display: flex;
		margin-left: 7%;
		width: 92%;
	}

	.week_div .week_day {
		font-size: 15px;
		color: #69768C;
		font-weight: 600;
		flex-basis: 100%;
		text-align: center;
		font-weight: 600;
	}

	.container.pl-none.pr-60 {
		max-width: unset;
	}

	.booked_div {
		flex-basis: 100%;
		font-size: 10px;
		font-weight: 600;
		display: block;
	}

	.container pl-none pr-60 {
		max-width: unset;

	}

	.cal-days li {

		margin: 37% 0px;
	}

	.booked_div_monthly {
		flex-basis: 100%;
		height: auto;
		min-height: 150px;
		font-size: 13px;
		padding: 30px 0px;
		font-weight: 600;
	}

	.pd-boxes {
		padding: 0px 0px !important;
	}

	.red_box {
		background: #FCEEEC;
		color: #ff2000 !important;
		border-left: 1px solid #ff2000;
		border-radius: 3px;
		cursor: pointer;
		padding: 0px;
		display: block;
		border-bottom: 1px solid #ff2000;
	}


	.green_box {
		background: #F1FFE9;
		color: #16DB65 !important;
		border-left: 1px solid #16DB65;
		border-radius: 3px;
		cursor: pointer;
		padding: 0px;
		display: block;
		border-bottom: 1px solid #16DB65;
	}

	.orange_box {
		background: #FCF0E4;
		color: #F79256 !important;
		border-left: 1px solid #F79256;
		border-radius: 3px;
		cursor: pointer;
		padding: 0px;
		display: block;
		border-bottom: 1px solid #F79256;
	}

	.week_count {
		display: table;
		margin: -6px auto;
		font-size: 18px;
		padding-bottom: 15px;

	}

	.monthly_booking {
		display: list-item !important;
		list-style-type: disc;
		margin-left: 25% !important;
		color: red;
		margin-left: 25%;
		font-weight: 500;
		font-size: 11px;
		cursor: pointer;
	}

	.red_bullet {
		color: #ff2000;

	}

	.orange_bullet {
		color: #F79256;
	}

	.green_bullet {
		color: #16DB65;

	}

	.active-day-month {
		background: #ECEDF1;
		border-radius: 3px;
		color: #172B4D !important;
		padding: 0px 5px;
	}

	.orange_box,
	.green_box,
	.red_box {
		padding-left: 6px;
		padding-top: 3px;
		padding-bottom: 1px;
	}

	span.week_count.active-day-month {
		margin-bottom: 10px;
		padding: 0px 10px;
		background-color: #182a4e;
		color: white !important;
	}

	div#daily_calender .col-md-12.cal-flex.bookings {
		flex-wrap: wrap;
		flex-direction: column;

	}

	div#daily_calender .show_booking {
		margin-top: 2% !important;
	}
</style>
@verbatim
<div id="content">
	<div class="row p-15 prl-30 border-all ">
		<div class="col-md-3 cal-flex month_div">
			<div class="arrow-l-style" v-on:click="month_nav(-1)">
				<img src="img/arrow-l.png">
			</div>
			<div class="mnth-style">
				{{months[month_index]}} {{year}}
			</div>
			<div class="arrow-l-style" v-on:click="month_nav(+1)">
				<img src="img/arrow-r.png">
			</div>
		</div>
		<div class="col-md-3 cal-flex date_div" style="display:none">
			<div class="mnth-style">
				{{today_date}}
			</div>
		</div>
		<div class="col-md-2 wickly-btn">
			<select class="select-styles bgc-new" id="calender_type">
				<option value="week">
					Weekly
				</option>
				<option value="daily">
					Daily
				</option>
				<option value="month">
					Monthly
				</option>
			</select>
		</div>
		<div class="col-md-7 text-right">
			<select class="select-styles bgc-new" @change="changeforeman($event)">
				<option value="">All Foreman</option>
				<?php foreach ($foremans as $foreman) { ?>
					<option value="<?= $foreman->id ?>">
						<?= ucfirst($foreman->name); ?>
					</option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div id="weekly_calender" class="calenders">
		<div class="row ptb-30 bd-btm">
			<div class="col-md-1"></div>
			<div class="col-md-11">
				<ul class="names-style">
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
				<div v-if="activeStep>0" v-on:click="remove" class="text-center arrow-u-style">
					<img src="img/arrow-u.png">
				</div>
				<div>

					<transition-group name="list" tag="ul" class="cal-days">

						<li v-for="step in currentitem" v-bind:data-date="step.date" class="show_notes" :key="step.day" v-bind:class="[step.today=='yes' ? 'active-day':'']" :style="{'color': step.thisMonth===false ?'#ECEDF1' : ''}"><span>{{step.name}}</span><br>{{step.day}}</li>
					</transition-group>

				</div>
				<div v-if="activeStep<items.length-1" class="text-center arrow-u-style" v-on:click="add">
					<img src="img/arrow-d.png">
				</div>
			</div>
			<div class="col-md-11 mt-100 calender">

			</div>
		</div>
	</div>
	<div id="daily_calender" class="calenders" style="display:none">
		<div class="row p-15">
			<div class="col-md-12 cal-flex bookings" style="justify-content:center">

			</div>
		</div>
	</div>
	<div id="monthly_calender" class="calenders" style="display:none">
		<div class="row ptb-30 bd-btm">
			<div class="col-md-1" style="
    display: none;
"></div>
			<div class="col-md-11">
				<div class="week_div">
					<div class="week_day">SUN</div>
					<div class="week_day">MON</div>
					<div class="week_day">TUE</div>
					<div class="week_day">WED</div>
					<div class="week_day">THU</div>
					<div class="week_day">FRI</div>
					<div class="week_day">SAT</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-1 ptb-30 border-rb" style="
    display: none;
">

			</div>
			<div class="col-md-11 monthly_dates">


			</div>
		</div>
	</div>
</div>
@endverbatim
@endmobile

<script>
	function wrapupSpan() {
		$(".booked_div").each(function() {
			var count = $(this).find('span').length;
			if (count > 3) {
				var last_c = count - 3;
				$(this).find('span').slice(0 - last_c).addClass("hidden_bookings");
				$(this).find('span').slice(0 - last_c).hide();
				$(this).append("<span class='show_more' >" + last_c + " more project"+last_c==1?'':'s'+"..</span>");
				$(this).append("<span class='show_less' style='display:none'>Show Less</span>");

			}
		});
	}

	$(document).on("click", ".show_more", function() {
       $(this).parents(".booked_div").find("span").show();
	   $(this).hide();
	});

	$(document).on("click", ".show_less", function() {
		console.log("test");
		$(this).parents(".booked_div").find(".hidden_bookings").hide();
		$(this).parents(".booked_div").find(".show_more").show();
		$(this).hide();

	});

	var is_mobile = false;
	if (/Android|webOS|iPhone|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))
		is_mobile = true;

	$(document).on('change', '#calender_type', function() {
		if ($(this).val() == 'week') {
			$('#weekly_calender').show();
			$('#monthly_calender').hide();
			$('#daily_calender').hide();
			$('.month_div').show();
			$('.date_div').hide();
		}
		if ($(this).val() == 'month') {
			$('#weekly_calender').hide();
			$('#daily_calender').hide();
			$('#monthly_calender').show();
			$('.month_div').show();
			$('.date_div').hide();
		}
		if ($(this).val() == 'daily') {
			$('#daily_calender').show();
			$('#weekly_calender').hide();
			$('#monthly_calender').hide();
			$('.month_div').hide()
			$('.date_div').show();
		}
	})
	var monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
	var active_date;

	function getFirstDayOfMonth(zeroBasedMonthNum, fullYear) {

		if (cur_month == zeroBasedMonthNum) {
			var monthStart = new Date();

		} else {
			var dateStr = `${monthNames[zeroBasedMonthNum]} 1, ${fullYear}, 00:00:00`;
			var monthStart = new Date(dateStr);
		}

		return monthStart;
	}

	function daysInMonth(zeroBasedMonthNumber) {
		var days = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
		return days[zeroBasedMonthNumber];
	}

	function MonthDay(number, isThisMonth, year, month) {
		var daysOfTheWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
		var d = new Date(year, month - 1, number);
		this.day = number;
		this.date = d.getDate() + " " + monthNames[(d.getMonth())] + " " + d.getFullYear();
		this.thisMonth = isThisMonth;
		if (d.setHours(0, 0, 0, 0) === (new Date()).setHours(0, 0, 0, 0))
			this.today = 'yes';
		else
			this.today = 'no';
		this.name = daysOfTheWeek[d.getDay()];;
		return this;
	}

	function test3(monthIndex, year) {
		var firstDay = getFirstDayOfMonth(monthIndex, year).getDay();
		if (firstDay == 0)
			firstDay = 7;
		else
			firstDay;

		var daysFromLastMonth = firstDay;
		var result = [];

		var daysInLastMonth = daysInMonth(monthIndex - 1);
		var first = daysInLastMonth - daysFromLastMonth + 1;
		var count = 0;
		if (monthIndex == cur_month) {
			let currentDateObj = new Date();
			var day_num = getFirstDayOfMonth(monthIndex, year).getDay();
			currentDateObj.setDate(1); // going to 1st of the month
			currentDateObj.setHours(-1);
			var l_date = currentDateObj.setDate(currentDateObj.getDate() - (currentDateObj.getDay() + (7 - day_num)) % 7);
			var first = new Date(l_date).getDate();
			daysFromLastMonth = daysInLastMonth - first + 1;
			if (first == 0)
				first = 7;
		}
		for (var i = 0; i < daysFromLastMonth; i++) {
			console.log(first);
			//result.push(first+i);
			count++;
			result.push(new MonthDay(first + i, false, year, monthIndex));
			if (count == 7) {
				result = result.slice(0, -7);
				count = 0;
			}
		}

		for (var i = 1; i <= daysInMonth(monthIndex); i++)
			//result.push( i );
			result.push(new MonthDay(i, true, year, monthIndex + 1));

		var daysDone = result.length;
		var daysToGo = (5 * 7) - daysDone;
		if (daysToGo < 0) {
			daysToGo = (6 * 7) - daysDone;
		}
		var count = 0;

		for (var i = 1; i <= daysToGo; i++) { //result.push( i );
			count++;
			result.push(new MonthDay(i, false, year, monthIndex + 2));
			if (count == 7) {
				//   console.log(true);
				console.log(true);
				result = result.slice(0, -7);
				count = 0;
			}
		}

		var size = 7;
		var weekgroup = [];
		for (var i = 0; i < result.length; i += size) {
			weekgroup.push(result.slice(i, i + size));
		}
		return weekgroup;
	}
	const d = new Date();
	var cur_month = d.getMonth();;
	var cur_year = d.getFullYear();
	var cur_date = d.getDate() + " " + monthNames[cur_month] + " " + cur_year;
	const getInitialItems = (cur_month, cur_year) => test3(cur_month, cur_year)
	Vue.createApp({
		el: '#content',
		computed: {
			currentitem() {
				return this.items[this.activeStep];
			}
		},
		mounted() {
			let today = new Date();
			let dd = today.getDate();
			var index;
			let data = this.items;
			for (var i in data)
				for (var j = 0; j < 7; j++)
					if (data[i][j].day == dd && data[i][j].thisMonth === true) {
						index = i;
						break;
					}
			this.date = String(dd);
			this.activeStep = index;
			this.getCalender()

		},
		data() {
			return {
				items: getInitialItems(cur_month, cur_year),
				nextNum: 2,
				activeStep: 0,
				months: monthNames,
				foreman_id: '',
				year: cur_year,
				mobile_calender: [],
				foreman_id: '',
				month_index: cur_month,
				date: 'test',
				today_date: cur_date
			}
		},
		methods: {
			getCalender() {
				if (is_mobile) {

					axios.post('/mobile-calender', {
							year: this.year,
							month: this.month_index,
							dates: this.items[this.activeStep],
							foreman_id: this.foreman_id
						})
						.then((response) => {
							var result = response.data;
							for (let key in result) {
								this.mobile_calender[key] = result[key]
								console.log(key, result[key]);
							}
						})


				} else {

					axios.post('/calender', {
							year: this.year,
							month: this.month_index,
							dates: this.items[this.activeStep],
							foreman_id: this.foreman_id
						})
						.then((response) => {
							$(".calender").html(response.data)
							wrapupSpan();
						})
				}

				axios.post('/calender-daily', {
						today_date: this.today_date,
						foreman_id: this.foreman_id
					})
					.then((response) => {

						$("#daily_calender").find(".bookings").html(response.data)
					})

				axios.post('/calender-monthly', {
						year: this.year,
						month: this.month_index,
					})
					.then((response) => {
						$(".monthly_dates").html(response.data)
					})
			},
			randomIndex: function() {
				return Math.floor(Math.random() * this.items.length)
			},
			add: function() {
				this.activeStep++;
				this.getCalender();

			},
			remove: function() {
				this.activeStep--;
				this.getCalender();

			},
			changeforeman: function(event) {
				this.foreman_id = event.target.value;
				this.getCalender();

			},
			month_nav: function(todo) {
				var new_index = this.month_index + todo;

				if (new_index > 11) {
					this.year++;
					this.month_index = 0
				} else if (new_index < 0) {
					this.year--;
					this.month_index = 11
				} else {
					this.month_index = this.month_index + todo;
				}

				this.items = getInitialItems(this.month_index, this.year);
				this.activeStep = 0;
				this.getCalender();

			},

		}
	}).mount("#content");

	$(document).on('click', '#booking_address', function() {

		var id = $(this).attr('data-id');
		window.location.href = "<?php echo URL('projects?project_id=') ?>" + id
	});

	$(document).on('click', '.show_booking', function() {
		var id = $(this).data('id');
		axios.post('/calender-detail', {
				id: id
			})
			.then((response) => {
				$("#booking_address").attr('data-id', response.data.id);
				$("#booking_address").html(response.data.address);
				$("#floor_type").html(response.data.floor_type);
				$("#floor_area").html(response.data.floor_area);
				$("#building_company").html(response.data.building_company);
				if (response.data.bcn != "") {
					$("#bcn").html(response.data.bcn);
				}
				$("#booking_notes").html(response.data.notes);
				$(".card-new").html(response.data.html);
				$("#exampleModal").modal("show");
			})
	})
	$(document).on('click', '.close', function() {
		$(".modal").modal("hide");
	})
	$(document).on('click', '.show_notes', function() {
		$("#single_note").hide();
		$("#notes_list").show();
		var date = $(this).data("date");
		$("#foremanModalLabel").find("span").html(date);
		$("#foremanModal").modal("show");

	})
	$(document).on('click', '.foreman_notes_edit', function() {
		var date = $("#foremanModalLabel").find("span").html();
		$("#single_note").show();
		$("#notes_list").hide();
		var id = $(this).data('id');
		$(".save_note").attr('data-id', id)
		axios.post('/foreman-notes', {
				date: date,
				id: id
			})
			.then((response) => {
				tinymce.get('note_editor').setContent(response.data);

			})
	})

	$(document).on('click', '.save_note', function() {
		var notes = tinymce.get("note_editor").getContent();
		var date = $("#foremanModalLabel").find("span").html();
		var id = $(this).attr('data-id');
		axios.post('/save-foreman-notes', {
				date: date,
				id: id,
				notes: notes
			})
			.then((response) => {
				Toast.fire({
					icon: 'success',
					title: "Note saved successfuly."
				}).then(() => {
					$("#single_note").hide();
					$("#notes_list").show();
				});

			})
	})

	$(".show_note_list").click(function() {
		$("#single_note").hide();
		$("#notes_list").show();
	});

	$(document).on("click", ".annual_leave", function() {
		var note = $(this).attr("data-note");
		$("#leave_note").html(note);
		$("#leaveModal").modal("show");
	});
	tinymce.init({
		selector: "#note_editor",
		plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
		menubar: 'file edit view insert format tools table tc help',
		toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media pageembed template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
		autosave_ask_before_unload: true,
		image_advtab: true,
		height: 700,
		image_caption: true,
		toolbar_mode: 'sliding',
		contextmenu: 'link image imagetools table configurepermanentpen',

	});
</script>
@endsection