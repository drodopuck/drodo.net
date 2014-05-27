//拼写“转播”按钮的html代码
function share_2_html(video){
	//console.info(video);
	var btn_id = 'btn_share_'+video.id;
	var html_str='';
	if (video.shared_by){
		html_str = "<div id='"+btn_id+"' class='btn_shared' onclick=''></div> ";
	}
	else{
		html_str = "<div id='"+btn_id+"' class='btn_share clickable' onclick='share_video("+video.id+","+video.cursor_id+","+video.first_feed.id+");' " +
				"onmouseover='change_class(\""+btn_id+"\",\"btn_share\",\"btn_share_2\");' "+ 
				"onmouseout='change_class(\""+btn_id+"\",\"btn_share_2\",\"btn_share\");' ></div> ";
	}
	return html_str;
}

//拼写“喜欢”按钮的html代码
function like_2_html(video){
	//console.info(video);
	var btn_id = 'btn_like_'+video.id;
	var html_str='';
	if (video.liked_by){
		html_str = "<div id='"+btn_id+"' class='btn_liked' onclick=''></div> ";
	}
	else{
		html_str = "<div id='"+btn_id+"' class='btn_like clickable' onclick='like_video("+video.id+","+video.cursor_id+");' " +
				"onmouseover='change_class(\""+btn_id+"\",\"btn_like\",\"btn_like_2\");' "+ 
				"onmouseout='change_class(\""+btn_id+"\",\"btn_like_2\",\"btn_like\");' ></div> ";
	}
	return html_str;
}

//拼写“收看”按钮的html代码
function watch_2_html(user,video,color){
	//console.info(user);
	var btn_id = 'btn_watch_'+user.id;
	var html_str='';
	if (color==0){ //灰色版
		if (user.following || user.id==user_id){
			html_str = "<div id='"+btn_id+"' class='btn_watched "+btn_id+"' onclick=''></div> ";
		}
		else{
			html_str = "<div id='"+btn_id+"' class='btn_watch clickable "+btn_id+"' onclick='watch_user("+user.id+","+video.cursor_id+");' " +
					"onmouseover='change_class(\""+btn_id+"\",\"btn_watch\",\"btn_watch_2\");' "+ 
					"onmouseout='change_class(\""+btn_id+"\",\"btn_watch_2\",\"btn_watch\");' ></div> ";
		}
	}
	if (color==1){ //白色版
		if (user.following || user.id==user_id){
			html_str = "<div id='"+btn_id+"' class='btn_watched_white "+btn_id+"' onclick=''></div> ";
		}
		else{
			html_str = "<div id='"+btn_id+"' class='btn_watch_white clickable shadow "+btn_id+"' onclick='watch_user_white("+user.id+");' " +
					"onmouseover='change_class(\""+btn_id+"\",\"btn_watch_white\",\"btn_watch_white_2\");' "+ 
					"onmouseout='change_class(\""+btn_id+"\",\"btn_watch_white_2\",\"btn_watch_white\");' ></div> ";
		}
	}
	if (color==2){ //白色版-可取消的
		if (user.following || user.id==user_id){
			html_str = "<div id='"+btn_id+"' style='margin-top:0px;' class='btn_watched_white_cancel clickable "+btn_id+"' onclick='cancel_watch_user("+user.id+");'></div> ";
		}
		else{
			html_str = "<div id='"+btn_id+"' style='margin-top:0px;' class='btn_watch_white clickable shadow "+btn_id+"' onclick='watch_user_white_2("+user.id+");' " +
					"onmouseover='change_class(\""+btn_id+"\",\"btn_watch_white\",\"btn_watch_white_2\");' "+ 
					"onmouseout='change_class(\""+btn_id+"\",\"btn_watch_white_2\",\"btn_watch_white\");' ></div> ";
		}
	}
	return html_str;
}


