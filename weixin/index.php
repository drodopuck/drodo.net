<?php
include_once 'dinner.php';
include_once 'dota.php';
include_once 'wolf.php';
include_once 'roll.php';


$wechatObj = new wechat();
$wechatObj->responseMsg();
class wechat {
	
	public function responseMsg() {

		//---------- 接 收 数 据 ---------- //

		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"]; //获取POST数据

		//用SimpleXML解析POST过来的XML数据
		$postObj = simplexml_load_string($postStr,'SimpleXMLElement',LIBXML_NOCDATA);

		$fromUsername = $postObj->FromUserName; //获取发送方帐号（OpenID）
		$toUsername = $postObj->ToUserName; //获取接收方账号
		if ($postObj->MsgType == "text"){
			$keyword = trim($postObj->Content); //获取消息内容
		}
		if ($postObj->MsgType == "voice"){
			$keyword = trim($postObj->Recognition); //获取语音识别消息内容
		}
		$time = time(); //获取当前时间戳


		//---------- 返 回 数 据 ---------- //

		//返回消息模板
		$textTpl = "<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[%s]]></MsgType>
		<Content><![CDATA[%s]]></Content>
		<FuncFlag>0</FuncFlag>
		</xml>";

		$msgType = "text"; //消息类型
		
		// 应用: 吃饭
		$contentStr = dinner($fromUsername,$keyword);
		
		// 应用: 刀塔比赛
		if (empty($contentStr)){
			$contentStr = dota($fromUsername,$keyword);
		}
		
		// 应用: 狼人杀
		if (empty($contentStr)){
			$contentStr = wolf($fromUsername,$keyword);
		}
		
		// 应用: roll点
		if (empty($contentStr)){
			$contentStr = roll($fromUsername,$keyword);
		}

		// 应用: 小黄鸡
		if (empty($contentStr)){
			$contentStr = SimSimi($keyword);
		}

		//格式化消息模板
		$resultStr = sprintf($textTpl,$fromUsername,$toUsername,
		$time,$msgType,$contentStr);
		echo $resultStr; //输出结果
	}
	

}

function SimSimi($keyword) {

	//----------- 获取COOKIE ----------//
	$url = "http://www.simsimi.com/";
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HEADER,1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	$content = curl_exec($ch);
	list($header, $body) = explode("\r\n\r\n", $content);
	preg_match("/set\-cookie:([^\r\n]*);/iU", $header, $matches);
	$cookie = $matches[1];
	curl_close($ch);

	//----------- 抓 取 回 复 ----------//
	$url = "http://www.simsimi.com/func/req?lc=ch&msg=$keyword";
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_REFERER, "http://www.simsimi.com/talk.htm?lc=ch");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	$content = json_decode(curl_exec($ch),1);
	curl_close($ch);

	if($content['result']=='100') {
		$content['response'];
		return $content['response'];
	} else {
		return '您好，萌萌的巨鸟多多为您服务~';
	}
}

function isnum($num){
	$alb= array('0','1','2','3','4','5','6','7','8','9','-');
	if(strlen($num)<1){
		return false;
	}
	for ($i=0;$i<=strlen($num);$i++){
		if(!in_array(substr($num,$i,1),$alb)){
			return false;
		}
	}
	return true;
}



?>