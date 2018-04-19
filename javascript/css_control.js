$(window).resize(function(){
	let winw = $(window).width();
	if(winw < 1050){
		$("html").css("width",winw-50+"px");
	}
});
	