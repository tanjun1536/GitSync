/*
SQLyog v10.2 
MySQL - 5.5.7-rc : Database - saas-server
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `menu` */

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  `link` varchar(200) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `target` varchar(10) DEFAULT NULL,
  `ordernumber` int(11) DEFAULT NULL,
  `ext` varchar(500) DEFAULT NULL,
  `type` smallint(6) DEFAULT NULL,
  `pos` smallint(6) DEFAULT NULL,
  `endtag` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8;

/*Data for the table `menu` */

insert  into `menu`(`id`,`name`,`parent_id`,`link`,`image`,`target`,`ordernumber`,`ext`,`type`,`pos`,`endtag`) values (1,'編輯個人檔案',NULL,'__APP__/User/profile','__PUBLIC__/images/icon_edit.gif',NULL,NULL,NULL,0,1,NULL),(2,'訊息管理\r\n',NULL,NULL,'__PUBLIC__/images/icon_mail.gif',NULL,NULL,NULL,0,1,NULL),(3,'一般訊息',2,'__APP__/Msg/index',NULL,NULL,NULL,NULL,0,1,NULL),(4,'我交辦事項',2,'__APP__/Msg/work',NULL,NULL,NULL,NULL,0,1,NULL),(5,'他人交辦事項',2,'__APP__/Msg/work',NULL,NULL,NULL,NULL,0,1,'<br/>'),(6,'提醒\r\n',NULL,'__APP__/Remind/index','__PUBLIC__/images/icon_recommend.gif',NULL,NULL,NULL,0,1,NULL),(7,'同事名單\r\n',NULL,'__APP__/User/friend','__PUBLIC__/images/icon_friend.gif',NULL,NULL,NULL,0,1,NULL),(8,'公司管理',NULL,NULL,'__PUBLIC__/images/company_32.png',NULL,NULL,NULL,0,1,NULL),(9,'公司基本資料',8,'__APP__/Company/edit',NULL,NULL,NULL,NULL,0,1,'<br />'),(10,'部門管理',8,'__APP__/Depart/index',NULL,NULL,NULL,NULL,0,1,NULL),(11,'組別管理',8,'__APP__/Team/index',NULL,NULL,NULL,NULL,0,1,'<br />'),(12,'級別管理',8,'__APP__/Level/index',NULL,NULL,NULL,NULL,0,1,NULL),(13,'員工管理',8,'__APP__/User/index',NULL,NULL,NULL,NULL,0,1,'<br />'),(14,'權限管理',8,'__APP__/Limit/index',NULL,NULL,NULL,NULL,0,1,NULL),(15,'公佈欄\r\n\r\n',NULL,'__APP__/News/index',NULL,NULL,NULL,'新增訊息,刪除訊息',0,0,NULL),(16,'出勤管理\r\n',NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL),(17,'我的紀錄',16,'__APP__/Check/index',NULL,NULL,NULL,NULL,0,0,NULL),(18,'出勤管理',16,'__APP__/Check/manage',NULL,NULL,NULL,NULL,0,0,NULL),(19,'工作日誌',NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL),(20,'我的日誌',19,'__APP__/Work/index',NULL,NULL,NULL,NULL,0,0,NULL),(21,'同事日誌',19,'__APP__/Work/cindex',NULL,NULL,NULL,NULL,0,0,'<br/>'),(22,'常用片語',19,'__APP__/Phrase/index',NULL,NULL,NULL,NULL,0,0,NULL),(23,'類別管理',19,'__APP__/Type/childcategory',NULL,NULL,NULL,NULL,0,0,'<br/>'),(24,'人事管理',NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL),(25,'獎懲記錄',24,'__APP__/Human/index',NULL,NULL,NULL,NULL,0,0,NULL),(26,'職務代理',24,'__APP__/Duty/index',NULL,NULL,NULL,NULL,0,0,'<br/>'),(27,'文件管理',NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL),(28,'電子簽呈',27,'__APP__/Elec/index',NULL,NULL,NULL,NULL,0,0,NULL),(29,'會議管理',27,'__APP__/Meeting/index',NULL,NULL,NULL,NULL,0,0,NULL),(30,'類別管理',27,'__APP__/Elec/category',NULL,NULL,NULL,NULL,0,0,'<br/>'),(31,'資源分享',NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL),(32,'常用表單',31,'__APP__/Form/index',NULL,NULL,NULL,'新增,刪除,類別管理',0,0,'<br/>'),(33,'檔案分享',31,'__APP__/Doc/index',NULL,NULL,NULL,'新增,刪除,類別管理',0,0,'<br/>'),(34,'合約管理',NULL,'__APP__/Contract/index','__PUBLIC__/images/document.png',NULL,NULL,'新增合約,修改,刪除,下載附件\r\n',0,1,NULL),(35,'客戶管理',NULL,'__APP__/Customer/index','__PUBLIC__/images/user_business_chart_32.png',NULL,NULL,'新增客戶,修改,刪除\r\n',0,1,NULL),(36,'業務管理\r\n',NULL,NULL,'__PUBLIC__/images/page_text_chart_32.png',NULL,NULL,NULL,0,1,NULL),(37,'業務資料追蹤表',36,'__APP__/Business/index',NULL,NULL,NULL,NULL,0,1,NULL),(38,'業務報價管理\r\n',36,'__APP__/Business/bid',NULL,NULL,NULL,NULL,0,1,NULL),(39,'商品管理\r\n',NULL,NULL,'__PUBLIC__/images/pd_32.png',NULL,NULL,NULL,0,1,NULL),(40,'商品類別管理',39,'__APP__/Stock/productBigType',NULL,NULL,NULL,NULL,0,1,'<br/>'),(41,'商品列表',39,'__APP__/Stock/product',NULL,NULL,NULL,'新增商品,修改商品,刪除商品\r\n',0,1,NULL),(42,'廠商管理\r\n',NULL,NULL,'__PUBLIC__/images/business_32.png',NULL,NULL,NULL,0,1,NULL),(43,'廠商類別管理',42,'__APP__/Stock/manufacturersType',NULL,NULL,NULL,NULL,0,1,'<br/>'),(44,'廠商列表',42,'__APP__/Stock/manufacturers',NULL,NULL,NULL,'新增廠商,修改廠商,刪除廠商',0,1,NULL),(45,'進銷存管理\r\n',NULL,NULL,'__PUBLIC__/images/stock.png',NULL,NULL,NULL,0,1,NULL),(46,'庫存管理',45,'__APP__/Stock/stock',NULL,NULL,NULL,NULL,0,1,'<br/>'),(47,'採購管理',45,'__APP__/Stock/purchase',NULL,NULL,NULL,'新增採購單,刪除採購單',0,1,'<br/>'),(48,'驗貨管理',45,'__APP__/Stock/stockCheck',NULL,NULL,NULL,'新增驗貨單,刪除驗貨單',0,1,'<br/>'),(49,'進貨管理',45,'__APP__/Stock/stockStorage',NULL,NULL,NULL,NULL,0,1,'<br/>'),(50,'異動管理',45,'__APP__/Stock/stockChange',NULL,NULL,NULL,NULL,0,1,'<br/>'),(51,'會計系統',NULL,NULL,'__PUBLIC__/images/accounting.png',NULL,NULL,NULL,0,1,NULL),(52,'常用帳號設定',51,'__APP__/Account/accountlist',NULL,NULL,NULL,NULL,0,1,'<br/>'),(53,'科目設定',51,'__APP__/Account/subjectlist',NULL,NULL,NULL,NULL,0,1,'<br/>'),(54,'收入管理',51,'__APP__/Account/incomelist',NULL,NULL,NULL,'新增,刪除,拋轉傳票功能\r\n',0,1,'<br/>'),(55,'支付管理',51,'__APP__/Account/paylist',NULL,NULL,NULL,'新增,刪除,拋轉傳票功能\r\n',0,1,'<br/>'),(56,'傳票管理',51,'__APP__/Account/billlist',NULL,NULL,NULL,'新增,刪除',0,1,'<br/>'),(57,'預算管理',51,'__APP__/Account/budgetlist',NULL,NULL,NULL,NULL,0,1,NULL),(59,'專案管理',NULL,'__APP__/Case/index','__PUBLIC__/images/hire_me.png',NULL,NULL,NULL,1,1,NULL),(60,'專案內容',59,'__APP__/Case/view',NULL,NULL,NULL,'新增專案,修改專案',1,2,'<br/>'),(61,'班別設定',59,'__APP__/Case/work',NULL,NULL,NULL,NULL,1,2,NULL),(62,'組別設定',59,'__APP__/Case/team',NULL,NULL,NULL,NULL,1,2,NULL),(63,'所屬人員',59,'__APP__/Case/member',NULL,NULL,NULL,NULL,1,2,NULL),(64,'查看人員',59,'__APP__/Case/looker',NULL,NULL,NULL,NULL,1,2,'<br/>'),(65,'差勤管理',59,'__APP__/Case/attendance',NULL,NULL,NULL,NULL,1,2,NULL),(66,'成本分析\r\n',59,'__APP__/Case/costanalysis',NULL,NULL,NULL,NULL,1,2,'<br/>'),(67,'相關文件',59,'__APP__/Case/file',NULL,NULL,NULL,'刪除',1,2,'<br/>'),(68,'調班管理',59,'__APP__/Case/moveshift',NULL,NULL,NULL,'新增,修改,刪除',1,2,NULL),(69,'設備管理\r\n',NULL,NULL,'__PUBLIC__/images/database_32.png',NULL,NULL,NULL,1,2,NULL),(70,'設備列表',69,'__APP__/Case/deviceIndex',NULL,NULL,NULL,'新增,刪除,匯入,匯出',1,2,'<br/>'),(71,'建物區域管理',69,'__APP__/Case/buildingFloorArea',NULL,NULL,NULL,'棟別,樓層,區域',1,2,'<br/>'),(72,'類別管理',69,'__APP__/Case/deviceType',NULL,NULL,NULL,NULL,1,2,'<br/>'),(73,'月保養排程',69,'__APP__/Case/maintenanceScheduling',NULL,NULL,NULL,'核對,匯出',1,2,'<br/>'),(74,'日保養排程',69,'__APP__/Case/dayMaintenanceRecord',NULL,NULL,NULL,'異動,保養',1,2,'<br/>'),(75,'保養週期',69,'__APP__/Case/maintenanceOverTime',NULL,NULL,NULL,'新增,修改,刪除',1,2,'<br/>'),(76,'保養管理',NULL,NULL,'__PUBLIC__/images/screwdriver_32.png',NULL,NULL,NULL,1,2,NULL),(77,'保養記錄',76,'__APP__/Case/maintenanceRecord',NULL,NULL,NULL,'新增,刪除',1,2,'<br/>'),(78,'保養明細管理',76,'__APP__/Case/maintenanceRecordDetail',NULL,NULL,NULL,'新增,修改,刪除',1,2,'<br/>'),(79,'維修管理\r\n',NULL,NULL,'__PUBLIC__/images/tools_32.png',NULL,NULL,NULL,1,2,NULL),(80,'維修列表',79,'__APP__/Case/repair',NULL,NULL,NULL,'委外說明,取消,刪除,留言',1,2,'<br/>'),(81,'申請叫修',79,'__APP__/Case/addRepair',NULL,NULL,NULL,NULL,1,2,NULL),(82,'派工',79,'__APP__/Case/doRepair',NULL,NULL,NULL,NULL,1,2,NULL),(83,'完工回報',79,'__APP__/Case/repairFinish',NULL,NULL,NULL,NULL,1,2,'<br/>'),(84,'委外管理',79,'__APP__/Case/delegateRepair',NULL,NULL,NULL,NULL,1,2,NULL),(85,'工程報價',79,'__APP__/Case/projectBid',NULL,NULL,NULL,NULL,1,2,NULL),(86,'警示設定',79,'__APP__/Case/warnSetting',NULL,NULL,NULL,NULL,1,2,NULL),(87,'統計資料',NULL,NULL,'__PUBLIC__/images/statistics.png',NULL,NULL,NULL,1,2,NULL),(88,'月叫修數量統計表',87,'__APP__/Case/statisticsbymonth',NULL,'_blank',NULL,NULL,1,2,NULL),(89,'月叫修明細統計表\r\n',87,'__APP__/Case/statisticsbymonthDetail',NULL,'_blank',NULL,NULL,1,2,'<br/>'),(90,'年度叫修數量統計表',87,'__APP__/Case/statisticsbyyear',NULL,'_blank',NULL,NULL,1,2,NULL),(91,'年度叫修明細統計表\r\n',87,'__APP__/Case/statisticsbyyearDetail',NULL,'_blank',NULL,NULL,1,2,'<br/>'),(92,'月完工數量統計表',87,'__APP__/Case/statisticsCompletebyMonth',NULL,'_blank',NULL,NULL,1,2,NULL),(93,'月完工明細統計表\r\n',87,'__APP__/Case/statisticsCompletebyMonthDetail',NULL,'_blank',NULL,NULL,1,2,'<br/>'),(94,'年度完工數量統計表 ',87,'__APP__/Case/statisticsCompletebyYear',NULL,'_blank',NULL,NULL,1,2,NULL),(95,'年度完工明細統計表\r\n',87,'__APP__/Case/statisticsCompletebyYearDetail',NULL,'_blank',NULL,NULL,1,2,'<br/>'),(96,'月保養數量統計表',87,'__APP__/Case/statisticsMaintenancebyMonth',NULL,'_blank',NULL,NULL,1,2,NULL),(97,'月保養明細統計表\r\n',87,'__APP__/Case/statisticsMaintenancebyMonthDetail',NULL,'_blank',NULL,NULL,1,2,'<br/>'),(98,'年度保養數量統計表',87,'__APP__/Case/statisticsMaintenancebyYear',NULL,'_blank',NULL,NULL,1,2,NULL),(99,'年度保養明細統計表\r\n',87,'__APP__/Case/statisticsMaintenancebyYearDetail',NULL,'_blank',NULL,NULL,1,2,'<br/>'),(100,'月故障完修時間統計表',87,'__APP__/Case/statisticsbyfault',NULL,'_blank',NULL,NULL,1,2,NULL),(101,'業主管理',NULL,NULL,'__PUBLIC__/images/user_business_32.png',NULL,NULL,NULL,1,2,'<br/>'),(102,'承租戶管理',101,'__APP__/Case/proprietorList',NULL,NULL,NULL,NULL,1,2,NULL),(103,'承租單位管理',101,'__APP__/Case/rentunitList',NULL,NULL,NULL,NULL,1,2,'<br/>'),(104,'繳費紀錄',101,'__APP__/Case/payList',NULL,NULL,NULL,NULL,1,2,NULL),(105,'抄表管理',107,'__APP__/Case/copyFormList',NULL,NULL,NULL,NULL,1,2,'<br/>'),(106,'抄表紀錄列表',107,'__APP__/Case/copyFormHistoryList',NULL,NULL,NULL,NULL,1,2,NULL),(107,'抄表管理',NULL,NULL,'__PUBLIC__/images/page_text_32.png',NULL,NULL,NULL,1,2,NULL),(108,'詢價管理',NULL,NULL,'__PUBLIC__/images/price.png',NULL,NULL,NULL,0,1,'<br/>'),(109,'客戶詢價管理',108,'__APP__/Price/PriceCustomerList',NULL,NULL,NULL,NULL,0,1,'<br/>'),(110,'廠商詢價管理',108,'__APP__/Price/PriceBusinessList',NULL,NULL,NULL,NULL,0,1,NULL);

