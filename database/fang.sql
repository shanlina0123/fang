/*
SQLyog 企业版 - MySQL GUI v8.14 
MySQL - 5.5.5-10.1.31-MariaDB : Database - renren001
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`renren001` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `renren001`;

/*Table structure for table `renren_admin` */

DROP TABLE IF EXISTS `renren_admin`;

CREATE TABLE `renren_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '姓名',
  `nickname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '姓名',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '账号',
  `mobile` char(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '手机号',
  `password` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '密码',
  `isadmin` tinyint(1) DEFAULT '0' COMMENT '是否管理员 1是 0否',
  `companyid` int(11) DEFAULT '1' COMMENT '对应 公司表company表id, 默认1，内部公司',
  `roleid` int(11) DEFAULT NULL COMMENT '角色id 对应角色表role的id',
  `wechatopenid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '微信openid',
  `wechatbackstatus` tinyint(1) DEFAULT '0' COMMENT '微信找回密码绑定后返回的状态id  1成功 0未进行',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态  1启用 0禁用',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='管理员';

/*Data for the table `renren_admin` */

insert  into `renren_admin`(`id`,`uuid`,`nickname`,`name`,`mobile`,`password`,`isadmin`,`companyid`,`roleid`,`wechatopenid`,`wechatbackstatus`,`status`,`created_at`,`updated_at`) values (1,'0210d0483aeb11e8a35594de807e34a0','管理员','admin','18602963711','50d71422a80af970df3455e224db035a',1,1,1,NULL,0,1,'2018-04-08 13:09:28',NULL),(2,'0210f3793aeb11e8a35594de807e34a0','单莉娜','shanlina','18092013097','50d71422a80af970df3455e224db035a',1,1,1,NULL,0,1,'2018-04-08 13:09:28','2018-04-08 07:19:11'),(3,'0210f8763aeb11e8a35594de807e34a0','赵颖','zy','18291846993','50d71422a80af970df3455e224db035a',1,1,3,NULL,0,1,'2018-04-08 13:09:28',NULL),(5,'a7238b2f83a46c9d06f8a64b4d2dfc08','田英敏','tymaa','18691895595','50d71422a80af970df3455e224db035a',0,1,2,NULL,0,0,'2018-04-08 05:54:42','2018-04-24 23:17:16'),(6,'26b23a3c949cfac1542e280e590213b8','舒全刚','sqg','15094014446','50d71422a80af970df3455e224db035a',1,1,1,'oPso81XmC312cF6YBSifXHeKu5-w',0,1,'2018-04-08 07:24:03',NULL),(9,'9783b5da6fa911f45fa039d827b8f891','何文荣','hrwss','18093378259','50d71422a80af970df3455e224db035a',0,1,2,NULL,0,1,'2018-04-10 07:30:29','2018-04-24 23:18:41'),(10,'1ebe0ae8d657354b9d6f594823ab0154','业务员','test','15000000000','50d71422a80af970df3455e224db035a',1,1,1,NULL,0,1,'2018-04-12 13:55:30',NULL),(11,'75345d3bc5706f8b1e23d8721ed965f0','test','testadmin','15894569874','fddd1d6a216e8e176ac7b5533caa455f',0,1,2,NULL,0,0,'2018-04-23 11:44:52','2018-04-24 23:16:39'),(12,'9b8916b881c5c54274f1eeaf88661b65','test1','testadmin2','15894589478','fddd1d6a216e8e176ac7b5533caa455f',0,1,2,NULL,0,0,'2018-04-23 11:57:26','2018-04-24 23:16:40'),(13,'4226665f3ef3a0dd1acf5a313ce6c633','test2','testadmin3','15894589479','fddd1d6a216e8e176ac7b5533caa455f',0,1,2,NULL,0,0,'2018-04-23 11:58:30','2018-04-24 23:16:41'),(14,'aef09a0f3d0d14310c48a2ff72b6b4f5','aaac','aacd','15894857845','fddd1d6a216e8e176ac7b5533caa455f',0,1,2,NULL,0,1,'2018-04-23 11:59:05',NULL),(15,'cdde6ad7042f89a1aaf1f911b3482a11','bbc','testbbc','15895698987','fddd1d6a216e8e176ac7b5533caa455f',0,1,2,NULL,0,1,'2018-04-23 11:59:48',NULL),(16,'6531f8549cc54183a4b86f6d972d45a8','testaac','testaac','15894587895','fddd1d6a216e8e176ac7b5533caa455f',0,1,2,NULL,0,1,'2018-04-23 12:01:10',NULL),(17,'5291dcba96c1179a5ad6116c458f0b1a','testTest','testTest','15894587897','fddd1d6a216e8e176ac7b5533caa455f',0,1,3,NULL,0,1,'2018-04-23 13:39:28',NULL),(18,'8c402034a3c11dc4faf3522a49a04419','ggg','ggg','15894589784','fddd1d6a216e8e176ac7b5533caa455f',0,1,3,NULL,0,1,'2018-04-23 14:09:41',NULL),(19,'ee287ef893ce16e3aefdd1ead998adfc','test4','tes','15987847848','fddd1d6a216e8e176ac7b5533caa455f',0,1,4,NULL,0,1,'2018-04-23 14:10:49','2018-04-24 23:17:53'),(20,'0b5482e0d431e65793d646c4a81d3673','test5','test5','15565659898','fddd1d6a216e8e176ac7b5533caa455f',0,1,2,NULL,0,1,'2018-04-23 14:12:26',NULL),(21,'35343f2204c3eb22b25f3cf4d2fb63f9','test6','test6','15656565656','fddd1d6a216e8e176ac7b5533caa455f',0,1,5,NULL,0,1,'2018-04-23 14:14:10',NULL),(22,'d1e7c10015643607731f9237c1f68542','fsdh','sfsfsdf','15002960388','fddd1d6a216e8e176ac7b5533caa455f',0,1,2,NULL,0,1,'2018-04-24 22:38:58',NULL),(23,'8281628c95a7caa54a8b7fc48a6304ff','tesdt','sssss','15689487874','fddd1d6a216e8e176ac7b5533caa455f',0,1,3,NULL,0,1,'2018-04-24 22:44:09',NULL);

/*Table structure for table `renren_admin_token` */

DROP TABLE IF EXISTS `renren_admin_token`;

CREATE TABLE `renren_admin_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '唯一索引',
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '生成的token',
  `expiration` int(11) DEFAULT NULL COMMENT '过期时间',
  `userid` char(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '用户id  或admin id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='管理员 - token';

/*Data for the table `renren_admin_token` */

insert  into `renren_admin_token`(`id`,`uuid`,`token`,`expiration`,`userid`,`created_at`,`updated_at`) values (2,'494297eb0681ffbae0e6f3ab5ad4531f','QIomlprwCnSEe0pqbcuLKa1Mwcqo58VQYf5ab2d63FNaaMaaB8svHSvO7J68',1524590011,'1','2018-04-08 03:03:12','2018-04-24 23:13:31'),(3,'7ba90cdd509010665c8877be43f9ccec','VKD9M9NDAu6RLHeAykOU6urpWb2PxCVddbv8JzLMnFH9lvvs97yPK58TNoVK',1524586337,'2','2018-04-12 00:57:38','2018-04-24 22:12:17'),(4,'72b5e6086117d9bc28f0b2c41bfc3854','r4A9aq6EMP3ZPxMhMdAmSvbthzBBjzG4zWv1Dy7dQH3jFdnjvrPZkXFLkhYq',1524589759,'3','2018-04-19 11:32:20','2018-04-24 23:09:19'),(5,'ea05451b3c06f52d9da939b6d4a90eda','354G08QcIep9sDZDpGAVWiKLBFYCCxuGBHlinQHFdy0uFSh5w36dF3OJ311h',1524585934,'10','2018-04-19 15:01:12','2018-04-24 22:05:34'),(6,'beb300279ca0768beb76df4d22b7bfbd','diquA6pxfxxpuUlgiHWpR662butYqJ2MfsUuCnpX1aTH6g7cVbsHG0RjgxoY',1524588808,'6','2018-04-20 15:25:27','2018-04-24 22:53:28');

/*Table structure for table `renren_client` */

DROP TABLE IF EXISTS `renren_client`;

CREATE TABLE `renren_client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '唯一索引',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '客户姓名',
  `mobile` char(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '手机号码',
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '备注，默认推荐备注 可修改',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='客户 - 信息';

/*Data for the table `renren_client` */

insert  into `renren_client`(`id`,`uuid`,`name`,`mobile`,`remark`,`created_at`,`updated_at`) values (1,'5be2a0c63b1711e8a35594de807e34a0','ddd','15002960355','sdgsdg','2018-04-08 18:26:48',NULL),(2,'b98ac06c2f307141d4908cae38858e54','nanatuitui','15000257892','gggggg','2018-04-11 16:58:25',NULL),(3,'37b66bb78654caa8b8a9bb2f4ee0c50c','nanatuitui','15000257811','gggggg','2018-04-11 16:58:54',NULL),(4,'71883455f0a741efc175b575e007c78c','nanatuitui','15000257822','gggggg','2018-04-11 16:59:45',NULL),(5,'12ab346ed1237739ece35600ecb77238','bbb','15002323652','gggg','2018-04-11 18:02:01',NULL),(6,'8ec68498f81f2e472a46d3a027384119','bbb','15002323111','ggggfhd','2018-04-11 22:59:37',NULL),(7,'86fc520b4324de1c964b29ec022e4a89','bbb','15002323222','ggggfhd','2018-04-11 23:00:33',NULL),(9,'0847ab1151c1849decf460b39255c988','小小','15002365955','我的朋友推荐','2018-04-13 15:09:19',NULL),(10,'e74e1ac9fdff59180da3df52db94eea2','sdg','18092013055','ddd','2018-04-17 09:26:48',NULL),(12,'d81395b8b9391a64c2d496b09d2facfb','CCC','15002632653','公司内部员工推荐','2018-04-17 09:31:36',NULL),(13,'2497e10bdb2f895e271baf1f84e1eea7','asdgdsg','15002568941','sdssdssdsdsd','2018-04-18 09:19:38',NULL),(14,'952650ff5ca7435708b1341eb20ff797','ggggg','15002362312','公司内部员工推荐','2018-04-18 12:04:12',NULL),(17,'02cd30587d7b4b6338cae6e90e01e431','张飒','15265984874','公司内部员工推荐','2018-04-18 16:41:02',NULL),(18,'3960795a96dab49d46d7d2c82274a3ed','test','15895698748','test','2018-04-18 18:03:17',NULL),(19,'4c6af9191f704991702ff239ad1d855f','张思','15894989784','','2018-04-18 18:26:34',NULL),(20,'3adbc7bd239dda2f33cf7e0f5940e2d2','张三','15769157465','公司内部员工推荐','2018-04-19 14:39:22',NULL),(23,'ea0501c0dd8c6bf10ec6c9d9db24a432','李琪','15769157468','来了','2018-04-19 16:29:08',NULL),(25,'28bc80e01b94246ebc68c9cb0102ae90','张丽','15769157456','公司内部员工推荐','2018-04-19 19:16:57',NULL);

/*Table structure for table `renren_client_dispatch` */

DROP TABLE IF EXISTS `renren_client_dispatch`;

CREATE TABLE `renren_client_dispatch` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '唯一索引',
  `clientid` int(11) DEFAULT NULL COMMENT '客户id  对应客户表client的id 可重复',
  `type` tinyint(1) DEFAULT NULL COMMENT '派单类型 1归属  2跟进 3移交后归属   4 移交后跟进',
  `remark` text COLLATE utf8mb4_unicode_ci COMMENT '派单备注，默认系统自动派单',
  `adminid` int(11) DEFAULT NULL COMMENT '接单人 对应后台用户表admin的id',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='客户 - 派单记录';

/*Data for the table `renren_client_dispatch` */

insert  into `renren_client_dispatch`(`id`,`uuid`,`clientid`,`type`,`remark`,`adminid`,`created_at`) values (1,'8a3c2781cd046376f75c762763eb8a79',2,1,'推荐客户系统自动派单',NULL,'2018-04-11 16:58:25'),(2,'406fcc995cdacb430cb36f1c87e4d66f',3,1,'推荐客户系统自动派单',NULL,'2018-04-11 16:58:54'),(3,'78e548d3ffbb8d7e798661c6eb9339b7',4,1,'推荐客户系统自动派单',NULL,'2018-04-11 16:59:45'),(4,'0d6e046a8d6fab9fd547230213a3e06b',NULL,NULL,NULL,NULL,NULL),(10,'fb0820472c9323c797e02bf17be12477',1,3,'移交派单',2,'2018-04-11 17:23:15'),(11,'4cd5779fe95fb70ca0126f24a0339e24',1,3,'移交派单',2,'2018-04-11 17:26:04'),(12,'354b96a1ac094f39ba3f2ecacd9d944a',5,1,'推荐客户系统自动派单',NULL,'2018-04-11 18:02:01'),(13,'137ffb151222919f035cd49c842d17d4',6,1,'推荐客户系统自动派单',3,'2018-04-11 22:59:37'),(14,'2004ec8bc20d785924d33fbca602a434',7,1,'推荐客户系统自动派单',9,'2018-04-11 23:00:33'),(16,'c0364c87e2fbc481e33fc655dd3c5c87',9,1,'推荐客户系统自动派单',3,'2018-04-13 15:09:19'),(17,'2e52db7900072245a6838c80800bf705',10,1,'推荐客户系统自动派单',1,'2018-04-17 09:26:48'),(19,'43d0b5f2fbcc19f4f97c4b9144781736',12,1,'推荐客户系统自动派单',2,'2018-04-17 09:31:36'),(20,'620b13e9ff8d3c853bb8bb3e4088b2af',13,1,'推荐客户系统自动派单',9,'2018-04-18 09:19:38'),(21,'a5157b70c6712002055cd2a650a60050',14,1,'推荐客户系统自动派单',2,'2018-04-18 12:04:12'),(24,'0fe1ab0df46e9928fd9aa138e21553b7',17,1,'推荐客户系统自动派单',3,'2018-04-18 16:41:02'),(25,'9c40c52beb34c342d9ea0f849b883c77',18,1,'推荐客户系统自动派单',9,'2018-04-18 18:03:17'),(26,'a30a3758f75e1002324f574e33325d38',19,1,'推荐客户系统自动派单',6,'2018-04-18 18:26:34'),(27,'7077a376877985f23753ea5e404019b7',20,1,'推荐客户系统自动派单',5,'2018-04-19 14:39:22'),(30,'bdda90c84f380ba10aaa0bed4c36e570',23,1,'推荐客户系统自动派单',3,'2018-04-19 16:29:08'),(32,'2417335ff18191b069d5a9b05670a79f',25,1,'推荐客户系统自动派单',5,'2018-04-19 19:16:57'),(36,'9613bb3a9b18be563f76fbdfe116e11c',12,3,'移交派单',3,'2018-04-23 21:57:19'),(37,'195c0a600d34138f97958715db111445',12,3,'移交派单',2,'2018-04-23 21:57:58'),(38,'ed43344880981666d82f74d73347f627',12,3,'移交派单',3,'2018-04-23 21:58:18'),(39,'8faecdecab91d68359c715355e5e792a',12,3,'移交派单',2,'2018-04-23 21:58:38'),(40,'8e13de558f0509b499471568a3fbf201',12,3,'移交派单',2,'2018-04-23 21:59:06'),(41,'d71835e87c43bb8927363441ed4d3c12',12,3,'移交派单',2,'2018-04-23 21:59:22'),(42,'f4b2a6ff1af8aa3b7199b02587528f7d',12,3,'移交派单',3,'2018-04-23 21:59:34'),(43,'a5f45dd074976fe810e097340f4501d8',12,3,'移交派单',2,'2018-04-23 22:00:17'),(44,'af231cac12b365ee703eab9716324af3',2,3,'移交派单',3,'2018-04-24 11:06:40'),(46,'1e812d2053559f7b2f8e3b7e2973a31f',20,3,'移交派单',3,'2018-04-24 11:46:17'),(47,'33573097c59a92f0a5294e1dceee855c',10,3,'移交派单',3,'2018-04-24 14:41:39'),(48,'f1a2f008b7202f509f64c5bad1059bed',25,3,'移交派单',3,'2018-04-24 14:42:13'),(49,'d09fe55682e84f832f2f8271a62225eb',12,3,'移交派单',3,'2018-04-24 23:08:17'),(50,'aadc6cf98211b1e9068d45c2c1433bb2',19,3,'移交派单',2,'2018-04-24 23:14:45'),(51,'64abe6d9ab376973b7ec9ab5dbbe01d1',2,3,'移交派单',2,'2018-04-24 23:15:04'),(52,'4cf1ed3522ca6114cffd36f5eb01e285',9,3,'移交派单',2,'2018-04-24 23:15:18'),(53,'206274c05126d4a5fba164944a3af54d',3,3,'移交派单',3,'2018-04-24 23:15:51'),(54,'f730c80a725ff01181cf170b718c8209',3,3,'移交派单',3,'2018-04-24 23:15:54');

/*Table structure for table `renren_client_dynamic` */

DROP TABLE IF EXISTS `renren_client_dynamic`;

CREATE TABLE `renren_client_dynamic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '唯一索引',
  `clientid` int(11) DEFAULT NULL COMMENT '客户id 对应client表id',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `houseid` int(11) DEFAULT NULL COMMENT '楼盘id  对应house表id',
  `housename` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '楼盘名称 对应house表name',
  `followstatusid` int(11) DEFAULT NULL COMMENT '客户跟进状态id 对应 data_select表id',
  `commissionid` int(11) DEFAULT NULL COMMENT '佣金规则 对应data_select表id',
  `levelid` int(11) DEFAULT NULL COMMENT '客户等级  最新一次',
  `makedate` datetime DEFAULT NULL COMMENT '预约时间',
  `comedate` datetime DEFAULT NULL COMMENT '上门时间 ',
  `dealdate` datetime DEFAULT NULL COMMENT '成交时间',
  `followcount` int(11) DEFAULT NULL COMMENT '跟进次数',
  `followdate` datetime DEFAULT NULL COMMENT '最后跟进时间',
  `refereeuserid` int(11) DEFAULT NULL COMMENT '推荐人id 对应user表id',
  `followadminid` int(11) DEFAULT NULL COMMENT '最新跟进者id 对应后台用户admin表id',
  `ownadminid` int(11) DEFAULT NULL COMMENT '客户归属用户id 对应后台用户admin表的id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='客户 - 详情';

/*Data for the table `renren_client_dynamic` */

insert  into `renren_client_dynamic`(`id`,`uuid`,`clientid`,`companyid`,`houseid`,`housename`,`followstatusid`,`commissionid`,`levelid`,`makedate`,`comedate`,`dealdate`,`followcount`,`followdate`,`refereeuserid`,`followadminid`,`ownadminid`,`created_at`,`updated_at`) values (1,'674a65093b1411e8a35594de807e34a0',1,1,1,'aaaa',36,1,16,'2018-04-08 18:03:59','2018-04-08 18:03:59','2018-04-08 18:03:59',6,'2018-04-08 18:03:59',1,1,1,'2018-04-08 18:04:16',NULL),(2,'6e48941037f4e00fe204add0bfc174e5',2,1,1,'aaaa',40,1,17,'2018-04-11 20:34:20','2018-04-11 20:34:20','2018-04-11 20:34:20',3,'2018-04-11 20:34:20',7,1,2,'2018-04-11 16:58:25','2018-04-16 20:58:15'),(3,'2f2f2c7a25bdaed0027ce26cefa7adba',3,1,1,'aaaa',37,1,17,'2018-04-11 20:34:22','2018-04-11 20:34:22','2018-04-11 20:34:22',2,'2018-04-11 20:34:22',7,1,3,'2018-04-11 16:58:54',NULL),(4,'c2842dc367686e2e4ed95aa3cdac495b',4,1,1,'aaaa',40,1,17,'2018-04-11 20:34:24','2018-04-11 20:34:24','2018-04-11 20:34:24',2,'2018-04-11 20:34:24',7,1,1,'2018-04-11 16:59:45',NULL),(5,'2d8409186284bade2d81722889af62fd',5,1,1,'aaaa',36,1,17,'2018-04-11 20:34:26','2018-04-11 20:34:26','2018-04-11 20:34:26',1,'2018-04-11 20:34:26',7,1,1,'2018-04-11 18:02:01','2018-04-19 18:07:33'),(6,'1c72d54f7c703f76259bbd31b5bd49a3',6,1,1,NULL,38,1,18,'2018-04-11 20:34:26','2018-04-11 20:34:26','2018-04-11 20:34:26',1,'2018-04-11 20:34:26',7,3,3,'2018-04-11 22:59:37',NULL),(7,'b7c89f1e518580801c1f1b877eec6931',7,1,1,'aaaa',38,1,18,'2018-04-11 20:34:26','2018-04-11 20:34:26','2018-04-11 20:34:26',1,'2018-04-11 20:34:26',7,9,9,'2018-04-11 23:00:33',NULL),(9,'b17fd9dc740eef4b94e114b267e53e91',9,1,1,'aaaa',38,1,19,'2018-04-11 20:34:26','2018-04-11 20:34:26','2018-04-11 20:34:26',1,'2018-04-11 20:34:26',7,3,2,'2018-04-13 15:09:19',NULL),(10,'38ff6c7ba316164fbc9b697bebd93099',10,3,3,'金色悦城02',40,1,19,'2018-04-11 20:34:26','2018-04-11 20:34:26','2018-04-11 20:34:26',1,'2018-04-11 20:34:26',6,1,3,'2018-04-17 09:26:48','2018-04-17 18:16:25'),(12,'d3ff81d34cd0b08dd3f10a3d03e8c434',12,1,1,'aaaa',38,1,18,'2018-04-11 20:34:26','2018-04-11 20:34:26','2018-04-11 20:34:26',2,'2018-04-11 20:34:26',7,2,3,'2018-04-17 09:31:36','2018-04-18 14:21:50'),(13,'1d2ebf97f28336538a3b2af75689565a',13,4,1,'aaaa',40,1,16,'2018-04-11 20:34:26','2018-04-11 20:34:26','2018-04-11 20:34:26',2,'2018-04-11 20:34:26',6,9,9,'2018-04-18 09:19:38','2018-04-18 09:23:32'),(14,'ac12965e26ad78d71ae01e809e396300',14,1,1,'aaaa',38,1,16,'2018-04-11 20:34:26','2018-04-11 20:34:26','2018-04-11 20:34:26',2,'2018-04-11 20:34:26',7,2,2,'2018-04-18 12:04:12','2018-04-19 17:37:22'),(17,'b233e9bbc64d1c71261e9ec00a9bf088',17,1,3,'金色悦城02',37,1,16,'2018-04-11 20:34:26','2018-04-11 20:34:26','2018-04-11 20:34:26',2,'2018-04-11 20:34:26',5,3,3,'2018-04-18 16:41:02','2018-04-19 19:32:50'),(18,'415673dd0c7fbfcf0de0d3ec5429ebb0',18,4,4,'金色悦城03',38,1,18,'2018-04-11 20:34:26','2018-04-11 20:34:26','2018-04-11 20:34:26',2,'2018-04-11 20:34:26',6,9,9,'2018-04-18 18:03:17',NULL),(19,'5f96a607fdf2241b20fe44ec18c95e3a',19,4,2,'金色悦城',38,1,19,'2018-04-11 20:34:26','2018-04-11 20:34:26','2018-04-11 20:34:26',2,'2018-04-11 20:34:26',6,6,2,'2018-04-18 18:26:34',NULL),(20,'786ff185ae0b8acf7a5a2ec4245f87ad',20,1,2,'金色悦城',40,1,16,'2018-04-19 14:39:22','2018-04-19 14:39:22','2018-04-19 14:39:22',2,'2018-04-19 14:39:22',4,5,3,'2018-04-19 14:39:22','2018-04-19 20:50:07'),(23,'b53e36a06c10333ee28eac091ce164ff',23,5,2,'金色悦城',38,1,16,'2018-04-19 16:29:08','2018-04-19 16:29:08','2018-04-19 16:29:08',2,'2018-04-19 16:29:08',9,3,3,'2018-04-19 16:29:08',NULL),(25,'82a51c2949612cc8d838ddaa1792851c',25,1,2,'金色悦城',37,1,16,'2018-04-19 19:16:57','2018-04-20 00:00:00','2018-04-18 00:00:00',4,'2018-04-24 22:03:35',4,5,3,'2018-04-19 19:16:57','2018-04-19 21:51:48');

/*Table structure for table `renren_client_follow` */

DROP TABLE IF EXISTS `renren_client_follow`;

CREATE TABLE `renren_client_follow` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '唯一索引',
  `clientid` int(11) DEFAULT NULL COMMENT '客户id 对应客户表client的id',
  `followstatusid` int(11) DEFAULT NULL COMMENT '跟进状态id 对应data_select表id',
  `content` text COLLATE utf8mb4_unicode_ci COMMENT '跟进 内容',
  `adminid` int(11) DEFAULT NULL COMMENT '跟进人 对应后台用户admin表的id',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='客户 - 跟进记录';

/*Data for the table `renren_client_follow` */

insert  into `renren_client_follow`(`id`,`uuid`,`clientid`,`followstatusid`,`content`,`adminid`,`created_at`,`updated_at`) values (1,'5e1db83f05d18c370a00d2100f6c57d4',1,36,'swqd',1,'2018-04-11 17:07:03',NULL),(2,'516916e747d96631da72d6ec34d6b85b',1,38,'swqd',1,'2018-04-11 17:07:03',NULL),(3,'0a0dd6e54849bc235dfa345736d8e5b2',1,40,'swqd',1,'2018-04-11 17:07:03','2018-04-11 17:07:03'),(4,'22884cb38749806112c48e0a548f039e',1,40,'swqd',1,'2018-04-11 17:09:15','2018-04-11 17:09:15'),(13,'7533e3df813529fc47396d82932aa3c8',25,37,'通过广告',1,'2018-04-24 14:40:23','2018-04-24 14:40:23'),(14,'4766094eb0e2251a9ce7875a3b6f925a',25,37,'客户已经够购买了',1,'2018-04-24 22:03:35','2018-04-24 22:03:35');

/*Table structure for table `renren_client_referee` */

DROP TABLE IF EXISTS `renren_client_referee`;

CREATE TABLE `renren_client_referee` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '唯一索引',
  `clientid` int(11) DEFAULT NULL COMMENT '客户id  对应客户表client的id 不可重复',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id 对应公司表company的id, 对重生客户需要修改该值',
  `houseid` int(11) DEFAULT NULL COMMENT '房源id  对应house表id',
  `housename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '楼盘名称',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '客户姓名',
  `mobile` char(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '手机号',
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '推荐备注',
  `userid` int(11) DEFAULT NULL COMMENT '推荐人 对应用户表user的id',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='客户 - 我的推荐';

/*Data for the table `renren_client_referee` */

insert  into `renren_client_referee`(`id`,`uuid`,`clientid`,`companyid`,`houseid`,`housename`,`name`,`mobile`,`remark`,`userid`,`created_at`) values (1,'25abdf68cf422fb8a3bc54cf6f8e7d24',2,1,1,'aaaa','nanatuitui','15000257892','gggggg',7,'2018-04-11 16:58:25'),(2,'866f2631aae7d35ebe65d5ba2666205c',3,1,1,'aaaa','nanatuitui','15000257811','gggggg',7,'2018-04-11 16:58:54'),(3,'93b8544dbbe0b3ca60acf490ea02f69f',4,1,1,'aaaa','nanatuitui','15000257822','gggggg',7,'2018-04-11 16:59:45'),(4,'eeb5a180a8cbf640b86ee5e820a4d456',5,1,1,'aaaa','bbb','15002323652','gggg',7,'2018-04-11 18:02:01'),(5,'8dcc39317900cb5c9cfe2c46e8865e6d',6,1,1,NULL,'bbb','15002323111','ggggfhd',7,'2018-04-11 22:59:37'),(6,'ccecb3b28b6bc5a306c43955015fabf6',7,1,1,'aaaa','bbb','15002323222','ggggfhd',7,'2018-04-11 23:00:33'),(7,'5b0c458c55a2a7e4efc492979956c2f8',8,1,1,'aaaa','bbb','15002323229','ggggfhd',7,'2018-04-11 23:53:54'),(8,'9f34111737b90931149465368af0f63a',9,1,1,'aaaa','小小','15002365955','我的朋友推荐',7,'2018-04-13 15:09:19'),(9,'c71d1589ee9b47e6e8a97a3c1a022d1f',10,3,3,'金色悦城02','sdg','18092013055','ddd',6,'2018-04-17 09:26:48'),(10,'fd3e4c0926637e0f79ed8a96610cc164',11,1,5,'金色悦城04','HHHH','18092013066','公司内部员工推荐',7,'2018-04-17 09:28:35'),(11,'03b0d04891b0f445f8c16fb5925f8d77',12,1,1,'aaaa','CCC','15002632653','公司内部员工推荐',7,'2018-04-17 09:31:36'),(12,'15400bfaffcf073a86984192617cfe7a',13,4,1,'aaaa','asdgdsg','15002568941','sdssdssdsdsd',6,'2018-04-18 09:19:40'),(13,'f29486b4629e5c63813cd42ef8119774',14,1,1,'aaaa','ggggg','15002362312','公司内部员工推荐',7,'2018-04-18 12:04:12'),(14,'6cda0a8fb68792d1045fa894806b8bef',15,1,1,'aaaa','是东方红东方','15002365956','公司内部员工推荐',7,'2018-04-18 16:10:04'),(15,'ed7763d7c1c0f195896dc0a0d1b000c1',16,1,2,'金色悦城','NNN','15002362653','公司内部员工推荐',7,'2018-04-18 16:10:42'),(16,'b64ec241b8645e7703f12ae1658e9e2e',17,1,3,'金色悦城02','张飒','15265984874','公司内部员工推荐',5,'2018-04-18 16:41:02'),(17,'bbc186a89f4de4f4c904e81acf428f37',18,4,4,'金色悦城03','test','15895698748','test',6,'2018-04-18 18:03:17'),(18,'b387ef9f7431a30a4f24b2bb2739f583',19,4,2,'金色悦城','张思','15894989784','',6,'2018-04-18 18:26:34'),(19,'ca740e89e93e01e96d5fb627d39d22e9',20,1,2,'金色悦城','张三','15769157465','公司内部员工推荐',4,'2018-04-19 14:39:22'),(20,'62077fe0fe352cac34da094afd112bdd',21,5,2,'金色悦城','18710730591','18710730591','',9,'2018-04-19 14:52:22'),(21,'5693895c1f5cd08c3482a869c5b0ce18',22,4,1,'aaaa','18093378259','18093378259','',9,'2018-04-19 14:54:35'),(22,'884865c84e322b153b7cc5dc767c2b34',23,5,2,'金色悦城','李琪','15769157468','来了',9,'2018-04-19 16:29:08'),(23,'27e346dbd8fa47a332b79e52e6d8d8cb',24,1,1,'aaaa','sdgsdg','15002365986','公司内部员工推荐',7,'2018-04-19 17:37:44'),(24,'64aebeb1182f3785462b2d8166a88476',25,1,2,'金色悦城','张丽','15769157456','公司内部员工推荐',4,'2018-04-19 19:16:57'),(25,'d4e819f2583c5265a4ee207c0e37d9dd',26,4,2,'金色悦城','李丽','15769157457','备注',9,'2018-04-19 19:39:46'),(26,'21b889e37d00abf9d489cb3eaa520690',27,1,4,'金色悦城03','小赵','15769157469','公司内部员工推荐',4,'2018-04-19 20:45:58'),(27,'f18ab085a097464d1d0d772dc602ce60',28,1,5,'金色悦城04','感受到','15002362356','公司内部员工推荐',7,'2018-04-19 22:54:13');

/*Table structure for table `renren_client_transfer` */

DROP TABLE IF EXISTS `renren_client_transfer`;

CREATE TABLE `renren_client_transfer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '唯一索引',
  `clientid` int(11) DEFAULT NULL COMMENT '客户id  对应客户表id',
  `beforeownadminid` int(11) DEFAULT NULL COMMENT '移交前客户归属者id   对应后台用户admin表的id',
  `afterownadminid` int(11) DEFAULT NULL COMMENT '移交后客户归属者id  对应后台用户admin表的id',
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '备注',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='客户 - 移交记录';

/*Data for the table `renren_client_transfer` */

insert  into `renren_client_transfer`(`id`,`uuid`,`clientid`,`beforeownadminid`,`afterownadminid`,`remark`,`created_at`) values (1,'c5f3057d7a1d9ba471cf06504eef3e8c',1,NULL,3,'客户移交','2018-04-11 17:23:15'),(2,'90ad802a7f99f72372f9973a70cc6446',1,3,2,'客户移交','2018-04-11 17:26:04'),(3,'7395fba6154cecccac025eeac32af228',12,2,3,'客户移交','2018-04-23 21:57:19'),(4,'d540dbce2d3116dd3f1e565a43a3fa46',12,3,2,'客户移交','2018-04-23 21:57:58'),(5,'0bbbee7b37aef9cba768cd477f559421',12,2,3,'客户移交','2018-04-23 21:58:18'),(6,'07bc995ec073fe3c7978d528c8354c7b',12,3,2,'客户移交','2018-04-23 21:58:38'),(7,'d75c75b4de49f2cb18dca5fd249aee21',12,3,2,'客户移交','2018-04-23 21:59:06'),(8,'79d588ef3e15107558e7ee94145255c9',12,3,2,'客户移交','2018-04-23 21:59:22'),(9,'e7fc1de895d94fbd7c052a6aea2e217d',12,2,3,'客户移交','2018-04-23 21:59:34'),(10,'64b62abfc19f7350643e0ead52dc8fab',12,3,2,'客户移交','2018-04-23 22:00:17'),(11,'39ccce0cbf966e6eae319524b9b164c1',2,1,3,'客户移交','2018-04-24 11:06:40'),(13,'ab42b23638097d589797abc3e31741ab',20,5,3,'客户移交','2018-04-24 11:46:17'),(14,'d6e13443df78ee52fbce8da2a1556e33',10,5,3,'客户移交','2018-04-24 14:41:39'),(15,'209b591eeac57060a037371b6de6b3ba',25,5,3,'客户移交','2018-04-24 14:42:13'),(16,'e1ba3d96db3835ff5458a1886900c150',12,2,3,'客户移交','2018-04-24 23:08:17'),(17,'c5154e04fac057fc49bc360be950c202',19,6,2,'客户移交','2018-04-24 23:14:45'),(18,'6553c4bf47d15b2d4d79e1ce2bc03fa5',2,3,2,'客户移交','2018-04-24 23:15:04'),(19,'a1498ffb43b8e12ef2e55bf6a38a28a8',9,3,2,'客户移交','2018-04-24 23:15:18'),(20,'232e08767d7c16c44e2281c1eb917e2c',3,1,3,'客户移交','2018-04-24 23:15:51'),(21,'178aee67c20234a4578fbcc752b38722',3,1,3,'客户移交','2018-04-24 23:15:54');

/*Table structure for table `renren_company` */

DROP TABLE IF EXISTS `renren_company`;

CREATE TABLE `renren_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '唯一索引',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '公司名称',
  `mobile` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '联系人手机号 获取其他号码',
  `conncat` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '联系人名称',
  `addr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '公司地址',
  `isdefault` tinyint(1) DEFAULT '0' COMMENT '是否默认  ，默认0，1默认 0非默认 默认的不能进行增删改',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='公司';

/*Data for the table `renren_company` */

insert  into `renren_company`(`id`,`uuid`,`name`,`mobile`,`conncat`,`addr`,`isdefault`,`created_at`,`updated_at`,`deleted_at`) values (1,'73c3a56641dd11e8a44d94de807e34a0','内部公司','029-86687002','人人找房','西安',1,'2018-04-17 09:20:02',NULL,NULL),(10,'db5415c8f490fb5be52ee1d039fe30a5','发发发','15002960311','发发发','订单',0,'2018-04-24 23:09:33','2018-04-24 23:09:33',NULL);

/*Table structure for table `renren_data_city` */

DROP TABLE IF EXISTS `renren_data_city`;

CREATE TABLE `renren_data_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `provinceid` int(11) DEFAULT NULL COMMENT '省份id',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='数据源 - 市';

/*Data for the table `renren_data_city` */

insert  into `renren_data_city`(`id`,`name`,`provinceid`,`status`,`created_at`) values (1,'西安市',1,1,'2018-03-19 16:45:53');

/*Table structure for table `renren_data_country` */

DROP TABLE IF EXISTS `renren_data_country`;

CREATE TABLE `renren_data_country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `cityid` int(11) DEFAULT NULL COMMENT '市id',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='数据源 - 区';

/*Data for the table `renren_data_country` */

insert  into `renren_data_country`(`id`,`name`,`cityid`,`status`,`created_at`) values (1,'未央区',1,1,'2018-03-19 16:45:53'),(2,'高新区',1,1,'2018-03-22 11:10:23');

/*Table structure for table `renren_data_function` */

DROP TABLE IF EXISTS `renren_data_function`;

CREATE TABLE `renren_data_function` (
  `id` int(11) NOT NULL COMMENT '编号',
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '姓名',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '名称',
  `pid` int(11) DEFAULT NULL COMMENT '父类id',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `ismenu` tinyint(1) DEFAULT NULL COMMENT '是否菜单显示 1显示 0不显示',
  `menuicon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '菜单图标',
  `menuname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '菜单显示名称',
  `level` tinyint(1) DEFAULT NULL COMMENT '层级',
  `controller` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '接口地址  和真实一样',
  `action` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '方法 和真实一样',
  `method` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '请求方式 GET POST PUT DELETE',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '访问路径',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 1可用 0 不可用',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='功能';

/*Data for the table `renren_data_function` */

insert  into `renren_data_function`(`id`,`uuid`,`name`,`pid`,`sort`,`ismenu`,`menuicon`,`menuname`,`level`,`controller`,`action`,`method`,`url`,`status`,`created_at`) values (100,'73c0badd41dd11e8a44d94de807e34a0','角色管理',0,1,1,'&#xe613;','角色管理',1,'','','','roles/roles.html',1,'2018-04-17 09:20:02'),(101,'73c0d3fe41dd11e8a44d94de807e34a0','列表',100,1,0,NULL,'',2,'RolesController','index','GET','',1,'2018-04-17 09:20:02'),(102,'73c0d56d41dd11e8a44d94de807e34a0','添加',100,2,0,NULL,'',2,'RolesController','store','POST','',1,'2018-04-17 09:20:02'),(103,'73c0d5f841dd11e8a44d94de807e34a0','详情',100,3,0,NULL,'',2,'RolesController','edit','GET','',1,'2018-04-17 09:20:02'),(104,'73c0d67941dd11e8a44d94de807e34a0','修改',100,4,0,NULL,'',2,'RolesController','update','PUT','',1,'2018-04-17 09:20:02'),(105,'73c0d75341dd11e8a44d94de807e34a0','删除',100,5,0,NULL,'',2,'RolesController','delete','DELETE','',1,'2018-04-17 09:20:02'),(106,'73c0d7d441dd11e8a44d94de807e34a0','权限列表',100,6,0,NULL,'',2,'AuthController','index','GET','',1,'2018-04-17 09:20:02'),(107,'73c0d84b41dd11e8a44d94de807e34a0','角色权限详情',100,7,0,NULL,'',2,'AuthController','edit','GET','',1,'2018-04-17 09:20:02'),(108,'73c0d8be41dd11e8a44d94de807e34a0','勾选权限',100,8,0,NULL,'',2,'AuthController','update','PUT','',1,'2018-04-17 09:20:02'),(200,'73c0d93241dd11e8a44d94de807e34a0','用户管理',0,2,1,'&#xe612;','用户管理',1,'','','','admin/admin.html',1,'2018-04-17 09:20:02'),(201,'73c0d9a541dd11e8a44d94de807e34a0','列表',200,1,0,NULL,'',2,'AdminController','index','GET','',1,'2018-04-17 09:20:02'),(202,'73c0da1c41dd11e8a44d94de807e34a0','添加',200,2,0,NULL,'',2,'AdminController','store','POST','',1,'2018-04-17 09:20:02'),(203,'73c0da8d41dd11e8a44d94de807e34a0','详情',200,3,0,NULL,'',2,'AdminController','edit','GET','',1,'2018-04-17 09:20:02'),(204,'73c0dafd41dd11e8a44d94de807e34a0','修改',200,4,0,NULL,'',2,'AdminController','update','PUT','',1,'2018-04-17 09:20:02'),(205,'73c0db7041dd11e8a44d94de807e34a0','锁定',200,5,0,NULL,'',2,'AdminController','setting','PUT','',1,'2018-04-17 09:20:02'),(300,'73c0dbe441dd11e8a44d94de807e34a0','房源管理',0,3,1,'&#xe68e;','房源管理',1,'','','','house/houseList.html',1,'2018-04-17 09:20:02'),(301,'73c0dc5441dd11e8a44d94de807e34a0','列表',300,1,0,NULL,'',2,'HouseController','index','GET','',1,'2018-04-17 09:20:02'),(302,'73c0dcc741dd11e8a44d94de807e34a0','添加房源图片+发布',300,2,0,NULL,'',2,'HouseController','storeImg','POST','',1,'2018-04-17 09:20:02'),(303,'73c0dd3b41dd11e8a44d94de807e34a0','添加房源基本信息',300,3,0,NULL,'',2,'HouseController','store','POST','',1,'2018-04-17 09:20:02'),(304,'73c0ddaf41dd11e8a44d94de807e34a0','添加房源标签',300,4,0,NULL,'',2,'HouseController','storeTag','POST','',1,'2018-04-17 09:20:02'),(305,'73c0de2541dd11e8a44d94de807e34a0','推荐房源',300,5,0,NULL,'',2,'HouseController','recommend','POST','',1,'2018-04-17 09:20:02'),(306,'73c0de9641dd11e8a44d94de807e34a0','房源详情',300,6,0,NULL,'',2,'HouseController','edit','GET','',1,'2018-04-17 09:20:02'),(307,'73c0df0641dd11e8a44d94de807e34a0','修改房源',300,7,0,NULL,'',2,'HouseController','update','PUT','',1,'2018-04-17 09:20:02'),(308,'73c0df7d41dd11e8a44d94de807e34a0','删除房源',300,8,0,NULL,'',2,'HouseController','destroy','DELETE','',1,'2018-04-17 09:20:02'),(400,'73c0dfed41dd11e8a44d94de807e34a0','客户管理',0,4,1,'&#xe6b2;','客户管理',1,'','','','client/client.html',1,'2018-04-17 09:20:02'),(401,'73c0e06b41dd11e8a44d94de807e34a0','列表',400,1,0,NULL,NULL,2,'ClientController','index','GET',NULL,1,'2018-04-17 09:20:02'),(402,'73c0e0ec41dd11e8a44d94de807e34a0','客户详情',400,2,0,NULL,NULL,2,'ClientController','edit','GET',NULL,1,'2018-04-17 09:20:02'),(403,'73c0e16341dd11e8a44d94de807e34a0','客户修改',400,3,0,NULL,NULL,2,'ClientController','update','PUT',NULL,1,'2018-04-17 09:20:02'),(404,'73c0e1d641dd11e8a44d94de807e34a0','跟进详情',400,4,0,NULL,NULL,2,'ClientController','followEdit','GET',NULL,1,'2018-04-17 09:20:02'),(405,'73c0e27241dd11e8a44d94de807e34a0','跟进修改',400,5,0,NULL,NULL,2,'ClientController','followStore','PUT',NULL,1,'2018-04-17 09:20:02'),(406,'73c0e2e941dd11e8a44d94de807e34a0','客户移交',400,6,0,NULL,NULL,2,'ClientController','transferUpdate','POST',NULL,1,'2018-04-17 09:20:02'),(407,'73c0e35d41dd11e8a44d94de807e34a0','客户删除',400,7,0,NULL,NULL,2,'ClientController','destroy','DELETE',NULL,1,'2018-04-17 09:20:02'),(500,'73c0e3d441dd11e8a44d94de807e34a0','公司管理',0,5,1,'&#xe630;','公司管理',1,'','','','company/companylist.html',1,'2018-04-17 09:20:02'),(501,'73c0e44b41dd11e8a44d94de807e34a0','列表',500,1,0,NULL,'',2,'CompanyController','index','GET',NULL,1,'2018-04-17 09:20:02'),(502,'73c0e4be41dd11e8a44d94de807e34a0','添加',500,2,0,NULL,'',2,'CompanyController','store','POST',NULL,1,'2018-04-17 09:20:02'),(503,'73c0e53541dd11e8a44d94de807e34a0','详情',500,3,0,NULL,NULL,2,'CompanyController','edit','GET',NULL,1,'2018-04-17 09:20:02'),(504,'73c0e5a541dd11e8a44d94de807e34a0','修改',500,4,0,NULL,NULL,2,'CompanyController','update','PUT',NULL,1,'2018-04-17 09:20:02'),(505,'73c0e61c41dd11e8a44d94de807e34a0','删除',500,5,0,NULL,NULL,2,'CompanyController','destroy','DELETE',NULL,1,'2018-04-17 09:20:02'),(600,'73c0e69341dd11e8a44d94de807e34a0','经纪人管理',0,6,1,'&#xe6af;','经纪人管理',1,'','','','user/user.html',1,'2018-04-17 09:20:02'),(601,'73c0e70a41dd11e8a44d94de807e34a0','列表',600,1,0,NULL,NULL,2,'UserController','broker','GET',NULL,1,'2018-04-17 09:20:02'),(602,'73c0e78141dd11e8a44d94de807e34a0','锁定',600,2,0,NULL,NULL,2,'UserController','setting','PUT',NULL,1,'2018-04-17 09:20:02'),(700,'73c0e7f541dd11e8a44d94de807e34a0','数据分析',0,7,1,'&#xe62a;','数据分析',1,'','','','charts/charts.html',1,'2018-04-17 09:20:02'),(701,'73c0e86c41dd11e8a44d94de807e34a0','列表',700,1,0,NULL,NULL,2,'ChartController','index','POST',NULL,1,'2018-04-17 09:20:02'),(702,'73c0e8df41dd11e8a44d94de807e34a0','经纪人下拉列表',700,2,0,NULL,NULL,2,'ChartController','getUsers','GET',NULL,1,'2018-04-17 09:20:02'),(800,'73c0e95641dd11e8a44d94de807e34a0','系统设置',0,8,1,'&#xe620;','系统设置',1,'','','','datas/setting.html',1,'2018-04-17 09:20:02'),(801,'73c0e9ca41dd11e8a44d94de807e34a0','列表',800,1,0,NULL,'',2,'DatasController','index','GET',NULL,1,'2018-04-17 09:20:02'),(802,'73c0ea4141dd11e8a44d94de807e34a0','添加',800,2,0,NULL,'',2,'DatasController','store','POST',NULL,1,'2018-04-17 09:20:02'),(803,'73c0eab441dd11e8a44d94de807e34a0','单分类列表',800,3,0,NULL,NULL,2,'DatasController','getOne','GET',NULL,1,'2018-04-17 09:20:02'),(804,'73c0eb2841dd11e8a44d94de807e34a0','详情',800,4,0,NULL,NULL,2,'DatasController','edit','GET',NULL,1,'2018-04-17 09:20:02'),(805,'73c0eb9b41dd11e8a44d94de807e34a0','修改',800,5,0,NULL,NULL,2,'DatasController','update','PUT',NULL,1,'2018-04-17 09:20:02'),(806,'73c0ec1241dd11e8a44d94de807e34a0','锁定',800,6,0,NULL,NULL,2,'DatasController','setting','PUT',NULL,1,'2018-04-17 09:20:02');

/*Table structure for table `renren_data_province` */

DROP TABLE IF EXISTS `renren_data_province`;

CREATE TABLE `renren_data_province` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='数据源 - 省';

/*Data for the table `renren_data_province` */

insert  into `renren_data_province`(`id`,`name`,`status`,`created_at`) values (1,'陕西省',1,'2018-03-19 16:45:30');

/*Table structure for table `renren_data_select` */

DROP TABLE IF EXISTS `renren_data_select`;

CREATE TABLE `renren_data_select` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) DEFAULT NULL COMMENT '唯一索引',
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `cateid` int(11) DEFAULT NULL COMMENT '分类id 对应select_cate表id',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` date DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COMMENT='数据源 - 自定义';

/*Data for the table `renren_data_select` */

insert  into `renren_data_select`(`id`,`uuid`,`name`,`cateid`,`status`,`created_at`,`updated_at`) values (1,'8b01ab35479c11e8add894de807e34a0','80000元',1,1,'2018-04-24 16:50:30','2018-04-24'),(2,'8b01acd4479c11e8add894de807e34a0','20000元',1,1,'2018-04-24 16:50:30',NULL),(3,'8b01ae32479c11e8add894de807e34a0','1室1厅',2,1,'2018-04-24 16:50:30',NULL),(4,'8b01ae8a479c11e8add894de807e34a0','2室1厅',2,1,'2018-04-24 16:50:30',NULL),(5,'8b01aece479c11e8add894de807e34a0','1室0厅',2,1,'2018-04-24 16:50:30',NULL),(6,'8b01af08479c11e8add894de807e34a0','2室2厅',2,1,'2018-04-24 16:50:30',NULL),(7,'8b01af67479c11e8add894de807e34a0','3室1厅',2,1,'2018-04-24 16:50:30',NULL),(8,'8b01afa1479c11e8add894de807e34a0','4室1厅',2,1,'2018-04-24 16:50:30',NULL),(9,'8b01afde479c11e8add894de807e34a0','3室2厅',2,1,'2018-04-24 16:50:30',NULL),(10,'8b01b01f479c11e8add894de807e34a0','4室2厅',2,1,'2018-04-24 16:50:30',NULL),(11,'8b01b05f479c11e8add894de807e34a0','精装修',3,1,'2018-04-24 16:50:30',NULL),(12,'8b01b099479c11e8add894de807e34a0','简单装修',3,1,'2018-04-24 16:50:30',NULL),(13,'8b01b0d3479c11e8add894de807e34a0','毛坯',3,1,'2018-04-24 16:50:30',NULL),(14,'8b01b10d479c11e8add894de807e34a0','豪华装修',3,1,'2018-04-24 16:50:30',NULL),(15,'8b01b143479c11e8add894de807e34a0','中等装修',3,1,'2018-04-24 16:50:30',NULL),(16,'8b01b17d479c11e8add894de807e34a0','A类客户',4,1,'2018-04-24 16:50:30',NULL),(17,'8b01b1ba479c11e8add894de807e34a0','B类客户',4,1,'2018-04-24 16:50:30',NULL),(18,'8b01b1f0479c11e8add894de807e34a0','C类客户',4,1,'2018-04-24 16:50:30',NULL),(19,'8b01b22a479c11e8add894de807e34a0','D类客户',4,1,'2018-04-24 16:50:30',NULL),(20,'8b01b264479c11e8add894de807e34a0','配套齐全',5,1,'2018-04-24 16:50:30',NULL),(21,'8b01b29e479c11e8add894de807e34a0','邻地铁',5,1,'2018-04-24 16:50:30',NULL),(22,'8b01b2d7479c11e8add894de807e34a0','车位充足',5,1,'2018-04-24 16:50:30',NULL),(23,'8b01b311479c11e8add894de807e34a0','小户型',5,1,'2018-04-24 16:50:30',NULL),(24,'8b01b34b479c11e8add894de807e34a0','学校周边',5,1,'2018-04-24 16:50:30',NULL),(25,'8b01b385479c11e8add894de807e34a0','绿化率高',5,1,'2018-04-24 16:50:30',NULL),(26,'8b01b3be479c11e8add894de807e34a0','品牌公寓',5,1,'2018-04-24 16:50:30',NULL),(27,'8b01b3f8479c11e8add894de807e34a0','五证齐全',5,1,'2018-04-24 16:50:30',NULL),(28,'8b01b432479c11e8add894de807e34a0','南北通透',5,1,'2018-04-24 16:50:30',NULL),(29,'8b01b46c479c11e8add894de807e34a0','带幼儿园',5,1,'2018-04-24 16:50:30',NULL),(30,'8b01b4a6479c11e8add894de807e34a0','购物中心',5,1,'2018-04-24 16:50:30',NULL),(31,'8b01b4df479c11e8add894de807e34a0','轨交房',5,1,'2018-04-24 16:50:30',NULL),(32,'8b01b516479c11e8add894de807e34a0','品牌开发商',5,1,'2018-04-24 16:50:30',NULL),(33,'8b01b56e479c11e8add894de807e34a0','满二唯一',5,1,'2018-04-24 16:50:30',NULL),(34,'8b01b5a8479c11e8add894de807e34a0','满两年',5,1,'2018-04-24 16:50:30',NULL),(35,'8b01b5e2479c11e8add894de807e34a0','满五唯一',5,1,'2018-04-24 16:50:30',NULL),(36,'8b01b61b479c11e8add894de807e34a0','满五年',5,1,'2018-04-24 16:50:30',NULL),(37,'8b01b655479c11e8add894de807e34a0','精装修',5,1,'2018-04-24 16:50:30',NULL),(38,'8b01b68f479c11e8add894de807e34a0','随时看房',5,1,'2018-04-24 16:50:30',NULL),(39,'8b01b6c9479c11e8add894de807e34a0','可短租',5,1,'2018-04-24 16:50:30',NULL),(40,'8b01b706479c11e8add894de807e34a0','首次出租',5,1,'2018-04-24 16:50:30',NULL);

/*Table structure for table `renren_data_select_cate` */

DROP TABLE IF EXISTS `renren_data_select_cate`;

CREATE TABLE `renren_data_select_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='数据源 - 自定义分类';

/*Data for the table `renren_data_select_cate` */

insert  into `renren_data_select_cate`(`id`,`name`,`status`,`created_at`) values (1,'佣金规则',1,'2018-04-02 19:00:40'),(2,'房型',1,'2018-04-02 19:00:37'),(3,'装修',1,'2018-04-02 19:00:40'),(4,'客户等级',1,'2018-04-02 19:00:40'),(5,'房源特色',1,'2018-04-02 19:00:40');

/*Table structure for table `renren_data_select_cate_default` */

DROP TABLE IF EXISTS `renren_data_select_cate_default`;

CREATE TABLE `renren_data_select_cate_default` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='数据源 - 默认分类';

/*Data for the table `renren_data_select_cate_default` */

insert  into `renren_data_select_cate_default`(`id`,`name`,`status`,`created_at`) values (1,'房屋类型',1,'2018-04-02 19:00:40'),(2,'楼层位置',1,'2018-04-02 19:00:37'),(3,'朝向',1,'2018-04-02 19:00:40'),(4,'用途',1,'2018-04-02 19:00:40'),(5,'权属',1,'2018-04-02 19:00:40'),(6,'双气',1,'2018-04-02 19:00:40'),(7,'现状',1,'2018-04-02 19:00:40'),(8,'客户状态',1,'2018-04-02 19:00:40'),(9,'用户类型',1,'2018-04-02 19:00:40');

/*Table structure for table `renren_data_select_default` */

DROP TABLE IF EXISTS `renren_data_select_default`;

CREATE TABLE `renren_data_select_default` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `cateid` int(11) DEFAULT NULL COMMENT '分类id 对应select_cate表id',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COMMENT='数据源 - 默认';

/*Data for the table `renren_data_select_default` */

insert  into `renren_data_select_default`(`id`,`name`,`cateid`,`status`,`created_at`) values (1,'新房',1,1,'2018-04-02 19:20:49'),(2,'二手房',1,1,'2018-04-02 19:20:49'),(3,'商铺写字楼',1,1,'2018-04-02 19:20:49'),(4,'中',2,1,'2018-04-02 19:20:49'),(5,'低',2,1,'2018-04-02 19:20:49'),(6,'高',2,1,'2018-04-02 19:20:49'),(7,'东',3,1,'2018-04-02 19:20:49'),(8,'南',3,1,'2018-04-02 19:20:49'),(9,'西',3,1,'2018-04-02 19:20:49'),(10,'北',3,1,'2018-04-02 19:20:49'),(11,'东南',3,1,'2018-04-02 19:20:49'),(12,'西南',3,1,'2018-04-02 19:20:49'),(13,'东北',3,1,'2018-04-02 19:20:49'),(14,'西北',3,1,'2018-04-02 19:20:49'),(15,'东西',3,1,'2018-04-02 19:20:49'),(16,'南北',3,1,'2018-04-02 19:20:49'),(17,'住宅',4,1,'2018-04-02 19:20:49'),(18,'商业',4,1,'2018-04-02 19:20:49'),(19,'综合',4,1,'2018-04-02 19:20:49'),(20,'办公',4,1,'2018-04-02 19:20:49'),(21,'工业',4,1,'2018-04-02 19:20:49'),(22,'商品房',5,1,'2018-04-02 19:20:49'),(23,'经济适用房',5,1,'2018-04-02 19:20:49'),(24,'使用权',5,1,'2018-04-02 19:20:49'),(25,'公房',5,1,'2018-04-02 19:20:49'),(26,'其他',5,1,'2018-04-02 19:20:49'),(27,'有',6,1,'2018-04-02 19:20:49'),(28,'仅暖气',6,1,'2018-04-02 19:20:49'),(29,'仅燃气',6,1,'2018-04-02 19:20:49'),(30,'无',6,1,'2018-04-02 19:20:49'),(31,'在售',7,1,'2018-04-02 19:20:49'),(32,'待售',7,1,'2018-04-02 19:20:49'),(33,'售罄',7,1,'2018-04-02 19:20:49'),(36,'有效',8,1,'2018-04-02 19:20:49'),(37,'无效',8,1,'2018-04-02 19:20:49'),(38,'未跟进',8,1,'2018-04-02 19:20:49'),(39,'跟进中',8,1,'2018-04-02 19:20:49'),(40,'已上门',8,1,'2018-04-02 19:20:49'),(41,'已成交',8,1,'2018-04-02 19:20:49'),(42,'房地产经纪人',9,1,'2018-04-02 19:20:49'),(43,'独立经纪人',9,1,'2018-04-02 19:20:49');

/*Table structure for table `renren_data_stree` */

DROP TABLE IF EXISTS `renren_data_stree`;

CREATE TABLE `renren_data_stree` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `countryid` int(11) DEFAULT NULL COMMENT '市id',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='数据源 - 街道';

/*Data for the table `renren_data_stree` */

insert  into `renren_data_stree`(`id`,`name`,`countryid`,`status`,`created_at`) values (1,'未央区',1,1,'2018-03-19 16:45:53'),(2,'高新区',1,1,'2018-03-22 11:10:23');

/*Table structure for table `renren_house` */

DROP TABLE IF EXISTS `renren_house`;

CREATE TABLE `renren_house` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '唯一索引',
  `provinceid` int(11) DEFAULT NULL COMMENT '省id',
  `cityid` int(11) DEFAULT NULL COMMENT '城市id 对应data_city表的id',
  `typeid` int(11) DEFAULT NULL COMMENT '房源类型  对应data_select_default表id',
  `salestatusid` int(11) DEFAULT NULL COMMENT '现状 ，对应data_select_default表id ',
  `orientationid` int(11) DEFAULT NULL COMMENT '朝向id 对应data_select_default表id',
  `decoratestyleid` int(11) DEFAULT NULL COMMENT '装修风格  对应data_select 表id',
  `ownershipid` int(11) DEFAULT NULL COMMENT '权属id 对应 data_select_default的id',
  `purposeid` int(11) DEFAULT NULL COMMENT '用途id 对应data_select_default表id',
  `commissionid` int(11) DEFAULT NULL COMMENT '佣金规则id   对应data_select表id',
  `floorpostionid` int(11) DEFAULT NULL COMMENT '楼层位置 对应data_select表id',
  `hasdoublegasid` int(11) DEFAULT NULL COMMENT '双气id  对应data_select表id',
  `roomtypeid` int(11) DEFAULT NULL COMMENT '房型id  对应data_select表id',
  `iscommission` tinyint(1) DEFAULT '0' COMMENT '是否展示佣金 ，默认展示0，1展示 0不展示',
  `iselevator` tinyint(1) DEFAULT NULL COMMENT '是否有电梯 1有 0无',
  `ishome` tinyint(1) DEFAULT NULL COMMENT '是否推荐 1推荐 0不推荐',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '楼盘名称',
  `street` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '街道',
  `addr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '地址 地图的title',
  `fulladdr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '详细地址 地图的 address',
  `lng` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '经度',
  `lat` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '维度',
  `area` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '建筑面积  自定义',
  `covermap` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '封面图地址，只存放自定义的路径，不含域名 和 上传图片一级目录。',
  `floor` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '楼层',
  `opendate` datetime DEFAULT NULL COMMENT '开盘日期',
  `propertyfee` decimal(10,2) DEFAULT NULL COMMENT '物业费',
  `years` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '年代',
  `wide` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '面宽',
  `storey` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '层高',
  `depth` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '进深',
  `price` decimal(10,2) DEFAULT NULL COMMENT '单价',
  `total` int(11) DEFAULT NULL COMMENT '总价 int类型 四舍五入',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 手机端是否显示  1展示 0不展示',
  `adminid` int(11) DEFAULT NULL COMMENT '发布者id 对应后台用户admin表id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='房源';

/*Data for the table `renren_house` */

insert  into `renren_house`(`id`,`uuid`,`provinceid`,`cityid`,`typeid`,`salestatusid`,`orientationid`,`decoratestyleid`,`ownershipid`,`purposeid`,`commissionid`,`floorpostionid`,`hasdoublegasid`,`roomtypeid`,`iscommission`,`iselevator`,`ishome`,`name`,`street`,`addr`,`fulladdr`,`lng`,`lat`,`area`,`covermap`,`floor`,`opendate`,`propertyfee`,`years`,`wide`,`storey`,`depth`,`price`,`total`,`status`,`adminid`,`created_at`,`updated_at`,`deleted_at`) values (1,NULL,1,1,1,32,1,1,1,1,1,1,1,1,0,1,1,'aaaa','ffff','ddd','ddd',NULL,NULL,'ddd','ddd','ddd','2018-04-08 18:05:12','1.00','gg','dd','df','ff','33.00',33,1,1,'2018-04-08 18:05:32',NULL,NULL),(2,'fa7164edbf87cd6e8d3bc45ba3c2f8dd',1,1,1,33,2,1,1,2,1,2,1,1,1,1,0,'金色悦城','龙首街道','印象城','西安市龙首村印象城','108.9470100000','34.2928300000','20.66',NULL,'30/31','2018-04-10 07:33:11','150.00','2015年',NULL,NULL,NULL,'6700.00',NULL,1,NULL,'2018-04-10 07:33:11',NULL,NULL),(3,'dbc3ffa1620fba7ed3ff2eb72cab1357',1,1,2,32,2,1,1,2,1,2,1,3,1,1,1,'金色悦城02','龙首街道','印象城','西安市龙首村印象城','108.9470100000','34.2928300000','20.66',NULL,'30/31',NULL,'150.00','2015年',NULL,NULL,NULL,'6700.00',80,1,NULL,'2018-04-10 07:37:13',NULL,NULL),(4,'8f6de57045c626fa873a64c746003a10',1,1,3,33,2,1,1,2,1,2,1,NULL,1,1,1,'金色悦城03','龙首街道','印象城','西安市龙首村印象城','108.9470100000','34.2928300000','20.66',NULL,'30/31',NULL,'150.00','2015年','20米','3米','60',NULL,100,1,NULL,'2018-04-10 07:39:49',NULL,NULL),(5,'c1df6edc8486d10673cc7220172ee91f',1,1,1,32,2,1,1,2,1,2,1,1,1,1,0,'金色悦城04','龙首街道','印象城','西安市龙首村印象城','108.9470100000','34.2928300000','20.66',NULL,'30/31','2018-04-10 16:12:08','150.00','2015年',NULL,NULL,NULL,'6700.00',NULL,1,1,'2018-04-10 16:12:08',NULL,NULL),(9,'36254d1b8f0ec5911fba5e87dbff37cb',1,1,1,31,7,11,22,17,1,4,27,4,0,1,0,'无午','长安区盛世长安','盛世长安','陕西省西安市长安区西部大道与文苑北路交叉口','108.87663','34.16919','22',NULL,'22','2018-04-20 00:00:00','222.00','',NULL,NULL,NULL,'22.00',NULL,0,1,'2018-04-20 16:23:25',NULL,NULL),(10,'0ba03a653c6f6a69bd54de0310906c8a',1,1,1,31,7,11,22,17,1,4,27,4,0,1,0,'无午','长安区盛世长安','盛世长安','陕西省西安市长安区西部大道与文苑北路交叉口','108.87663','34.16919','22',NULL,'30','2018-04-20 00:00:00','222.00','2018-04-21',NULL,NULL,NULL,'22.00',NULL,0,6,'2018-04-20 16:28:49',NULL,NULL),(11,'618e5adbdda6c4a25d91595b307eb6b5',1,1,1,31,7,11,22,17,1,4,27,4,0,1,0,'公园一号','新城区宫园1号','宫园1号','陕西省西安市新城区未央路27号','108.94848','34.29173','80',NULL,'80','2018-04-27 00:00:00','8.00','2018-04-27',NULL,NULL,NULL,'9000.00',NULL,0,6,'2018-04-20 16:40:24',NULL,NULL),(12,'f500486d98a7280704b6849562556dd5',1,1,1,31,7,11,22,17,1,4,27,4,0,1,0,'车速','未央区海荣豪佳花园','海荣豪佳花园','陕西省西安市未央区凤城五路26号','108.94138','34.32835','60',NULL,'222','2018-04-26 00:00:00','99.00','2018-04-20',NULL,NULL,NULL,'500.00',NULL,0,6,'2018-04-20 19:57:18',NULL,NULL),(13,'a6bee8d57e5d89cd8372d15cbf8a1c19',1,1,1,31,7,11,22,17,1,4,27,4,0,1,0,'哈哈','未央区海荣豪佳花园','海荣豪佳花园','陕西省西安市未央区凤城五路26号','108.94138','34.32835','33',NULL,'33','0000-00-00 00:00:00','33.00','',NULL,NULL,NULL,'333.00',NULL,0,6,'2018-04-20 19:58:14',NULL,NULL),(14,'2beb67befc47ec6b6bbe08479a030bde',1,1,1,31,7,11,22,17,1,4,27,4,0,1,0,'哈哈','雁塔区东仪福利区','东仪福利区','陕西省西安市雁塔区东仪路29号','108.92951','34.20318','55',NULL,'22','2018-04-20 00:00:00','85.00','2018-04-20',NULL,NULL,NULL,'6555.00',NULL,0,6,'2018-04-20 20:03:07',NULL,NULL),(15,'911c6741adc714fea5481cfbe156130e',1,1,1,31,7,11,22,17,1,4,27,4,0,1,0,'车是的','碑林区东大街马场子第一公寓','东大街马场子第一公寓','陕西省西安市碑林区马厂子31','108.9612','34.25815','333',NULL,'333','2018-04-20 00:00:00','444.00','2018-04-20',NULL,NULL,NULL,'3333.00',NULL,0,6,'2018-04-20 20:04:35',NULL,NULL),(16,'17718eb63e7b691d8e9809110335d92c',1,1,1,31,7,11,22,17,1,4,27,4,0,1,0,'车的撒','雁塔区西安华城国际','西安华城国际','陕西省西安市雁塔区长安南路82号','108.94397','34.19102','55等哈',NULL,'22','0000-00-00 00:00:00','222.00','',NULL,NULL,NULL,'0.00',NULL,0,6,'2018-04-22 16:04:42',NULL,NULL),(17,'f070b1b97bd31be774fa78b57d368b22',1,1,1,31,7,11,22,17,1,4,27,4,0,1,0,'sggd','雁塔区美丽的院子','美丽的院子','陕西省西安市雁塔区丁白路西段92号','108.92335','34.21951','222',NULL,'22','0000-00-00 00:00:00','222.00','2018-04-22',NULL,NULL,NULL,'222222.00',NULL,0,6,'2018-04-22 18:33:49',NULL,NULL),(18,'2b903a83a4aecbd6523b944c837ec60d',1,1,1,31,7,11,22,17,1,4,27,4,0,1,0,'混合双打','未央区世融嘉城','世融嘉城','陕西省西安市未央区凤城四路与朱宏路十字东南角(36平方公里国家级公园东侧)','108.92606','34.32668','80','/house/18/ec84c6038d7f19a9497d0386bb144917.jpg','88','0000-00-00 00:00:00','80.00','2018-04-23',NULL,NULL,NULL,'8900.00',NULL,0,6,'2018-04-23 09:34:41',NULL,NULL),(19,'72a9e3dfedb5cc0a643312430cbbef54',1,1,1,31,7,11,22,17,1,4,27,4,0,1,0,'我去打球我','未央区文景苑','文景苑','陕西省西安市未央区凤城三路26','108.94223','34.32182','222','/house/19/26b63d70fc8c8fe9421df52132d3d9d1.jpg','22','0000-00-00 00:00:00','222.00','2018-04-23',NULL,NULL,NULL,'222.00',NULL,0,6,'2018-04-23 11:01:25',NULL,NULL),(21,'fc69587af82af96a7813b39d7a10c874',1,1,2,NULL,7,11,22,17,1,4,27,4,0,1,0,'省市','未央区龙首村华迪大厦','龙首村华迪大厦','陕西省西安市未央区未央路69号','108.9476','34.29713','222','/house/21/96c6c4cf199d3d4c14fedd9092383cf7.jpg','22',NULL,'22.00','2021',NULL,NULL,NULL,'222.00',89,0,6,'2018-04-23 11:51:32',NULL,NULL),(22,'dfdea7b3d1046377a36d70efa017a57e',1,1,3,NULL,7,11,22,17,1,4,27,NULL,0,1,0,'车上3eeeee','未央区老三届·首座大厦','老三届·首座大厦','陕西省西安市未央区未央路60号','108.94636','34.29475','500','/house/22/933c14ae1386cba248b64b6fa889d729.jpg','50',NULL,'3.00','2018','30','3','30',NULL,89,1,6,'2018-04-23 14:14:10',NULL,NULL),(23,'cd4bc5f4728085c2e59e342ac35ad40e',1,1,1,31,7,11,22,17,1,4,27,4,0,1,0,'万达广场','','','','','','22','/house/23/63d0cf243f798276d4fe0d1e5a61de23.jpg','33','0000-00-00 00:00:00','1.50','',NULL,NULL,NULL,'0.00',NULL,1,1,'2018-04-23 20:25:12',NULL,NULL),(24,'aedb54693484c70e82880e31909029db',1,1,1,31,7,11,22,17,1,4,27,4,0,1,0,'ki','','','','','','66','/house/24/922a8fd68348ab92c2c3a6c5a64474ec.jpg','6','0000-00-00 00:00:00','3.00','',NULL,NULL,NULL,'0.00',NULL,0,10,'2018-04-24 11:13:59',NULL,NULL),(25,'1f38d6b7cab9126bbc056f9680f5eddd',1,1,1,31,7,11,22,17,1,4,27,4,0,1,0,'万千瓦群','','','','','','66',NULL,'6','0000-00-00 00:00:00','6.00','',NULL,NULL,NULL,'0.00',NULL,0,10,'2018-04-24 21:53:04',NULL,NULL),(26,'a5391fbd41c6b0f4966aad104573172d',1,1,1,33,16,15,26,21,2,6,30,6,1,0,0,'哈哈','雁塔区西安华城国际','西安华城国际','陕西省西安市雁塔区长安南路82号','108.94397','34.19102','80','/house/26/36127277260f1b1b2c41436d5203a9f0.jpg','80','2018-04-24 00:00:00','22.00','2022',NULL,NULL,NULL,'0.00',NULL,1,6,'2018-04-24 22:55:38',NULL,NULL),(27,'211c93781510aa50d4068822f0f5205b',1,1,1,32,10,12,25,18,2,5,28,5,1,1,0,'测试1','未央区海璟·印象城','海璟·印象城','陕西省西安市未央区东二环与矿山路十字向东300米(西安煤矿机械厂正对面)','109.00219','34.30101','22','/house/27/a14b020f1aaad5986c4d97dd40acba75.png','20','2018-04-24 00:00:00','44.00','2014',NULL,NULL,NULL,'22.00',NULL,0,2,'2018-04-24 23:05:56',NULL,NULL),(28,'59088c9724747b6af4208c5f7b03c4ac',1,1,1,33,14,15,22,21,2,6,30,6,1,0,0,'无午','雁塔区无线电信局家属院','无线电信局家属院','陕西省西安市雁塔区长安南路杨家巷1号','108.94469','34.20466','2222',NULL,'222','2018-04-24 00:00:00','2222.00','2025',NULL,NULL,NULL,'22222.00',NULL,0,6,'2018-04-24 23:09:16',NULL,NULL);

/*Table structure for table `renren_house_home` */

DROP TABLE IF EXISTS `renren_house_home`;

CREATE TABLE `renren_house_home` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cityid` int(11) DEFAULT NULL COMMENT '城市id',
  `houseid` int(11) DEFAULT NULL COMMENT '房源信息id 对应house表的id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='房源 - 后台推荐显示';

/*Data for the table `renren_house_home` */

insert  into `renren_house_home`(`id`,`uuid`,`cityid`,`houseid`,`created_at`,`updated_at`,`deleted_at`) values (1,'1111111',11,1,'2018-04-09 17:19:45',NULL,NULL),(2,'222222',11,2,'2018-04-09 17:22:09',NULL,NULL);

/*Table structure for table `renren_house_image` */

DROP TABLE IF EXISTS `renren_house_image`;

CREATE TABLE `renren_house_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '唯一索引',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '图片路径',
  `title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `houseid` int(11) DEFAULT NULL COMMENT '房源id',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='房源 - 图片记录';

/*Data for the table `renren_house_image` */

insert  into `renren_house_image`(`id`,`uuid`,`url`,`title`,`houseid`,`created_at`,`updated_at`,`deleted_at`) values (1,NULL,'1.jpg','111',1,'2018-04-10 11:34:11',NULL,NULL),(2,NULL,'2.jpg','2222',1,NULL,NULL,NULL),(3,NULL,'3.jpg','333',2,NULL,NULL,NULL),(4,NULL,'4.jpg','444',2,NULL,NULL,NULL),(5,NULL,'5.jpg','555',3,NULL,NULL,NULL),(6,NULL,'6.jpg','666',3,NULL,NULL,NULL),(7,NULL,'7.jpg','777',4,NULL,NULL,NULL),(8,NULL,'8.jpg','888',4,NULL,NULL,NULL),(9,NULL,'9.jpg','99',5,NULL,NULL,NULL),(12,'452c0dcf17eae7a1c67b636f14398d86','/house/19/fdd2d562eaa85bdf9e6bde089a583871.jpg',NULL,19,'2018-04-23 11:01:43',NULL,NULL),(13,'758cda1ec73a488d665ffa0960609b75','/house/19/1d2adefec7f5ff4a1ad37ed5c5f70838.jpg',NULL,19,'2018-04-23 11:01:43',NULL,NULL),(14,'5e3b3eb395a89bedcd52c374b74cd985','/house/21/2b7c4e017699e61e688b0c3ef44c39e1.jpg',NULL,21,'2018-04-23 11:51:46',NULL,NULL),(15,'3313a1be7aacdb3cd7fe1d0d06bfb0de','/house/22/d9c8f98a18b977fbd68f7a40643602f3.jpg',NULL,22,'2018-04-23 14:14:31',NULL,NULL),(16,'742221c72d3902bda4190d09750b8083','/house/22/147ff454d2a6e16244eae3e5559d9866.jpg',NULL,22,'2018-04-23 19:53:25',NULL,NULL),(18,'0cdbfd861fa8799ba8e9e3e845dfcc9c','/house/23/0bf5e34c770b2c34ca2aad3ccfdd658f.jpg',NULL,23,'2018-04-23 20:25:52',NULL,NULL),(19,'c2028e2d903f1ae21c15e599470f2074','/house/23/d4d9779e44c410169f3002f7b46ec46f.jpg',NULL,23,'2018-04-24 11:53:38',NULL,NULL),(21,'1ad667b1305e0119c771151289f3e860','/house/23/564ca92113514fdc09cf493ac0c2e661.png',NULL,23,'2018-04-24 13:41:00',NULL,NULL),(22,'572935b2762e36a2c855fd2233ca0c6b','/house/24/544a28a1da29d8ce4fa6b1293c68123e.jpg',NULL,24,'2018-04-24 13:45:02',NULL,NULL),(23,'1507113fcba3274ccdcb447b265ca01c','/house/24/d432588ebe84f1ee3664a4b636f75492.jpg',NULL,24,'2018-04-24 13:45:02',NULL,NULL),(24,'8eb5282c748e9466e3a203687565f74e','/house/26/eb6a465ff28f94ec3a3da3a90153cdae.jpg',NULL,26,'2018-04-24 22:56:16',NULL,NULL),(25,'c9fb87f598a067d5b74b03fb26a36716','/house/26/00a7f6268e4be6e668fea93d60b65d15.jpg',NULL,26,'2018-04-24 22:56:16',NULL,NULL),(26,'d9fa9e6d913ffc53b1d850621a54a7ea','/house/26/7d378bf282076d5330c5286c2e0940a1.jpg',NULL,26,'2018-04-24 22:56:16',NULL,NULL),(33,'97e1ff2bc923d1be4604c044b83211fb','/house/27/d1ea1ee097713115fa488bb1fbd75c85.jpg',NULL,27,'2018-04-24 23:06:40',NULL,NULL);

/*Table structure for table `renren_house_tag` */

DROP TABLE IF EXISTS `renren_house_tag`;

CREATE TABLE `renren_house_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '唯一索引',
  `tagid` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '特色id  对应data_select表id',
  `houseid` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '房屋信息id 对应house表id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='房源 - 特色标签';

/*Data for the table `renren_house_tag` */

insert  into `renren_house_tag`(`id`,`uuid`,`tagid`,`houseid`,`created_at`,`updated_at`) values (1,'cc1e9b7a17d2176069bf112bb2a62b15','20','1',NULL,NULL),(2,'dd3c047812fd6785618e9618994fb1f5','21','1',NULL,NULL),(3,'1dddd4f57dbee08ddb36da5ad0153337','22','1',NULL,NULL),(4,'5ebea204b452272a2cdd91c590ac9ab5','23','2','2018-04-10 08:05:43','2018-04-10 08:05:43'),(5,'a6ec7255690ca59d7a58224d21a59366','34','2','2018-04-10 08:05:43','2018-04-10 08:05:43'),(6,'ecc356016456b248d602c96258bd136b','25','2','2018-04-10 08:05:43','2018-04-10 08:05:43'),(7,'b211b5a090df92540ad4c6bb52381698','26','3','2018-04-10 08:08:16','2018-04-10 08:08:16'),(8,'e6301785968753999036a30f0dfa0e32','27','3','2018-04-10 08:08:16','2018-04-10 08:08:16'),(9,'703c50daf88b777483d02233fae60d11','28','3','2018-04-10 08:08:16','2018-04-10 08:08:16'),(10,'d71e1e54564c8df1ecbef854cc993304','29','4','2018-04-10 08:09:15','2018-04-10 08:09:15'),(11,'5cd42a8a98ea419f6a577f006e4f8df8','22','4','2018-04-10 08:09:15','2018-04-10 08:09:15'),(12,'b7d5ea0940f9d4b889cd72c8873595ef','23','4','2018-04-10 08:09:15','2018-04-10 08:09:15'),(13,'802945846a01dca8a6e69524370a7abb','1','5','2018-04-10 08:10:11','2018-04-10 08:10:11'),(14,'5026f6c211898212ede3486406bb2cec',NULL,NULL,NULL,NULL),(31,'4231d438debb348e6397377d85bbb889','22','16',NULL,NULL),(32,'88abc29f87d507872aedc889b23d281d','29','16',NULL,NULL),(33,'06d22e9c44fcf04d276b3ef0d301a9f0','35','16',NULL,NULL),(34,'b5ce070853a975784d5ec7b66b497773','40','16',NULL,NULL),(35,'fc0c96166f34ea48280cd31a09e4ec05','34','16',NULL,NULL),(36,'f24b6de2d956c200e91c87dbac951a8a','22','16',NULL,NULL),(37,'432afbeea557e5884943fe2b5a6db252','29','16',NULL,NULL),(38,'09320071bc6032f0dad74f5326f4cf08','35','16',NULL,NULL),(39,'2da30cea8f2b70201e065f47be55c2a7','40','16',NULL,NULL),(40,'d303aa7e8801abc8624356cc410f3f91','34','16',NULL,NULL),(41,'5bef64647d9b71f1cecbfe4bc4c1d647','22','17',NULL,NULL),(42,'4551b3b4748ef53500c143bc19677c07','23','17',NULL,NULL),(43,'e4663253d901b71a01826c3a4f3afe09','22','17',NULL,NULL),(44,'fb73bb2055df8de2f3a8eccedf02e860','23','17',NULL,NULL),(45,'6f43d34de924e5fa5a7ea8ca6029dcf7','29','17',NULL,NULL),(46,'68171affe9d5ed4858e8f0ca4419a7ca','29','17',NULL,NULL),(47,'3e974a28443501f12f02a7009e0e1132','35','17',NULL,NULL),(51,'a5f39dc344c2357b0963e436f35f1f3f','28','19',NULL,NULL),(52,'d1e7ada0a456971e1235cf2cd95e672c','34','19',NULL,NULL),(53,'3d32f562bf75777e655b5393d6a4c5d1','33','19',NULL,NULL),(54,'107550f4965d9e3d3b3a384542533445','29','19',NULL,NULL),(55,'4052a25d24d1ed993a1cd78fb6da7165','24','19',NULL,NULL),(56,'3684c9c8db66d4bb8ed187fb07749916','21','19',NULL,NULL),(57,'7c1537fef7dc245fbb02935f0cefa549','22','21',NULL,NULL),(58,'00e894fa703cb1be5ea44fd45692cd2e','28','21',NULL,NULL),(59,'eb0082abd398a3ada8d5134fd6663f94','28','22',NULL,NULL),(60,'b1beceac8e35681927b2add2b2bce95f','29','22',NULL,NULL),(61,'f3c905ad4b2cdc9c85171d0dd2123349','24','22',NULL,NULL),(63,'f8c9d8bec564335c8f664e64a48bc25d','23','23',NULL,NULL),(64,'5db2020cdac1ff84c8a38b9cc7864363','24','23',NULL,NULL),(65,'1f3a20d2e77e53fde7f6ff6030a7ab97','25','23',NULL,NULL),(66,'fe55c2491d068ab7cd839b7f35a0d206','21','23','2018-04-24 10:56:05','2018-04-24 10:56:05'),(67,'e7623cd9d88a0b42a1d350666ea9db66','20','23','2018-04-24 10:56:05','2018-04-24 10:56:05'),(68,'a6a1437a59bf48e68e115fbf3a18ae7e','28','23','2018-04-24 10:58:58','2018-04-24 10:58:58'),(69,'e2bbf6e07e81f9010f0ad2321b23610d','27','24',NULL,NULL),(70,'543f4cac0283a00201d16a108a17ed40','28','24',NULL,NULL),(71,'cef48d1fd1f6b6eef4a273e09fb9c900','29','24','2018-04-24 13:44:45','2018-04-24 13:44:45'),(72,'03b21a97fbcf0221675bff1c2ddd9743','30','24','2018-04-24 21:46:09','2018-04-24 21:46:09'),(73,'e788944708bdcffd7003626b6ec51c1f','23','25',NULL,NULL),(74,'e1d65a6c19ad41e046a6567c3b8c02ab','24','25',NULL,NULL),(75,'640c4b0be57a74155886b6a55e8304d7','22','25',NULL,NULL),(76,'bce000ebabc6f2d1db9b46a0f3a49caf','21','25',NULL,NULL),(77,'eca05930f71f4c3c6ee96ae1ab4e7b71','27','25',NULL,NULL),(78,'1cb4146a48d973a829ec433c64dfb4f2','28','25',NULL,NULL),(79,'6e411c0c7f7d29adecb3ecb1f1c01b36','21','26',NULL,NULL),(80,'b799e58d9a7fd6422043badebb8e4744','27','26',NULL,NULL),(81,'cbd8db753d435218bdc29162e2021d15','34','26',NULL,NULL),(82,'a74e2a0fa74ce5f82f99dbd9daf040ff','29','26','2018-04-24 23:03:45','2018-04-24 23:03:45'),(83,'3f31ad7685cf128fd602795ba538d275','23','27',NULL,NULL),(84,'a4319e4b7d6ce5ff84ceb60cb309739d','29','27',NULL,NULL),(85,'132015158d0349b0d316fecf50dcd3d3','35','27',NULL,NULL),(86,'be39cd9712c016e2f30e149abe91762a','36','27',NULL,NULL),(87,'ce924bb0cb8916be6a78b050a1ff3059','34','27',NULL,NULL),(88,'c7ac7651555727720a096547b7b70acd','28','27',NULL,NULL),(89,'573055b0171737fdc1b11d9664ec551e','29','28',NULL,NULL),(90,'776b0d07ab015ce66a10f2220a08d562','34','28',NULL,NULL);

/*Table structure for table `renren_role` */

DROP TABLE IF EXISTS `renren_role`;

CREATE TABLE `renren_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '姓名',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '公司id 对应公司表company的id',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 1可用 0 不可用',
  `isdeafult` tinyint(1) DEFAULT '0' COMMENT '是否默认 1默认 0非默认 ， 默认的不能删除',
  `islook` tinyint(1) DEFAULT '1' COMMENT '是否可以全部 0全部 1个人',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='角色';

/*Data for the table `renren_role` */

insert  into `renren_role`(`id`,`uuid`,`name`,`status`,`isdeafult`,`islook`,`created_at`,`updated_at`) values (1,'4a7fd8cb371511e89ce094de807e34a0','管理员',1,1,1,'2018-04-03 16:02:01',NULL),(2,'4a800506371511e89ce094de807e34a0','操作员a',1,1,1,'2018-04-03 16:02:01','2018-04-10 06:23:08'),(3,'4a8008b0371511e89ce094de807e34a0','业务员',1,1,1,'2018-04-03 16:02:01',NULL),(4,'90652f05bd4a0c3ee5c52e052d1847d7','aaaaa',1,0,1,'2018-04-04 06:11:12',NULL),(5,'f553f771190178179cc082bd1ba3435c','aaaaa',1,0,1,'2018-04-04 06:12:47',NULL),(6,'a5fb23066848591fbe595c405bc8747c','test2222',1,0,1,'2018-04-24 14:08:21',NULL),(7,'607ff6e3c648e77c126671c4b5287d79','testUser',1,0,1,'2018-04-24 14:09:55',NULL),(8,'9bb08063c026621a0603117b3cd93128','测试角色',1,0,1,'2018-04-24 14:12:52',NULL),(9,'f8dd25b2f0e4475c2f08ae702363eaca','辅导费',1,0,1,'2018-04-24 14:15:16',NULL),(10,'34ad6b303093c2910faaf93473964860','格瑞特',1,0,1,'2018-04-24 14:16:35',NULL),(13,'5e430d8f1c1be4053038ae0944dcecc7','yyy',1,0,1,'2018-04-24 22:55:10',NULL),(14,'00c5410a79c98357e511369227da3c71','yyyyy',1,0,1,'2018-04-24 23:02:30',NULL),(15,'75cca3ec0f559591751d30a63dc1d54b','fdf',1,0,1,'2018-04-24 23:03:18',NULL),(16,'368297b21ab462e7182ad9bfb3f1afde','aaaa',1,0,1,'2018-04-24 23:25:35',NULL);

/*Table structure for table `renren_role_function` */

DROP TABLE IF EXISTS `renren_role_function`;

CREATE TABLE `renren_role_function` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '姓名',
  `roleid` int(11) DEFAULT NULL COMMENT '角色id 对应role表id',
  `functionid` int(11) DEFAULT NULL COMMENT '功能id 对应功能表function的id',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 1可用 0 不可用',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='角色 - 功能';

/*Data for the table `renren_role_function` */

insert  into `renren_role_function`(`id`,`uuid`,`roleid`,`functionid`,`status`,`created_at`) values (1,'39d3dc00-3a73-11e8-80a6-54e1adc5',1,0,1,'2018-04-07 22:52:00'),(2,'38b8c6f02853ac2903e34a02553e2c92',4,4,1,'2018-04-12 01:00:54'),(3,'9b1a7b04f1bd5e7b61412a0eafe69b6f',4,400,1,'2018-04-12 01:00:54'),(4,'008fcd4801b80268592f0a8082272cb6',4,410,1,'2018-04-12 01:00:54'),(5,'f2d77fc8b347d3eb64c75209e2531411',4,420,1,'2018-04-12 01:00:54'),(6,'425ece4f4ff6606c2b8c2e6c0dc5698b',4,401,1,'2018-04-12 01:00:54'),(7,'a7d961988c8ef7010789b9cc77823d26',4,402,1,'2018-04-12 01:00:54'),(8,'1382d32042ce3a96b2983b8d404d2dc0',4,403,1,'2018-04-12 01:00:54'),(9,'0ba2ccae14d13c1d3bb2c62d1f5bc125',4,404,1,'2018-04-12 01:00:54'),(10,'a7b3384790dc5b391b457f4a142b7dd0',4,405,1,'2018-04-12 01:00:54'),(11,'2d28abefdfeea772810bf4efd1cc542c',4,411,1,'2018-04-12 01:00:54'),(12,'60ad6da8055dcec146eeac2ccd40e850',4,412,1,'2018-04-12 01:00:54'),(13,'d22e84460e7c051ba5ce4636af0790e2',4,413,1,'2018-04-12 01:00:54'),(14,'e6edc5daaea7102aa15aadb8c751dd10',4,414,1,'2018-04-12 01:00:54'),(15,'df427e90618228d7a3c2d4b347a21897',4,415,1,'2018-04-12 01:00:54'),(16,'3503bae108a04cb8aa5529dedbc85446',4,421,1,'2018-04-12 01:00:54'),(17,'46315c7379573d7fe07f15d77d26a28f',4,422,1,'2018-04-12 01:00:54'),(32,'9db6aa2c467a86d768d302d55d5cd5a0',2,700,1,'2018-04-24 22:15:28'),(33,'dd2e770dc2389b2400cb5321e0958ad2',2,701,1,'2018-04-24 22:15:28'),(34,'107e3be2dad6c75471a11fd829587ebc',2,702,1,'2018-04-24 22:15:28'),(35,'b89ccb2b8f7c5745495d7f44c1b20936',2,800,1,'2018-04-24 22:16:13'),(36,'be77df616138574dc989b9b304068288',2,801,1,'2018-04-24 22:16:13'),(37,'45e834f5aed730820cc792f6e9bee956',2,802,1,'2018-04-24 22:16:13'),(38,'abc8c4af6d986a48a99836216cd124c7',2,803,1,'2018-04-24 22:16:13'),(39,'a14b60b42069152afbf510b0af572cb9',2,804,1,'2018-04-24 22:16:13'),(40,'d9e917c902572c653c46f3b23d84ad98',2,805,1,'2018-04-24 22:16:13'),(41,'dccf51d9b467dba235704373ab47200d',2,806,1,'2018-04-24 22:16:13'),(56,'afd4e415bb2c2681419ec40e5cb89d35',14,100,1,'2018-04-24 23:02:50'),(57,'b968dc1b9a09dedca62932c66c1d41cb',14,101,1,'2018-04-24 23:02:50'),(58,'bd255384ac40a4bc2180d4ca4a580bca',14,102,1,'2018-04-24 23:02:50'),(59,'3b18f3db0e77a90d9173815b45607daa',14,103,1,'2018-04-24 23:02:50'),(60,'dc6244d6255d50ccb4733e09a1375934',14,104,1,'2018-04-24 23:02:50'),(61,'e62f17405e5986c026ca00fffad06b57',14,105,1,'2018-04-24 23:02:50'),(62,'c4345341b4e3135e98755d0b110d66ce',14,106,1,'2018-04-24 23:02:50'),(63,'a59b7ced91dc5040f6fda0f2b5ac9ac0',14,107,1,'2018-04-24 23:02:50'),(64,'f4826d8b176b3d61bb6d6081b8f5ec78',14,108,1,'2018-04-24 23:02:50'),(65,'822adba21326c2edb2dc1a0767f031cd',14,200,1,'2018-04-24 23:02:50'),(66,'ca10054f3036499f684206137bc4ac02',14,201,1,'2018-04-24 23:02:50'),(67,'a45edfb5e10d3616e8b8af55aaa2f6c5',14,202,1,'2018-04-24 23:02:50'),(68,'ec4f926a94ebae9cfa5b030a6f0a739a',14,203,1,'2018-04-24 23:02:50'),(69,'1bbab089ae38289b53b2b87a55d05838',14,204,1,'2018-04-24 23:02:50'),(70,'47549ce59071eca372d97ae86e65488a',14,205,1,'2018-04-24 23:02:50'),(71,'90150cdc57891a3828054b7c166ae5e1',14,300,1,'2018-04-24 23:02:50'),(72,'9bc0dce1936c4eb714950107c7553b53',14,301,1,'2018-04-24 23:02:50'),(73,'c86439a0adc3bf85c1d2a1e8a1482ac6',14,302,1,'2018-04-24 23:02:50'),(74,'237541b0bbd555817f865867ebd05114',14,303,1,'2018-04-24 23:02:50'),(75,'3f19f078d72b5300a00bc1c9a427f034',14,304,1,'2018-04-24 23:02:50'),(76,'7479190d948512f78a41642d20be26ee',14,305,1,'2018-04-24 23:02:50'),(77,'a70158d60f9bb08eeae51b873718537f',14,306,1,'2018-04-24 23:02:50'),(78,'dffe5450cb111eeaaa2c0da1b6df92e7',14,307,1,'2018-04-24 23:02:50'),(79,'e01ab375320da5cf1653705821c80322',14,308,1,'2018-04-24 23:02:50'),(80,'811018caabe58e1d09af8653aee78f19',14,400,1,'2018-04-24 23:02:50'),(81,'d9261574d695f7ae0f101797dce86ca7',14,401,1,'2018-04-24 23:02:50'),(82,'b2251cd8018cdc5ede7427a2f233a8b1',14,402,1,'2018-04-24 23:02:50'),(83,'8e92b235bd76b715a689170c84f5d0e6',14,403,1,'2018-04-24 23:02:50'),(84,'77b649f26b861f491082cf5a6b79cc94',14,404,1,'2018-04-24 23:02:50'),(85,'7a7d0f6c87a4f06b17ede9f6df14d149',14,405,1,'2018-04-24 23:02:50'),(86,'a3ffafb88f2025cd410f9dc68dc8f4af',14,406,1,'2018-04-24 23:02:50'),(87,'9196ce6eade80949fa1075934f8734b2',14,407,1,'2018-04-24 23:02:50'),(88,'54906b4f826914f21a75d74b9651c33a',14,500,1,'2018-04-24 23:02:50'),(89,'038b2d2a6f8d748b366f2c90a71cdaf2',14,501,1,'2018-04-24 23:02:50'),(90,'bc226cd75ac5bc9466d5bbca11432a96',14,502,1,'2018-04-24 23:02:50'),(91,'e6e3ba19eb808b63bbe70313bbf685e6',14,503,1,'2018-04-24 23:02:50'),(92,'85be248b9cead4bf658059c0cd72c10f',14,504,1,'2018-04-24 23:02:50'),(93,'96300ef6aebd06c9ed82cb46f6a325ab',14,505,1,'2018-04-24 23:02:50'),(94,'0739facef22e6cc585d4a287e2f892e0',14,600,1,'2018-04-24 23:02:50'),(95,'be7269c0524f084fb6b8d6ded8b30739',14,601,1,'2018-04-24 23:02:51'),(96,'cf47c25a48bb134328eccab47bc7df28',14,602,1,'2018-04-24 23:02:51'),(97,'63454143da74968f1ead68c15d8fd394',14,700,1,'2018-04-24 23:02:51'),(98,'c4a9fb6249c39eca7118c30f00ba6fd6',14,701,1,'2018-04-24 23:02:51'),(99,'011fe741a3d4c1ed5d7dc6539b772ae8',14,702,1,'2018-04-24 23:02:51'),(100,'5a39216c3332eeee4e348b325ed5963d',14,800,1,'2018-04-24 23:02:51'),(101,'0001bb6f62ddd31a3684d65ec153c7f0',14,801,1,'2018-04-24 23:02:51'),(102,'8fe89fd44b5012541534db890c09359a',14,802,1,'2018-04-24 23:02:51'),(103,'e1876776768ac6183f64ed10efcef6c1',14,803,1,'2018-04-24 23:02:51'),(104,'8529cf7e1b021e200fe89f65f4b2f655',14,804,1,'2018-04-24 23:02:51'),(105,'ff2604aee858db11fe860356b383889d',14,805,1,'2018-04-24 23:02:51'),(106,'d2f81961f22fc0dda8ec588cb47cd18f',14,806,1,'2018-04-24 23:02:51'),(114,'8a1bcdd56c504f02395c09388b356406',6,800,1,'2018-04-24 23:05:09'),(115,'06c1d1a12164f5f3c761a3dd00bacdcf',6,801,1,'2018-04-24 23:05:09'),(116,'d83ca0d5a8cac40cb9552e6968d7d1aa',6,802,1,'2018-04-24 23:05:09'),(117,'dd41306c66b585fc492201e214d69f26',6,803,1,'2018-04-24 23:05:09'),(118,'d611c63cab9f30fb497cdc24a86a1851',6,804,1,'2018-04-24 23:05:09'),(119,'4f11ab79daf89957a75b3c58fcfe2140',6,805,1,'2018-04-24 23:05:09'),(120,'627077a917df5828c624872ac5de26a4',6,806,1,'2018-04-24 23:05:09'),(121,'4f22c2bdf84e7d41a3f6d9836eb5d952',4,600,1,'2018-04-24 23:05:31'),(122,'9a188930e996059d04a12cdc0bd0dc55',4,601,1,'2018-04-24 23:05:31'),(123,'00daa32cac26f09fbd8895249ae0093d',4,602,1,'2018-04-24 23:05:31'),(124,'a97e5a5760d3411f4ecf9675de7336ed',5,700,1,'2018-04-24 23:07:08'),(125,'e17a5064784fa644e23fc92e18efa01c',5,701,1,'2018-04-24 23:07:08'),(126,'f7514dc9ccd34b8fe688c0491c3be91d',5,702,1,'2018-04-24 23:07:08'),(127,'7a29a2ba0815d3bb8ab88199cf0b5a83',5,500,1,'2018-04-24 23:09:02'),(128,'3a313e9f1999ff18d6f8e0954cfbf445',5,501,1,'2018-04-24 23:09:02'),(129,'0572dc421da8a84bd0bc246ebc6c294c',5,502,1,'2018-04-24 23:09:02'),(130,'17a15ae3e65790fb2154afde238537ba',5,503,1,'2018-04-24 23:09:02'),(131,'e7587163de34da6315fd63442d82005b',5,504,1,'2018-04-24 23:09:02'),(132,'ed7b67283d229a1b827ccaf1b3215a09',5,505,1,'2018-04-24 23:09:02');

/*Table structure for table `renren_user` */

DROP TABLE IF EXISTS `renren_user`;

CREATE TABLE `renren_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '唯一索引',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id 对应公司表company的id',
  `nickname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '姓名',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '账号',
  `mobile` char(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '手机号',
  `password` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '密码',
  `economictid` tinyint(4) DEFAULT NULL COMMENT '经纪人类型id 对应data_select_default表id',
  `isadminafter` tinyint(1) DEFAULT '0' COMMENT '是否后端创建过来的 1是 0不是',
  `adminid` int(11) DEFAULT NULL COMMENT '后端用户id 对应admin表id',
  `wechatopenid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '微信openid',
  `wechatbackstatus` tinyint(1) DEFAULT '0' COMMENT '微信找回密码绑定后返回的状态id  1成功 0未进行',
  `faceimg` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '微信头像',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态  1可用 0不可用',
  `created_at` datetime DEFAULT NULL,
  `updated_at` date DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='经纪人';

/*Data for the table `renren_user` */

insert  into `renren_user`(`id`,`uuid`,`companyid`,`nickname`,`name`,`mobile`,`password`,`economictid`,`isadminafter`,`adminid`,`wechatopenid`,`wechatbackstatus`,`faceimg`,`status`,`created_at`,`updated_at`) values (1,'5179a20a439d11e8920894de807e34a0',1,'何雄伟','hxw','18602963711','00b8a2b07952ad41131c65e64ee51056',42,1,1,NULL,0,NULL,1,'2018-04-19 14:45:59',NULL),(2,'5179c903439d11e8920894de807e34a0',1,'业务员','ywy','15000000000','00b8a2b07952ad41131c65e64ee51056',42,1,10,NULL,0,NULL,1,'2018-04-19 14:45:59','2018-04-12'),(3,'5179cbc2439d11e8920894de807e3888',1,'舒全刚','sqg','15094014444','00b8a2b07952ad41131c65e64ee51056',42,1,6,'oPso81XmC312cF6YBSifXHeKu5-w',0,'http://thirdwx.qlogo.cn/mmopen/vi_32/BZROGkDG04ibOyfGcic8dcrYXpPKU4Eic2ls0KazPaTnVtibGfYDPOU7XKOz0w7ibKC9iaFQbYichyEgVruiaQeAMoiab4g/132',1,'2018-04-19 14:45:59',NULL),(4,'5179cd16439d11e8920894de807e34a0',1,'田英敏','tym','18691895593','00b8a2b07952ad41131c65e64ee51056',42,1,5,'',0,NULL,1,'2018-04-19 14:45:59','2018-04-19'),(5,'5179ce3e439d11e8920894de807e34a0',1,'赵颖','zy','18291846993','00b8a2b07952ad41131c65e64ee51056',42,1,3,'',0,NULL,1,'2018-04-19 14:45:59',NULL),(6,'5179cf69439d11e8920894de807e34a0',NULL,'凡凡','fan','15002960374','00b8a2b07952ad41131c65e64ee51056',43,NULL,NULL,'',0,NULL,1,'2018-04-19 14:45:59','2018-04-18'),(7,'5179d086439d11e8920894de807e34a0',1,'单莉娜','shanlina','18092013097','00b8a2b07952ad41131c65e64ee51056',42,1,2,'',0,'http://img.sccnn.com/bimg/338/48220.jpg',1,'2018-04-19 14:45:59','2018-04-18'),(8,'5179d19d439d11e8920894de807e34a0',1,'何文荣','hwr','18093378259','00b8a2b07952ad41131c65e64ee51056',42,1,9,'',0,NULL,1,'2018-04-19 14:45:59',NULL),(9,'5179d2c4439d11e8920894de807e34a0',NULL,'张三','zs','15769157467','00b8a2b07952ad41131c65e64ee51056',43,0,NULL,NULL,0,NULL,1,'2018-04-19 14:45:59',NULL),(10,'b34d42af4e40ab8adf7adc6059670254',NULL,'是的',NULL,'15064525668',NULL,43,0,NULL,'',0,'',1,NULL,NULL),(11,'10fe7cf3dfa90cf96f6d2719ff9b3453',NULL,'的服务器嗯',NULL,'15032012558',NULL,43,0,NULL,'',0,'',1,NULL,NULL),(13,'4ec87a84367fe95d21b5d050cd3302ee',NULL,'等哈我',NULL,'15094014147',NULL,43,0,NULL,'oPso81XmC312cF6YBSifXHeKu5-w',0,'',1,NULL,NULL),(14,'588ee18eb505ad2279a3befdb350b14a',NULL,'田噢',NULL,'15769157460',NULL,43,0,NULL,'oPso81cfpiXVSYujB0Yu6dLPBuE4',0,'',1,NULL,NULL),(15,'4b60cc05ae228e32209d1ec0ab9dc866',1,'test','testadmin','15894569874','xxs111111',42,1,11,NULL,0,NULL,1,'2018-04-23 11:44:52',NULL),(16,'1c915494eecca43126b0f58b4f666d8e',1,'test1','testadmin2','15894589478','xxs111111',42,1,12,NULL,0,NULL,1,'2018-04-23 11:57:26',NULL),(17,'855bb6454ed831b8d630a42ba4ed3eb5',1,'test2','testadmin3','15894589479','xxs111111',42,1,13,NULL,0,NULL,1,'2018-04-23 11:58:30',NULL),(18,'21745924aeaa038eadd154310bc5c3ae',1,'aaac','aacd','15894857845','xxs111111',42,1,14,NULL,0,NULL,1,'2018-04-23 11:59:05',NULL),(19,'d203e7116a98cd1bf7492f37178e3eed',1,'bbc','testbbc','15895698987','xxs111111',42,1,15,NULL,0,NULL,1,'2018-04-23 11:59:48',NULL),(20,'3a56ef3c1cd922e7f6dbf51211413449',1,'testaac','testaac','15894587895','xxs111111',42,1,16,NULL,0,NULL,1,'2018-04-23 12:01:10',NULL),(21,'5a89bf9674f20e1aadd58a950e529fda',1,'testTest','testTest','15894587897','xxs111111',42,1,17,NULL,0,NULL,1,'2018-04-23 13:39:28',NULL),(22,'550bd99d4741a44370b3031a3947cf33',1,'ggg','ggg','15894589784','xxs111111',42,1,18,NULL,0,NULL,1,'2018-04-23 14:09:41',NULL),(23,'3023960cf61751a6e6bb8dff1490d912',1,'test4','test4','15987847848','xxs111111',42,1,19,NULL,0,NULL,1,'2018-04-23 14:10:49',NULL),(24,'7345b1cd7307b871c7839f87bcffb082',1,'test5','test5','15565659898','xxs111111',42,1,20,NULL,0,NULL,1,'2018-04-23 14:12:26',NULL),(25,'5ec25cd92c7dbfbcea52d5371290b32c',1,'test6','test6','15656565656','xxs111111',42,1,21,NULL,0,NULL,1,'2018-04-23 14:14:10',NULL),(26,'a47abe9fccacfa114b1eecd29a5fbc9c',1,'fsdh','sfsfsdf','15002960388','xxs111111',42,1,22,NULL,0,NULL,1,'2018-04-24 22:38:58',NULL),(27,'085380623ee047ed7c43c59e64bd36cf',1,'tesdt','sssss','15689487874','xxs111111',42,1,23,NULL,0,NULL,1,'2018-04-24 22:44:09',NULL);

/*Table structure for table `renren_user_token` */

DROP TABLE IF EXISTS `renren_user_token`;

CREATE TABLE `renren_user_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '唯一索引',
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '生成的token',
  `expiration` int(11) DEFAULT NULL COMMENT '过期时间',
  `userid` char(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '用户id  或admin id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户 - token';

/*Data for the table `renren_user_token` */

insert  into `renren_user_token`(`id`,`uuid`,`token`,`expiration`,`userid`,`created_at`,`updated_at`) values (2,'494297eb0681ffbae0e6f3ab5ad4531f','asKBRU7LExZMwC223tmCSi725Wkn7mZaq47caE3VJinMecEc5ffNYD6PRQYU',1523262624,'1','2018-04-08 03:03:12','2018-04-09 06:30:24'),(3,'3924f4494facadfe8a5b3a53617625af','uy09LDQmYPtOlbPvRI4JlEfcMJBu2qeAoggqNHdLg8wM60YZEx8dbsvvRC1H',1524148579,'4','2018-04-09 07:45:45','2018-04-19 20:36:19'),(4,'fa19d521e8d975a11e74ca0d6dd0f8cd','DmY4ZVfvp4GLRMVW9jFy9NVdQozm4QsDLKd1LwM1KlFZTCZvle6WsvZB0TEg',1524153344,'7','2018-04-09 10:40:11','2018-04-19 21:55:44'),(5,'621d2b4f404a5626dbfdd81e2561025d','MSbAECUM7dfeCAmz6nZWb1TcBPbGsUnyItRtniUf21OrfLk4LG2v9KXdj34v',1524586701,'3','2018-04-16 15:35:12','2018-04-24 22:18:21'),(6,'ae16ee14a1db5dbcbf9221f98a11013b','CM4Hj3hspECArrNfBoEWb5KzRKfpbl1RIF3hoZvHgc4QR0SbL29UWIkxXprE',1524143054,'6','2018-04-16 19:11:34','2018-04-19 19:04:14'),(7,'e06f937261e3cc50a2a810bbf017fb41','6ku4sLOTaoVUVTFFn8xQMcSRj4dOzs8qHmBlzzjjQgArzw1C89isjzK4kkTG',1524201870,'5','2018-04-17 21:18:03','2018-04-20 11:24:30'),(8,'d67b03362337e3deb580e62015977591','7ca2CNsCF9QNxiJ0QLPyS7eNy2tJjT64zAiiZR4RXXuqE3PaVjqXo9vMXoJd',1524142677,'9','2018-04-19 14:51:39','2018-04-19 18:57:57'),(9,'68febadc1050c5c783fd4fa1afd10676','ftaqmO1w3qFGBfldYTaTsGPEg51xOUR0jfuH13gp7EjEBeX9mGrNteaFOjyQ',1524388994,'10','2018-04-22 15:20:37','2018-04-22 15:23:14'),(10,'64c9c6532e3e33c5eabf404b98b49e92','Xr1TqJm5HZwy5s2gcUEe5odtVm9aYokDmDP4EZvpJSVhIuNGaUfc7cy5MPHe',1524393439,'11','2018-04-22 16:37:19','2018-04-22 16:37:19'),(11,'506ca48c1eb42dd0de2a7b31d5744bb1','uZDstRR1E6GFgkfkR0jAVSd3NSstiNF4dsHLDDbZbiMymTnUffHUKwXZxCF9',1524395551,'12','2018-04-22 16:45:58','2018-04-22 17:12:31'),(12,'e7655a1f7f6865d181c60c8dc2e71976','mIlOVQtnHt9RP2jF0f4IrIuwDJtOHfFmU57DmAiBPBoH7TfjnhmRxbjXM1Vz',1524396450,'13','2018-04-22 17:27:30','2018-04-22 17:27:30'),(13,'d31affb9869dab8c9cc65d323933b5ab','vhmKFqFCtIErNny4ej3VQCWWxR13pvY3C8FL2B1DhvLjq1qmxN0NeaLJAeYq',1524399019,'14','2018-04-22 18:00:19','2018-04-22 18:10:19');

/*Table structure for table `renren_web_conf` */

DROP TABLE IF EXISTS `renren_web_conf`;

CREATE TABLE `renren_web_conf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '标题',
  `content` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'json内容',
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '备注',
  `status` tinyint(1) DEFAULT '1' COMMENT '是否 显示  1显示 0不显示  ',
  `pid` int(11) DEFAULT NULL COMMENT '父类id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='配置 - Web端  (手机端)';

/*Data for the table `renren_web_conf` */

insert  into `renren_web_conf`(`id`,`name`,`content`,`remark`,`status`,`pid`,`created_at`,`updated_at`) values (1,'connect','','联系我们',1,0,NULL,NULL),(2,'tel',' 029-86687002','联系电话',1,1,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