//拼写“我的信息”html代码
function my_info_2_html(user){
	//console.info(user);
	var html_str="";
	html_str += "<div class='hugehead_border shadow' style='width:200px;background-color:#ffffff;padding:0px;'><div>" +
			"<img class='hugehead' src='"+user.avatar+"'/></div><div style='padding-left:10px;padding-right:10px;padding-bottom:10px;'>";
	html_str += "<div class='right_title'>";
	html_str += "<font class='xxlarge gray' >"+user.name+"</font>";
	html_str += "<hr size=1 color=#eeeeee class='line_220' style='margin-top:5px;'>"
	html_str += "</div>";
	
	html_str += "<div class='right_title'>";
	if (curr_type==2){
		html_str += "<font class='orange xxlarge clickable' onclick='jump_page(2,1,0,0,0);'>我的趣点</font>";
	}
	else {
		html_str += "<font class='gray xxlarge clickable hover' onclick='jump_page(2,1,0,0,0);'>我的趣点</font>";
	}
	html_str += "</div>";
	html_str += "<div class='right_title'>";
	if (curr_type==3 && curr_user==user_id){
		html_str += "<font class='orange xxlarge clickable ' onclick='jump_page(3,1,0,"+user.id+",0);'>我的个人频道</font>";
	}
	else{
		html_str += "<font class='gray xxlarge clickable hover' onclick='jump_page(3,1,0,"+user.id+",0);'>我的个人频道</font>";
	}
	html_str += "</div></div></div>";
	return html_str;
}


//拼写“ta收看的”html代码
function his_friends_2_html(friends,count){
	var html_str='';
	//console.info(friends);
	var gd = (curr_user_info.gender=="female"?"她":"他");
	if (curr_user_info.id==user_id) { gd = "我"; }
	
	html_str += "<div id='icon_refresh_friends' class='icon_refresh clickable' title='换一批' ";
		html_str += "onclick='get_friends();' ";
		html_str += "onmouseover='change_class(\"icon_refresh_friends\",\"icon_refresh\",\"icon_refresh_2\")'  ";
		html_str += "onmouseout='change_class(\"icon_refresh_friends\",\"icon_refresh_2\",\"icon_refresh\")'> ";
	html_str += "</div> ";
	
	html_str += "<font id='qudian_plaza_title' class='gray xxlarge'>"+gd+"收看的&nbsp;</font>";
	html_str += "<font id='qudian_plaza_title' class='gray xlarge'>"+count+"</font>";
	html_str += "<hr size=1 color=#e4e4e4 class='line_220'>";
	html_str += "<div id='his_friends' class='his_friends'>";
	for (var i=0;i<friends.length;i++){
		var user = friends[i];
		html_str += '<div >';
		html_str += '<div class="clickable" onclick="jump_page(3,1,0, '+user.id+',0);" style="width:40px;height:40px;float:left;"><img class="smallhead_recommened" src='+user.avatar+' /></div>'
		html_str += '<div class="clickable" onclick="jump_page(3,1,0, '+user.id+',0);" style="width:105px;height:30px;margin-top:10px;float:left;line-height:30px;"><font class="gray large">'+user.name+'&nbsp;&nbsp;&nbsp;&nbsp;</font></div>';
		html_str += '<div style="width:55px;height:30px;margin-top:10px;float:left;text-align:center;line-height:30px;">';
		html_str += ""+watch_2_html(user,0,1)+"</div>" ;
		html_str += "</div>";
	}
	
	html_str += "</div>'";
	
	
	return html_str;
}

//拼写“ta的观众”html代码
function his_followers_2_html(followers,count){
	html_str='';
	//console.info(followers);
	
	var gd = (curr_user_info.gender=="female"?"她":"他");
	if (curr_user_info.id==user_id) { gd = "我"; }
	
	html_str += "<div id='icon_refresh_followers' class='icon_refresh clickable' title='换一批' ";
		html_str += "onclick='get_followers();' ";
		html_str += "onmouseover='change_class(\"icon_refresh_followers\",\"icon_refresh\",\"icon_refresh_2\")'  ";
		html_str += "onmouseout='change_class(\"icon_refresh_followers\",\"icon_refresh_2\",\"icon_refresh\")'> ";
	html_str += "</div> ";
	
	html_str += "<font id='qudian_plaza_title' class='gray xxlarge'>"+gd+"的观众&nbsp;</font>";
	html_str += "<font id='qudian_plaza_title' class='gray xlarge'>"+count+"</font>";
	html_str += "<hr size=1 color=#e4e4e4 class='line_220'>";
	html_str += "<div id='his_friends' class='his_friends'>";
	for (var i=0;i<followers.length;i++){
		var user = followers[i];
		html_str += '<div >';
		html_str += '<div class="clickable" onclick="jump_page(3,1,0, '+user.id+',0);" style="width:40px;height:40px;float:left;"><img class="smallhead_recommened" src='+user.avatar+' /></div>'
		html_str += '<div class="clickable" onclick="jump_page(3,1,0, '+user.id+',0);" style="width:105px;height:30px;margin-top:10px;float:left;line-height:30px;"><font class="gray large">'+user.name+'&nbsp;&nbsp;&nbsp;&nbsp;</font></div>';
		html_str += '<div style="width:55px;height:30px;margin-top:10px;float:left;text-align:center;line-height:30px;">';
		html_str += ""+watch_2_html(user,0,1)+"</div>" ;
		html_str += "</div>";
	}
	
	html_str += "</div>'";
	
	return html_str;
}


