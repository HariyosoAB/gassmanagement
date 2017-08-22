<!DOCTYPE html>
<html>
@include('master/head')
<body>
	<div class="head">
		<div class="logo desktop"><p>GMF Aircraft Support Services</p></div>
		<div class="logo mobile"><p>GASS</p></div>
		<div class="notif">
			@if(Auth::user()->user_role==1)
			<i class="fa fa-bell" onclick="read()" role="button">
				@if($unread > 0)
				<span id="jmlnotif"class="badge" style="background-color:  #ff3333">{{$unread}}</span>
				@endif
			</i>
			@endif
			<button id="profil">Hi, <?php $nama = explode(' ', Auth::user()->user_nama); echo $nama[0];  ?></button><button id="nav-mobile"><i class="fa fa-bars" aria-hidden="true"></i></button>
			<div id="notif-menu">
				<ul class="profil-menu">
					<div id="lodn" class="text-center" style="padding-right:20px">
							<i class="fa  fa-spinner fa-spin fa-3x" style="color:grey;"></i>
							<br><small style="color:grey">loading notification</small>
					</div>
					<div id="isi">
						<!-- <li>your blabla is blablaasdad</li>
						<li>your blabla is blablaasdad</li>
						<li>your blabla is blablaasdad</li>
						<li>your blabla is blablaasdad</li>
						<li>your blabla is blablaasdad</li>
						<li>your blabla is blablaasdad</li>
						<li>your blabla is blablaasdad</li>
						<li>your blabla is blablaasdad</li>
						<li>your blabla is blablaasdad</li>
						<li>your blabla is blablaasdad</li> -->
					</div>

				</ul>
			</div>
		</div>

			<div id="profil-menu">
				<a href="{{url('/')}}/editaccount/{{Auth::user()->user_id}}"><div class="profil-menu">Edit Profile</div></a>
				<a href="{{url('')}}/logout"><div class="profil-menu">Log Out</div></a>
			</div>
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

	$("#profil").click(function(){
		$("#notif-menu").hide(200);

		$("#profil-menu").toggle(200);

	});

	$("#nav-mobile").click(function(){
		$(".nav2").slideToggle(200);
	});

	function read(){
		$("#isi").html("");
		$("#profil-menu").hide(200);

		$("#notif-menu").toggle(200);
		$("#lodn").show(100);
		$.get("{{url('/')}}/getnotif",function (data){
		//	 console.log(data.notif);
        $('#lodn').hide();
        $("#isi").html(data);
				$('#jmlnotif').hide();

    });

	}
	</script>

	</html>
