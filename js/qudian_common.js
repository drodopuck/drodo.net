
//全局变量
var domin = "vision.pptv.com";
var curr_video_cursor_id = 0;
var video_page_size = 20;

var curr_type = 3;//1=广场页面;2=我的趣点;3=用户页面
if (!curr_type) { curr_type=3; }
var waterfall_col =3;
var curr_cata = 0;//(type=1时)当前页面是广场的哪个分类,0为无分类
if (!curr_cata) { curr_cata=0; }
var curr_user = 85216;//(type=3时)当前这个页面是哪个用户的主页
if (!curr_user) { curr_user=85216; }
var curr_flag = 1;//0=转播;1=喜欢
if (!curr_flag) { curr_flag=1; }
var curr_play = request("play");

//var access_token = "w6NpPitdalSYi62yATHjXf/bsh3OICnO2IhyzBut8bE=";
//var user_id = "85216";

var access_token = "NCCtPS/ARapz/ahfq5yo52K9zqwrZASGc1L7K5+rNWxZjI5sI5K93jWmrMqgyLbAy6C/rBRo4yvYiHLMG63xsQ==";
var user_id = "2697";

//var access_token = request("access_token");
//var user_id = request("user_id");

var curr_user_info = null;

var curr_page = 0;
var loading = false;
var video_list=[];

var pre_video = [];
var next_video = [];
var previous_cursor_id =0;

var playing = false;
var playing_video_cursor_id=0;


var common_param = "platform=ipad&version=1&format=jsonp";
var curr_operate_id = 0;
var curr_operate_cursor_id = 0;



/**************************************以下为通用的函数************************************/
function getScrollWidth() { 
	  var noScroll, scroll, oDiv = document.createElement("DIV"); 
	  oDiv.style.cssText = "position:absolute; top:-1000px; width:100px; height:100px; overflow:hidden;"; 
	  noScroll = document.body.appendChild(oDiv).clientWidth; 
	  oDiv.style.overflowY = "scroll"; 
	  scroll = oDiv.clientWidth; 
	  document.body.removeChild(oDiv); 
	  return noScroll-scroll; 
	}

//友好化时间显示
$(function(){
	prepareDynamicDates();
	 $(".timeago").timeago();
});
var zeropad = function (num) {
  return ((num < 10) ? '0' : '') + num;
};
var iso8601 = function (date) {
  return date.getUTCFullYear()
    + "-" + zeropad(date.getUTCMonth()+1)
    + "-" + zeropad(date.getUTCDate())
    + "T" + zeropad(date.getUTCHours())
    + ":" + zeropad(date.getUTCMinutes())
    + ":" + zeropad(date.getUTCSeconds()) + "Z";
};
function prepareDynamicDates() {
  $('abbr.loaded').attr("title", iso8601(new Date()));
}
function min(a,b){
	if (a<=b) {return a;}
	else {return b;}
}

function getdate()
{
	var now=new Date();
	y=now.getFullYear();
	m=now.getMonth()+1;
	d=now.getDate();
	m=m<10?"0"+m:m;
	d=d<10?"0"+d:d;
	return y+"-"+m+"-"+d;
}

//获取url参数
function request(paras)
{ 
    var url = location.href; 
    var paraString = url.substring(url.indexOf("?")+1,url.length).split("&"); 
    var paraObj = {} 
    for (i=0; j=paraString[i]; i++){ 
    paraObj[j.substring(0,j.indexOf("=")).toLowerCase()] = j.substring(j.indexOf("=")+1,j.length); 
    } 
    var returnValue = paraObj[paras.toLowerCase()]; 
    if(typeof(returnValue)=="undefined"){ 
    return ""; 
    }else{ 
    return returnValue; 
    } 
}

//显示、隐藏div
function showdiv(name){
	$('.'+name).fadeIn("slow");
}
function hidediv(name){
	$('.'+name).fadeOut("slow");
}