//拼写左边的标题栏的html代码
function left_title_2_html(type,title1,title1_color,title2,title2_color,icon){
	var html_str="";
	html_str += "<div class='left_title_left'>";
	html_str += "<div class='"+icon+"'>";
	html_str += "<div style='line-height:24px;position:absolute;margin-top:25px;margin-left:30px;width:690px;height:30px;'>" +
			"<font class='xxxlarge "+title1_color+"' style='float:left;'>"+title1+"</font>" +
			"<font class='xxlarge "+title2_color+"' style='float:left;'>"+title2+"&nbsp;</font>";
	if (type==3){
		if (!(curr_user == user_id)){ //收看
			html_str += watch_2_html(curr_user_info,0,2);
		}
		if (curr_flag==1){
			html_str += "<div id='title_share_count' style='float:right;' onclick='jump_page(3,1,0,"+curr_user_info.id+",0);'><font class='xxlarge gray hover clickable'>&nbsp;&nbsp;&nbsp;转播&nbsp;</font><font class='xlarge gray'>"+curr_user_info.share_count+"</font></div>";
			html_str += "<div id='title_like_count' style='float:right;'><font class='xxlarge orange'>&nbsp;&nbsp;&nbsp;喜欢&nbsp;</font><font class='xlarge orange'>"+curr_user_info.like_count+"</font></div>";		
		}
		else{
			html_str += "<div id='title_share_count' style='float:right;'><font class='xxlarge orange'>&nbsp;&nbsp;&nbsp;转播&nbsp;</font><font class='xlarge orange'>"+curr_user_info.share_count+"</font></div>";
			html_str += "<div id='title_like_count' style='float:right;' onclick='jump_page(3,1,0,"+curr_user_info.id+",1);'><font class='xxlarge gray hover clickable'>&nbsp;&nbsp;&nbsp;喜欢&nbsp;</font><font class='xlarge gray'>"+curr_user_info.like_count+"</font></div>";		
		}
	}
	if (type==1 || type==2){
		html_str += "<div style='float:right;'><font class='xlarge gray'>"+getdate()+"</font></div>";
	}
	html_str += "</div>";
	html_str += "</div>";
	return html_str;
}


//拼写播放器的html代码
function video_2_player(video) {
	var html_str="";
	var width=910,height=600;
	var url = '';
	url = video.swf_url;
	if (!url){
		url = web_url_2_play_swf(video.web_url,video.from);
		//url2 = "http://qudian.pptv.com/updateinfo?vedio_id="+video.id;
		//http_get_no_jsonp(url2,true,cb);
		//http://vision.synacast.com/man/video/3869300/get_swf_url
		//如果没有swf_url，调用自己的逻辑尝试解析，并且异步报告
		//var url_rpt = "http://vision.synacast.com/man/video/"+video.id+"/get_swf_url";
		//http_get(url_rpt, cb);
	}
	
	if (url==''||url==null){
		//url = 'http://player.video.qiyi.com/967951b6b7944555a42d7d8ba7938106/458a93a9a77c6960.swf';
		//url = 'http://player.youku.com/player.php/sid/XNDcxMDkyNTc2/v.swf';
		//url = 'http://share.vrs.sohu.com/my/v.swf&topBar=1&autoplay=true&id=53604639';
		//url = 'http://you.video.sina.com.cn/api/sinawebApi/outplayrefer.php/vid=102427057_1_ahrhTCpqXGDK+l1lHz2stqkM7KQNt6nknynt71+iJw1dUAuLZIrfO4kK4SnUBM1F8WlK/s.swf';
		//url = 'http://player.56.com/v_NzkxMzIyMzU.swf';
		//url = 'http://static.video.qq.com/TPout.swf?vid=l0011a5dx48&auto=1';
		//url = 'http://www.tudou.com/v/ThxKzrRowuA/&resourceId=0_04_05_99/v.swf';
		//url = 'http://player.pptv.com/v/icIbYVk32aKYJhib8.swf';
		//url = 'http://player.yinyuetai.com/video/player/553740/v_0.swf'; //不好用了
		//url = 'http://v.ifeng.com/include/exterior.swf?guid=8460820a-7b60-43b7-9ee0-b4dfc733d1a6&AutoPlay=true';
		return '';
	}
	
// 	html_str+= '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width='+width+' height='+height+'> ';
// 	html_str+= '<param name="movie" value="'+url+'" />';
// 	html_str+= '<!--[if !IE]>--> ';
// 	html_str+= '<object type="application/x-shockwave-flash" data="'+url+'" width='+width+' height='+height+'> ';
// 	html_str+= '<!--<![endif]--> ';
// 	html_str+= '<p>Alternative content</p> ';
// 	html_str+= '<!--[if !IE]>--> ';
// 	html_str+= '</object> ';
// 	html_str+= '<!--<![endif]--> ';
// 	html_str+= '</object> ';

	html_str+= '<embed id="share_player" style="background:black" src="'+url+'" ';
	html_str+= 'type="application/x-shockwave-flash" allowscriptaccess="always" ';
	html_str+= 'allowfullscreen="true" wmode="opaque" width='+width+' height='+height+' ';
	html_str+= 'loop="true" autostart="true"></embed> ';

	return html_str;
}

