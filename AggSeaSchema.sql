# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.9)
# Database: permia
# Generation Time: 2017-03-23 02:05:37 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table AggSeaAnswers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `AggSeaAnswers`;

CREATE TABLE `AggSeaAnswers` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `User_ID` int(11) NOT NULL,
  `Task_ID` int(11) NOT NULL,
  `Question_ID` int(11) NOT NULL,
  `Response` varchar(1024) NOT NULL,
  `System` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table AggSeaFavoriteLog
# ------------------------------------------------------------

DROP TABLE IF EXISTS `AggSeaFavoriteLog`;

CREATE TABLE `AggSeaFavoriteLog` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Query_ID` int(11) NOT NULL,
  `Link` varchar(1000) DEFAULT NULL,
  `Unique_ID` varchar(200) DEFAULT NULL,
  `Vertical` varchar(20) DEFAULT NULL,
  `Title` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `Snippet` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `Rank` varchar(10) DEFAULT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `Task_ID` int(11) NOT NULL,
  `Interface` varchar(20) DEFAULT NULL,
  `Current_Interface` varchar(20) DEFAULT NULL,
  `Timestamp` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table AggSeaLinkLog
# ------------------------------------------------------------

DROP TABLE IF EXISTS `AggSeaLinkLog`;

CREATE TABLE `AggSeaLinkLog` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Query_ID` int(11) DEFAULT NULL,
  `Link` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `Vertical` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `Title` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `Snippet` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `Rank` varchar(10) DEFAULT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `Task_ID` int(11) NOT NULL,
  `Interface` varchar(20) DEFAULT NULL,
  `Current_Interface` varchar(20) DEFAULT NULL,
  `Timestamp` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table AggSeaNavLog
# ------------------------------------------------------------

DROP TABLE IF EXISTS `AggSeaNavLog`;

CREATE TABLE `AggSeaNavLog` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Query_ID` int(11) DEFAULT NULL,
  `Page` int(11) DEFAULT NULL,
  `Type` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `Task_ID` int(11) NOT NULL,
  `Interface` varchar(20) DEFAULT NULL,
  `Previous_Interface` varchar(20) DEFAULT NULL,
  `Current_Interface` varchar(20) DEFAULT NULL,
  `Timestamp` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table AggSeaQueryLog
# ------------------------------------------------------------

DROP TABLE IF EXISTS `AggSeaQueryLog`;

CREATE TABLE `AggSeaQueryLog` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `User_ID` int(11) NOT NULL,
  `Task_ID` int(11) NOT NULL,
  `Search_Query` varchar(300) CHARACTER SET utf8 DEFAULT NULL,
  `Interface` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `Current_Interface` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `Suggestion` tinyint(1) NOT NULL DEFAULT '0',
  `Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table AggSeaQuestions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `AggSeaQuestions`;

