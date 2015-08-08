/*
Navicat MySQL Data Transfer

Source Server         : only
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : sqldemo

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2015-08-08 09:52:24
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `a_id` int(11) NOT NULL AUTO_INCREMENT,
  `a_no` int(11) NOT NULL,
  `a_name` char(20) NOT NULL,
  `a_age` int(11) DEFAULT NULL,
  `a_address` char(100) DEFAULT NULL,
  `a_tel` char(20) DEFAULT NULL,
  `a_password` char(100) NOT NULL,
  PRIMARY KEY (`a_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', '1001', '李老师', '39', '山西太原', '18435132506', 'b8c37e33defde51cf91e1e03e51657da');
INSERT INTO `admin` VALUES ('2', '1002', '李老师', '39', '山西太原', '18435132506', 'fba9d88164f3e2d9109ee770223212a0');

-- ----------------------------
-- Table structure for `dor`
-- ----------------------------
DROP TABLE IF EXISTS `dor`;
CREATE TABLE `dor` (
  `d_id` int(11) NOT NULL AUTO_INCREMENT,
  `d_no` int(11) NOT NULL,
  `db_no` char(20) NOT NULL,
  `d_num` int(11) DEFAULT NULL,
  `d_numnow` int(11) DEFAULT NULL,
  PRIMARY KEY (`d_id`),
  KEY `db_no` (`db_no`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of dor
-- ----------------------------
INSERT INTO `dor` VALUES ('1', '101', 'WY1', '6', '4');
INSERT INTO `dor` VALUES ('2', '102', 'WY1', '8', '8');
INSERT INTO `dor` VALUES ('3', '103', 'WY1', '6', '4');
INSERT INTO `dor` VALUES ('4', '104', 'WY1', '6', '2');
INSERT INTO `dor` VALUES ('5', '105', 'WY1', '6', '2');
INSERT INTO `dor` VALUES ('6', '201', 'WY1', '6', '5');
INSERT INTO `dor` VALUES ('7', '202', 'WY1', '6', '5');
INSERT INTO `dor` VALUES ('8', '301', 'WY1', '6', '6');
INSERT INTO `dor` VALUES ('9', '401', 'WY1', '6', '5');
INSERT INTO `dor` VALUES ('10', '101', 'WY2', '6', '1');
INSERT INTO `dor` VALUES ('11', '202', 'WY2', '6', '0');
INSERT INTO `dor` VALUES ('12', '103', 'WY3', '6', '0');
INSERT INTO `dor` VALUES ('13', '305', 'WY3', '6', '0');
INSERT INTO `dor` VALUES ('14', '105', 'WY4', '6', '0');
INSERT INTO `dor` VALUES ('15', '503', 'WY4', '6', '0');
INSERT INTO `dor` VALUES ('16', '202', 'WY6', '6', '0');
INSERT INTO `dor` VALUES ('17', '301', 'WY7', '6', '0');
INSERT INTO `dor` VALUES ('18', '401', 'WY10', '6', '0');
INSERT INTO `dor` VALUES ('19', '535', 'WY5', '6', '0');
INSERT INTO `dor` VALUES ('20', '501', 'WY1', '6', '0');
INSERT INTO `dor` VALUES ('21', '601', 'WY1', '6', '0');
INSERT INTO `dor` VALUES ('22', '102', 'WY2', '6', '0');
INSERT INTO `dor` VALUES ('23', '103', 'WY2', '6', '0');
INSERT INTO `dor` VALUES ('24', '104', 'WY2', '6', '0');
INSERT INTO `dor` VALUES ('25', '105', 'WY2', '6', '0');
INSERT INTO `dor` VALUES ('26', '106', 'WY2', '6', '0');
INSERT INTO `dor` VALUES ('27', '107', 'WY2', '6', '0');
INSERT INTO `dor` VALUES ('28', '101', 'WY3', '6', '0');
INSERT INTO `dor` VALUES ('29', '102', 'WY3', '6', '0');
INSERT INTO `dor` VALUES ('30', '104', 'WY3', '6', '0');
INSERT INTO `dor` VALUES ('31', '105', 'WY3', '6', '0');
INSERT INTO `dor` VALUES ('32', '106', 'WY3', '6', '0');
INSERT INTO `dor` VALUES ('33', '107', 'WY3', '6', '0');
INSERT INTO `dor` VALUES ('34', '101', 'WY4', '6', '0');
INSERT INTO `dor` VALUES ('35', '102', 'WY4', '6', '0');
INSERT INTO `dor` VALUES ('36', '103', 'WY4', '6', '0');
INSERT INTO `dor` VALUES ('37', '104', 'WY4', '6', '0');
INSERT INTO `dor` VALUES ('38', '106', 'WY4', '6', '0');
INSERT INTO `dor` VALUES ('39', '107', 'WY4', '6', '0');
INSERT INTO `dor` VALUES ('40', '108', 'WY4', '6', '0');

-- ----------------------------
-- Table structure for `dor_admin`
-- ----------------------------
DROP TABLE IF EXISTS `dor_admin`;
CREATE TABLE `dor_admin` (
  `da_id` int(11) NOT NULL AUTO_INCREMENT,
  `da_no` int(11) NOT NULL,
  `db_no` char(20) NOT NULL,
  `da_name` char(20) NOT NULL,
  `da_age` int(11) DEFAULT NULL,
  `da_address` char(100) DEFAULT NULL,
  `da_tel` char(20) DEFAULT NULL,
  `da_password` char(100) NOT NULL,
  PRIMARY KEY (`da_id`),
  KEY `db_no` (`db_no`)
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of dor_admin
-- ----------------------------
INSERT INTO `dor_admin` VALUES ('47', '1000001', 'WY1', '张阿姨', '40', '山西忻州', '18626953548', '59e711d152de7bec7304a8c2ecaf9f0f');
INSERT INTO `dor_admin` VALUES ('48', '1000002', 'WY2', '赵师傅', '40', '山西大同', '18626953548', '877466ffd21fe26dd1b3366330b7b560');
INSERT INTO `dor_admin` VALUES ('49', '1000003', 'WY3', '李阿姨', '40', '山西忻州', '18621653548', 'f31c147335274c56d801f833d3c26a70');
INSERT INTO `dor_admin` VALUES ('50', '1000004', 'WY4', '钱师傅', '40', '山西长治', '12695354825', 'f68ec4f0c6df90137749af75a929a3eb');
INSERT INTO `dor_admin` VALUES ('51', '1000005', 'WY5', '孙阿姨', '40', '河南洛阳', '15026953548', '0f190e6e164eafe66f011073b4486975');
INSERT INTO `dor_admin` VALUES ('52', '1000006', 'WY6', '周师傅', '40', '山西忻州', '18626953548', 'a9588aa82388c0579d8f74b4d02b895f');
INSERT INTO `dor_admin` VALUES ('53', '1000007', 'WY7', '王师傅', '40', '北京', '18462953548', '66a516f865fca1c921dba625ede4a693');
INSERT INTO `dor_admin` VALUES ('54', '1000008', 'WY8', '陈阿姨', '40', '上海', '18626953548', '7cebd0178b69b2e88774529e1e59a7b0');
INSERT INTO `dor_admin` VALUES ('55', '1000009', 'WY9', '郭师傅', '40', '湖北武汉', '18626953548', 'ad1df793247a0e650d0d7166341b8d97');
INSERT INTO `dor_admin` VALUES ('56', '1000010', 'WY10', '万师傅', '40', '山西运城', '18456953548', '3e267ff3c8b6621e5ad4d0f26142892b');
INSERT INTO `dor_admin` VALUES ('57', '1000011', 'WT1', '郑师傅', '40', '山西忻州', '18626953548', '87dbe662a0f9238ddd0fca0f5cc1bb67');
INSERT INTO `dor_admin` VALUES ('58', '1000012', 'WT2', '狄阿姨', '40', '山西忻州', '18626953548', 'f1073dcfacb60ad7d23604071d476558');
INSERT INTO `dor_admin` VALUES ('59', '1000013', 'WT3', '刘阿姨', '40', '山西朔州', '18623535486', '880c6de112a048b0fc4ddb0a8b513e17');
INSERT INTO `dor_admin` VALUES ('60', '1000014', 'WT4', '徐师傅', '40', '山西忻州', '12626953548', '7bef20627bb50052e352b9653c3bca53');
INSERT INTO `dor_admin` VALUES ('61', '1000015', 'WT5', '魏师傅', '40', '山东济南', '18626953548', 'b5a5e2e8958e765c2822d5cf7c60df7d');
INSERT INTO `dor_admin` VALUES ('62', '1000016', 'WT6', '鲁阿姨', '40', '山西忻州', '18622353548', 'f67d389ebfb89c9a47d196e0ef2b9aae');
INSERT INTO `dor_admin` VALUES ('63', '1000017', 'WT7', '贾师傅', '40', '四川成都', '18626953548', '2a52b09ef991474c21f6a102511c416a');
INSERT INTO `dor_admin` VALUES ('64', '1000018', 'WT8', '林师傅', '40', '山西忻州', '18626143548', '9558075e9454035c61a4a4d665161692');
INSERT INTO `dor_admin` VALUES ('65', '1000019', 'WT9', '钱师傅', '40', '山西忻州', '18246936548', 'd0d9a78e15b3bf9d1105cdb5721e7c3c');
INSERT INTO `dor_admin` VALUES ('66', '1000020', 'WT10', '吴阿姨', '40', '山西忻州', '18626953548', 'e66174c2d569a2e847a94f7d1042cbd3');
INSERT INTO `dor_admin` VALUES ('67', '1000021', 'WY1', '董师傅', '40', '山西忻州', '18669953548', '4883b75dfe172846bd7d0b4ab4dad05e');
INSERT INTO `dor_admin` VALUES ('68', '1000022', 'WY5', '马阿姨', '40', '山西忻州', '18626953588', '9a498942ef50bcc9a32e85140b7e8402');

-- ----------------------------
-- Table structure for `dor_build`
-- ----------------------------
DROP TABLE IF EXISTS `dor_build`;
CREATE TABLE `dor_build` (
  `db_id` int(11) NOT NULL AUTO_INCREMENT,
  `db_no` char(20) NOT NULL,
  `db_name` char(20) NOT NULL,
  `db_sex` char(10) NOT NULL DEFAULT '男',
  PRIMARY KEY (`db_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of dor_build
-- ----------------------------
INSERT INTO `dor_build` VALUES ('1', 'WY1', '文瀛1号楼', '男');
INSERT INTO `dor_build` VALUES ('2', 'WY2', '文瀛2号楼', '男');
INSERT INTO `dor_build` VALUES ('3', 'WY3', '文瀛3号楼', '男');
INSERT INTO `dor_build` VALUES ('4', 'WY4', '文瀛4号楼', '女');
INSERT INTO `dor_build` VALUES ('5', 'WY5', '文瀛5号楼', '男');
INSERT INTO `dor_build` VALUES ('6', 'WY6', '文瀛6号楼', '男');
INSERT INTO `dor_build` VALUES ('7', 'WY7', '文瀛7号楼', '男');
INSERT INTO `dor_build` VALUES ('8', 'WY8', '文瀛8号楼', '男');
INSERT INTO `dor_build` VALUES ('9', 'WY9', '文瀛9号楼', '女');
INSERT INTO `dor_build` VALUES ('10', 'WY10', '文瀛10号楼', '女');
INSERT INTO `dor_build` VALUES ('11', 'WT1', '文韬1号楼', '男');
INSERT INTO `dor_build` VALUES ('12', 'WT2', '文韬2号楼', '男');
INSERT INTO `dor_build` VALUES ('13', 'WT3', '文韬3号楼', '男');
INSERT INTO `dor_build` VALUES ('14', 'WT4', '文韬4号楼', '女');
INSERT INTO `dor_build` VALUES ('15', 'WT5', '文韬5号楼', '男');
INSERT INTO `dor_build` VALUES ('16', 'WT6', '文韬6号楼', '女');
INSERT INTO `dor_build` VALUES ('17', 'WT7', '文韬7号楼', '男');
INSERT INTO `dor_build` VALUES ('18', 'WT8', '文韬8号楼', '男');
INSERT INTO `dor_build` VALUES ('19', 'WT9', '文韬9号楼', '女');
INSERT INTO `dor_build` VALUES ('20', 'WT10', '文韬10号楼', '男');

-- ----------------------------
-- Table structure for `student`
-- ----------------------------
DROP TABLE IF EXISTS `student`;
CREATE TABLE `student` (
  `s_id` int(11) NOT NULL AUTO_INCREMENT,
  `s_no` int(11) NOT NULL,
  `s_name` char(20) NOT NULL,
  `s_age` int(11) DEFAULT NULL,
  `s_sex` char(20) NOT NULL DEFAULT '男',
  `s_address` char(100) DEFAULT NULL,
  `s_tel` char(20) DEFAULT NULL,
  `s_class` char(20) DEFAULT NULL,
  `s_sub` char(20) DEFAULT NULL,
  `s_school` char(100) DEFAULT NULL,
  `s_family` char(10) NOT NULL DEFAULT '汉',
  `s_password` char(100) NOT NULL,
  `s_bed` int(11) NOT NULL,
  `s_isadmin` int(11) NOT NULL DEFAULT '0',
  `d_id` int(11) NOT NULL,
  PRIMARY KEY (`s_id`),
  KEY `d_id` (`d_id`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of student
-- ----------------------------
INSERT INTO `student` VALUES ('48', '1307084124', '小明', '0', '男', '中北大学', '18369596525', '13070841', '网络工程', '计算机与控制工程学院', '汉', '202cb962ac59075b964b07152d234b70', '3', '0', '1');
INSERT INTO `student` VALUES ('3', '1307094103', '小红', '0', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '2', '1', '1');
INSERT INTO `student` VALUES ('4', '1307094104', '胡歌', '0', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '1', '0', '5');
INSERT INTO `student` VALUES ('5', '1307094105', '霍佳华', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '5', '0', '1');
INSERT INTO `student` VALUES ('6', '1307094106', '吴彦祖', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '6', '0', '1');
INSERT INTO `student` VALUES ('7', '1307094107', '祁建斌', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '1', '0', '2');
INSERT INTO `student` VALUES ('8', '1307094108', '高雅妮', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '2', '1', '2');
INSERT INTO `student` VALUES ('9', '1307094109', '王超', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '3', '0', '2');
INSERT INTO `student` VALUES ('10', '1307094110', '田孟', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '4', '0', '2');
INSERT INTO `student` VALUES ('11', '1307094111', '李佳坤', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '5', '0', '2');
INSERT INTO `student` VALUES ('12', '1307094112', '万贝拉', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '6', '0', '2');
INSERT INTO `student` VALUES ('13', '1307094113', '郭红飞', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '7', '0', '2');
INSERT INTO `student` VALUES ('14', '1307094114', '郭志雄', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '8', '0', '2');
INSERT INTO `student` VALUES ('15', '1307094115', '王一超', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '3', '0', '3');
INSERT INTO `student` VALUES ('16', '1307094116', '杨坤', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '4', '1', '3');
INSERT INTO `student` VALUES ('17', '1307094117', '董睿', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '5', '0', '3');
INSERT INTO `student` VALUES ('18', '1307094118', '王祖蓝', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '1', '0', '6');
INSERT INTO `student` VALUES ('19', '1307094119', '邓超', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '2', '0', '6');
INSERT INTO `student` VALUES ('20', '1307094120', '陈赫', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '3', '0', '6');
INSERT INTO `student` VALUES ('21', '1307094121', '王宝强', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '4', '0', '6');
INSERT INTO `student` VALUES ('22', '1307094122', '李晨', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '6', '0', '6');
INSERT INTO `student` VALUES ('23', '1307094123', '宁泽涛', '0', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '5', '1', '5');
INSERT INTO `student` VALUES ('24', '1307094124', '成龙', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '1', '1', '7');
INSERT INTO `student` VALUES ('25', '1307094125', '李连杰', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '2', '0', '7');
INSERT INTO `student` VALUES ('26', '1307094126', '周星驰', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '3', '0', '7');
INSERT INTO `student` VALUES ('27', '1307094127', '陈奕迅', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '4', '0', '7');
INSERT INTO `student` VALUES ('28', '1307094128', '周杰伦', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '6', '0', '7');
INSERT INTO `student` VALUES ('29', '1307094129', '刘翔', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '1', '0', '8');
INSERT INTO `student` VALUES ('30', '1307094130', '姚明', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '2', '1', '8');
INSERT INTO `student` VALUES ('31', '1307094131', '周志桐', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '3', '0', '8');
INSERT INTO `student` VALUES ('32', '1307094132', '李志宏', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '5', '0', '8');
INSERT INTO `student` VALUES ('33', '1307094133', '程鹏', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '6', '0', '8');
INSERT INTO `student` VALUES ('34', '1307094134', '裴峰', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '4', '0', '8');
INSERT INTO `student` VALUES ('35', '1307094135', '茶叶', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '1', '0', '9');
INSERT INTO `student` VALUES ('36', '1307094136', '牟馨竹', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '3', '0', '9');
INSERT INTO `student` VALUES ('37', '1307094137', '小艾', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '4', '1', '9');
INSERT INTO `student` VALUES ('38', '1307094138', '程恺', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '5', '0', '9');
INSERT INTO `student` VALUES ('47', '1307084113', '任远', '20', '男', '中北大学', '18369596525', '13070841', '网络工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '1', '1', '10');
INSERT INTO `student` VALUES ('40', '1307094140', '许亚敏', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '2', '0', '9');
INSERT INTO `student` VALUES ('41', '1307094141', '霍霍', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '1', '1', '4');
INSERT INTO `student` VALUES ('42', '1307094142', '龙龙', '20', '男', '山西临汾', '18435138798', '13070941', '物联网工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '3', '0', '4');
INSERT INTO `student` VALUES ('46', '1307084112', '李明', '20', '男', '湖北武汉', '18369596525', '13070842', '网络工程', '计算机与控制工程学院', '汉', '96e79218965eb72c92a549dd5a330112', '1', '0', '3');