/*Table structure for table `price_business` */

DROP TABLE IF EXISTS `price_business`;

CREATE TABLE `price_business` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `querydate` datetime DEFAULT NULL,
  `querycode` varchar(20) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `queryerdepart` bigint(20) DEFAULT NULL,
  `queryerteam` bigint(20) DEFAULT NULL,
  `queryer` bigint(20) DEFAULT NULL,
  `reqtype` varchar(10) DEFAULT NULL,
  `state` varchar(10) DEFAULT NULL,
  `purchaseremark` varchar(100) DEFAULT NULL,
  `remark` varchar(200) DEFAULT NULL,
  `totaldj` varchar(10) DEFAULT NULL,
  `totalfj` varchar(10) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `price_business` */

insert  into `price_business`(`id`,`querydate`,`querycode`,`type`,`queryerdepart`,`queryerteam`,`queryer`,`reqtype`,`state`,`purchaseremark`,`remark`,`totaldj`,`totalfj`,`code`) values (1,'2013-01-05 22:53:00','P2013010502',NULL,31,55,196,'電料','未處理','111213','123123','24','13','13108617');

/*Table structure for table `price_business_detail` */

DROP TABLE IF EXISTS `price_business_detail`;

CREATE TABLE `price_business_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `price` bigint(20) DEFAULT NULL,
  `cp` varchar(20) DEFAULT NULL,
  `spmc` varchar(20) DEFAULT NULL,
  `ggcc` varchar(20) DEFAULT NULL,
  `cpxh` varchar(20) DEFAULT NULL,
  `sl` varchar(20) DEFAULT NULL,
  `dw` varchar(20) DEFAULT NULL,
  `dj` varchar(20) DEFAULT NULL,
  `fj` varchar(20) DEFAULT NULL,
  `bz` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `price_business_detail` */

insert  into `price_business_detail`(`id`,`price`,`cp`,`spmc`,`ggcc`,`cpxh`,`sl`,`dw`,`dj`,`fj`,`bz`) values (2,1,'11','11','11','11','11','11','22','11','22'),(3,1,'2','2','2','2','2','2','2','2','2');

/*Table structure for table `price_customer` */

DROP TABLE IF EXISTS `price_customer`;

CREATE TABLE `price_customer` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `querydate` datetime DEFAULT NULL,
  `querycode` varchar(20) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `queryerdepart` bigint(20) DEFAULT NULL,
  `queryerteam` bigint(20) DEFAULT NULL,
  `queryer` bigint(20) DEFAULT NULL,
  `reqtype` varchar(10) DEFAULT NULL,
  `state` varchar(10) DEFAULT NULL,
  `purchaseremark` varchar(100) DEFAULT NULL,
  `remark` varchar(200) DEFAULT NULL,
  `totaldj` varchar(10) DEFAULT NULL,
  `totalfj` varchar(10) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `price_customer` */

insert  into `price_customer`(`id`,`querydate`,`querycode`,`type`,`queryerdepart`,`queryerteam`,`queryer`,`reqtype`,`state`,`purchaseremark`,`remark`,`totaldj`,`totalfj`,`code`) values (1,'2013-01-05 21:34:00','Q2013010522',NULL,31,54,197,'照明','未處理','11','22',NULL,NULL,'13108617'),(2,'2013-01-05 22:40:00','Q2013010523',NULL,31,55,196,'電料','未處理','222','333','76','10','13108617'),(4,'2013-01-05 22:49:00','Q2013010525',NULL,31,55,196,'馬達','未處理','ada','asd','1','1','13108617');

/*Table structure for table `price_customer_detail` */

DROP TABLE IF EXISTS `price_customer_detail`;

CREATE TABLE `price_customer_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `price` bigint(20) DEFAULT NULL,
  `cp` varchar(20) DEFAULT NULL,
  `spmc` varchar(20) DEFAULT NULL,
  `ggcc` varchar(20) DEFAULT NULL,
  `cpxh` varchar(20) DEFAULT NULL,
  `sl` varchar(20) DEFAULT NULL,
  `dw` varchar(20) DEFAULT NULL,
  `dj` varchar(20) DEFAULT NULL,
  `fj` varchar(20) DEFAULT NULL,
  `bz` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `price_customer_detail` */

insert  into `price_customer_detail`(`id`,`price`,`cp`,`spmc`,`ggcc`,`cpxh`,`sl`,`dw`,`dj`,`fj`,`bz`) values (1,1,'1',',','1',',','1','1',',','1',','),(2,1,'2',',','2',',','2',',','2',',','2'),(4,3,'11','1','22','1','33','1','44','1','44'),(5,3,'1','4','2','4','3','3','4','2','5'),(6,3,'4','4','4','4','4','4','4','4','4'),(7,2,'1','2','3','4','5','6','7','8','9'),(8,2,'2','2','22','2','2','2','2','2','2'),(9,4,'11','1','1','1','11','11','1','1','11');

/*Table structure for table `price_linecode` */

DROP TABLE IF EXISTS `price_linecode`;

CREATE TABLE `price_linecode` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` varchar(10) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `line` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `price_linecode` */

insert  into `price_linecode`(`id`,`type`,`code`,`date`,`line`) values (1,'customer','13108617','2013-01-05',3),(2,'Q','13108617','2013-01-05',25),(3,'P','13108617','2013-01-05',2);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
