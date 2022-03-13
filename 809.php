<?php 

$timezone = "PRC";
////////////////////////////////////////////////////
if(function_exists('date_default_timezone_set')){
    date_default_timezone_set($timezone);
}
 //校正时间
 ////////////////////////////////////////////////////
ini_set("display_errors", 0);
function _get($str){
	$val = !empty($_GET[$str]) ? $_GET[$str] : null;
	//或isset($_GET['你的变量'])?$_GET['你的变量']:'';
	return $val;
}

/**
 * 发送get请求
 * @param string $url 请求地址
 * @param array $header 请求头部
 * @return string
 */
function send_get($url) {
 
  $options = array(
    'http' => array(
      'method' => 'GET',
      'header' => 'Content-type:application/x-www-form-urlencoded',
	  'user_agent' => 'Mozilla/5.0 (Linux; U; Android 4.0.4; es-mx; HTC_One_X Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0',
      'timeout' => 15 * 60 // 超时时间（单位:s）
    )
  );
  $context = stream_context_create($options);
  $result = file_get_contents($url, false, $context);
 
  return $result;
}

/**
 * 发送post请求
 * @param string $url 请求地址
 * @param string $header 请求头部
 * @param array $post_data post键值对数据
 * @return string
 */
function send_post($url,$header,$post_data) {
 
  $options = array(
    'http' => array(
      'method' => 'POST',
	  'header' => $header,
	  'user_agent' => 'User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36 SE 2.X MetaSr 1.0',
	  'content' => $post_data,
      'timeout' => 15 * 60 // 超时时间（单位:s）
    )
  );
  $context = stream_context_create($options);
  $result = file_get_contents($url, false, $context);
 
  return $result;
}

function get_cookies($url) {

// 一、定义Cookie存储路径
// $cookie_jar = dirname(__FILE__)."/baidu.cookie";
// 二、将cookie存入文件
// 初始化CURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
// 获取头部信息
curl_setopt($ch, CURLOPT_HEADER, 1);
// 返回原生的（Raw）输出 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_jar);
$content = curl_exec($ch);
curl_close($ch);
return $content;
	
}
/*以下是取中间文本的函数 
  midstr=调用名称
  $str=预取全文本 
  $str1=左边文本
  $str2=右边文本
*/
function midstr($str,$str1,$str2)
  {
    $result='';
    $l=strpos($str,$str1);
    if(is_numeric($l))
    {
      $str=substr($str,$l+mb_strlen($str1));
      $l=strpos($str,$str2);
      if(is_numeric($l)) $result=substr($str,0,$l);
    }
    return $result;
  }

$authUrl = 'http://119.3.176.199:33200/VSP/V3/Authenticate';
$queryVideoUrl = 'https://mobileapi.chinaunicomvideo.cn:10001/queryVideoURLForWV';
// $id = 'i1qmlvg';//获取数据
$data = '{"authenticateBasic":{"userType": "3"},"authenticateDevice":{"deviceModel":"Wotv_Android","physicalDeviceID":"7185b6cb-70c9-48f5-8563-51dfac10c3f4"},"authenticateTolerant":{"subnetID": "8601","bossID":"TJBOSS2"}}';
$tokenData = send_post($authUrl,'',$data);
$csrfToken = midstr($tokenData,'csrfToken":"','","');
$jSessionID = midstr($tokenData,'jSessionID":"','","');
$header = "X_CSRFToken: ".$csrfToken."\r\nCookie: CSRFSESSION=".$csrfToken.";JSESSIONID=".$jSessionID."\r\n";
$data = '{"VSCIP":"119.3.176.199:33200","codeRate":"1","contentId":"fe2daad63b6e46ea920275307cbd31b1","contentIdV6":"20729754","mediaIdV6":"20729916","subContentId":"fe2daad63b6e46ea920275307cbd31b1","userId":"02910308087","userIp":"192.168.7.188","videoName":"极盗行动","videoType":"1"}';
$tokenData = send_post($queryVideoUrl,$header,$data);
$data = midstr($tokenData,'tvURL":"','","');
$tokenData = send_get($data);
$tokenData = str_replace("\\","",iconv( "UTF-8", "gb2312//IGNORE" , $tokenData));
// echo $csrfToken.','.$jSessionID;
file_put_contents('wo809.txt', $tokenData);
echo $tokenData;

exit;
?>