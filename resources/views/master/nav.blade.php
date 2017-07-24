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
		<button id="order-occ" autofocus><i class="fa fa-shopping-cart" aria-hidden="true"></i>Preview Order</button>
		<button id="history-occ"><i class="fa fa-history" aria-hidden="true"></i>History</button>
		<button id="settings-occ"><i class="fa fa-cogs" aria-hidden="true"></i>Settings</button>
		@endif
		<!-- manager -->
		@if(Auth::user()->user_role==3)
		<button id="order-man" autofocus>Order</button>
		<button id="history-man">History</button>
		<button id="report">Report</button>
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
			<a href="">On-Progress</a>
			<a href="">Completed</a>
			<a href="">Canceled</a>
			<a href="">All Order</a>
		</div>
		<div id="sub-menu-settings-occ" style="display:none">
			<a href="">Equipment Data</a>
			<a href="">Airline Data</a>
			<a href="">Urgency Data</a>
			<a href="">Root Cause Data</a>
			<a href="">Man Power Data</a>
			<a href="">AC Type Data</a>
		</div>
		@endif
		<!-- manager -->
		@if(Auth::user()->user_role == 3)
		<div id="sub-menu-order-man">
		</div>
		<div id="sub-menu-history-man" style="display:none">
			<a href="">On-Progress</a>
			<a href="">Completed</a>
		</div>
		<div id="sub-menu-report" style="display:none">
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
		<button id="order-occ"><i class="fa fa-shopping-cart" aria-hidden="true"></i>Preview Order</button>
		<button id="history-occ2"><i class="fa fa-history" aria-hidden="true"></i>History</button>
		<div class="sub-menu-history-cus2" id="sub-menu-history-occ2" style="display:none">
			<a href="">On-Progress</a>
			<a href="">Completed</a>
			<a href="">Canceled</a>
			<a href="">All Order</a>
		</div>
		<button id="settings-occ2"><i class="fa fa-cogs" aria-hidden="true"></i>Settings</button>
		<div class="sub-menu-history-cus2" id="sub-menu-settings-occ2" style="display:none">
			<a href="">Equipment Data</a>
			<a href="">Airline Data</a>
			<a href="">Urgency Data</a>
			<a href="">Root Cause Data</a>
			<a href="">Man Power Data</a>
			<a href="">AC Type Data</a>
		</div>
		@endif
		<!-- manager -->
		@if(Auth::user()->user_role==3)
		<button id="order-man" autofocus>Order</button>
		<button id="history-man">History</button>
		<button id="report">Report</button>
		@endif
	</div>
</div>