//发送http get请求
function http_get(httpurl,callback){

 	//console.info(">>>>>>>>>>", httpurl);
	$.ajax({
        type: "get",
        async: true,
        timeout: 2000,  
        url: httpurl,
        dataType: "jsonp",
        jsonp: "cb",//传递给请求处理程序或页面的，用以获得jsonp回调函数名的参数名(一般默认为:callback)
        jsonpCallback : callback,//自定义的jsonp回调函数名称，默认为jQuery自动生成的随机函数名，也可以写"?"，jQuery会自动为你处理数据
        success: function(json){
        	loading = false;
            //alert(json);
        },
        error: function(json){
        	console.info(json);
        	loading = false;
            //alert('http get fail:'+httpurl);
        }
    });
	
}

//发送http post请求
function http_post(httpurl,data,callback){
	httpurl="http://feed.vision.pptv.com/v1/feed/create";
	data = {
			'video_id':3560646,
			'text':'%E8%BD%AC%E6%92%AD%E8%A7%86%E9%A2%91',
			'ref_feed_id':137043871100000,
			'uid':72888,
			'access_token':'1rqZBk4slFVc1Wd1nVICzQ6Zc6SygZ/ouiHPoQTHsFc7efXttqp0iQnHgKXN8kIeTvrdFmfxHWumEE+cwTQ9zg==',
			'platform':'ipad',
			'version':1,
			'format':'jsonp',
			'jsonpcallback':callback
	};
	console.info("httpurl>>>>>>>>>>",  httpurl);
	console.info("data>>>>>>>>>>",  data);
	console.info("callback>>>>>>>>>>",  callback);

	$.ajax({  
        url: httpurl,  
        data: data, 
        type: "post",  
        processData: false,  
        timeout: 2000,  
        dataType: "json",
        success: function(result) {  
        	console.info("result>>>>>>>>>>",  result); 
        }, 
        error: function(jqXHR, textStatus, errorThrown ){
        	console.info("jqXHR>>>>>>>>>>",  jqXHR);
        	console.info("textStatus>>>>>>>>>>",  textStatus); 
        	console.info("errorThrown>>>>>>>>>>",  errorThrown); 
        }
    });  
}

//跳转页面
function jump_page(type,col,cata,user,flag){
	return;
	var url = "index.php?type="+type+"&col="+col+"&cata="+cata+"&user="+user+"&flag="+flag;
	window.location.href =url;
}

//固定位置的元素，随着页面的滚动而调整位置
window.onscroll= function (e){
	e.preventDefault();
	var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
	//alert(scrollTop);

	//显示、隐藏“回到顶部”按钮
	if (scrollTop>200){
		showdiv('qd_go_top');
	}
	else{
		hidediv('qd_go_top');
	}
	
	//谁要固定，就把谁添加到这里
	$('.player_outside_large').css('margin-top',(scrollTop-330)+'px');
	$('.player_outside_min').css('margin-top',(scrollTop+110)+'px');
	$('.player_mask').css('top',(scrollTop)+'px');
	//$('.login_mask').css('top',(scrollTop)+'px');
	//$('.header_outside').css('padding-top',scrollTop+'px');
	//$('.login').css('margin-top',(scrollTop-170)+'px');
	$('.player_arrow_left').css('padding-top',scrollTop+'px');
	$('.player_arrow_right').css('padding-top',scrollTop+'px');
	//$('.qd_go_top').css('margin-top',scrollTop+'px');
	
	//滚动到底部的话，增量加载新视频
	var a = document.documentElement.scrollTop==0? document.body.clientHeight : document.documentElement.clientHeight;
	var b = document.documentElement.scrollTop==0? document.body.scrollTop : document.documentElement.scrollTop;
	var c = document.documentElement.scrollTop==0? document.body.scrollHeight : document.documentElement.scrollHeight;
	if(a+b==c){
		page_add();
	}
}

function jumppage(url){
	window.location.href=url;
}

/**************************以下为页面交互函数*******************************/

//鼠标移到图片上的放大效果
function enlarge_video(id,x,y) {
	$('#img_div_video_'+id).removeClass('normal');

	$('#img_video_'+id).width(x);
	$('#img_video_'+id).height(y);
	$('#btn_play_'+id).show();
	$('#btn_time_'+id).show();
}
function ennormal_video(id,x,y) {
	$('#img_div_video_'+id).addClass('normal');
	$('#img_video_'+id).width(x);
	$('#img_video_'+id).height(y);
	$('#btn_play_'+id).hide();
	$('#btn_time_'+id).hide();
}

