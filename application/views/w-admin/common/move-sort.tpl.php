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
			url: $("form").data("page")+".php",
			dataType: "json",
			data: { "act":"moveSort","page":$("input[name=page]").val(),"c":"{$smarty.get.c}","id[]":data } ,
			timeout:10000,     //ajax请求超时时间10秒
			error: function() {
				alert("error!");
			}
		} );
	}
} );
</script>