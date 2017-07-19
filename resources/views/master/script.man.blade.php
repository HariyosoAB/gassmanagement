<script>
	$("#order-man").click(function(){
		$(this).addClass("active");
		$("#history-man").removeClass("active");
		$("#report").removeClass("active");

		$("#sub-menu-order-man").show();
		$("#sub-menu-history-man").hide();
		$("#sub-menu-report").hide();
	});

	$("#history-man").click(function(){
		$(this).addClass("active");
		$("#report").removeClass("active");
		$("#order-man").removeClass("active");

		$("#sub-menu-history-man").show();
		$("#sub-menu-order-man").hide();
		$("#sub-menu-report").hide();
	});

	$("#report").click(function(){
		$(this).addClass("active");
		$("#history-man").removeClass("active");
		$("#order-man").removeClass("active");

		$("#sub-menu-report").show();
		$("#sub-menu-history-man").hide();
		$("#sub-menu-order-man").hide();
	});
</script>