function change_class(id,a,b){
	$('#'+id).removeClass(a);
	$('#'+id).addClass(b);
}

//关闭播放窗口
function close_player(){
	//hidediv('player');
	$('#video_player_outside').hide();
	$('.player_mask').fadeOut("slow");
	$('#player_arrow_left').fadeOut("slow");
	$('#player_arrow_right').fadeOut("slow");
	playing = false;
	playing_video_cursor_id = 0;
	$('#video_details').html("");
	$('#video_player').html("");

//	//启用滚动条
	$(document.body).css({
		"overflow-x":"auto",
		"overflow-y":"auto"
	});
}

//最小化播放窗口(测试)
function min_player(){
	$('.player_mask').fadeOut("slow");
	$('#player_arrow_left').fadeOut("slow");
	$('#player_arrow_right').fadeOut("slow");
	$('#video_details').hide();
	
	$('#video_player_outside').removeClass('player_outside');
	$('#video_player_outside').addClass('player_outside_min');
	$('#video_player').removeClass('player_left');
	$('#video_player').addClass('player_left_min');
	$('#player_x').removeClass('player_x');
	$('#player_x').addClass('player_x_min');
	$('#share_player').width(200);
	$('#share_player').height(150);
	
	var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
	$('.player_outside_min').css('margin-top',(scrollTop+110)+'px');
	
	playing = false;

}

//恢复最大化de播放窗口(测试)
function max_player(){
	
	if (playing){ return;}
	
	$('.player_mask').fadeIn("slow");
	$('#player_arrow_left').fadeIn("slow");
	$('#player_arrow_right').fadeIn("slow");
	$('#video_details').show();
	
	$('#video_player_outside').removeClass('player_outside_min');
	$('#video_player_outside').addClass('player_outside');
	$('#video_player').removeClass('player_left_min');
	$('#video_player').addClass('player_left');
	$('#player_x').removeClass('player_x_min');
	$('#player_x').addClass('player_x');
	$('#share_player').width(640);
	$('#share_player').height(480);
	
	var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
	$('.player_outside').css('margin-top',(scrollTop-290)+'px');
	
	playing = true;
}

function copy_play_url(){
	var url = window.location.href + "&play=" +playing_video_cursor_id;
	window.clipboardData.setData("Text",url);
	//alert(url);
}

//展示播放器
function play_video(video_cursor_id){
	
	//alert('正在播放:'+video_cursor_id+' 上一个是:'+pre_video[video_cursor_id]+'下一个是:'+next_video[video_cursor_id]);
	
	//if (playing){ return;}

	$('.player_mask').fadeIn("slow");
	$('#video_player_outside').fadeIn("fast");
	$('.player_left').fadeIn("slow");
	$('.player_right').fadeIn("slow");
	
	if (pre_video[video_cursor_id]>0){
		var curr_pre_video = video_list[pre_video[video_cursor_id]];
		var pre_title = '上一个视频:'+curr_pre_video.title;
		
		var html_str = "";
		html_str += "<div id='icon_arrow_left' class='icon_arrow_left clickable' title='"+pre_title+"' ";
			html_str += "onclick='play_video("+pre_video[video_cursor_id]+");' "
			html_str += "onmouseover='change_class(\"icon_arrow_left\",\"icon_arrow_left\",\"icon_arrow_left_2\")' ";
			html_str += "onmouseout='change_class(\"icon_arrow_left\",\"icon_arrow_left_2\",\"icon_arrow_left\")'> ";
		html_str += "</div>";
		
		$('#player_arrow_left').html($(html_str));
		
		$('.player_arrow_left').fadeIn("slow");
	}
	else{
		$('.player_arrow_left').fadeOut("slow");
	}
	
	if (next_video[video_cursor_id]>0){
		var curr_next_video = video_list[next_video[video_cursor_id]];
		var next_title = '下一个视频:'+curr_next_video.title;
		
		var html_str = "";
		html_str += "<div id='icon_arrow_right' class='icon_arrow_right clickable' title='"+next_title+"' ";
			html_str += "onclick='play_video("+next_video[video_cursor_id]+");' "
			html_str += "onmouseover='change_class(\"icon_arrow_right\",\"icon_arrow_right\",\"icon_arrow_right_2\")' ";
			html_str += "onmouseout='change_class(\"icon_arrow_right\",\"icon_arrow_right_2\",\"icon_arrow_right\")'> ";
		html_str += "</div>";
		
		$('#player_arrow_right').html($(html_str));
		$('.player_arrow_right').fadeIn("slow");
	}	
	else{
		$('.player_arrow_right').fadeOut("slow");
	}
	
	//max_player();

	//禁止滚动条
 	$(document.body).css({
 		"overflow-x":"hidden",
 		"overflow-y":"hidden"
 	});
 	
	$('#whole_page').css('width',document.body.clientWidth-getScrollWidth());
	$('#header_outside').css('width',document.body.clientWidth-getScrollWidth());
	$('#video_player_outside').css('margin-left',-620-getScrollWidth());
	//$('#player_arrow_left').css('margin-left',-530-getScrollWidth());
	//$('#player_arrow_right').css('margin-left',510-getScrollWidth());
 	

	playing = true;
	playing_video_cursor_id = video_cursor_id;
	var video = video_list[video_cursor_id];

	//console.info(">>>>>>>>>>", video);
	
	//console.info(video);
	var html_str=video_2_html(video);

	$('#video_details').html(html_str);

	$(".timeago").timeago();

	//var url_play_video = "http://"+domin+"/v1/play/get.api"
	//	+"?web_url="+escape(video.web_url)+"&access_token=0&platform=ipad&version=1&format=jsonp";

	//http_get(url_play_video,'show_video_player');

	//解析播放串
	var player_html_str = video_2_player(video);
	
	//需要辗转加载的，先不急着报错，等等
	if (video.from=='新浪视频'){ return;}
	
	if (!(player_html_str=='')){
		show_swf_player(player_html_str);
	}
	else{
		player_html_str="<font class='large white'>"+video.web_url+"</font>";
		show_swf_player(player_html_str);
	}
}