function swf_2_player(url) {
	var html_str="";
	var width=640,height=480;
	if (url==''||url==null){
		//url = 'http://player.video.qiyi.com/967951b6b7944555a42d7d8ba7938106/458a93a9a77c6960.swf';
		//url = 'http://player.youku.com/player.php/sid/XNDcxMDkyNTc2/v.swf';
		//url = 'http://share.vrs.sohu.com/my/v.swf&topBar=1&autoplay=true&id=53604639';
		//url = 'http://you.video.sina.com.cn/api/sinawebApi/outplayrefer.php/vid=102427057_1_ahrhTCpqXGDK+l1lHz2stqkM7KQNt6nknynt71+iJw1dUAuLZIrfO4kK4SnUBM1F8WlK/s.swf';
		//url = 'http://player.56.com/v_NzkxMzIyMzU.swf';
		//url = 'http://static.video.qq.com/TPout.swf?vid=l0011a5dx48&auto=1';
		//url = 'http://www.tudou.com/v/ThxKzrRowuA/&resourceId=0_04_05_99/v.swf';
		//url = 'http://player.pptv.com/v/icIbYVk32aKYJhib8.swf';
		//url = 'http://player.yinyuetai.com/video/player/553740/v_0.swf'; //不好用了
		//url = 'http://v.ifeng.com/include/exterior.swf?guid=8460820a-7b60-43b7-9ee0-b4dfc733d1a6&AutoPlay=true';
		return '';
	}
	
// 	html_str+= '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width='+width+' height='+height+'> ';
// 	html_str+= '<param name="movie" value="'+url+'" />';
// 	html_str+= '<!--[if !IE]>--> ';
// 	html_str+= '<object type="application/x-shockwave-flash" data="'+url+'" width='+width+' height='+height+'> ';
// 	html_str+= '<!--<![endif]--> ';
// 	html_str+= '<p>Alternative content</p> ';
// 	html_str+= '<!--[if !IE]>--> ';
// 	html_str+= '</object> ';
// 	html_str+= '<!--<![endif]--> ';
// 	html_str+= '</object> ';

	html_str+= '<embed id="share_player" style="background:black" src="'+url+'" ';
	html_str+= 'type="application/x-shockwave-flash" allowscriptaccess="always" ';
	html_str+= 'allowfullscreen="true" wmode="opaque" width='+width+' height='+height+' ';
	html_str+= 'loop="true" autostart="true"></embed> ';

	return html_str;
}


//拼写分类列表的html代码
function catalogs_2_html(catas){
	var html_str='';
	if (curr_type==1 && curr_cata==0){
		html_str += "<font id='qudian_plaza_title' class='orange xxlarge clickable hover' ";
	}
	else{
		html_str += "<font id='qudian_plaza_title' class='gray xxlarge clickable hover' ";
	}
	html_str += "	onclick=\"jump_page(1,3,0,0,0);\" >趣点广场</font>";
	html_str += "	<hr size=1 color=#e4e4e4 class='line_220'>";
	html_str += "	<div class='qudian_plaza_cata'>";
	for (var i=0;i<catas.length;i++){
		var cata = catas[i];
		html_str += '<div class="cata clickable" onclick="jump_page(1,3,'+cata.id+',0,0);">';
		if (curr_cata ==cata.id){
			html_str += '<font class="orange xlarge">'+cata.name+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></div>';
		}
		else{
			html_str += '<font class="gray xlarge hover">'+cata.name+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></div>';
		}
	}
	html_str += "</div>";
	return html_str;
}

