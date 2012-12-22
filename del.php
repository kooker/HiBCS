<?php header("Content-Type:text/html; charset=utf-8");error_reporting(0);
/*************************
【此文件有风险，请慎用！】
*************************/
//使用请去除require_once 'config.php';前面注释
//require_once 'config.php';
if (!defined('HiBCS')) die('Access Denied');
require_once 'bcs/bcs.class.php';
$baidu_bcs = new BaiduBCS ( $ak, $sk, $host );
function delete_object($baidu_bcs) {
global $object, $bucket;
$response = $baidu_bcs->delete_object ( $bucket, $object );
if (! $response->isOK ()) {die ( "Delete object failed." );} echo "Delete object[$object] in bucket[$bucket] success<br />";
}
$result=mysql_query("SELECT * FROM baefile_info"); while ($row=mysql_fetch_array($result))
{
$object = $row['object'];
delete_object($baidu_bcs);
}
mysql_free_result($result);
mysql_close($conn);
?>