function show_swf_player(player_html_str){
	
	if (!(player_html_str=='')){
		$('#video_player').html(player_html_str);
	}
	else{
		
		player_html_str="<font class='large white'>对不起，该视频暂时无法播放: <br>"+video.web_url+"</font>";
		$('#video_player').html(player_html_str);
	}
}

//展示广场的分类列表
function add_catas(jsonobj){
	var catas = jsonobj.config.content.catalogs;
	//console.info(catas);

	var html_str='';
	html_str = catalogs_2_html(catas);
	$("#qudian_plaza").html(html_str);
	
}

//展示推荐收看列表
function add_recommened_user(jsonobj){
	var users = jsonobj.users;
	//console.info(users);

	var html_str='';
	html_str = recommened_users_2_html(users);
	$("#recommened_user").html(html_str);
	
}

//展示视频
function add_video(jsonobj){
	loading = false;
	var videos = jsonobj.videos;
	//console.info("!!!!!!!!!!!!!!!!!", videos);

	if (videos==null || videos.length<5 ){
		$('.body_left_loading_more').hide();
		showdiv("body_left_no_more");

	}
	
	var html_str='';
	if (waterfall_col==1){
		html_str = videos_2_html_1_col(videos);
	}
	else{
		html_str = videos_2_html_3_col(videos);
	}
	
	var html_node = $(html_str);
	
	$("#waterfall_today").append(html_node);
	
	$(".timeago").timeago();

	if (waterfall_col>1){
		$('#waterfall_today').masonry({
	        itemSelector:'.item',
	        columnWidth : 0,
	        isAnimated: false,
	        animationOptions: {
	          duration: 750,
	          easing: 'easeInExpo',
	          queue: true
	        }
	    });
	}
	
	//如果curr_play有值，直接播放
	//alert(curr_play);
//	if (curr_play>0){
//		play_video(curr_play);
//	}
}

//展示视频(追加)
function add_video_append(jsonobj){
	loading = false;
	var videos = jsonobj.videos;
	//console.info(">>>>>>>>>>", videos);
	
	if (videos==null || videos.length<5 ){
		$('.body_left_loading_more').hide();
		showdiv("body_left_no_more");
	}
	
	var html_str='';
	if (waterfall_col==1){
		html_str = videos_2_html_1_col(videos);
	}
	else{
		html_str = videos_2_html_3_col(videos);
	}
	var html_node = $(html_str);

	$("#waterfall_today").append( html_node );
	
	if (waterfall_col>1){
		$('#waterfall_today').masonry( 'appended', html_node );
	}

	$(".timeago").timeago();
}