CREATE TABLE `AggSeaQuestions` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Question_ID` int(11) NOT NULL,
  `Task_ID` int(11) NOT NULL,
  `Question_Order` int(11) NOT NULL,
  `Question_Text` varchar(1000) CHARACTER SET utf8 NOT NULL,
  `Type` varchar(45) CHARACTER SET utf8 NOT NULL,
  `Size` varchar(42) CHARACTER SET utf8 DEFAULT NULL,
  `Q_Option` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,
  `Q_Order` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

LOCK TABLES `AggSeaQuestions` WRITE;
/*!40000 ALTER TABLE `AggSeaQuestions` DISABLE KEYS */;

INSERT INTO `AggSeaQuestions` (`ID`, `Question_ID`, `Task_ID`, `Question_Order`, `Question_Text`, `Type`, `Size`, `Q_Option`, `Q_Order`)
VALUES
	(134,1,14,1,'Consent Form','checkbox',NULL,NULL,NULL),
	(136,3,15,1,'What is your age?','text','small',NULL,NULL),
	(137,4,15,2,'How often do you use Web Search engines such as Google (daily, weekly, monthly)?','text','small',NULL,NULL),
	(139,49,16,1,'1. The system provided enough information to help me solve the search tasks.','radio','small','1',1),
	(140,49,16,1,'1. The system provided enough information to help me solve the search tasks.','radio','small','2',2),
	(141,49,16,1,'1. The system provided enough information to help me solve the search tasks.','radio','small','3',3),
	(142,49,16,1,'1. The system provided enough information to help me solve the search tasks.','radio','small','4',4),
	(143,49,16,1,'1. The system provided enough information to help me solve the search tasks.','radio','small','5',5),
	(144,50,16,2,'2. The system provided me with many different kinds of information.','radio','small','1',1),
	(145,50,16,2,'2. The system provided me with many different kinds of information.','radio','small','2',2),
	(146,50,16,2,'2. The system provided me with many different kinds of information.','radio','small','3',3),
	(147,50,16,2,'2. The system provided me with many different kinds of information.','radio','small','4',4),
	(148,50,16,2,'2. The system provided me with many different kinds of information.','radio','small','5',5),
	(149,51,16,3,'3. The presentation of search results helped me easily combine information from different sources.','radio','small','1',1),
	(150,51,16,3,'3. The presentation of search results helped me easily combine information from different sources.','radio','small','2',2),
	(151,51,16,3,'3. The presentation of search results helped me easily combine information from different sources.','radio','small','3',3),
	(152,51,16,3,'3. The presentation of search results helped me easily combine information from different sources.','radio','small','4',4),
	(153,51,16,3,'3. The presentation of search results helped me easily combine information from different sources.','radio','small','5',5),
	(154,52,16,4,'4. The presentation of search results allowed me to easily identify relevant information.','radio','small','1',1),
	(155,52,16,4,'4. The presentation of search results allowed me to easily identify relevant information.','radio','small','2',2),
	(156,52,16,4,'4. The presentation of search results allowed me to easily identify relevant information.','radio','small','3',3),
	(157,52,16,4,'4. The presentation of search results allowed me to easily identify relevant information.','radio','small','4',4),
	(158,52,16,4,'4. The presentation of search results allowed me to easily identify relevant information.','radio','small','5',5),
	(159,53,16,5,'5. The presentation of search results helped me get an overview of the information available across multiple verticals.','radio','small','1',1),
	(160,53,16,5,'5. The presentation of search results helped me get an overview of the information available across multiple verticals.','radio','small','2',2),
	(161,53,16,5,'5. The presentation of search results helped me get an overview of the information available across multiple verticals.','radio','small','3',3),
	(162,53,16,5,'5. The presentation of search results helped me get an overview of the information available across multiple verticals.','radio','small','4',4),
	(163,53,16,5,'5. The presentation of search results helped me get an overview of the information available across multiple verticals.','radio','small','5',5),
	(170,5,17,1,'1.','radio','large','Many of the unhappy things in people\'s lives are partly due to bad luck',1),
	(171,5,17,1,'1.','radio','large','People\'s misfortunes result from the mistakes they make.',2),
	(172,54,18,1,'1. Which interface did you find the easiest to use?','radio','large','panelled',1),
	(173,54,18,1,'1. Which interface did you find the easiest to use?','radio','large','tabbed',2),
	(174,54,18,1,'1. Which interface did you find the easiest to use?','radio','large','blended',3),
	(175,54,18,1,'Why?','text','large',NULL,4),
	(176,55,18,2,'2. Which interface did you like the most?','radio','large','panelled',1),
	(177,55,18,2,'2. Which interface did you like the most?','radio','large','tabbed',2),
	(178,55,18,2,'2. Which interface did you like the most?','radio','large','blended',3),
	(179,55,18,2,'Why?','text','large',NULL,4),
	(180,56,18,3,'3. Which interface did you like the least?','radio','large','panelled',1),
	(181,56,18,3,'3. Which interface did you like the least?','radio','large','tabbed',2),
	(182,56,18,3,'3. Which interface did you like the least?','radio','large','blended',3),
	(183,56,18,3,'Why?','text','large',NULL,4),
	(184,57,18,4,'4. Any other comments?','text','large',NULL,NULL),
	(185,6,17,2,'2.','radio','large','One of the major reasons why we have wars is because people don\'t take enough interest in politics.',1),
	(186,6,17,2,'2.','radio','large','There will always be wars, no matter how hard people try to prevent them.',2),
	(189,7,17,3,'3.','radio','large','In the long run, people get the respect they deserve in this world.',1),
	(190,7,17,3,'3.','radio','large','Unfortunately, an individual\'s worth often passes unrecognized no matter how hard he tries.',2),
	(191,8,17,4,'4.','radio','large','The idea that teachers are unfair to students is nonsense.',1),
	(192,8,17,4,'4.','radio','large','Most students don\'t realize the extent to which their grades are influenced by accidental happenings.',2),
	(193,9,17,5,'5.','radio','large','Without the right breaks, one cannot be an effective leader.',1),
	(194,9,17,5,'5.','radio','large','Capable people who fail to become leaders have not taken advantage of their opportunities.',2),
	(195,10,17,6,'6.','radio','large','No matter how hard you try, some people just don\'t like you.',1),
	(196,10,17,6,'6.','radio','large','People who can\'t get others to like them don\'t understand how to get along with others.',2),
	(197,11,17,7,'7.','radio','large','I have often found that what is going to happen will happens',1),
	(198,11,17,7,'7.','radio','large','Trusting to fate has never turned out as well for me as making a decision to take a definite course of action.',2),
	(199,12,17,8,'8.','radio','large','In the case of the well prepared student, there is rarely, if ever, such a thing as an unfair test.',1),
	(200,12,17,8,'8.','radio','large','Many times exam questions tend to be so unrelated to course work that studying is really useless.',2),
	(201,13,17,9,'9.','radio','large','Becoming a success is a matter of hard work; luck has little or nothing to do with it.',1),
	(202,13,17,9,'9.','radio','large','Getting a good job depends mainly on being in the right place at the right time.',2),
	(203,14,17,10,'10.','radio','large','The average citizen can have an influence in government decisions.',1),
	(204,14,17,10,'10.','radio','large','This world is run by the few people in power, and there is not much the little guy can do about it.',2),
	(205,15,17,11,'11.','radio','large','When I make plans, I am almost certain that I can make them work.',1),
	(206,15,17,11,'11.','radio','large','It is not always wise to plan too far ahead because many things turn out to be a matter of luck anyway.',2),
	(207,16,17,12,'12.','radio','large','In my case, getting what I want has little or nothing to do with luck.',1),
	(208,16,17,12,'12.','radio','large','Many times we might just as well decide what to do by flipping a coin.',2),
	(209,17,17,13,'13.','radio','large','What happens to me is my own doing.',1),
	(210,17,17,13,'13.','radio','large','Sometimes I feel that I don\'t have enough control over the direction my life is taking.',2);

/*!40000 ALTER TABLE `AggSeaQuestions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table AggSeaSearches
# ------------------------------------------------------------

