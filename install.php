<?php
require_once 'config.php';
$sql = "CREATE TABLE baefile_info (\n"
    . " `id` int(11) NOT NULL auto_increment,\n"
    . " `filename` varchar(255) NOT NULL,\n"
    . " `ksize` varchar(14) NOT NULL,\n"
    . " `msize` decimal(10,2) NOT NULL,\n"
    . " `datetime` datetime NOT NULL,\n"
    . " `object` varchar(255) NOT NULL,\n"
    . " `fileurl` varchar(255) NOT NULL,\n"
    . " `ext` varchar(10) NOT NULL, \n"
    . " `ip` varchar(15) NOT NULL,\n"
    . " PRIMARY KEY (`id`),\n"
    . " KEY `datetime` (`datetime`)\n"
    . ") ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$install = mysql_query($sql);
if ($install){echo "安装成功！";}else{echo "安装失败！数据表可能已存在请删除已存在数据表或检查config.php数据库配置是否正确……";}
?>