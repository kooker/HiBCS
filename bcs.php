<?php header("Content-Type:text/html; charset=utf-8");header("Cache-control: no-cache, no-store,must-revalidate");
error_reporting(0);
require_once 'config.php';

session_start();
$allow_sep = "60"; //限制重复上传时间，防止短时间刷新本文件重复上传,以秒为单位
if (isset($_SESSION['post_sep']))
{
if (time() - $_SESSION['post_sep'] < $allow_sep)
{
exit('<!doctype html><html><head><meta charset="utf-8" /><meta name="robots,Baiduspider" content="noindex,noarchive,nofollow"><title>HiBCS_MySQL测试版</title></head><body><div><p>请1分钟后再上传</p></div></body></html>');
}
else
{
$_SESSION['post_sep'] = time();
}
}
else
{
$_SESSION['post_sep'] = time();
}
date_default_timezone_set('Asia/Taipei');
if($_SERVER['REQUEST_URI']) {
$temp = urldecode($_SERVER['REQUEST_URI']);
if(strpos($temp, '<') !== false || strpos($temp, '>') !== false || strpos($temp, '(') !== false || strpos($temp, '"') !== false) {
exit('Request Bad url');
}
}
if($_FILES['Filedata']['size'] != 0){
if(isset($_FILES['Filedata']) && is_array($_FILES['Filedata'])) {
$attach = $_FILES['Filedata'];
}
$max_upload_size = 10485760; //单位字节
$old_attachName = mb_detect_encoding($attach['name'])=='UTF-8'?$attach['name']:iconv('gbk',"utf-8",$attach['name']);
$attach['ext']  = explode('.', $attach['name']);
if (($length = count($attach['ext'])) > 1) {
$ext = strtolower($attach['ext'][$length - 1]);
}
if ($ext == NULL){$ext = 'hibcs';}
function real_ip(){
static $realip = NULL; 
if ($realip !== NULL){
return $realip;
}
if (isset($_SERVER)){
if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
$arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
foreach ($arr AS $ip){
$ip = trim($ip);
if ($ip != 'unknown'){
$realip = $ip;
break;
}
}
}
elseif (isset($_SERVER['HTTP_CLIENT_IP'])){
$realip = $_SERVER['HTTP_CLIENT_IP'];
}
else{
if (isset($_SERVER['REMOTE_ADDR'])){
$realip = $_SERVER['REMOTE_ADDR'];
}
else{
$realip = '0.0.0.0';
}
}
}
else{
if (getenv('HTTP_X_FORWARDED_FOR')){
$realip = getenv('HTTP_X_FORWARDED_FOR');
}
elseif (getenv('HTTP_CLIENT_IP')){
$realip = getenv('HTTP_CLIENT_IP');
}
else{
$realip = getenv('REMOTE_ADDR');
}
} 
preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
$realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0'; 
return $realip;
}
$ip=real_ip();//上传者IP
$year = date("Y");
$month = date("m");
$day = date("d");
$fnamehash = md5(uniqid(microtime()));// fnamehash变量为当前时间的MD5散列,重命名附件名
require_once 'bcs/bcs.class.php';
$object = '/'.$year.'/'.$month.'/'.$day.'/'.$fnamehash.'.'.$ext;
$path =$attach['tmp_name'];
$opt=array(
"filename"=>$old_attachName,
"acl"=>"public-read"
);
$baiduBCS = new BaiduBCS ( $ak, $sk, $host );
if (in_array($ext, array('exe', 'cmd', 'sh', 'torrent'))) { @unlink($attach['tmp_name']);echo '<!doctype html><html><head><meta charset="utf-8" /><meta name="robots,Baiduspider" content="noindex,noarchive,nofollow"><title>kooker BCS 专用上传</title></head><body><div><p>该附件类型被限制上传！<br />Extension the system limit!<br />返回<a href="bcs.html">上传页</a></p></div></body></html>';} //限制附件类型
if ($attach['size'] > $max_upload_size) { @unlink($attach['tmp_name']); echo '<!doctype html><html><head><meta charset="utf-8" /><meta name="robots,Baiduspider" content="noindex,noarchive,nofollow"><title>kooker BCS 专用上传</title></head><body><div><p>文件大小超出系统限制！<br />File size exceeds the system limit!<br />返回<a href="bcs.html">上传页</a></p></div></body></html>';}
$response = $baiduBCS->create_object ( $bucket, $object, $path ,$opt); //上传附件
if (! $response->isOK ())die ( "Create object failed." );
$url=$response->header['_info']['url'];
$arr=explode("?",$url);
$url=urldecode($arr[0]);
$url=preg_replace('/\/\//','/',$url);
$url=preg_replace('/http:\//','http://',$url);
$ksize=number_format($attach['size']/(1024),2);
$msize=number_format($attach['size']/(1024*1024),2);
$datetime=date("Y-m-d H:i:s");
$type=$attach['type'];
$webhtml_echo1='<div><p>您上传的文件，HTML代码：</p><textarea rows="4" cols="80"><a href="';
$webhtml_echo2='" target="_blank">';
$webhtml_echo3='</a></textarea></div>';
$img_echo1='<div><p>您上传的文件类型为图片，HTML代码：</p><textarea rows="4" cols="80"><img src="';
$img_echo2='" alt="" /></textarea></div>';
$mp3_echo1='<div><p>您上传的文件类型为MP3，HTML代码：</p><textarea rows="5" cols="80"><p><embed src="http://bae.kooker.jp/mp3/dewplayer.swf?mp3=';
$mp3_echo2='&autostart=0&autoreplay=1&volume=90" type="application/x-shockwave-flash" width="180" height="20" quality="high" /></p></textarea></div>';
$mp3_echo3='<div><p>MP3试听：</p><p><embed src="http://bae.kooker.jp/mp3/dewplayer.swf?mp3=';
$mp3_echo4='&autostart=0&autoreplay=1&volume=90" type="application/x-shockwave-flash" width="180" height="20" quality="high" /></p></div>';
}?>
<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="utf-8" />
<meta name="robots,Baiduspider" content="noindex,noarchive,nofollow">
<title>HiBCS_MySQL测试版</title>
</head>
<body>
<div><p>文件名称: <?php echo $old_attachName;?><br />文件大小: <?php echo $ksize;?>KB<br />文件约合: <?php echo $msize;?>MB<br />文件地址: <a href="<?php echo $url;?>"><?php echo $url;?></a></p></div>
<?php if (!in_array($ext, array('gif', 'jpg', 'jpeg', 'png','mp3'))) { echo $webhtml_echo1.$url.$webhtml_echo2.$url.$webhtml_echo3;} ?>
<?php if (in_array($ext, array('gif', 'jpg', 'jpeg', 'png'))) { echo $img_echo1.$url.$img_echo2;} ?>
<?php if (in_array($ext, array('mp3'))) { echo $mp3_echo1.$url.$mp3_echo2.$mp3_echo3.$url.$mp3_echo4;} ?>
<div><a href="index.php">列表页</a> 返回<a href="bcs.html">上传页</a></div>
</body>
</html>
<?php if ($datetime != "0000-00-00 00:00:00" && $ip != NULL){ $sql="INSERT INTO baefile_info (id, filename, ksize, msize, datetime, object, fileurl, ext, ip) VALUES ('', '$old_attachName', '$ksize', '$msize', '$datetime', '$object', '$url', '$ext', '$ip')";}
mysql_query($sql)OR die("<p>写入数据库错误！</p>");mysql_close($conn);?>