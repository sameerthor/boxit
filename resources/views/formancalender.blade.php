@extends('layouts.app')

@section('content')
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.1.2/axios.min.js" integrity="sha512-bHeT+z+n8rh9CKrSrbyfbINxu7gsBmSHlDCb3gUF1BjmjDzKhoKspyB71k0CIRBSjE5IVQiMMVBgCWjF60qsvA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<style>
	.modal-dialog{
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
    width: 93%;
    height: 12%;
	}

	.foo:first-child {
		margin-top: 3%;
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
    .container.pl-none.pr-60{
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
		height: 85px !important;
		font-size: 13px;
		font-weight: 600;
	}

	.pd-boxes {
		padding: 0px 0px !important;
		padding-top: 27px !important;
	}

	.red_box {
		background: #FCEEEC;
		color: #FCEEEC !important;
		border-left: 1px solid #16DB65;
		border-radius: 3px;
		cursor: pointer;
		padding: 0px;
		display: block;
		border-bottom: 1px solid #16DB65;
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

	@media screen and (max-width:767px)
	{
		.cal-days li {

margin: 15px 0px !important;
}
	}
</style>
@verbatim
<div id="content">
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header  no-border">
					<!-- <span class="modal-title" id="exampleModalLabel">Project Name</span> -->
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
				<div class="row">
					 <div class="col-md-6">
					 <div class="info-txt">
						<span>Address</span>
						<p id="booking_address">NA</p>
					</div>
					 </div>
					 <div class="col-md-6">
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
						<span>Information</span>
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
	<div class="row p-15 prl-30 border-all">
		<div class="col-md-3 cal-flex">
			<div class="arrow-l-style" v-on:click="month_nav(-1)">
				<img src="img/arrow-l.png" >
			</div>
			<div class="mnth-style">
				{{months[month_index]}} {{year}}
			</div>
			<div class="arrow-l-style" v-on:click="month_nav(+1)">
				<img src="img/arrow-r.png" >
			</div>
		</div>
		<div class="col-md-2 mob-center">
			<select class="select-styles bgc-new" id="calender_type">
				<option value="week">
					Weekly
				</option>
				<option value="month">
					Monthly
				</option>
			</select>
		</div>
		<div class="col-md-7 text-right">

		</div>
	</div>
	<div id="weekly_calender">
		<div class="row ptb-30 bd-btm">
			<div class="col-md-1"></div>
			<div class="col-md-11">
				<ul class="names-style">
				<li><span>Foreman</span><br><?php echo ucfirst($foreman->name); ?></li>
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

						<li v-for="step in currentitem" :key="step.day" v-bind:class="[step.today=='yes' ? 'active-day':'']" :style="{'color': step.thisMonth===false ?'#ECEDF1' : ''}"><span>{{step.name}}</span><br>{{step.day}}</li>
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
	<div id="monthly_calender" style="display:none">
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

<script>
	$(document).on('change', '#calender_type', function() {
		if ($(this).val() == 'week') {
			$('#weekly_calender').show();
			$('#monthly_calender').hide();
		}
		if ($(this).val() == 'month') {
			$('#weekly_calender').hide();
			$('#monthly_calender').show();
		}
	})
	var monthNames = ['January', 'Febuary', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
	var active_date;

	function getFirstDayOfMonth(zeroBasedMonthNum, fullYear) {
		if(cur_month==zeroBasedMonthNum)
		{
			var monthStart = new Date();

		}else
		{
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
		if(monthIndex==cur_month)
		{
			let currentDateObj = new Date();
			var day_num=getFirstDayOfMonth(monthIndex, year).getDay();
			currentDateObj.setDate(1); // going to 1st of the month
            currentDateObj.setHours(-1);
            var l_date = currentDateObj.setDate(currentDateObj.getDate() - (currentDateObj.getDay()+(7-day_num)) % 7);
			var first=new Date(l_date).getDate();
			daysFromLastMonth=daysInLastMonth-first+1;
			if (first == 0)
			first = 7;
		}
		for (var i = 0; i < daysFromLastMonth; i++) {
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
	const getInitialItems = (cur_month, cur_year) => test3(cur_month, cur_year)
	console.log(getInitialItems(cur_month, cur_year));
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
				year: cur_year,
				month_index: cur_month,
				date: 'test'
			}
		},
		methods: {
			getCalender() {

				axios.post('/foreman-calender', {
						year: this.year,
						month: this.month_index,
						dates: this.items[this.activeStep]
					})
					.then((response) => {
						$(".calender").html(response.data)
					})

				axios.post('/foreman-calender-monthly', {
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

			}
		}
	}).mount("#content");
	$(document).on('click', '.show_booking', function() {
		var id = $(this).data('id');
		axios.post('/foreman-calender-detail', {
				id: id
			})
			.then((response) => {
				$("#booking_address").html(response.data.address);
				$("#floor_type").html(response.data.floor_type);
				$("#floor_area").html(response.data.floor_area);
				$("#building_company").html(response.data.building_company);
				$("#booking_notes").html(response.data.notes);
				$(".card-new").html(response.data.html);
				$("#exampleModal").modal("show");
			})
	})
	$(document).on('click', '.close', function() {
		$("#exampleModal").modal("hide");
	})
</script>
@endsection