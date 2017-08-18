<div class="nav">
	<div class="menu">
		<!-- cutomer -->
		@if(Auth::user()->user_role==1)
		<button id="order-cus" onclick="window.location.href='{{url('')}}/cust/create-order'" <?php if($nav=="order") echo "class='active'";?>><i class="fa fa-shopping-cart" aria-hidden="true"></i>Order</button>
		<button id="history-cus"><i class="fa fa-history" aria-hidden="true"></i>History</button>
		<script>
			<?php if($nav=="history") echo "window.onload = function () {document.querySelector('#history-cus').click();}";?>
		</script>
		@endif
		<!-- occ -->
		@if(Auth::user()->user_role==2)
		<button id="order-occ"  onclick="window.location.href='{{url('')}}/occ/preview-order'" <?php if($nav=="preview") echo "class='active'";?>><i class="fa fa-shopping-cart" aria-hidden="true"></i>Review Order</button>
		<button id="history-occ"><i class="fa fa-history" aria-hidden="true"></i>History</button>
		<button id="alokasi-occ" onclick="window.location.href='{{url('')}}/occ/allocation'" <?php if($nav=="alokasi-occ") echo "class='active'";?>><i class="fa fa-pie-chart" aria-hidden="true"></i>Allocation</button>
		<button id="settings-occ"><i class="fa fa-cogs" aria-hidden="true"></i>Settings</button>
		<script>
			<?php if($nav=="history-occ") echo "window.onload = function () {document.querySelector('#history-occ').click();}";?>
			<?php if($nav=="settings-occ") echo "window.onload = function () {document.querySelector('#settings-occ').click();}";?>
		</script>
		@endif
		<!-- manager -->
		@if(Auth::user()->user_role==3)
		<button id="report" autofocus>Report</button><script>
			<?php if($nav=="report") echo "window.onload = function () {document.querySelector('#report').click();}";?>
		</script>
		@endif
	</div>
	<div class="sub-menu">
		<!-- customer -->
		@if(Auth::user()->user_role == 1)
		<div id="sub-menu-order-cus">
		</div>
		<div id="sub-menu-history-cus" style="display:none">
			<a href="{{url('')}}/cust/on-progress"><i class="fa fa-refresh" aria-hidden="true"></i>On-Progress</a>
			<a href="{{url('')}}/cust/completed"><i class="fa fa-check" aria-hidden="true"></i>Completed</a>
		</div>
		@endif
		<!-- occ -->
		@if(Auth::user()->user_role == 2)
		<div id="sub-menu-order-occ"></div>
		<div id="sub-menu-history-occ" style="display:none">
			<a href="{{url('')}}/occ/wait-exec"><i class="fa fa-clock-o" aria-hidden="true"></i>Waiting for Execution</a>
			<a href="{{url('')}}/occ/on-progress"><i class="fa fa-refresh" aria-hidden="true"></i>On-Progress</a>
			<a href="{{url('')}}/occ/completed"><i class="fa fa-check" aria-hidden="true"></i>Completed</a>
			<a href="{{url('')}}/occ/canceled"><i class="fa fa-times" aria-hidden="true"></i>Canceled</a>
			<a href="{{url('')}}/occ/all-order"><i class="fa fa-list" aria-hidden="true"></i>All Order</a>
		</div>
		<div id="sub-menu-alokasi-occ" style="display:none"></div>
		<div id="sub-menu-settings-occ" style="display:none">
			<a href="{{url('/')}}/occ/equipmenttable"><i class="fa fa-wrench" aria-hidden="true"></i>Equipment Data</a>
			<a href="{{url('/')}}/occ/airlinetable"><i class="fa fa-plane" aria-hidden="true"></i>Airline Data</a>
			<a href="{{url('/')}}/occ/rootcausetable"><i class="fa fa-bomb" aria-hidden="true"></i>Root Cause Data</a>
			<a href="{{url('/')}}/occ/mantable"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>Man Power Data</a>
			<a href="{{url('/')}}/occ/actable"><i class="fa fa-code-fork" aria-hidden="true"></i>AC Type Data</a>
		</div>
		@endif
		<!-- manager -->
		@if(Auth::user()->user_role == 3)
		<div id="sub-menu-report">
			<a href="{{url('')}}/management/daily">Daily</a>
			<a href="{{url('')}}/management/weekly">Weekly</a>
			<a href="{{url('')}}/management/monthly">Monthly</a>
		</div>
		@endif
	</div>
