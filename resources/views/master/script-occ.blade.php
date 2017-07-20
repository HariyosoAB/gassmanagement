<script>
	$("#order-occ").click(function(){
		$(this).addClass("active");
		$("#history-occ").removeClass("active");

		$("#sub-menu-order-occ").show();
		$("#sub-menu-history-occ").hide();
	});

	$("#history-occ").click(function(){
		$(this).addClass("active");
		$("#order-occ").removeClass("active");

		$("#sub-menu-history-occ").show();
		$("#sub-menu-order-occ").hide();
	});
</script>