<script>
	$("#home").click(function(){
		$(this).addClass("active");
		$("#order").removeClass("active");
		$("#setting").removeClass("active");

		$("#sub-menu-home").show();
		$("#sub-menu-order").hide();
		$("#sub-menu-setting").hide();
	});

	$("#order").click(function(){
		$(this).addClass("active");
		$("#home").removeClass("active");
		$("#setting").removeClass("active");

		$("#sub-menu-home").hide();
		$("#sub-menu-order").show();
		$("#sub-menu-setting").hide();
	});

	$("#setting").click(function(){
		$(this).addClass("active");
		$("#order").removeClass("active");
		$("#home").removeClass("active");

		$("#sub-menu-home").hide();
		$("#sub-menu-order").hide();
		$("#sub-menu-setting").show();
	});
</script>