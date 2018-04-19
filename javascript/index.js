$(document).ready(function(){
	storager.delete();
	$.ajax({
		url:"../php/count_logger.php",
		cache: false,
		timeout: 10000,
        type:'POST',
        dataType: 'json',
        data : {
        	id:"index"
        }
	}).then(function(data){
		console.log(data);
	},
	function(){
		console.log("error");
	});
})