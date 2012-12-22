DROP TABLE IF EXISTS baefile_info;
CREATE TABLE baefile_info (
  `id` int(11) NOT NULL auto_increment,
  `filename` varchar(255) NOT NULL,
  `ksize` varchar(14) NOT NULL,
  `msize` decimal(10,2) NOT NULL,
  `datetime` datetime NOT NULL,
  `object` varchar(255) NOT NULL,
  `fileurl` varchar(255) NOT NULL,
  `ext` varchar(10) NOT NULL,  
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `datetime` (`datetime`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;