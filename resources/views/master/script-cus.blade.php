<script>
	$("#order-cus").click(function(){
		$(this).addClass("active");
		$("#history-cus").removeClass("active");

		$("#sub-menu-order-cus").show();
		$("#sub-menu-history-cus").hide();
	});

	$("#history-cus").click(function(){
		$(this).addClass("active");
		$("#order-cus").removeClass("active");

		$("#sub-menu-history-cus").show();
		$("#sub-menu-order-cus").hide();
	});
</script>