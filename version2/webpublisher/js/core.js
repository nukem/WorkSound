$(function() {

	$(".tbl_repeat tbody").tableDnD({
		onDrop: function(table, row) {
			var orders = $.tableDnD.serialize();
			$.post('/mod/order.php', { orders : orders });
		}
	});

});