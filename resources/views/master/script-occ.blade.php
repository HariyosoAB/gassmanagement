<script>
	$("#order-occ").click(function(){
		$(this).addClass("active");
		$("#history-occ").removeClass("active");
		$("#settings-occ").removeClass("active");
		$("#alokasi-occ").removeClass("active");

		$("#sub-menu-order-occ").show();
		$("#sub-menu-history-occ").hide();
		$("#sub-menu-settings-occ").hide();
		$("#sub-menu-alokasi-occ").hide();
	});

	$("#history-occ").click(function(){
		$(this).addClass("active");
		$("#order-occ").removeClass("active");
		$("#settings-occ").removeClass("active");
		$("#alokasi-occ").removeClass("active");

		$("#sub-menu-history-occ").show();
		$("#sub-menu-order-occ").hide();
		$("#sub-menu-settings-occ").hide();
		$("#sub-menu-alokasi-occ").hide();
	});

	$("#settings-occ").click(function(){
		$(this).addClass("active");
		$("#history-occ").removeClass("active");
		$("#order-occ").removeClass("active");
		$("#alokasi-occ").removeClass("active");

		$("#sub-menu-settings-occ").show();
		$("#sub-menu-history-occ").hide();
		$("#sub-menu-order-occ").hide();
		$("#sub-menu-alokasi-occ").hide();
	});

	$("#alokasi-occ").click(function(){
		$(this).addClass("active");
		$("#history-occ").removeClass("active");
		$("#order-occ").removeClass("active");
		$("#settings-occ").removeClass("active");

		$("#sub-menu-settings-occ").hide();
		$("#sub-menu-history-occ").hide();
		$("#sub-menu-order-occ").hide();
		$("#sub-menu-alokasi-occ").show();
	});

	$("#history-occ2").click(function(){
		$("#sub-menu-history-occ2").slideToggle();
	});

	$("#settings-occ2").click(function(){
		$("#sub-menu-settings-occ2").slideToggle();
	});

	$("#order-occ2").click(function(){
		$("#sub-menu-order-occ2").slideToggle();
	});
</script>