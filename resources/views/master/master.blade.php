<!DOCTYPE html>
<html>
@include('master/head')
<body>
	<div class="head">
		<div class="logo"><p>GMF Aircraft Support Services</p></div>
		<div class="notif"></div>
	</div>
	<div class="outter">
		<div class="outter2">
			@include('master/nav')
			<div class="content">
				@yield('content')
			</div>
			<div class="footer">
				@yield('footer')
			</div>
		</div>
	</div>
</body>
@if(Auth::user()->user_role == 1)
	@include('master/script-cus')
@elseif(Auth::user()->user_role == 2)
	@include('master/script-occ')
@elseif(Auth::user()->user_role== 3)
	@include('master/script-man')
@endif
</html>