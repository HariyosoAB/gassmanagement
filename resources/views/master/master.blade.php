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
@include('master/script')
</html>