DROP TABLE IF EXISTS `AggSeaSearches`;

CREATE TABLE `AggSeaSearches` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Task_ID` int(11) NOT NULL,
  `Type` varchar(45) CHARACTER SET utf8 NOT NULL,
  `Description` varchar(2048) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `AggSeaSearches` WRITE;
/*!40000 ALTER TABLE `AggSeaSearches` DISABLE KEYS */;

INSERT INTO `AggSeaSearches` (`ID`, `Task_ID`, `Type`, `Description`)
VALUES
	(1,0,'Learning','Find documents that describe or discuss the impact of consumer boycotts.'),
	(2,1,'Learning','Look for information on the existence and/or the discovery of remains of the seven wonders of the ancient world.'),
	(3,2,'Learning','Find publications providing general introductions to food allergies and the prevention of such allergies.'),
	(4,3,'Learning','We seek any information on human cloning including claims of the production of the first human clone.'),
	(5,4,'Learning','In what sports are drugs used illegally?'),
	(6,5,'Doing','You want to buy Yves Saint Laurent boots.\nYou want to find places to buy, reviews, etc.'),
	(7,6,'Doing','Find recipes for chocolate puddings.'),
	(8,7,'Doing','You want to know how a .csv file can be imported in excel.'),
	(9,8,'Doing','Rock Climbing for Beginners-Only publications which specifically provide information on climbs that are not difficult or give instructions on rock climbing for beginners are of interest.'),
	(10,9,'FactFinding','What is the current price of oil?'),
	(11,10,'FactFinding','Give the names and/or location of places that have been designated as UNESCO World Heritage Sites of outstanding beauty or importance.'),
	(12,11,'FactFinding','What conditions can trigger asthma in children?'),
	(13,12,'FactFinding','How high above ground level is the ozone layer?');

/*!40000 ALTER TABLE `AggSeaSearches` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table AggSeaStudy
# ------------------------------------------------------------

DROP TABLE IF EXISTS `AggSeaStudy`;

CREATE TABLE `AggSeaStudy` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Study_ID` int(11) NOT NULL,
  `Task_Order` int(11) NOT NULL,
  `Task_ID` int(11) NOT NULL,
  `Task_Type` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `System` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

LOCK TABLES `AggSeaStudy` WRITE;
/*!40000 ALTER TABLE `AggSeaStudy` DISABLE KEYS */;

