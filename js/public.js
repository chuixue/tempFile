// JavaScript Document
	function getQueryString(name) { 
		var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i"); 
		var r = window.location.search.substr(1).match(reg); 
		if (r != null) return unescape(r[2]); return null; 
	}
	function cout(obj){ console.log(obj);	}
	function range(a, b){
		var begin = b && a || 0, end = b || a, ls = [];
		for(var i=begin; i<end; i++)ls.push(i);
		return ls;
	}


	function getNames(count){
		var all = [], names = {};
		var temp1 = ['赵','钱','孙','李','周','吴','郑','王','冯','陈','楚','卫','刘','何'];
		var temp2 = ["曼","婷","玥","婷","优","璇","雨","嘉","娅","楠","明","美","惠","茜","漫","妮","媛","馨","梦","涵","碧",
						"萱","慧","妍","璟","雯","梦","婷","雪","怡","彦","歆","芮","涵","笑","薇","婧","涵","鑫","蕾","淑","颖",
						"钰","彤","天","瑜","梦","洁","凌","薇","雅","静","雅","芙","思","颖","欣","然","滢","心","雪","馨","凌",
						"菲","钰","琪","婧","宸","靖","瑶","熙","雯","琪","涵","伶","韵","思","睿"];
		for(var i=0; i<count; i++){
			var nm = "";
			while(nm == "" || names[nm] == 1){
				nm = temp1[parseInt(Math.random() * temp1.length)] + temp2[parseInt(Math.random() * temp2.length)];
				if(Math.random()>0.5)nm += temp2[parseInt(Math.random() * temp2.length)];
			}
			names[nm] = 1; all.push(nm);
		}
		return all;
	}