//展示左侧标题
function add_left_title(type,title1,title1_color,title2,title2_color,icon){
	var html_str = '';
	html_str = left_title_2_html(type,title1,title1_color,title2,title2_color,icon);
	
	var html_node = $(html_str);
	$("#left_title").html( html_node );
}

function get_friends(){
	var max_r=parseInt(curr_user_info.friends_count/5)+1;
	var r=parseInt(Math.random()*max_r)+1;
	url_get_friends = "http://user."+domin+"/v1/friendship/friends.api?" +
		"uid="+curr_user_info.id+"&access_token="+access_token+"&page="+r+"&count=5&"+common_param;
	http_get(url_get_friends,'after_get_friends');
}

function get_followers(){
	var max_r=parseInt(curr_user_info.followers_count/5)+1;
	var r=parseInt(Math.random()*max_r)+1;
	url_get_followers = "http://user."+domin+"/v1/friendship/followers.api?" +
		"uid="+curr_user_info.id+"&access_token="+access_token+"&page="+r+"&count=5&"+common_param;
	http_get(url_get_followers,'after_get_followers');
}

function after_get_friends(json){
	//console.info(json);
	html_str_friends = his_friends_2_html(json.users,curr_user_info.friends_count);
	$('#friends').html($(html_str_friends));
}

function after_get_followers(json){
	//console.info(json);
	html_str_followers = his_followers_2_html(json.users,curr_user_info.followers_count); 
	$('#followers').html($(html_str_followers));
}

//获取完用户信息
function after_get_user_info(json){
	var user = json.user;
	
	curr_user_info = user;
	
	if (curr_type==3){
		//console.info (curr_user_info);
		add_left_title(3,''+user.name,'orange','的频道','gray','bigicon_qudian');
		//alert(json);
	}
	
	//展示“ta收看的”“ta的观众”
	$('#friends').fadeIn("slow");
	$('#followers').fadeIn("slow");
	
	//console.info(curr_user_info);

	get_friends();
	get_followers();

}

function after_get_my_info(json){

	var user = json.user;
	//console.info(user);
	html_str = my_info_2_html(user);
	
	var html_node = $(html_str);
	$("#my_info").html( html_node );
}

//转播视频(TODO:不好用！)
function share_video(video_id,video_cursor_id,feed_id){
	 if (!user_id || user_id==0) { alert('用微博登录以后才可以转播!');return; }
	 var share_input = $('#share_input').val();
	 if(!share_input) { share_input='转播视频'; }
	 curr_operate_id = video_id;
	 curr_operate_cursor_id = video_cursor_id;
//	 var url_like_video = "http://video."+domin+"/v1/video/like?video_id="+video_id+"&uid="+user_id+"&access_token="+access_token+"&"+common_param;
//	 http_get(url_like_video,'after_like_video');
	 http://feed.vision.pptv.com/v1/feed/create.api?video_id=3316625&text=%E8%BD%AC%E6%92%AD%E8%A7%86%E9%A2%91&share_to[]=weibo&ref_feed_id=137006424400004&uid=72888&access_token=1rqZBk4slFVc1Wd1nVICzQ6Zc6SygZ/ouiHPoQTHsFc7efXttqp0iQnHgKXN8kIeTvrdFmfxHWumEE+cwTQ9zg==&platform=ipad&version=1&format=jsonp&cb=after_watch_user&_=1370552079672
	 var url_share_video = "http://feed."+domin+"/feed/create&uid="+user_id+"&access_token="+access_token+"&"+common_param;
	 var post_data = "video_id="+video_id+"&text="+share_input+"&[share_to=weibo]&ref_feed_id="+feed_id;
	 
	 http_post(url_share_video,post_data,'after_share_video');
//	 feed.domain/feed/create&登录信息&通用参数&动态参数
//	 video_id=视频ID&text=分享文本&[share_to[]=weibo&share_to[]=sina...]&ref_feed_id=引用的FeedId
}