//拼写推荐收看的html代码
function recommened_users_2_html(users){
	var html_str='';
	for (var i=0;i<users.length;i++){
		var user = users[i];
		html_str += '<div >';
		html_str += '<div class="clickable" onclick="jump_page(3,1,0, '+user.id+',0);" style="width:40px;height:40px;float:left;"><img class="smallhead_recommened" src='+user.avatar+' /></div>'
		html_str += '<div class="clickable" onclick="jump_page(3,1,0, '+user.id+',0);" style="width:105px;height:30px;margin-top:10px;float:left;line-height:30px;"><font class="gray large">'+user.name+'&nbsp;&nbsp;&nbsp;&nbsp;</font></div>';
		html_str += '<div style="width:55px;height:30px;margin-top:10px;float:left;text-align:center;line-height:30px;">';
		html_str += ""+watch_2_html(user,0,1)+"</div>" ;
		html_str += "</div>";

	}
	return html_str;
}

//将video，转化成html代码(用于播放页右侧)
function video_2_html(video){
	
	var html_str="";
	//关键feed的用户信息
	var feed = video.first_feed;
	if (feed){
		var feed_user = feed.user;
		var feed_user_url = feed_user.avatar;
	}

 	html_str+= "<div><div class='player_sharer'>";
	if (feed){
	 	html_str+= "<img class='normalhead clickable' onclick='jump_page(3,1,0,"+feed_user.id+",0);' src='"+feed_user_url+"' title='"+feed_user.name+"'/>";
		html_str+= "<font class='xlarge orange clickable' onclick='jump_page(3,1,0,"+feed_user.id+",0);'>"+feed_user.name+"</font><br>";
		html_str+= "<time class='timeago gray normal' datetime='"+feed.time+"'></time>";
 	}
 	html_str+= "</div>";

	html_str+= "</div>";
 	 	
 	html_str+= "<div style='padding-right:20px; min-height:98px;'>";
	
	html_str+= "<font class='xlarge lightgray ' >"+(video.description)+"</font></div>";

	//喜欢
	var liked_users = video.liked_users;
	html_str+= "<br><br>";
 	html_str+= "<div><div><div id='player_like_list_count'><font class='large gray'>"+video.liked_count+"人喜欢</font></div>";
 	html_str+= "<hr size=1 color=#222222 class='player_line' >";
	
	html_str+= "<div id='player_like_list' class='player_like_list'>";
	for(var i=0;i<min(liked_users.length,5);i++ ){
		var curr_user = liked_users[i];
		html_str+= "<img class='player_smallhead clickable' onclick='jump_page(3,1,0,"+curr_user.id+",0);' src='"+curr_user.avatar+"' title='"+curr_user.name+"'/>";
	}
	html_str+= "</div></div>";

	//转播
	var shared_feeds = video.shared_feeds;
 	html_str+= "<div style='float:left;width:200px;'><div><font class='large gray'>"+video.shared_count+"人转播</font>";
 	html_str+= "<hr size=1 color=#222222 class='player_line'></div>";
 	html_str+= "<div>";
	for(var i=0;i<min(shared_feeds.length,5);i++ ){
		var curr_feed = shared_feeds[i];
		//console.info(">>>>>>>>>>", curr_feed);
		//html_str+= "<img class='player_smallhead' src='"+curr_feed.user.avatar+"' title='"+curr_feed.user.name+"'/>";
		html_str+= "<div style='float:left;width:200px;padding-right:20px;'><img class='player_shared_smallhead clickable' onclick='jump_page(3,1,0,"+curr_feed.user.id+",0);' src='"+curr_feed.user.avatar+"' title='"+curr_feed.user.name+"'/>";
	 	html_str+= "<div class='player_smallhead_desc' style='float:left;width:160px;'>";
		html_str+= "<font class='small orange clickable' onclick='jump_page(3,1,0,"+curr_feed.user.id+",0);'>"+curr_feed.user.name+"</font><br>";
		html_str+= "<time class='timeago gray small' datetime='"+curr_feed.time+"'></time>";
		html_str+= "<font class='small lightgray'>&nbsp;"+curr_feed.text+"</font></div></div>";
	}
	html_str+= "</div></div>";

	return html_str;
}

