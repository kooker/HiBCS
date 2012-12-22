<?php header("Content-Type:text/html; charset=utf-8");error_reporting(0);require_once 'config.php';
if (!defined('HiBCS')) die('Access Denied'); 
$share_id = intval($_GET['id']);
$result=mysql_query("SELECT * FROM baefile_info WHERE id=$share_id");
while ($row=mysql_fetch_array($result))
{
$ext=$row['ext'];
if (!in_array($ext, array('gif', 'jpg', 'jpeg', 'png', 'bmp', 'mp3'))){echo '<!doctype html><html><head><meta charset="utf-8" /><meta name="Baiduspider" content="noarchive"><title>HiBCS_分享文件_'.$row['filename'].'</title></head><body><div><p>文件名称: '.$row['filename'].'<br />文件大小: '.$row['ksize'].' KB<br />文件约合: '.$row['msize'].' MB<br /><a title="上传时间:'.$row['datetime'].'" href="'.$row['fileurl'].'"><span>下载&#9829;&#8660;'.$row['filename'].'</span></a></p><p>您分享的文件，HTML代码：</p><textarea rows="4" cols="55"><a href="'.$row['fileurl'].'" target="_blank">'.$row['fileurl'].'</a></textarea></div></body></html>';}
if (in_array($ext, array('mp3'))){echo '<!doctype html><html><head><meta charset="utf-8" /><meta name="Baiduspider" content="noarchive"><title>HiBCS_MP3分享_在线试听_'.$row['filename'].'</title></head><body><div><p>文件名称: '.$row['filename'].'<br />文件大小: '.$row['ksize'].' KB<br />文件约合: '.$row['msize'].' MB<br /><a title="上传时间:'.$row['datetime'].'" href="'.$row['fileurl'].'"><span>下载&#9829;&#8660;'.$row['filename'].'</span></a></p><p>MP3试听：</p><p><embed src="http://bae.kooker.jp/mp3/dewplayer.swf?mp3='.$row['fileurl'].'&autostart=0&autoreplay=1&volume=90" type="application/x-shockwave-flash" width="180" height="20" quality="high" /></p><p>您分享的文件类型为MP3，HTML代码：</p><textarea rows="6" cols="55"><p><embed src="http://bae.kooker.jp/mp3/dewplayer.swf?mp3='.$row['fileurl'].'&autostart=0&autoreplay=1&volume=90" type="application/x-shockwave-flash" width="180" height="20" quality="high" /></p></textarea></div></body></html>';}
if (in_array($ext, array('gif', 'jpg', 'jpeg', 'png', 'bmp'))){ echo '<!doctype html><html><head><meta charset="utf-8" /><meta name="Baiduspider" content="noarchive"><title>HiBCS_图片分享_'.$row['filename'].'</title></head><body><div><p>文件名称: '.$row['filename'].'<br />文件大小: '.$row['ksize'].' KB<br />文件约合: '.$row['msize'].' MB<br /><a title="上传时间:'.$row['datetime'].'" href="'.$row['fileurl'].'"><span>下载&#9829;&#8660;'.$row['filename'].'</span></a></p><p>您分享的文件类型为图片，HTML代码：</p><textarea rows="4" cols="55"><img src="'.$row['fileurl'].'" alt="" /></textarea></div></body></html>';}
}
mysql_free_result($result);
mysql_close($conn);
?>