function after_share_video(json){
	alert(json);
	var btn_id = 'btn_share_'+curr_operate_id;
	change_class(btn_id,"btn_share_2","btn_shared");
	$("#" + btn_id).attr("onclick", "");
	$("#" + btn_id).removeClass("clickable");
	//console.info(video_list[curr_operate_cursor_id]);
	video_list[curr_operate_cursor_id].shared_by = true;
}

//取消喜欢视频
function unlike_video(video_id,video_cursor_id){
	 curr_operate_id = video_id;
	 curr_operate_cursor_id = video_cursor_id;
	 var url_like_video = "http://video."+domin+"/v1/video/unlike?video_id="+video_id+"&uid="+user_id+"&access_token="+access_token+"&"+common_param;
	 http_get(url_like_video,'after_unlike_video');
}

function after_unlike_video(json){
	var water_id = 'water_1_'+curr_operate_cursor_id;
	$('#'+water_id).fadeOut("slow");
	curr_user_info.like_count--;
	var html_str = "<font class='xxlarge orange'>喜欢</font><font class='xlarge orange'>"+curr_user_info.like_count+"</font>";
	$('#title_like_count').html($(html_str));
	
	curr_operate_id = 0;
	curr_operate_cursor_id = 0;
}

//喜欢视频
function like_video(video_id,video_cursor_id){
	 if (!user_id || user_id==0) { alert('用微博登录以后才可以喜欢!');return; }
	 curr_operate_id = video_id;
	 curr_operate_cursor_id = video_cursor_id;
	 var url_like_video = "http://video."+domin+"/v1/video/like?video_id="+video_id+"&uid="+user_id+"&access_token="+access_token+"&"+common_param;
	 http_get(url_like_video,'after_like_video');
}

function after_like_video(json){
	//alert('OK!');
	var btn_id = 'btn_like_'+curr_operate_id;
	change_class(btn_id,"btn_like_2","btn_liked");
	$("#" + btn_id).attr("onclick", "");
	$("#" + btn_id).removeClass("clickable");
	//console.info(video_list[curr_operate_cursor_id]);
	video_list[curr_operate_cursor_id].liked_by = true;
	
	//刷新一下视频喜欢列表的喜欢个数
	var temp_liked_count = video_list[curr_operate_cursor_id].liked_count ;
	temp_liked_count ++;
	video_list[curr_operate_cursor_id].liked_count = temp_liked_count;
	var html_str = "<font class='large gray'>"+temp_liked_count+"人喜欢</font>";
	$('#player_like_list_count').html($(html_str));
	
	//刷新一下视频喜欢列表(重新查一下)
	var url_get_video_liked_list = "http://user."+domin+"/v1/user/video_likes.api?video_id="+curr_operate_id+"&"+common_param;
	http_get(url_get_video_liked_list,'after_refresh_liked_list');
}

function after_refresh_liked_list(json){
	//console.info('!!!!!!'+json);
	var users = json.users;
	video_list[curr_operate_cursor_id].liked_users=users;
	
	html_str = "";
	for(var i=0;i<min(users.length,3);i++ ){
		var curr_user = users[i];
		html_str+= "<img class='player_smallhead clickable' onclick='jump_page(3,1,0,"+curr_user.id+",0);' src='"+curr_user.avatar+"' title='"+curr_user.name+"'/>";
	}
	
	$('#player_like_list').html($(html_str));
	
	curr_operate_id = 0;
	curr_operate_cursor_id = 0;
}


//收看某人
function watch_user(watch_user_id,video_cursor_id){
	 if (!user_id || user_id==0) { alert('用微博登录以后才可以收看!');return; }
	 curr_operate_id = watch_user_id;
	 curr_operate_cursor_id = video_cursor_id;
	// var url_watch_user = "http://user."+domin+"/v1/friendship/create_batch.api&uid="+user_id+"&uids=["+watch_user_id+"]&access_token="+access_token+"&need_return=false&"+common_param;
	 var url_watch_user = "http://user."+domin+"/v1/friendship/create.api?uid="+watch_user_id+"&access_token="+access_token+"&"+common_param;
	 http_get(url_watch_user,'after_watch_user');
}

