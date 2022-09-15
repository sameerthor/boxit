@extends('layouts.app')

@section('content')
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>

<style>
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
  } }
</style>
@verbatim
<div id="content">

	<div class="row p-15 prl-30 border-all">
		<div class="col-md-3 cal-flex">
			<div class="arrow-l-style">
				<img src="img/arrow-l.png" v-on:click="month_nav(-1)">
			</div>
			<div class="mnth-style">
				{{months[month_index]}} {{year}}
			</div>
			<div>
				<img src="img/arrow-r.png" v-on:click="month_nav(+1)">
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
			<div v-if="activeStep>0" v-on:click="remove" class="text-center arrow-u-style">
				<img src="img/arrow-u.png">
			</div>
			<div>

				<transition-group name="list" tag="ul" class="cal-days">

					<li v-for="step in currentitem" :key="step.day" v-bind:class="[date==step.day && 'active-day']" :style="{'color': step.thisMonth===false && '#ECEDF1'}"><span>{{step.name}}</span><br>{{step.day}}</li>
				</transition-group>

			</div>
			<div v-if="activeStep<items.length-1" class="text-center" v-on:click="add">
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
						<p class="margin-center">98 Wembley</p>
					</div>
				</div>
			</div>
			<div class="row mt-50"></div>
			<div class="row mt-50"></div>
			<div class="row mt-50"></div>

		</div>
	</div>
</div>
@endverbatim

<script>
	var monthNames = ['January', 'Febuary', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
	var active_date;

	function getFirstDayOfMonth(zeroBasedMonthNum, fullYear) {
		var dateStr = `${monthNames[zeroBasedMonthNum]} 1, ${fullYear}, 00:00:00`;
		var monthStart = new Date(dateStr);
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

	var cur_month = 8;
	var cur_year = 2022;
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
				for (var j = 0; j <7; j++) 
                  if(data[i][j].day==dd && data[i][j].thisMonth===true)
				  {
                    index=i;
					break;
				  }
			this.date=String(dd);	
			this.activeStep = index;
		},
		data() {
			return {
				items: getInitialItems(cur_month, cur_year),
				nextNum: 2,
				activeStep: 0,
				months: monthNames,
				year: cur_year,
				month_index: cur_month,
				date:'test'
			}
		},
		methods: {
			randomIndex: function() {
				return Math.floor(Math.random() * this.items.length)
			},
			add: function() {
				this.activeStep++;
			},
			remove: function() {
				this.activeStep--;
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
			}
		}
	}).mount("#content");
</script>
@endsection