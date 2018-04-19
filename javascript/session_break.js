setTimeout(function(){
		storager.set("timeout",0);
	},30*60*1000)
	
	storager.set("timeout",1);
	
	storager.get("timeout");