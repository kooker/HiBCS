HiBCS
=====

#### 特别提示：本代码至少需百度应用引擎(BAE)中的百度云存储(BCS)支持

安装
----

`config.php` 填写BAE数据库名称<br />
①通过平台提供的phpMyAdmin访问，导入`baefile.sql`或使用`install.php`<br />
②运行install.php或force-install.php安装
不支持URL Rewrite请自行将`no-rewrite-index.php`重命名<br />
本地或其它空间大文件上传，修改`php.ini`配置例如:<br />

    post_max_size = 320M
    upload_max_filesize = 320M
    max_execution_time = 300
    max_input_time = 600
    memory_limit = 512M
    default_socket_timeout = 600

#####欢迎批评指正 [Hi kooker](http://blog.kooker.jp/)

特别说明：
----------
使用非BAE环境请将`localhost-config.php`重命名为`config.php` 配置数据库及百度云存储相关
* 1、请自行修改`config.php`里的配置
    * ①请将 `$dbname` 改为你的数据库名字<br />
          关于如何查看自己的数据库名，可在BAE后台点击各项菜单，切换到相应的页面查看数据库名。或者在登录BAE的状态下直接打开这个网址：http://developer.baidu.com/bae/bdbs/db
    * ②请在 `$ak` `$sk` 填写你的密匙对。关于查看自己的密匙对【如果没有则请创建】，请在登录BAE的状态下打开
          http://developer.baidu.com/bae/ref/key
* 2、请在BAE后台手动创建一个bucket<br />
        http://developer.baidu.com/bae/bcs/bucket 请注意自行修改`config.php`里的`$bucket`

更新小记
--------
* 2012-11-24
    * 修复上传数据库小BUG
* 2012-11-28 
    * 修正部分问题，增加del.php【此文件有风险，请慎用！】使用时请自行去掉`//require_once 'config.php';`前的双斜杠注释，使用完请删除本文件<br />【删除所有上传到BCS并且记录在数据库的object，此文件不删除数据库记录，请配合force-install.php重装数据库！】
    * config.php无需自己配置URL
* 2012-12-6
    * 增加install.php安装文件，安装完请删除本文件
    * 增加force-install.php【此文件有风险，请慎用！】强制重装文件配合del.php使用，可以删除文件和重装数据，使用完请删除本文件
* 2012-12-12
    * 增加del-list.php 增加删除功能 【此文件有风险，请慎用！】安全起见，请自行重命名
    * 增加del-object.php 删除文件用 【此文件有风险，请慎用！】安全起见，请自行重命名及修改del-list.php中相应链接
* 2012-12-21
    * 增加capacity.php 请搜索修改sablog为你所在的Bucket名，不使用请搜索删除index.php `include 'capacity.php';` 语句。
    * 增加share.php
    * 增加mp3-list.php
    * 这个算是稳定版，没有批量上传【因为起初我是用来传MP3的，以后也没打算批量上传】，以后基本不再更新
    * 与 hibcs.kooker.jp 有些不一样，因为那是我个人使用版【只是多了个javascript图片预览及视频在线播放】。

附：nginx的URL Rewrite规则，请将下面规则加入到站点配置中，重启nginx
----

    rewrite ^/page-([0-9]+)/?$ /index.php?page=$1 last;
    rewrite ^/mp3-page-([0-9]+)/?$ /mp3-list.php?page=$1 last;
    rewrite ^/del-list-([0-9]+)/?$ /del-list.php?page=$1 last;
    rewrite ^/share-([0-9]+)/?$ /share.php?page=$1 last;

#### 免责声明：已限制重复上传时间，防止短时间刷新`bcs.php`重复上传。不对代码的BUG负责！