</div>
<div class="nav2">
	<div class="menu">
		<!-- cutomer -->
		@if(Auth::user()->user_role==1)
		<button id="order-cus" onclick="window.location.href='{{url('')}}/cust/create-order'"><i class="fa fa-shopping-cart" aria-hidden="true"></i>Order</button>
		<button id="history-cus2"><i class="fa fa-history" aria-hidden="true"></i>History</button>
		<div class="sub-menu-history-cus2" id="sub-menu-history-cus2" style="display:none">
			<a href="{{url('')}}/cust/on-progress"><i class="fa fa-refresh" aria-hidden="true"></i>On-Progress</a>
			<a href="{{url('')}}/cust/completed"><i class="fa fa-check" aria-hidden="true"></i>Completed</a>
		</div>
		@endif
		<!-- occ -->
		@if(Auth::user()->user_role==2)
		<button id="order-occ"><i class="fa fa-shopping-cart" aria-hidden="true"></i>Review Order</button>
		<button id="history-occ2"><i class="fa fa-history" aria-hidden="true"></i>History</button>
		<div class="sub-menu-history-cus2" id="sub-menu-history-occ2" style="display:none">
			<a href="{{url('')}}/occ/wait-exec"><i class="fa fa-clock-o" aria-hidden="true"></i>Waiting for Execution</a>
			<a href="{{url('')}}/occ/on-progress"><i class="fa fa-refresh" aria-hidden="true"></i>On-Progress</a>
			<a href="{{url('')}}/occ/completed"><i class="fa fa-check" aria-hidden="true"></i>Completed</a>
			<a href="{{url('')}}/occ/canceled"><i class="fa fa-times" aria-hidden="true"></i>Canceled</a>
			<a href="{{url('')}}/occ/all-order"><i class="fa fa-list" aria-hidden="true"></i>All Order</a>
		</div>
		<button id="alokasi-occ2"><i class="fa fa-pie-chart" aria-hidden="true"></i>Allocation</button>
		<button id="settings-occ2"><i class="fa fa-cogs" aria-hidden="true"></i>Settings</button>
		<div class="sub-menu-history-cus2" id="sub-menu-settings-occ2" style="display:none">
			<a href=""><i class="fa fa-wrench" aria-hidden="true"></i>Equipment Data</a>
			<a href=""><i class="fa fa-plane" aria-hidden="true"></i>Airline Data</a>
			<a href=""><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>Urgency Data</a>
			<a href=""><i class="fa fa-bomb" aria-hidden="true"></i>Root Cause Data</a>
			<a href=""><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>Man Power Data</a>
			<a href=""><i class="fa fa-code-fork" aria-hidden="true"></i>AC Type Data</a>
		</div>
		@endif
		<!-- manager -->
		@if(Auth::user()->user_role==3)
		<button id="report2" autofocus>report</button>
		<div class="sub-menu-history-cus2" id="sub-menu-report2" style="display:none">
			<a href="{{url('')}}/management/daily"><i class="fa fa-wrench" aria-hidden="true"></i>Daily</a>
			<a href="{{url('')}}/management/weekly"><i class="fa fa-plane" aria-hidden="true"></i>Weekly</a>
			<a href="{{url('')}}/management/monthly"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>Monthly</a>
		</div>
		@endif
	</div>
</div>
