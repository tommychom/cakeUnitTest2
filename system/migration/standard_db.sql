DROP TABLE IF EXISTS `acos`;

CREATE TABLE `acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=111 DEFAULT CHARSET=utf8;

/*Data for the table `acos` */

insert  into `acos`(`id`,`parent_id`,`model`,`foreign_key`,`alias`,`lft`,`rght`) values (1,NULL,NULL,NULL,'controllers',1,92),(2,1,NULL,NULL,'Groups',2,19),(3,2,NULL,NULL,'admin_add',3,4),(4,2,NULL,NULL,'admin_delete',5,6),(5,2,NULL,NULL,'admin_edit',7,8),(6,2,NULL,NULL,'admin_index',9,10),(7,2,NULL,NULL,'blackhole',11,12),(8,2,NULL,NULL,'firstTimeLogIn',13,14),(9,2,NULL,NULL,'redirectHttps',15,16),(10,2,NULL,NULL,'stillValid',17,18),(11,1,NULL,NULL,'Pages',20,31),(12,11,NULL,NULL,'blackhole',21,22),(13,11,NULL,NULL,'display',23,24),(14,11,NULL,NULL,'firstTimeLogIn',25,26),(15,11,NULL,NULL,'redirectHttps',27,28),(16,11,NULL,NULL,'stillValid',29,30),(17,1,NULL,NULL,'Posts',32,53),(18,17,NULL,NULL,'admin_add',33,34),(19,17,NULL,NULL,'admin_delete',35,36),(20,17,NULL,NULL,'admin_edit',37,38),(21,17,NULL,NULL,'admin_index',39,40),(22,17,NULL,NULL,'blackhole',41,42),(23,17,NULL,NULL,'firstTimeLogIn',43,44),(24,17,NULL,NULL,'index',45,46),(25,17,NULL,NULL,'redirectHttps',47,48),(26,17,NULL,NULL,'stillValid',49,50),(27,17,NULL,NULL,'view',51,52),(28,1,NULL,NULL,'Users',54,91),(29,28,NULL,NULL,'admin_add',55,56),(30,28,NULL,NULL,'admin_dashboard',57,58),(31,28,NULL,NULL,'admin_delete',59,60),(32,28,NULL,NULL,'admin_edit',61,62),(33,28,NULL,NULL,'admin_index',63,64),(34,28,NULL,NULL,'admin_toggleStatus',65,66),(35,28,NULL,NULL,'admin_view',67,68),(36,28,NULL,NULL,'blackhole',69,70),(37,28,NULL,NULL,'changePassword',71,72),(38,28,NULL,NULL,'firstTimeLogIn',73,74),(39,28,NULL,NULL,'forgotPassword',75,76),(40,28,NULL,NULL,'login',77,78),(41,28,NULL,NULL,'logout',79,80),(42,28,NULL,NULL,'redirectHttps',81,82),(43,28,NULL,NULL,'resetPassword',83,84),(44,28,NULL,NULL,'stillValid',85,86),(45,28,NULL,NULL,'verifyEmail',87,88),(46,28,NULL,NULL,'verifyToResetPassword',89,90);

/*Table structure for table `aros` */

DROP TABLE IF EXISTS `aros`;

CREATE TABLE `aros` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `aros` */

insert  into `aros`(`id`,`parent_id`,`model`,`foreign_key`,`alias`,`lft`,`rght`) values (1,NULL,'Group',1,'administrators',1,4),(2,NULL,'Group',2,'managers',5,8),(3,NULL,'Group',3,'users',9,12),(4,1,'User',3,'admin',2,3),(5,2,'User',4,'tommymanager',6,7),(6,3,'User',5,'tommyusers',10,11);

/*Table structure for table `aros_acos` */

DROP TABLE IF EXISTS `aros_acos`;

CREATE TABLE `aros_acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `aro_id` int(10) NOT NULL,
  `aco_id` int(10) NOT NULL,
  `_create` varchar(2) NOT NULL DEFAULT '0',
  `_read` varchar(2) NOT NULL DEFAULT '0',
  `_update` varchar(2) NOT NULL DEFAULT '0',
  `_delete` varchar(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ARO_ACO_KEY` (`aro_id`,`aco_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `aros_acos` */

insert  into `aros_acos`(`id`,`aro_id`,`aco_id`,`_create`,`_read`,`_update`,`_delete`) values (1,1,1,'1','1','1','1'),(2,2,1,'1','1','1','1'),(3,3,1,'1','1','1','1');

/*Table structure for table `groups` */

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `groups` */

insert  into `groups`(`id`,`name`,`created`,`modified`) values (1,'administrators','2013-09-18 07:04:51','2013-09-18 07:09:16'),(2,'managers','2013-09-18 07:08:00','2013-09-18 07:08:00'),(3,'users','2013-09-18 07:08:14','2013-09-18 07:08:14');

/*Table structure for table `posts` */

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `body` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `posts` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  `role` varchar(20) NOT NULL DEFAULT '',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `verify` tinyint(4) DEFAULT '0',
  `active` tinyint(4) DEFAULT '1',
  `last_login_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`password`,`role`,`created`,`modified`,`group_id`,`verify`,`active`,`last_login_date`) values (3,'admin','$2a$10$GDm6vNlV6nRtY9Oi4wH3fOerq3Uj2G6TYoq.lP3gRlzrBkmTBFf12','','2013-09-18 07:49:09','2014-09-02 08:16:24',1,1,1,'2014-09-02 08:16:24'),(4,'tommymanager','$2a$10$rVqnABPODyANNZeP1TSJB.BEkhCciOozEOzXsh3XWE3RjfErQMAey','','2013-09-18 08:26:25','2013-09-18 08:26:25',2,1,1,'2013-09-18 07:53:11'),(5,'tommyusers','$2a$10$R7EVT.N8qM4H1aXlxmqrt.nudPotWPfz9R7x8Ew9QbCdkkqyBLama','','2013-09-18 08:26:51','2013-09-18 08:26:51',3,1,1,'2013-09-18 07:53:11');