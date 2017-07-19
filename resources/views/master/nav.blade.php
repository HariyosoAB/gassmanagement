<div class="nav">
	<div class="menu">
		<!-- cutomer -->
		@if(Auth::user()->user_role==1)
		<button id="order-cus" autofocus>Order</button>
		<button id="history-cus">History</button>
		@endif
		<!-- occ -->
		@if(Auth::user()->user_role==2)
		<button id="order-occ" autofocus>Order</button>
		<button id="history-occ">History</button>
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
		@if(Auth::user()->user_role==1)
		<div id="sub-menu-order-cus">
		</div>
		<div id="sub-menu-history-cus" style="display:none">
			<a href="">On-Progress</a>
			<a href="">Completed</a>
		</div>
		@endif
		<!-- occ -->
		@if(Auth::user()->user_role==2)
		<div id="sub-menu-order-occ">
		</div>
		<div id="sub-menu-history-occ" style="display:none">
			<a href="">On-Progress</a>
			<a href="">Completed</a>
		</div>
		@endif
		<!-- manager -->
		@if(Auth::user()->user_role==3)
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