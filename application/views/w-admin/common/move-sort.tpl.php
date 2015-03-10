<script type="text/javascript" src="/js/w-admin/jquery.dragsort-0.5.2.js"></script>
<script type="text/javascript">
$(function() {
	$("tbody#list").dragsort( {
		dragEnd: changeSort
	} );
	function changeSort() {
		var data = $("tbody#list tr").map(function() {
				return this.id;
			} ).get();
		$.ajax( {
			type: "POST",
			url: $("form").attr("action") + "/move",
			dataType: "json",
			data: { "page":"<?php echo $this->uri->segment(3, 1);?>","c":"<?php echo $this->uri->segment(4, '');?>","id[]":data } ,
			timeout:10000,     //ajax请求超时时间10秒
			error: function() {
				alert("error!");
			}
		} );
	}
} );
</script>