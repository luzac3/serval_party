$(document).ready(function(){
	$("#back").on("click",function(){
		storager.delete();
		location.href="./register.html";
	});
});