INSERT INTO `AggSeaStudy` (`ID`, `Study_ID`, `Task_Order`, `Task_ID`, `Task_Type`, `System`)
VALUES
	(1253,50,3,17,'survey',0),
	(1254,50,1,14,'survey',0),
	(1255,50,4,0,'task',1),
	(1256,50,2,15,'survey',0),
	(1257,50,5,1,'task',1),
	(1258,50,8,16,'survey',0),
	(1259,50,6,2,'task',1),
	(1260,50,7,3,'task',1),
	(1261,50,9,0,'task',2),
	(1262,50,10,6,'task',2),
	(1263,50,11,7,'task',2),
	(1264,50,12,8,'task',2),
	(1265,50,13,16,'survey',2),
	(1266,50,14,0,'task',3),
	(1267,50,15,9,'task',3),
	(1268,50,16,10,'task',3),
	(1269,50,17,11,'task',3),
	(1270,50,18,16,'survey',3),
	(1271,50,19,18,'survey',0),
	(1272,50,20,19,'survey',0),
	(1273,1,1,14,'survey',0),
	(1274,1,2,15,'survey',0),
	(1275,1,3,17,'survey',0),
	(1276,1,4,0,'task',1),
	(1277,1,5,9,'task',1),
	(1278,1,6,2,'task',1),
	(1279,1,7,6,'task',1),
	(1280,1,8,16,'survey',1),
	(1281,1,9,0,'task',2),
	(1282,1,10,7,'task',2),
	(1283,1,11,1,'task',2),
	(1284,1,12,10,'task',2),
	(1285,1,13,16,'survey',2),
	(1286,1,14,0,'task',3),
	(1287,1,15,3,'task',3),
	(1288,1,16,8,'task',3),
	(1289,1,17,11,'task',3),
	(1290,1,18,16,'survey',3),
	(1291,1,19,18,'survey',0),
	(1292,1,20,19,'survey',0),
	(1293,2,1,14,'survey',0),
	(1294,2,2,15,'survey',0),
	(1295,2,3,17,'survey',0),
	(1296,2,4,0,'task',1),
	(1297,2,5,1,'task',1),
	(1298,2,6,10,'task',1),
	(1299,2,7,7,'task',1),
	(1300,2,8,16,'survey',1),
	(1301,2,9,0,'task',2),
	(1302,2,10,6,'task',2),
	(1303,2,11,11,'task',2),
	(1304,2,12,12,'task',2),
	(1305,2,13,16,'survey',2),
	(1306,2,14,0,'task',3),
	(1307,2,15,9,'task',3),
	(1308,2,16,8,'task',3),
	(1309,2,17,3,'task',3),
	(1310,2,18,16,'survey',3),
	(1311,2,19,18,'survey',0),
	(1312,2,20,19,'survey',0),
	(1313,3,1,14,'survey',0),
	(1314,3,2,15,'survey',0),
	(1315,3,3,17,'survey',0),
	(1316,3,4,0,'task',1),
	(1317,3,5,10,'task',1),
	(1318,3,6,8,'task',1),
	(1319,3,7,3,'task',1),
	(1320,3,8,16,'survey',1),
	(1321,3,9,0,'task',2),
	(1322,3,10,2,'task',2),
	(1323,3,11,6,'task',2),
	(1324,3,12,11,'task',2),
	(1325,3,13,16,'survey',2),
	(1326,3,14,0,'task',3),
	(1327,3,15,1,'task',3),
	(1328,3,16,7,'task',3),
	(1329,3,17,9,'task',3),
	(1330,3,18,16,'survey',3),
	(1331,3,19,18,'survey',0),
	(1332,3,20,19,'survey',0),
	(1333,4,1,14,'survey',0),
	(1334,4,2,15,'survey',0),
	(1335,4,3,17,'survey',0),
	(1336,4,4,0,'task',1),
	(1337,4,5,1,'task',1),
	(1338,4,6,10,'task',1),
	(1339,4,7,7,'task',1),
	(1340,4,8,16,'survey',1),
	(1341,4,9,0,'task',2),
	(1342,4,10,3,'task',2),
	(1343,4,11,11,'task',2),
	(1344,4,12,6,'task',2),
	(1345,4,13,16,'survey',2),
	(1346,4,14,0,'task',3),
	(1347,4,15,8,'task',3),
	(1348,4,16,2,'task',3),
	(1349,4,17,9,'task',3),
	(1350,4,18,16,'survey',3),
	(1351,4,19,18,'survey',0),
	(1352,4,20,19,'survey',0),
	(1353,5,1,14,'survey',0),
	(1354,5,2,15,'survey',0),
	(1355,5,3,17,'survey',0),
	(1356,5,4,0,'task',1),
	(1357,5,5,9,'task',1),
	(1358,5,6,6,'task',1),
	(1359,5,7,1,'task',1),
	(1360,5,8,16,'survey',1),
	(1361,5,9,0,'task',2),
	(1362,5,10,2,'task',2),
	(1363,5,11,11,'task',2),
	(1364,5,12,8,'task',2),
	(1365,5,13,16,'survey',2),
	(1366,5,14,0,'task',3),
	(1367,5,15,7,'task',3),
	(1368,5,16,10,'task',3),
	(1369,5,17,3,'task',3),
	(1370,5,18,16,'survey',3),
	(1371,5,19,18,'survey',0),
	(1372,5,20,19,'survey',0),
	(1373,6,1,14,'survey',0),
	(1374,6,2,15,'survey',0),
	(1375,6,3,17,'survey',0),
	(1376,6,4,0,'task',2),
	(1377,6,5,1,'task',2),
	(1378,6,6,6,'task',2),
	(1379,6,7,10,'task',2),
	(1380,6,8,16,'survey',2),
	(1381,6,9,0,'task',3),
	(1382,6,10,2,'task',3),
	(1383,6,11,8,'task',3),
	(1384,6,12,9,'task',3),
	(1385,6,13,16,'survey',3),
	(1386,6,14,0,'task',1),
	(1387,6,15,11,'task',1),
	(1388,6,16,7,'task',1),
	(1389,6,17,3,'task',1),
	(1390,6,18,16,'survey',1),
	(1391,6,19,18,'survey',0),
	(1392,6,20,19,'survey',0),
	(1393,7,1,14,'survey',0),
	(1394,7,2,15,'survey',0),
	(1395,7,3,17,'survey',0),
	(1396,7,4,0,'task',2),
	(1397,7,5,2,'task',2),
	(1398,7,6,11,'task',2),
	(1399,7,7,8,'task',2),
	(1400,7,8,16,'survey',2),
	(1401,7,9,0,'task',3),
	(1402,7,10,1,'task',3),
	(1403,7,11,9,'task',3),
	(1404,7,12,6,'task',3),
	(1405,7,13,16,'survey',3),
	(1406,7,14,0,'task',1),
	(1407,7,15,3,'task',1),
	(1408,7,16,7,'task',1),
	(1409,7,17,10,'task',1),
	(1410,7,18,16,'survey',1),
	(1411,7,19,18,'survey',0),
	(1412,7,20,19,'survey',0),
	(1413,8,1,14,'survey',0),
	(1414,8,2,15,'survey',0),
	(1415,8,3,17,'survey',0),
	(1416,8,4,0,'task',2),
	(1417,8,5,9,'task',2),
	(1418,8,6,6,'task',2),
	(1419,8,7,3,'task',2),
	(1420,8,8,16,'survey',2),
	(1421,8,9,0,'task',3),
	(1422,8,10,2,'task',3),
	(1423,8,11,7,'task',3),
	(1424,8,12,10,'task',3),
	(1425,8,13,16,'survey',3),
	(1426,8,14,0,'task',1),
	(1427,8,15,11,'task',1),
	(1428,8,16,1,'task',1),
	(1429,8,17,8,'task',1),
	(1430,8,18,16,'survey',1),
	(1431,8,19,18,'survey',0),
	(1432,8,20,19,'survey',0),
	(1433,9,1,14,'survey',0),
	(1434,9,2,15,'survey',0),
	(1435,9,3,17,'survey',0),
	(1436,9,4,0,'task',2),
	(1437,9,5,11,'task',2),
	(1438,9,6,7,'task',2),
	(1439,9,7,3,'task',2),
	(1440,9,8,16,'survey',2),
	(1441,9,9,0,'task',3),
	(1442,9,10,9,'task',3),
	(1443,9,11,8,'task',3),
	(1444,9,12,1,'task',3),
	(1445,9,13,16,'survey',3),
	(1446,9,14,0,'task',1),
	(1447,9,15,10,'task',1),
	(1448,9,16,2,'task',1),
	(1449,9,17,6,'task',1),
	(1450,9,18,16,'survey',1),
	(1451,9,19,18,'survey',0),
	(1452,9,20,19,'survey',0),
	(1453,10,1,14,'survey',0),
	(1454,10,2,15,'survey',0),
	(1455,10,3,17,'survey',0),
	(1456,10,4,0,'task',2),
	(1457,10,5,9,'task',2),
	(1458,10,6,7,'task',2),
	(1459,10,7,1,'task',2),
	(1460,10,8,16,'survey',2),
	(1461,10,9,0,'task',3),
	(1462,10,10,6,'task',3),
	(1463,10,11,3,'task',3),
	(1464,10,12,10,'task',3),
	(1465,10,13,16,'survey',3),
	(1466,10,14,0,'task',1),
	(1467,10,15,2,'task',1),
	(1468,10,16,8,'task',1),
	(1469,10,17,11,'task',1),
	(1470,10,18,16,'survey',1),
	(1471,10,19,18,'survey',0),
	(1472,10,20,19,'survey',0),
	(1473,11,1,14,'survey',0),
	(1474,11,2,15,'survey',0),
	(1475,11,3,17,'survey',0),
	(1476,11,4,0,'task',3),
	(1477,11,5,8,'task',3),
	(1478,11,6,2,'task',3),
	(1479,11,7,9,'task',3),
	(1480,11,8,16,'survey',3),
	(1481,11,9,0,'task',1),
	(1482,11,10,1,'task',1),
	(1483,11,11,11,'task',1),
	(1484,11,12,7,'task',1),
	(1485,11,13,16,'survey',1),
	(1486,11,14,0,'task',2),
	(1487,11,15,6,'task',2),
	(1488,11,16,3,'task',2),
	(1489,11,17,10,'task',2),
	(1490,11,18,16,'survey',2),
	(1491,11,19,18,'survey',0),
	(1492,11,20,19,'survey',0),
	(1493,12,1,14,'survey',0),
	(1494,12,2,15,'survey',0),
	(1495,12,3,17,'survey',0),
	(1496,12,4,0,'task',3),
	(1497,12,5,10,'task',3),
	(1498,12,6,6,'task',3),
	(1499,12,7,3,'task',3),
	(1500,12,8,16,'survey',3),
	(1501,12,9,0,'task',1),
	(1502,12,10,8,'task',1),
	(1503,12,11,9,'task',1),
	(1504,12,12,1,'task',1),
	(1505,12,13,16,'survey',1),
	(1506,12,14,0,'task',2),
	(1507,12,15,7,'task',2),
	(1508,12,16,2,'task',2),
	(1509,12,17,11,'task',2),
	(1510,12,18,16,'survey',2),
	(1511,12,19,18,'survey',0),
	(1512,12,20,19,'survey',0),
	(1513,13,1,14,'survey',0),
	(1514,13,2,15,'survey',0),
	(1515,13,3,17,'survey',0),
	(1516,13,4,0,'task',3),
	(1517,13,5,10,'task',3),
	(1518,13,6,1,'task',3),
	(1519,13,7,6,'task',3),
	(1520,13,8,16,'survey',3),
	(1521,13,9,0,'task',1),
	(1522,13,10,8,'task',1),
	(1523,13,11,3,'task',1),
	(1524,13,12,11,'task',1),
	(1525,13,13,16,'survey',1),
	(1526,13,14,0,'task',2),
	(1527,13,15,7,'task',2),
	(1528,13,16,9,'task',2),
	(1529,13,17,2,'task',2),
	(1530,13,18,16,'survey',2),
	(1531,13,19,18,'survey',0),
	(1532,13,20,19,'survey',0),
	(1533,14,1,14,'survey',0),
	(1534,14,2,15,'survey',0),
	(1535,14,3,17,'survey',0),
	(1536,14,4,0,'task',3),
	(1537,14,5,3,'task',3),
	(1538,14,6,10,'task',3),
	(1539,14,7,7,'task',3),
	(1540,14,8,16,'survey',3),
	(1541,14,9,0,'task',1),
	(1542,14,10,9,'task',1),
	(1543,14,11,6,'task',1),
	(1544,14,12,2,'task',1),
	(1545,14,13,16,'survey',1),
	(1546,14,14,0,'task',2),
	(1547,14,15,1,'task',2),
	(1548,14,16,11,'task',2),
	(1549,14,17,8,'task',2),
	(1550,14,18,16,'survey',2),
	(1551,14,19,18,'survey',0),
	(1552,14,20,19,'survey',0),
	(1553,15,1,14,'survey',0),
	(1554,15,2,15,'survey',0),
	(1555,15,3,17,'survey',0),
	(1556,15,4,0,'task',3),
	(1557,15,5,3,'task',3),
	(1558,15,6,8,'task',3),
	(1559,15,7,9,'task',3),
	(1560,15,8,16,'survey',3),
	(1561,15,9,0,'task',1),
	(1562,15,10,1,'task',1),
	(1563,15,11,10,'task',1),
	(1564,15,12,6,'task',1),
	(1565,15,13,16,'survey',1),
	(1566,15,14,0,'task',2),
	(1567,15,15,2,'task',2),
	(1568,15,16,11,'task',2),
	(1569,15,17,7,'task',2),
	(1570,15,18,16,'survey',2),
	(1571,15,19,18,'survey',0),
	(1572,15,20,19,'survey',0),
	(1573,16,1,14,'survey',0),
	(1574,16,2,15,'survey',0),
	(1575,16,3,17,'survey',0),
	(1576,16,4,0,'task',1),
	(1577,16,5,8,'task',1),
	(1578,16,6,3,'task',1),
	(1579,16,7,11,'task',1),
	(1580,16,8,16,'survey',1),
	(1581,16,9,0,'task',3),
	(1582,16,10,7,'task',3),
	(1583,16,11,10,'task',3),
	(1584,16,12,1,'task',3),
	(1585,16,13,16,'survey',3),
	(1586,16,14,0,'task',2),
	(1587,16,15,2,'task',2),
	(1588,16,16,6,'task',2),
	(1589,16,17,9,'task',2),
	(1590,16,18,16,'survey',2),
	(1591,16,19,18,'survey',0),
	(1592,16,20,19,'survey',0),
	(1653,17,1,14,'survey',0),
	(1654,17,2,15,'survey',0),
	(1655,17,3,17,'survey',0),
	(1656,17,4,0,'task',1),
	(1657,17,5,2,'task',1),
	(1658,17,6,7,'task',1),
	(1659,17,7,9,'task',1),
	(1660,17,8,16,'survey',1),
	(1661,17,9,0,'task',3),
	(1662,17,10,8,'task',3),
	(1663,17,11,10,'task',3),
	(1664,17,12,1,'task',3),
	(1665,17,13,16,'survey',3),
	(1666,17,14,0,'task',2),
	(1667,17,15,6,'task',2),
	(1668,17,16,3,'task',2),
	(1669,17,17,11,'task',2),
	(1670,17,18,16,'survey',2),
	(1671,17,19,18,'survey',0),
	(1672,17,20,19,'survey',0),
	(1673,18,1,14,'survey',0),
	(1674,18,2,15,'survey',0),
	(1675,18,3,17,'survey',0),
	(1676,18,4,0,'task',1),
	(1677,18,5,3,'task',1),
	(1678,18,6,6,'task',1),
	(1679,18,7,11,'task',1),
	(1680,18,8,16,'survey',1),
	(1681,18,9,0,'task',3),
	(1682,18,10,9,'task',3),
	(1683,18,11,1,'task',3),
	(1684,18,12,8,'task',3),
	(1685,18,13,16,'survey',3),
	(1686,18,14,0,'task',2),
	(1687,18,15,7,'task',2),
	(1688,18,16,2,'task',2),
	(1689,18,17,10,'task',2),
	(1690,18,18,16,'survey',2),
	(1691,18,19,18,'survey',0),
	(1692,18,20,19,'survey',0),
	(1693,19,1,14,'survey',0),
	(1694,19,2,15,'survey',0),
	(1695,19,3,17,'survey',0),
	(1696,19,4,0,'task',1),
	(1697,19,5,9,'task',1),
	(1698,19,6,8,'task',1),
	(1699,19,7,2,'task',1),
	(1700,19,8,16,'survey',1),
	(1701,19,9,0,'task',3),
	(1702,19,10,1,'task',3),
	(1703,19,11,7,'task',3),
	(1704,19,12,11,'task',3),
	(1705,19,13,16,'survey',3),
	(1706,19,14,0,'task',2),
	(1707,19,15,6,'task',2),
	(1708,19,16,3,'task',2),
	(1709,19,17,10,'task',2),
	(1710,19,18,16,'survey',2),
	(1711,19,19,18,'survey',0),
	(1712,19,20,19,'survey',0),
	(1713,20,1,14,'survey',0),
	(1714,20,2,15,'survey',0),
	(1715,20,3,17,'survey',0),
	(1716,20,4,0,'task',1),
	(1717,20,5,9,'task',1),
	(1718,20,6,6,'task',1),
	(1719,20,7,2,'task',1),
	(1720,20,8,16,'survey',1),
	(1721,20,9,0,'task',3),
	(1722,20,10,7,'task',3),
	(1723,20,11,3,'task',3),
	(1724,20,12,10,'task',3),
	(1725,20,13,16,'survey',3),
	(1726,20,14,0,'task',2),
	(1727,20,15,1,'task',2),
	(1728,20,16,8,'task',2),
	(1729,20,17,11,'task',2),
	(1730,20,18,16,'survey',2),
	(1731,20,19,18,'survey',0),
	(1732,20,20,19,'survey',0),
	(1733,21,1,14,'survey',0),
	(1734,21,2,15,'survey',0),
	(1735,21,3,17,'survey',0),
	(1736,21,4,0,'task',2),
	(1737,21,5,9,'task',2),
	(1738,21,6,7,'task',2),
	(1739,21,7,3,'task',2),
	(1740,21,8,16,'survey',2),
	(1741,21,9,0,'task',1),
	(1742,21,10,1,'task',1),
	(1743,21,11,10,'task',1),
	(1744,21,12,8,'task',1),
	(1745,21,13,16,'survey',1),
	(1746,21,14,0,'task',3),
	(1747,21,15,6,'task',3),
	(1748,21,16,11,'task',3),
	(1749,21,17,2,'task',3),
	(1750,21,18,16,'survey',3),
	(1751,21,19,18,'survey',0),
	(1752,21,20,19,'survey',0),
	(1753,22,1,14,'survey',0),
	(1754,22,2,15,'survey',0),
	(1755,22,3,17,'survey',0),
	(1756,22,4,0,'task',2),
	(1757,22,5,7,'task',2),
	(1758,22,6,9,'task',2),
	(1759,22,7,3,'task',2),
	(1760,22,8,16,'survey',2),
	(1761,22,9,0,'task',1),
	(1762,22,10,11,'task',1),
	(1763,22,11,2,'task',1),
	(1764,22,12,6,'task',1),
	(1765,22,13,16,'survey',1),
	(1766,22,14,0,'task',3),
	(1767,22,15,10,'task',3),
	(1768,22,16,1,'task',3),
	(1769,22,17,8,'task',3),
	(1770,22,18,16,'survey',3),
	(1771,22,19,18,'survey',0),
	(1772,22,20,19,'survey',0),
	(1773,23,1,14,'survey',0),
	(1774,23,2,15,'survey',0),
	(1775,23,3,17,'survey',0),
	(1776,23,4,0,'task',2),
	(1777,23,5,8,'task',2),
	(1778,23,6,10,'task',2),
	(1779,23,7,2,'task',2),
	(1780,23,8,16,'survey',2),
	(1781,23,9,0,'task',1),
	(1782,23,10,6,'task',1),
	(1783,23,11,11,'task',1),
	(1784,23,12,3,'task',1),
	(1785,23,13,16,'survey',1),
	(1786,23,14,0,'task',3),
	(1787,23,15,7,'task',3),
	(1788,23,16,9,'task',3),
	(1789,23,17,1,'task',3),
	(1790,23,18,16,'survey',3),
	(1791,23,19,18,'survey',0),
	(1792,23,20,19,'survey',0),
	(1793,24,1,14,'survey',0),
	(1794,24,2,15,'survey',0),
	(1795,24,3,17,'survey',0),
	(1796,24,4,0,'task',2),
	(1797,24,5,6,'task',2),
	(1798,24,6,11,'task',2),
	(1799,24,7,2,'task',2),
	(1800,24,8,16,'survey',2),
	(1801,24,9,0,'task',1),
	(1802,24,10,7,'task',1),
	(1803,24,11,1,'task',1),
	(1804,24,12,9,'task',1),
	(1805,24,13,16,'survey',1),
	(1806,24,14,0,'task',3),
	(1807,24,15,10,'task',3),
	(1808,24,16,8,'task',3),
	(1809,24,17,3,'task',3),
	(1810,24,18,16,'survey',3),
	(1811,24,19,18,'survey',0),
	(1812,24,20,19,'survey',0),
	(1813,25,1,14,'survey',0),
	(1814,25,2,15,'survey',0),
	(1815,25,3,17,'survey',0),
	(1816,25,4,0,'task',2),
	(1817,25,5,2,'task',2),
	(1818,25,6,6,'task',2),
	(1819,25,7,9,'task',2),
	(1820,25,8,16,'survey',2),
	(1821,25,9,0,'task',1),
	(1822,25,10,8,'task',1),
	(1823,25,11,3,'task',1),
	(1824,25,12,11,'task',1),
	(1825,25,13,16,'survey',1),
	(1826,25,14,0,'task',3),
	(1827,25,15,7,'task',3),
	(1828,25,16,10,'task',3),
	(1829,25,17,1,'task',3),
	(1830,25,18,16,'survey',3),
	(1831,25,19,18,'survey',0),
	(1832,25,20,19,'survey',0),
	(1833,26,1,14,'survey',0),
	(1834,26,2,15,'survey',0),
	(1835,26,3,17,'survey',0),
	(1836,26,4,0,'task',3),
	(1837,26,5,9,'task',3),
	(1838,26,6,8,'task',3),
	(1839,26,7,2,'task',3),
	(1840,26,8,16,'survey',3),
	(1841,26,9,0,'task',2),
	(1842,26,10,6,'task',2),
	(1843,26,11,3,'task',2),
	(1844,26,12,11,'task',2),
	(1845,26,13,16,'survey',2),
	(1846,26,14,0,'task',1),
	(1847,26,15,10,'task',1),
	(1848,26,16,1,'task',1),
	(1849,26,17,7,'task',1),
	(1850,26,18,16,'survey',1),
	(1851,26,19,18,'survey',0),
	(1852,26,20,19,'survey',0),
	(1853,27,1,14,'survey',0),
	(1854,27,2,15,'survey',0),
	(1855,27,3,17,'survey',0),
	(1856,27,4,0,'task',3),
	(1857,27,5,1,'task',3),
	(1858,27,6,9,'task',3),
	(1859,27,7,7,'task',3),
	(1860,27,8,16,'survey',3),
	(1861,27,9,0,'task',2),
	(1862,27,10,6,'task',2),
	(1863,27,11,3,'task',2),
	(1864,27,12,11,'task',2),
	(1865,27,13,16,'survey',2),
	(1866,27,14,0,'task',1),
	(1867,27,15,2,'task',1),
	(1868,27,16,10,'task',1),
	(1869,27,17,8,'task',1),
	(1870,27,18,16,'survey',1),
	(1871,27,19,18,'survey',0),
	(1872,27,20,19,'survey',0),
	(1873,28,1,14,'survey',0),
	(1874,28,2,15,'survey',0),
	(1875,28,3,17,'survey',0),
	(1876,28,4,0,'task',3),
	(1877,28,5,11,'task',3),
	(1878,28,6,2,'task',3),
	(1879,28,7,8,'task',3),
	(1880,28,8,16,'survey',3),
	(1881,28,9,0,'task',2),
	(1882,28,10,7,'task',2),
	(1883,28,11,9,'task',2),
	(1884,28,12,1,'task',2),
	(1885,28,13,16,'survey',2),
	(1886,28,14,0,'task',1),
	(1887,28,15,10,'task',1),
	(1888,28,16,6,'task',1),
	(1889,28,17,3,'task',1),
	(1890,28,18,16,'survey',1),
	(1891,28,19,18,'survey',0),
	(1892,28,20,19,'survey',0),
	(1893,29,1,14,'survey',0),
	(1894,29,2,15,'survey',0),
	(1895,29,3,17,'survey',0),
	(1896,29,4,0,'task',3),
	(1897,29,5,9,'task',3),
	(1898,29,6,1,'task',3),
	(1899,29,7,8,'task',3),
	(1900,29,8,16,'survey',3),
	(1901,29,9,0,'task',2),
	(1902,29,10,6,'task',2),
	(1903,29,11,11,'task',2),
	(1904,29,12,2,'task',2),
	(1905,29,13,16,'survey',2),
	(1906,29,14,0,'task',1),
	(1907,29,15,10,'task',1),
	(1908,29,16,3,'task',1),
	(1909,29,17,7,'task',1),
	(1910,29,18,16,'survey',1),
	(1911,29,19,18,'survey',0),
	(1912,29,20,19,'survey',0),
	(1913,30,1,14,'survey',0),
	(1914,30,2,15,'survey',0),
	(1915,30,3,17,'survey',0),
	(1916,30,4,0,'task',3),
	(1917,30,5,7,'task',3),
	(1918,30,6,10,'task',3),
	(1919,30,7,3,'task',3),
	(1920,30,8,16,'survey',3),
	(1921,30,9,0,'task',2),
	(1922,30,10,6,'task',2),
	(1923,30,11,1,'task',2),
	(1924,30,12,11,'task',2),
	(1925,30,13,16,'survey',2),
	(1926,30,14,0,'task',1),
	(1927,30,15,2,'task',1),
	(1928,30,16,8,'task',1),
	(1929,30,17,9,'task',1),
	(1930,30,18,16,'survey',1),
	(1931,30,19,18,'survey',0),
	(1932,30,20,19,'survey',0);

/*!40000 ALTER TABLE `AggSeaStudy` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table AggSeaTaskPerformance
# ------------------------------------------------------------

DROP TABLE IF EXISTS `AggSeaTaskPerformance`;

CREATE TABLE `AggSeaTaskPerformance` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `User_ID` int(11) NOT NULL,
  `Study_ID` int(11) NOT NULL,
  `Task_ID` int(11) NOT NULL,
  `Task_Start` datetime NOT NULL,
  `Task_End` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table AggSeaUserLog
# ------------------------------------------------------------

DROP TABLE IF EXISTS `AggSeaUserLog`;

CREATE TABLE `AggSeaUserLog` (
  `User_ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Init_Time` datetime NOT NULL,
  `Study_ID` int(11) NOT NULL,
  PRIMARY KEY (`User_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