function after_watch_user(json){
	
	var btn_id = 'btn_watch_'+curr_operate_id;
	change_class(btn_id,"btn_watch_2","btn_watched");
	$("." + btn_id).attr("onclick", "");
	$("." + btn_id).removeClass("clickable");
	
	video_list[curr_operate_cursor_id].first_feed.user.following = true;
	
	curr_operate_id = 0;
	curr_operate_cursor_id = 0;
}


function watch_user_white(watch_user_id){
	 if (!user_id || user_id==0) { alert('用微博登录以后才可以收看!');return; }
	 curr_operate_id = watch_user_id;
	// var url_watch_user = "http://user."+domin+"/v1/friendship/create_batch.api&uid="+user_id+"&uids=["+watch_user_id+"]&access_token="+access_token+"&need_return=false&"+common_param;
	 var url_watch_user = "http://user."+domin+"/v1/friendship/create.api?uid="+watch_user_id+"&access_token="+access_token+"&"+common_param;
	 http_get(url_watch_user,'after_watch_user_white');
}

function after_watch_user_white(json){
	
	var btn_id = 'btn_watch_'+curr_operate_id;
	change_class(btn_id,"btn_watch_white_2","btn_watched_white");
	$("." + btn_id).attr("onclick", "");
	$("." + btn_id).removeClass("shadow");

	curr_operate_id = 0;
}

function watch_user_white_2(watch_user_id){
	if (!user_id || user_id==0) { alert('用微博登录以后才可以收看!');return; }
	 curr_operate_id = watch_user_id;
	// var url_watch_user = "http://user."+domin+"/v1/friendship/create_batch.api&uid="+user_id+"&uids=["+watch_user_id+"]&access_token="+access_token+"&need_return=false&"+common_param;
	 var url_watch_user = "http://user."+domin+"/v1/friendship/create.api?uid="+watch_user_id+"&access_token="+access_token+"&"+common_param;
	 http_get(url_watch_user,'after_watch_user_white_2');
}

function after_watch_user_white_2(json){
	
	var btn_id = 'btn_watch_'+curr_operate_id;
	change_class(btn_id,"btn_watch_white_2","btn_watched_white_cancel");
	$("." + btn_id).attr("onclick", "");
	$("." + btn_id).removeClass("shadow");
	$("." + btn_id).attr("onclick", "cancel_watch_user("+curr_operate_id+");");

	curr_operate_id = 0;
}

//取消收听
function cancel_watch_user(watch_user_id){
	 curr_operate_id = watch_user_id;
	 var url_cancel_watch_user = "http://user."+domin+"/v1/friendship/destroy.api?uid="+watch_user_id+"&access_token="+access_token+"&"+common_param;
	 http_get(url_cancel_watch_user,'after_cancel_watch_user_white');
}

function after_cancel_watch_user_white(json){
		
		var btn_id = 'btn_watch_'+curr_operate_id;
		change_class(btn_id,"btn_watched_white_cancel","btn_watch_white");
		
		$("." + btn_id).attr("onclick", "watch_user_white_2("+curr_operate_id+");");
		$("." + btn_id).addClass("clickable");
		$("." + btn_id).addClass("shadow");


		curr_operate_id = 0;
}

/**************************以下为入口函数************************/