//将video列表，转化成html代码(用于三列瀑布流)
function videos_2_html_3_col(videos){
	var html_str = "";
	curr_page++;
	for(var i=0;i<videos.length;i++) 
	{ 
		var video = videos[i];
		pre_video[video.cursor_id] = previous_cursor_id;
		next_video[previous_cursor_id] = video.cursor_id;
		next_video[video.cursor_id] = 0;
		previous_cursor_id = video.cursor_id;
		
		video_list[video.cursor_id] = video;
		var image = video.image;
		
		var last_liked_friend = null;
	 	if (video.liked_friends_count>0){
	 		last_liked_friend = video.liked_friends[0];
	 	}
	
		//x和y是图片的原始尺寸
	 	var x = image.w;
	 	var y = image.h;
	 	//x2和y2是固定204宽度的尺寸
	 	var x2 = 204;
	 	var y2 = x2*y/x;
	 	//x3和y3是鼠标放上去后放大效果的尺寸
	 	var x3 = 220;
	 	var y3 = y2+16;
		//播放按钮的位置
	 	var play_y = (y3-60)/2;
	 	var play_x = (x3-60)/2;
	 	//时间标签的位置
	 	var time_y = y3-8-20;
	 	var time_x = x3-8-50;
	 	//拼出时长的字符串time
	 	var sec = video.duration;
	 	var min =  parseInt(sec/60);
	 	sec = sec%60;
		if (sec<10){ sec='0'+sec; }
	 	time = min+':'+sec;
	 	if (min==0 && sec==0){ time = '未知'; }
		//关键feed的用户信息
	 	var feed = video.first_feed;
	 	var feed_user = feed.user;
	 	var feed_user_url = feed_user.avatar;

	 	
	 	curr_video_cursor_id = video.cursor_id;
	 	//console.info(curr_video_cursor_id);

	 	var id = video.cursor_id+'_'+curr_page; //用来给元素编号的id

		html_str+= "<div class='item'>";
		html_str+= "<div style='width:220px;height:"+y3+"px;' >";

		if (!(min==0 && sec==0)){
		html_str+= "<div id='btn_time_"+id+"' style='width:50px;height:20px;cursor:pointer;opacity:0.5; z-index:20;";
		html_str+= "position:absolute; margin-top:"+time_y+";margin-left:"+time_x+"; background-color:#333333; ";
		html_str+= "line-height:20px; text-align:center;'";
		html_str+= "onmouseover='enlarge_video(\""+id+"\","+x3+","+y3+");'";
		html_str+= "onmouseout='ennormal_video(\""+id+"\","+x2+","+y2+");' onclick='play_video("+video.cursor_id+");' hidden=true >";
		html_str+= "<font class='white normal'>"+time+"</font>";
		html_str+= "</div>";
		}
	
		html_str+= "<div id='btn_play_"+id+"' class='icon_play clickable' ";
		html_str+= "style='position:absolute; margin-top:"+play_y+";margin-left:"+play_x+"; opacity:1; z-index:20;cursor:pointer;'";
		html_str+= "onmouseover='enlarge_video(\""+id+"\","+x3+","+y3+");'";
		html_str+= "onmouseout='ennormal_video(\""+id+"\","+x2+","+y2+");' onclick='play_video("+video.cursor_id+");' hidden=true ></div>";
		
		html_str+= "<div id='img_div_video_"+id+"' class='normal clickable' " ;
		html_str+= "onmouseover='enlarge_video(\""+id+"\","+x3+","+y3+");' ";
		html_str+= "onmouseout='ennormal_video(\""+id+"\","+x2+","+y2+");' onclick='play_video("+video.cursor_id+");' >";
		html_str+= "<img id='img_video_"+id+"' src='"+image.url+"' style='width:"+x2+"px; height:"+y2+"px' >";
		html_str+= "</div>";

		
		html_str+="</div>";

			
		html_str+= "<div class='video'>";
	 	html_str+= "<font class='xlarge lightgray'>"+video.title+"</font><br>";
	 	html_str+= "<hr color=#222222 size=1>";
	 	html_str+= "<div style='float:left;'><font class='normal gray' style='margin-top:-5px;'>&nbsp;"+video.liked_count;
	 	html_str+= "人喜欢&nbsp;&nbsp;&nbsp;</font></div<div style='float:left;'><font class='normal gray' style='margin-top:-5px;'>&nbsp;"+video.shared_count+"人转播</font></div><br>";
	 	
	 	
	 	if (last_liked_friend){
	 	 	html_str+= "<div style=''><img class='smallhead clickable' title='"+last_liked_friend.name+"' onclick='jump_page(3,1,0,"+last_liked_friend.id+",0);' src='"+last_liked_friend.avatar+"'/>";
	 	 	html_str+= "<div class='smallhead_desc'>";
	 		html_str+= "<font class='small orange clickable' onclick='jump_page(3,1,0,"+last_liked_friend.id+",0);'>"+last_liked_friend.name+"</font><br>";
	 		html_str+= "<font class='small gray'>很喜欢这个视频</font>";
	 		html_str+= "</div>";
	 		html_str+= "</div>";
	 	}
	 	
	 	html_str+= "<img class='smallhead clickable' onclick='jump_page(3,1,0,"+feed_user.id+",0);' src='"+feed_user_url+"' title='"+feed_user.name+"'/>";
		//html_str+= "<dd class='tools c_b con'><a href='###' title='' class='share'><i></i>120</a><a href='###' title='' class='like'><i></i>120</a></dd>";
	 	html_str+= "<div class='smallhead_desc'>";
		html_str+= "<font class='small orange clickable' onclick='jump_page(3,1,0,"+feed_user.id+",0);'>"+feed_user.name+"</font><br>";
		html_str+= "<time class='timeago gray small' datetime='"+feed.time+"'></time>";
		html_str+= "<font class='small gray'>&nbsp;转播自"+video.from+"</font>";
	 	html_str+= "</div>";
	 	
	 	
	 	html_str+= "</div>";
	 	html_str+= "</div>";

	
	} 

	
	return html_str;
}

