<script>
	$("#report").click(function(){
		$(this).addClass("active");
		$("#history-occ").removeClass("active");
		$("#alokasi-occ").removeClass("active");

		$("#sub-menu-report").show();
		$("#sub-menu-history-occ").hide();
		$("#sub-menu-alokasi-occ").hide();
	});

	$("#history-occ").click(function(){
		$(this).addClass("active");
		$("#report").removeClass("active");
		$("#alokasi-occ").removeClass("active");

		$("#sub-menu-history-occ").show();
		$("#sub-menu-report").hide();
		$("#sub-menu-alokasi-occ").hide();
	});

	$("#alokasi-occ").click(function(){
		$(this).addClass("active");
		$("#report").removeClass("active");
		$("#history-occ").removeClass("active");

		$("#sub-menu-alokasi-occ").show();
		$("#sub-menu-report").hide();
		$("#sub-menu-history-occ").hide();
	});

	$("#report2").click(function(){
		$("#sub-menu-report2").slideToggle();
	});

	$("#history-occ2").click(function(){
		$("#sub-menu-history-occ2").slideToggle();
	});
</script>