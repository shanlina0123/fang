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
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '姓名',
  `mobile` char(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '手机号',
  `password` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '密码',
  `isadmin` tinyint(1) DEFAULT '0' COMMENT '是否管理员 1是 0否',
  `status` tinyint(1) DEFAULT NULL COMMENT '状态  1启用 0禁用',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='管理员';

/*Data for the table `renren_admin` */

insert  into `renren_admin`(`id`,`uuid`,`name`,`mobile`,`password`,`isadmin`,`status`,`created_at`,`updated_at`) values (1,'4d8eea03921d4d0a21106a5ab5fcc862','admin','1594014770','9b9a58a571e65876712f58219251dd89',1,1,'0000-00-00 00:00:00',NULL),(2,NULL,'admin',NULL,'9b9a58a571e65876712f58219251dd89',0,NULL,NULL,NULL);

/*Table structure for table `renren_client` */

DROP TABLE IF EXISTS `renren_client`;

CREATE TABLE `renren_client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '唯一索引',
  `houseid` int(11) DEFAULT NULL COMMENT '房源信息id 对应房源信息表house的id',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '客户姓名',
  `mobile` char(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '手机号码',
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '备注，默认推荐备注 可修改',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='客户 - 信息';

/*Data for the table `renren_client` */

/*Table structure for table `renren_client_dispatch` */

DROP TABLE IF EXISTS `renren_client_dispatch`;

CREATE TABLE `renren_client_dispatch` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '唯一索引',
  `clientid` int(11) DEFAULT NULL COMMENT '客户id  对应客户表client的id 可重复',
  `type` tinyint(1) DEFAULT NULL COMMENT '派单类型 1归属  2跟进 3移交后归属   4 移交后跟进',
  `remark` text COLLATE utf8mb4_unicode_ci COMMENT '派单备注，默认系统自动派单',
  `userid` int(11) DEFAULT NULL COMMENT '接单人 对应用户表user的id',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='客户 - 派单记录';

/*Data for the table `renren_client_dispatch` */

/*Table structure for table `renren_client_dynamic` */

DROP TABLE IF EXISTS `renren_client_dynamic`;

CREATE TABLE `renren_client_dynamic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '唯一索引',
  `clientid` int(11) DEFAULT NULL COMMENT '客户id 对应client表id',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `followstatusid` int(11) DEFAULT NULL COMMENT '客户跟进状态id 对应 data_select表id',
  `levelid` int(11) DEFAULT NULL COMMENT '客户等级  最新一次',
  `makedate` datetime DEFAULT NULL COMMENT '预约时间',
  `comedate` datetime DEFAULT NULL COMMENT '上门时间 最新记录',
  `dealdate` datetime DEFAULT NULL COMMENT '成交时间',
  `followcount` int(11) DEFAULT NULL COMMENT '跟进次数',
  `followdate` datetime DEFAULT NULL COMMENT '最后跟进时间',
  `refereeuserid` int(11) DEFAULT NULL COMMENT '推荐人id 对应user表id',
  `followuserid` int(11) DEFAULT NULL COMMENT '最新跟进者id 对应user表id',
  `ownuserid` int(11) DEFAULT NULL COMMENT '客户归属用户id 对应用户表user的id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='客户 - 详情';

/*Data for the table `renren_client_dynamic` */

/*Table structure for table `renren_client_follow` */

DROP TABLE IF EXISTS `renren_client_follow`;

CREATE TABLE `renren_client_follow` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '唯一索引',
  `clientid` int(11) DEFAULT NULL COMMENT '客户id 对应客户表client的id',
  `followstatusid` int(11) DEFAULT NULL COMMENT '跟进状态id 对应data_select表id',
  `content` text COLLATE utf8mb4_unicode_ci COMMENT '跟进 内容',
  `userid` int(11) DEFAULT NULL COMMENT '跟进人',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='客户 - 跟进记录';

/*Data for the table `renren_client_follow` */

/*Table structure for table `renren_client_referee` */

DROP TABLE IF EXISTS `renren_client_referee`;

CREATE TABLE `renren_client_referee` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '唯一索引',
  `clientid` int(11) DEFAULT NULL COMMENT '客户id  对应客户表client的id 不可重复',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id 对应公司表company的id, 对重生客户需要修改该值',
  `houseid` int(11) DEFAULT NULL COMMENT '房源id  对应house表id',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` char(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '手机号',
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '推荐备注',
  `userid` int(11) DEFAULT NULL COMMENT '推荐人 对应用户表user的id',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='客户 - 我的推荐';

/*Data for the table `renren_client_referee` */

/*Table structure for table `renren_client_transfer` */

DROP TABLE IF EXISTS `renren_client_transfer`;

CREATE TABLE `renren_client_transfer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '唯一索引',
  `clientid` int(11) DEFAULT NULL COMMENT '客户id  对应客户表id',
  `beforeownuserid` int(11) DEFAULT NULL COMMENT '移交前客户归属者id  对应用户表user的id',
  `afterownuserid` int(11) DEFAULT NULL COMMENT '移交后客户归属者id  对应用户表user的id',
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '备注',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='客户 - 移交记录';

/*Data for the table `renren_client_transfer` */

/*Table structure for table `renren_company` */

DROP TABLE IF EXISTS `renren_company`;

CREATE TABLE `renren_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '唯一索引',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '公司名称',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='公司';

/*Data for the table `renren_company` */

/*Table structure for table `renren_data_function` */

DROP TABLE IF EXISTS `renren_data_function`;

CREATE TABLE `renren_data_function` (
  `id` int(11) NOT NULL COMMENT '编号',
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '姓名',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '名称',
  `pid` int(11) DEFAULT NULL COMMENT '父类id',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `ismenu` tinyint(1) DEFAULT NULL COMMENT '是否菜单显示 1显示 0不显示',
  `level` tinyint(1) DEFAULT NULL COMMENT '层级',
  `module` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '模块名称',
  `control` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '控制器名称',
  `operation` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '操作',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 1可用 0 不可用',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='功能';

/*Data for the table `renren_data_function` */

insert  into `renren_data_function`(`id`,`uuid`,`name`,`pid`,`sort`,`ismenu`,`level`,`module`,`control`,`operation`,`status`,`created_at`) values (1,'7b53cccf37e211e8a43994de807e34a0','房源管理',0,1,1,1,'','','',1,'2018-04-04 16:30:50'),(2,'7b53ce2d37e211e8a43994de807e34a0','客户信息',0,2,1,1,NULL,NULL,NULL,1,'2018-04-04 16:30:50'),(3,'7b53cf4b37e211e8a43994de807e34a0','公司管理',0,3,1,1,NULL,NULL,NULL,1,'2018-04-04 16:30:50'),(4,'7b53d05037e211e8a43994de807e34a0','系统设置',0,4,1,1,NULL,NULL,NULL,1,'2018-04-04 16:30:50'),(5,'7b53d14f37e211e8a43994de807e34a0','属性管理',0,5,1,1,NULL,NULL,NULL,1,'2018-04-04 16:30:50'),(6,'7b53d25237e211e8a43994de807e34a0','数据分析',0,6,1,1,NULL,NULL,NULL,1,'2018-04-04 16:30:50'),(400,'7b53d35037e211e8a43994de807e34a0','角色',4,1,1,2,'admin','roles','index',1,'2018-04-04 16:30:50'),(401,'7b53d46e37e211e8a43994de807e34a0','列表',400,1,0,3,'admin','roles','index',1,'2018-04-04 16:30:50'),(402,'7b53d5cc37e211e8a43994de807e34a0','详情',400,2,0,3,'admin','roles','edit',1,'2018-04-04 16:30:50'),(403,'7b53d6df37e211e8a43994de807e34a0','新增',400,3,0,3,'admin','roles','create',1,'2018-04-04 16:30:50'),(404,'7b53d7ef37e211e8a43994de807e34a0','修改',400,4,0,3,'admin','roles','update',1,'2018-04-04 16:30:50'),(405,'7b53d8f537e211e8a43994de807e34a0','删除',400,5,0,3,'admin','roles','delete',1,'2018-04-04 16:30:50'),(410,'7b53d9f737e211e8a43994de807e34a0','用户',4,2,1,2,'admin','admin','index',1,'2018-04-04 16:30:50'),(411,'7b53db0337e211e8a43994de807e34a0','列表',410,1,0,3,'admin','admin','index',1,'2018-04-04 16:30:50'),(412,'7b53dc0637e211e8a43994de807e34a0','详情',410,2,0,3,'admin','admin','edit',1,'2018-04-04 16:30:50'),(413,'7b53dd2a37e211e8a43994de807e34a0','新增',410,3,0,3,'admin','admin','create',1,'2018-04-04 16:30:50'),(414,'7b53de3037e211e8a43994de807e34a0','修改',410,4,0,3,'admin','admin','update',1,'2018-04-04 16:30:50'),(415,'7b53df3c37e211e8a43994de807e34a0','删除',410,5,0,3,'admin','admin','delete',1,'2018-04-04 16:30:50'),(420,'7b53e04237e211e8a43994de807e34a0','权限',4,3,1,2,'admin','auth','index',1,'2018-04-04 16:30:50'),(421,'7b53e14e37e211e8a43994de807e34a0','列表',420,1,0,3,'admin','auth','index',1,'2018-04-04 16:30:50'),(422,'7b53e25b37e211e8a43994de807e34a0','勾选',420,2,0,3,'admin','auth','update',1,'2018-04-04 16:30:50');

/*Table structure for table `renren_data_select` */

DROP TABLE IF EXISTS `renren_data_select`;

CREATE TABLE `renren_data_select` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `cateid` int(11) DEFAULT NULL COMMENT '分类id 对应select_cate表id',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 默认1 ，1启用 0禁用',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COMMENT='数据源 - 自定义';

/*Data for the table `renren_data_select` */

insert  into `renren_data_select`(`id`,`name`,`cateid`,`status`,`created_at`) values (1,'10000元',1,1,'2018-04-02 19:04:30'),(2,'2000元',1,1,'2018-04-02 19:04:30'),(3,'1室1厅',2,1,'2018-04-02 19:04:30'),(4,'2室1厅',2,1,'2018-04-02 19:04:30'),(5,'1室0厅',2,1,'2018-04-02 19:04:30'),(6,'2室2厅',2,1,'2018-04-02 19:04:30'),(7,'3室1厅',2,1,'2018-04-02 19:04:30'),(8,'4室1厅',2,1,'2018-04-02 19:04:30'),(9,'3室2厅',2,1,'2018-04-02 19:04:30'),(10,'4室2厅',2,1,'2018-04-02 19:04:30'),(11,'精装修',3,1,'2018-04-02 19:04:30'),(12,'简单装修',3,1,'2018-04-02 19:04:30'),(13,'毛坯',3,1,'2018-04-02 19:04:30'),(14,'豪华装修',3,1,'2018-04-02 19:04:30'),(15,'中等装修',3,1,'2018-04-02 19:04:30'),(16,'A类客户',4,1,'2018-04-02 19:04:30'),(17,'B类客户',4,1,'2018-04-02 19:04:30'),(18,'C类客户',4,1,'2018-04-02 19:04:30'),(19,'D类客户',4,1,'2018-04-02 19:04:30'),(20,'配套齐全',5,1,'2018-04-02 19:04:30'),(21,'邻地铁',5,1,'2018-04-02 19:04:30'),(22,'车位充足',5,1,'2018-04-02 19:04:30'),(23,'小户型',5,1,'2018-04-02 19:04:30'),(24,'学校周边',5,1,'2018-04-02 19:04:30'),(25,'绿化率高',5,1,'2018-04-02 19:04:30'),(26,'品牌公寓',5,1,'2018-04-02 19:04:30'),(27,'五证齐全',5,1,'2018-04-02 19:04:30'),(28,'南北通透',5,1,'2018-04-02 19:04:30'),(29,'带幼儿园',5,1,'2018-04-02 19:04:30'),(30,'购物中心',5,1,'2018-04-02 19:04:30'),(31,'轨交房',5,1,'2018-04-02 19:04:30'),(32,'品牌开发商',5,1,'2018-04-02 19:04:30'),(33,'满二唯一',5,1,'2018-04-02 19:04:30'),(34,'满两年',5,1,'2018-04-02 19:04:30'),(35,'满五唯一',5,1,'2018-04-02 19:04:30'),(36,'满五年',5,1,'2018-04-02 19:04:30'),(37,'精装修',5,1,'2018-04-02 19:04:30'),(38,'随时看房',5,1,'2018-04-02 19:04:30'),(39,'可短租',5,1,'2018-04-02 19:04:30'),(40,'首次出租',5,1,'2018-04-02 19:04:30');

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

/*Table structure for table `renren_house` */

DROP TABLE IF EXISTS `renren_house`;

CREATE TABLE `renren_house` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '唯一索引',
  `provinceid` int(11) DEFAULT NULL COMMENT '省id',
  `cityid` int(11) DEFAULT NULL COMMENT '城市id 对应data_city表的id',
  `countryid` int(11) DEFAULT NULL COMMENT '区id',
  `streeid` int(11) DEFAULT NULL COMMENT '街道id',
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
  `addr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '地址',
  `fulladdr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '地址 省市区+具体地址',
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
  `total` decimal(10,2) DEFAULT NULL COMMENT '总价',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 手机端是否显示  1展示 0不展示',
  `userid` int(11) DEFAULT NULL COMMENT '发布者id 对应user表id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='房源';

/*Data for the table `renren_house` */

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='房源 - 后台推荐显示';

/*Data for the table `renren_house_home` */

/*Table structure for table `renren_house_image` */

DROP TABLE IF EXISTS `renren_house_image`;

CREATE TABLE `renren_house_image` (
  `id` int(11) NOT NULL,
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '唯一索引',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '图片路径',
  `title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `houseid` int(11) DEFAULT NULL COMMENT '房源id',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='房源 - 图片记录';

/*Data for the table `renren_house_image` */

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='房源 - 特色标签';

/*Data for the table `renren_house_tag` */

/*Table structure for table `renren_role` */

DROP TABLE IF EXISTS `renren_role`;

CREATE TABLE `renren_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '姓名',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '公司id 对应公司表company的id',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 1可用 0 不可用',
  `isdeafult` tinyint(1) DEFAULT '0' COMMENT '是否默认 1默认 0非默认 ， 默认的不能删除',
  `islook` tinyint(1) DEFAULT '1' COMMENT '是否可以全部 0全部 1个人',
  `adminid` int(11) DEFAULT NULL COMMENT '创建人id  对应 admin表id',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='角色';

/*Data for the table `renren_role` */

insert  into `renren_role`(`id`,`uuid`,`name`,`status`,`isdeafult`,`islook`,`adminid`,`created_at`,`updated_at`) values (1,'4a7fd8cb371511e89ce094de807e34a0','管理员',1,1,1,1,'2018-04-03 16:02:01',NULL),(2,'4a800506371511e89ce094de807e34a0','操作员',1,1,1,1,'2018-04-03 16:02:01',NULL),(3,'4a8008b0371511e89ce094de807e34a0','业务员',1,1,1,1,'2018-04-03 16:02:01',NULL),(4,'90652f05bd4a0c3ee5c52e052d1847d7','aaaaa',1,0,1,1,'2018-04-04 06:11:12',NULL),(5,'f553f771190178179cc082bd1ba3435c','aaaaa',1,0,1,1,'2018-04-04 06:12:47',NULL);

/*Table structure for table `renren_role_admin` */

DROP TABLE IF EXISTS `renren_role_admin`;

CREATE TABLE `renren_role_admin` (
  `id` int(11) NOT NULL,
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '姓名',
  `roleid` int(11) DEFAULT NULL COMMENT '角色id 对应role表id',
  `userid` int(11) DEFAULT NULL COMMENT '用户id 对应用户表user的id',
  `status` tinyint(1) DEFAULT NULL COMMENT '状态 1可用 0 不可用',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='角色 - 用户';

/*Data for the table `renren_role_admin` */

insert  into `renren_role_admin`(`id`,`uuid`,`roleid`,`userid`,`status`,`created_at`) values (0,NULL,5,1,NULL,NULL);

/*Table structure for table `renren_role_function` */

DROP TABLE IF EXISTS `renren_role_function`;

CREATE TABLE `renren_role_function` (
  `id` int(11) NOT NULL,
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '姓名',
  `roleid` int(11) DEFAULT NULL COMMENT '角色id 对应role表id',
  `functionids` text COLLATE utf8mb4_unicode_ci COMMENT '功能id 对应功能表function的id,json格式例如： {100:[101,102,103],200:[201,202,203]}',
  `status` tinyint(1) DEFAULT NULL COMMENT '状态 1可用 0 不可用',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='角色 - 功能';

/*Data for the table `renren_role_function` */

/*Table structure for table `renren_user` */

DROP TABLE IF EXISTS `renren_user`;

CREATE TABLE `renren_user` (
  `id` int(11) NOT NULL,
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '唯一索引',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id 对应公司表company的id',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '姓名',
  `mobile` char(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '手机号',
  `password` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '密码',
  `economictid` tinyint(4) DEFAULT NULL COMMENT '经纪人类型id 对应data_select_default表id',
  `isadminafter` tinyint(1) DEFAULT '0' COMMENT '是否后端创建过来的 1是 0不是',
  `wechatopenid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '微信openid',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='经纪人';

/*Data for the table `renren_user` */

/*Table structure for table `renren_user_token` */

DROP TABLE IF EXISTS `renren_user_token`;

CREATE TABLE `renren_user_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '唯一索引',
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '生成的token',
  `expiration` int(11) DEFAULT NULL COMMENT '过期时间',
  `userid` char(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '用户id  或admin id',
  `type` tinyint(1) DEFAULT NULL COMMENT '类型 1对应admin表 2对应user表id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户 - token';

/*Data for the table `renren_user_token` */

insert  into `renren_user_token`(`id`,`uuid`,`token`,`expiration`,`userid`,`type`,`created_at`,`updated_at`) values (1,'7e7a9db309029a1f18092808af988f5d','OP4NbtEQDDorxyEiPsHwZm4YFf7mtAKBsBTY4rWjPyKalC7nkOJLnDgiRyC2',1522828530,NULL,1,'2018-04-02 07:29:53','2018-04-04 05:55:30');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
