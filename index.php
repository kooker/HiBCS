<?php header("Content-Type:text/html; charset=utf-8"); require_once 'config.php'; ?>
<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="utf-8" />
<link rel="stylesheet" href="css/style.css" />
<title>HiBCS_MySQL测试版_文件上传列表</title>
</head>
<body>
<div class="navbar"><div class="navbar-inner"><div class="container"><ul class="nav">
<li><a href="http://blog.kooker.jp">网站</a></li>
<li class="active"><a href="http://<?php echo $sitehost ?>/index.php">已上传文件</a></li>
<li><a href="http://<?php echo $sitehost ?>/bcs.html">上传文件[已开放]</a></li>
<li><a href="http://<?php echo $sitehost; ?>/mp3-list.php">MP3 List</a></li>
<li><a href="http://same.kooker.jp">My BAE APP</a></li>
<li><a href="http://bae.kooker.jp">My BAE Site</a></li>
</ul></div></div></div>
<div class="container"><div class="hero-unit"><?php
if($_SERVER['REQUEST_URI']) {
$temp = urldecode($_SERVER['REQUEST_URI']);
if(strpos($temp, '<') !== false || strpos($temp, '>') !== false || strpos($temp, '(') !== false || strpos($temp, '"') !== false) {
exit('Request Bad url');
}
}
$sql = "SELECT count(id) FROM baefile_info";
$result=mysql_query($sql)OR die('<p>读取数据库错误！</p>');
$row=mysql_fetch_array($result);
$file_num=$row[0];
//计算已经占用了多少空间
$sql="SELECT sum(msize) FROM baefile_info";
$result=mysql_query($sql)OR die('<p>读取数据库错误！</p>');
$row=mysql_fetch_array($result);
$file_size=$row[0];
mysql_free_result($result);
//分页
$perNumber=$perNum;
$limit_page = $limitPage+1;
@$page=intval($_GET['page']);
$count=mysql_query("SELECT COUNT(*) FROM baefile_info");
$rs=mysql_fetch_array($count); 
$totalNumber=$rs[0];
$totalPage=ceil($totalNumber/$perNumber);
$page=isset($_GET['page'])?intval($_GET['page']):1; //如果没有值,则赋值1
$startCount=($page-1)*$perNumber;
$result=mysql_query("SELECT * FROM baefile_info ORDER BY datetime DESC LIMIT $startCount,$perNumber");
echo '<p>以下是本站全部已上传文件列表共有'.$totalPage.'页。本站目前有 '.$file_num.' 个文件，本站上传文件大约使用了 '.$file_size.' MB。'; include 'capacity.php'; echo '</p>';
echo '<table class="table"><tr>';
echo '<td>序号</td><td>操作</td><td>文件名</td><td>文件大小</td><td>文件约合</td><td>上传日期时间</td><td>文件后缀</td><td>上传者IP</td></tr>';
while ($row=mysql_fetch_array($result))
{
echo "<tr><td>".@++$id."</td><td><a href=\"".$row['fileurl']."\" target='_blank'>下载</a> | <a href=\"share.php?id=".$row['id']."\" onClick=\"window.open(this.href,'', 'height=380,width=480,toolbar=no,location=no,status=no,menubar=no');return false\">分享</a></td>";
echo "<td>".$row['filename']."</td>";    
echo "<td>".$row['ksize']." KB</td>";
echo "<td>".$row['msize']." MB</td>";
echo "<td>".$row['datetime']."</td>";
if ($row['ext'] != 'hibcs' && $row['ext'] != NULL){$row['ext']='.'.$row['ext'];}else{$row['ext']='未知';}
echo "<td>".$row['ext']."</td>";
$row['ip']=preg_replace('/\d+$/','*',$row['ip']);
echo "<td>".$row['ip']."</td>";
echo '</tr>';
}
echo '</table>';
mysql_free_result($result);
mysql_close($conn);
if ($page>$totalPage) { echo '<h1>没有记录……等待您上传！</h1>';}
?><div class="page"><?php if ($page == 1) {echo '<a href="http://'.$sitehost.'"><strong>首页</strong></a>';}
if ($page != 1) {echo '<a href="http://'.$sitehost.'/page-1" ><strong>首页</strong></a><a href="http://'.$sitehost.'/page-'.($page - 1).'" class="pagelist"><strong>上一页</strong></a>';}
for ($i=1;$i<=$totalPage;$i++) if($page < $limit_page && $i < $limit_page){echo '<a href="http://'.$sitehost.'/page-'.$i.'" class="pagelist">'.$i.'</a>';}
if ($page<$totalPage) {echo '<a href="http://'.$sitehost.'/page-'.($page + 1).'" class="pagelist">下一页</a><a href="http://'.$sitehost.'/page-'.$totalPage.'" class="pagelist">尾页</a>';}
if($page >= $limit_page){echo'<span class="pagelist">共有'.$totalPage.'页，第'.$page.'页，还有'.($totalPage-$page).'页</span>';}
echo '<span class="pagelist"></span>跳转到第<select onchange="window.location=this.value">';
for ($i=1;$i<=$totalPage;$i++) echo '<option value="http://'.$sitehost.'/page-'.$i.'">'.$i.'</option>';
echo '</select>页';?></div></div></div></body></html>