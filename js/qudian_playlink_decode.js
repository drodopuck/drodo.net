
//尝试使用phprpc解析视频网址，返回swf
function web_url_2_play_swf_phprpc(url){
	//http://rpc.vision.idc.pplive.cn/rpc/report
	var url = 'http://video.sina.com.cn/p/ent/y/2013-03-08/225662142371.html';
	
	var client = new PHPRPC_Client('http://rpc.vision.idc.pplive.cn/rpc/report', ['analysisVideo']);  
	client.setKeyLength(256);  
	client.setEncryptMode(2);  
	
	input = "{'version': 1,'meta': {'type': 3,'title': 'Web'},'params': {'url': 'http://video.sina.com.cn/p/ent/y/2013-03-08/225662142371.html'},'debug': {'trackID': 'uniqid(true)'}}";
	

	client.analysisVideo('1',function (result, args, output, warning){
	    console.info ("result>>>"+result);
	    console.info ("args>>>"+args);
	    console.info ("output>>>"+output);
	    console.info ("warning>>>"+warning);
	},true);

}


//将视频网址转换为swf播放器地址，每个网站都不一样，分开处理
function web_url_2_play_swf(url,src){
	var swf='';
	try{
	if (src=='PPTV'){ 
		//视频地址：http://v.pptv.com/show/icIbYVk32aKYJhib8.html
		//分享地址：http://player.pptv.com/v/icIbYVk32aKYJhib8.swf
		var re = '.*show\/(.*)\.html';
		var h = url.match(re);
		var id=h[1];
		swf='http://player.pptv.com/v/'+id+'.swf';
	}
	if (src=='优酷网'){
		//视频地址： http://v.youku.com/v_show/id_XNDcxMDkyNTc2.html
		//分享地址：http://player.youku.com/player.php/sid/XNDcxMDkyNTc2/v.swf
		var re = '.*id_(.*)\.html';
		var h = url.match(re);
		var id=h[1];
		swf='http://player.youku.com/player.php/sid/'+id+'/p/1.swf';
	}
	if (src=='56网'){ 
		//视频地址： http://www.56.com/u94/v_NzkxMzIyMzU.html/880831_quanmin2012.html
		//分享地址： http://player.56.com/v_NzkxMzIyMzU.swf
		var re = '.*\/(.*)\.html\/.*\.html';
		var h = url.match(re);
		var id=h[1];
		swf='http://player.56.com/'+id+'.swf';
	}
	if (src=='腾讯视频'){ //有的不行!
		//视频地址：http://v.qq.com/cover/h/hrppz6gng90l5ok.html?vid=l0011a5dx48
		//分享地址: http://static.video.qq.com/TPout.swf?vid=l0011a5dx48&auto=1
		var re = '.*vid=(.*)';
		var h = url.match(re);
		var id=h[1];
		swf='http://static.video.qq.com/TPout.swf?vid='+id+'&auto=1';
	}
	if (src=='土豆网'){ //有的不行!
		//视频地址：http://www.tudou.com/programs/view/ThxKzrRowuA/
		//分享地址：http://www.tudou.com/v/ThxKzrRowuA/&resourceId=0_04_05_99/v.swf
		var re = '.*view\/(.*)\/';
		var h = url.match(re);
		var id=h[1];
		swf='http://www.tudou.com/v/'+id+'/&resourceId=0_04_05_99/v.swf';
	}
	if (src=='爱奇艺'){ //貌似不行
		//视频地址：http://www.iqiyi.com/dianying/20130205/458a93a9a77c6960.html
		//分享地址：http://player.video.qiyi.com/967951b6b7944555a42d7d8ba7938106/458a93a9a77c6960.swf
		var re = '.*dianying\/.*\/(.*)\.html';
		var h = url.match(re);
		var id=h[1];
		swf='http://player.video.qiyi.com/967951b6b7944555a42d7d8ba7938106/'+id+'.swf';
	}
	if (src=='凤凰网'){
		//视频地址: http://v.ifeng.com/documentary/military/201304/8460820a-7b60-43b7-9ee0-b4dfc733d1a6.shtml
		//分享地址: http://v.ifeng.com/include/exterior.swf?guid=8460820a-7b60-43b7-9ee0-b4dfc733d1a6&AutoPlay=false
		var re = 'http:\/\/v.ifeng.com\/.*\/.*\/(.*)\.shtml';
		var h = url.match(re);
		var id=h[1];
		swf='http://v.ifeng.com/include/exterior.swf?guid='+id+'&AutoPlay=true';
	}
	if (src=='新浪视频'){  //不行？
		
		//视频地址: http://video.sina.com.cn/p/ent/y/2013-03-08/225662142371.html
		//分享地址: http://you.video.sina.com.cn/api/sinawebApi/outplayrefer.php/vid=98765385_28_PRrgSHNtCzHK+l1lHz2stqkM7KQNt6nngXz34gapIwxYUQ6NYJ2PJIRT7SDeB8lH8mRI/s.swf
		$.get("get_playlink.php?url="+url, 
				  function(data){
			  			//data = data.replace("\n", "");
			  			//console.info(data);
						var re = ".*swfOutsideUrl:\'(.*)\'.*";
						var h = data.match(re);
						var id=h[1];
						//var swf='http://you.video.sina.com.cn/api/sinawebApi/outplayrefer.php/vid='+id+'/s.swf';
						
						var swf_str=swf_2_player(id);
						show_swf_player(swf_str);
						
				  });

	}
	if (src=='搜狐视频'){  //有的不行？
		//视频地址: http://my.tv.sohu.com/us/50333101/24650158.shtml
		//分享地址: http://share.vrs.sohu.com/my/v.swf&topBar=1&autoplay=false&id=24650158
		var re = '.*\/(\\w+)\.shtml';
		var h = url.match(re);
		var id=h[1];
		swf='http://share.vrs.sohu.com/my/v.swf&topBar=1&autoplay=false&id='+id+'';
	}
	if (src=='音悦台'){  //不行？
		//视频地址: http://www.yinyuetai.com/video/26742
		//分享地址: http://player.yinyuetai.com/video/player/%s/v_0.swf
		var re = 'http:\/\/www\.yinyuetai\.com\/video\/(.*)';
		var h = url.match(re);
		var id=h[1];
		swf='http://player.yinyuetai.com/video/player/'+id+'/v_0.swf';
	}
	if (src=='酷六网'){  //不行？
		//视频地址: http://my.tv.sohu.com/us/50333101/24650158.shtml
		//分享地址: http://share.vrs.sohu.com/my/v.swf&topBar=1&autoplay=false&id=24650158
		var re = '.*\/(\\w+)\.shtml';
		var h = url.match(re);
		var id=h[1];
		swf='http://share.vrs.sohu.com/my/v.swf&topBar=1&autoplay=false&id='+id+'';
	}

	console.info(">>>>>>>>>>", url);
	console.info(">>>>>>>>>>", swf);
	}
	catch(e){
		console.info(">>>>>>>>>>", e);
	}
	
	return swf;
}