//将video列表，转化成html代码(用于单列瀑布流)
function videos_2_html_1_col(videos){
	var html_str = "";
	curr_page++;

	//console.info(videos);
	for(var i=0;i<videos.length;i++) 
	{ 
		var video = videos[i];
		//关键feed的用户信息
	 	var feed = video.first_feed;
		//console.info(feed);
	 	if (!feed){ continue; }
	 	
	 	var feed_user = feed.user;
	 	var feed_user_url = feed_user.avatar;
	 	var last_liked_friend = null;
	 	if (video.liked_friends_count>0){
	 		last_liked_friend = video.liked_friends[0];
	 	}
		
		
		pre_video[video.cursor_id] = previous_cursor_id;
		next_video[previous_cursor_id] = video.cursor_id;
		next_video[video.cursor_id] = 0;
		previous_cursor_id = video.cursor_id;
		
		video_list[video.cursor_id] = video;
		var image = video.image;
	
		//x和y是图片的原始尺寸
	 	var x = image.w;
	 	var y = image.h;
	 	//x2和y2是固定204宽度的尺寸
	 	var x2 = 204;
	 	var y2 = x2*y/x;
	 	//x3和y3是鼠标放上去后放大效果的尺寸
	 	var x3 = 220;
	 	var y3 = y2+16;
		//播放按钮的位置
	 	var play_y = (y3-60)/2;
	 	var play_x = (x3-60)/2;
	 	//时间标签的位置
	 	var time_y = y3-8-20;
	 	var time_x = x3-8-50;
	 	//拼出时长的字符串time
	 	var sec = video.duration;
	 	var min =  parseInt(sec/60);
	 	sec = sec%60;
		if (sec<10){ sec='0'+sec; }
	 	time = min+':'+sec;
	 	if (min==0 && sec==0){ time = '未知'; }


	 	
	 	curr_video_cursor_id = video.cursor_id;
	 	
	 	


	 	var id = video.cursor_id+'_'+curr_page; //用来给元素编号的id
	 	html_str+= "<div id='water_1_"+video.cursor_id+"'>";//每个视频块的大div开始\
	 	
		if (curr_user==user_id && curr_flag==1){ //如果是“我”的喜欢，可以取消
			html_str+= "<div id='icon_small_x_"+video.cursor_id+"' class='small_x' onclick='unlike_video("+video.id+","+video.cursor_id+")' " +
					"onmouseover='change_class(\"icon_small_x_"+video.cursor_id+"\",\"small_x\",\"small_x_2\");' " +
					"onmouseout='change_class(\"icon_small_x_"+video.cursor_id+"\",\"small_x_2\",\"small_x\");' " +
					"title='取消喜欢'></div>";
		}
	 	
	 	if (feed){ //大头像
	 		html_str+= "<div style='width:50px;height:50px;float:left;box-shadow:0px 2px 5px #e0e0e0;'><img class='largehead shadow clickable' title='"+feed_user.name+"' onclick='jump_page(3,1,0,"+feed_user.id+",0);' src='"+feed_user_url+"'/></div>";
	 	}
		
		
		html_str+= "<div style='width:640px;min-height:100px;background:#ffffff;float:right;margin-bottom:25px;margin-right:40px;box-shadow:0px 1px 1px #e0e0e0;'>";
			//图片部分开始
			html_str+= "<div style='width:220px;height:"+y3+";float:left;margin:12px;'>";
				if (!(min==0 && sec==0)){
					html_str+= "<div id='btn_time_"+id+"' style='width:50px;height:20px;cursor:pointer;opacity:0.5; z-index:20;";
					html_str+= "position:absolute; margin-top:"+time_y+";margin-left:"+time_x+"; background-color:#333333; ";
					html_str+= "line-height:20px; text-align:center;'";
					html_str+= "onmouseover='enlarge_video(\""+id+"\","+x3+","+y3+");'";
					html_str+= "onmouseout='ennormal_video(\""+id+"\","+x2+","+y2+");' onclick='play_video("+video.cursor_id+");' hidden=true >";
					html_str+= "<font class='white normal'>"+time+"</font>";
					html_str+= "</div>";
				}
		
				html_str+= "<div id='btn_play_"+id+"' class='icon_play clickable' ";
				html_str+= "style='position:absolute; margin-top:"+play_y+";margin-left:"+play_x+"; opacity:1; z-index:20;cursor:pointer;'";
				html_str+= "onmouseover='enlarge_video(\""+id+"\","+x3+","+y3+");'";
				html_str+= "onmouseout='ennormal_video(\""+id+"\","+x2+","+y2+");' onclick='play_video("+video.cursor_id+");' hidden=true ></div>";
				
				html_str+= "<div ><img id='img_video_"+id+"' class='normal' src='"+image.url+"' width="+x2+" height="+y2+" style='cursor:pointer;'";
				html_str+= "onmouseover='enlarge_video(\""+id+"\","+x3+","+y3+");'";
				html_str+= "onmouseout='ennormal_video(\""+id+"\","+x2+","+y2+");' onclick='play_video("+video.cursor_id+");' ></div>";
			html_str+= "</div>";//图片部分结束

			html_str+= "<div><div style='width=396;margin-top:20px;margin-right:20px;'>";

			html_str+= "<font style='float:left;' class='large black'>"+video.title+"</font>";

			html_str+= "</div>";

	 	 	html_str+= "<HR color=#eeeeee size=1 style='width:370px;margin-left:0px;'>";
	 	 	html_str+= "<div class='icon_small_like'></div><div style='float:left;'><font class='normal gray' style='margin-top:-5px;'>&nbsp;"+video.liked_count;
		 	html_str+= "&nbsp;&nbsp;&nbsp;</font></div><div class='icon_small_share'></div><div style='float:left;'><font class='normal gray' style='margin-top:-5px;'>&nbsp;"+video.shared_count+"</font></div><br>";

		 	if (last_liked_friend){
		 	 	html_str+= "<div style=''><img class='smallhead clickable' title='"+last_liked_friend.name+"' onclick='jump_page(3,1,0,"+last_liked_friend.id+",0);' src='"+last_liked_friend.avatar+"'/>";
		 	 	html_str+= "<div class='smallhead_desc'>";
		 		html_str+= "<font class='small orange clickable' onclick='jump_page(3,1,0,"+last_liked_friend.id+",0);'>"+last_liked_friend.name+"</font><br>";
		 		html_str+= "<font class='small gray'>很喜欢这个视频</font>";
		 		html_str+= "</div>";
		 		html_str+= "</div>";
		 	}
		 	
	 	 	if (feed){
		 	 	html_str+= "<div style='padding-bottom:20px;'><img class='smallhead clickable' title='"+feed_user.name+"' onclick='jump_page(3,1,0,"+feed_user.id+",0);' src='"+feed_user_url+"'/>";
		 	 	html_str+= "<div class='smallhead_desc'>";
		 		html_str+= "<font class='small orange clickable' onclick='jump_page(3,1,0,"+feed_user.id+",0);'>"+feed_user.name+"</font><br>";
		 		html_str+= "<time class='timeago gray small' datetime='"+feed.time+"'></time>";
		 		html_str+= "<font class='small gray'>&nbsp;转播自"+video.from+"</font>";
		 		html_str+= "</div>";
		 		html_str+= "</div>";
	 	 	}
	 	 	html_str += "</div>";
	 		
		
		html_str+= "</div>";
		html_str+= "<div class='item_arrow' ></div>";
		
		html_str+= "</div>";//每个视频块的大div结束

	
	} 

	
	return html_str;
}