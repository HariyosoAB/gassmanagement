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
			<div class="content col-md-12">
				<p class="judul" data-aos="zoom-in" data-aos-delay="100">@yield('judul')</p>
				<div class="isi" data-aos="zoom-in" data-aos-delay="100" >
					@yield('content')
				</div>
			</div>
			<div class="footer">
				Copyright © 2017 - Shafly Naufal A & Hariyoso Ario B
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

<script>
	AOS.init();
</script>

</html>