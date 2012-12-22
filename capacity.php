<?php header("Content-Type:text/html; charset=utf-8");error_reporting(0);
/*********************************
请搜索修改sablog为你所在的Bucket名
*********************************/
require_once 'config.php';
require_once 'bcs/bcs.class.php';
$baidu_bcs = new BaiduBCS ( $ak, $sk, $host );
function sizecount($fileSize) {
$size = sprintf("%u",$fileSize);
if($size == 0) {
return '0 Bytes';
}
$sizename = array(' Bytes',' KB',' MB',' GB',' TB',' PB',' EB',' ZB',' YB');
return round( $size / pow(1024,($i = floor(log($size,1024)))),2) .$sizename[$i];
}
function printResponse($response) {
$body = $response->body;
preg_match('/\"bucket_name\":\"sablog\",[^.]+$/', $body, $body);

preg_match('/\"cdatetime\":\"\d+\",/', $body[0], $cdatetime);
$cdatetime = $cdatetime[0];
$cdatetime = preg_replace('/\"cdatetime\":\"/','',$cdatetime);
$cdatetime = preg_replace('/\",/','',$cdatetime);
preg_match('/\"used_capacity\":\"\d+\",/', $body[0], $used_capacity);
$used_capacity = $used_capacity[0];
$used_capacity = preg_replace('/\"used_capacity\":\"/','',$used_capacity);
$used_capacity = preg_replace('/\",/','',$used_capacity);
$bcs_used_capacity = sizecount($used_capacity);

preg_match('/\"total_capacity\":\"\d+\"/', $body[0], $total_capacity);
$total_capacity = $total_capacity[0];
$total_capacity = preg_replace('/\"total_capacity\":\"/','',$total_capacity);
$total_capacity = preg_replace('/\"/','',$total_capacity);
$msize = number_format($total_capacity/(1024*1024),2);
$total_msize = $msize;
$total_msize =  preg_replace('/,/','',$total_msize);
$total_msize =  preg_replace('/\.\d+/','',$total_msize);
$have_capacity = $total_capacity-$used_capacity;
$have_capacity = number_format($have_capacity/(1024*1024*1024),2);
echo '所在BUCKET真实情况，已使用：'.$bcs_used_capacity.'，还剩余：'.@round(100/($total_msize/($total_msize-$bcs_used_capacity)),2).'% '.($total_msize-$bcs_used_capacity).' MB【'.$have_capacity.' GB】';
}
function list_bucket($baidu_bcs) {
$response = $baidu_bcs->list_bucket ();
printResponse ( $response );
}
list_bucket($baidu_bcs);
?>