//页面加载入口
function page_load(){
	loading = true;
	//加载标题
	if (curr_type==1){
		//显示“今日趣点”
		add_left_title(1,'今','gray','日趣点','gray','bigicon_qudian');
	}
	if (curr_type==2){
		//显示“我的趣点”
		add_left_title(2,'我','gray','的趣点','gray','bigicon_qudian');
		
		get_user_info(user_id);
	}
	if (curr_type==3){
		
		//显示“xxxx的频道”
		//add_left_title(3,'xxxx的频道','bigicon_weibo');
		get_user_info(curr_user);
	}
	
	
	//加载视频
	var url_get_video='';
	if (curr_type==1){
		if (curr_cata==null||curr_cata==0){
			url_get_video = "http://video."+domin+"/v1/video/popular.api?";
		}
		else{
			url_get_video = "http://video."+domin+"/v1/video/catalog.api?catalog_id="+curr_cata;
		}
		
		url_get_video+="&count="+video_page_size+"&access_token="+access_token+"&"+common_param;
		http_get(url_get_video,'add_video');
	}
	if (curr_type==2){

		url_get_video = "http://video."+domin+"/v1/video/home.api?uid="+user_id+
			"&count="+video_page_size+"&access_token="+access_token+"&"+common_param;

		http_get(url_get_video,'add_video');
	}
	if (curr_type==3){
		//获取视频
		var url_get_video='';
		if (curr_flag ==1){
			url_get_video = "http://video."+domin+"/v1/video/user_likes.api?";
		}
		else{
			url_get_video = "http://video."+domin+"/v1/video/user_shares.api?";
		}
		url_get_video += "uid="+curr_user+"&since_id=0&count="+video_page_size+"&access_token="+access_token+"&"+common_param;
		//url_get_video+=+"&count="+video_page_size+"&access_token=0&platform=ipad&version=1&format=jsonp&cb=add_video";
		
		http_get(url_get_video,'add_video');
	}
	
	//加载广场的分类
	var url_get_catas = "http://config."+domin+"/v1/config/get.api?type=catalog&config_version=1368776565&&access_token="+access_token+"&"+common_param;
	http_get(url_get_catas,'add_catas');

	//加载推荐收看
	get_recommend_user();
	
	//如果登陆了，加载个人信息
	if (user_id){
		url_get_my_info = "http://user."+domin+"/v1/user/show.api?uid="+user_id+"&access_token="+access_token+"&"+common_param;
		http_get(url_get_my_info,'after_get_my_info');
	}

}

//获取推荐收看入口
function get_recommend_user(){
	var url_get_recommend_user = "http://recommend."+domin+"/v1/recommend/users.api?count=10&exclude_uids=&access_token="+access_token+"&"+common_param;
	http_get(url_get_recommend_user,'add_recommened_user');
}

//页面增量加载视频入口
function page_add(){
	if (!loading && !playing){
		loading = true;
		var url_get_video_add='';
		if (curr_type==1){
			if (curr_cata==null||curr_cata==0){
				url_get_video_add = "http://video."+domin+"/v1/video/popular.api?";
			}
			else{
				url_get_video_add = "http://video."+domin+"/v1/video/catalog.api?catalog_id="+curr_cata;
			}
			url_get_video_add+="&max_id="+curr_video_cursor_id+"&count="+video_page_size+"&access_token="+access_token+"&"+common_param;
		}
		if (curr_type==2){

			url_get_video_add = "http://video."+domin+"/v1/video/home.api?uid="+user_id+
				"&max_id="+curr_video_cursor_id+"&count="+video_page_size+"&access_token="+access_token+"&"+common_param;

		}
		if (curr_type==3){
			if (curr_flag ==1){
				url_get_video_add = "http://video."+domin+"/v1/video/user_likes.api?";
			}
			else{
				url_get_video_add = "http://video."+domin+"/v1/video/user_shares.api?";
			}
			url_get_video_add += "uid="+curr_user+"&max_id="+curr_video_cursor_id+"&count="+video_page_size+"&access_token="+access_token+"&"+common_param;
		}
		http_get(url_get_video_add,'add_video_append');
	}
	
}

//新浪微博登录入口
function login_from_weibo(){
	var callback_url = (window.location.href.split("?"))[0];
	//url_login_from_weibo = "http://man."+domin+"/v1/account/connect?type=weibo";
	url_login_from_weibo_test = "http://man.vision.demo1.pptv.com/v1/account/connect/weibo.api?platform=ipad&version=0021&format=json&callback="+callback_url;
	window.location.href=url_login_from_weibo_test;
}
//腾讯微博登录入口
function login_from_tqq(){
	var callback_url = (window.location.href.split("?"))[0];
	//url_login_from_tqq = "http://user."+domin+"/v1/account/connect?type=tqq";
	url_login_from_weibo_test = "http://man.vision.demo1.pptv.com/v1/account/connect/tqq.api?platform=ipad&version=0021&format=json&callback="+callback_url;
	window.location.href=url_login_from_weibo_test;
}

function get_user_info(id){
	url_get_user_id = "http://user."+domin+"/v1/user/show.api?uid="+id+"&access_token="+access_token+"&"+common_param;
	http_get(url_get_user_id,'after_get_user_info');
}

