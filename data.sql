

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin_info`
-- ----------------------------
DROP TABLE IF EXISTS `admin_info`;
CREATE TABLE `admin_info` (
  `admin_id` int(4) NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `user_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `admin_pass` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `is_valid` smallint(2) DEFAULT '1' COMMENT '是否有效 1有效 2无效',
  `rtime` int(10) DEFAULT NULL COMMENT '创建时间',
  `last_time` int(10) DEFAULT NULL COMMENT '登陆时间',
  `city_code` varchar(10) DEFAULT 'xz' COMMENT '管理城市',
  `role` int(4) DEFAULT '3' COMMENT '角色管理 1:系统管理 2：负责人 3: 管理员',
  `last_ip` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `admin_phone` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=207 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of admin_info
-- ----------------------------

-- ----------------------------
-- Table structure for `dataface_admin_info`
-- ----------------------------
DROP TABLE IF EXISTS `dataface_admin_info`;
CREATE TABLE `dataface_admin_info` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) DEFAULT NULL COMMENT '姓名',
  `user_mobile` varchar(20) NOT NULL,
  `user_pwd` varchar(10) NOT NULL,
  `registration_time` datetime DEFAULT NULL,
  `last_login_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dataface_admin_info
-- ----------------------------

-- ----------------------------
-- Table structure for `dataface_api_visit_info`
-- ----------------------------
DROP TABLE IF EXISTS `dataface_api_visit_info`;
CREATE TABLE `dataface_api_visit_info` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(4) DEFAULT '0',
  `city_id` int(4) NOT NULL DEFAULT '0' COMMENT '城市ID',
  `page_source` varchar(20) NOT NULL DEFAULT '0' COMMENT '来源：10网页，20微信，30中介版, QF 巧房',
  `page_position` varchar(100) DEFAULT '0' COMMENT '接口位置描述：',
  `page_url` varchar(300) DEFAULT '接口url',
  `city_code` varchar(20) DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `user_company` varchar(100) DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=233173 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dataface_api_visit_info
-- ----------------------------


-- ----------------------------
-- Table structure for `dataface_city`
-- ----------------------------
DROP TABLE IF EXISTS `dataface_city`;
CREATE TABLE `dataface_city` (
  `city_id` int(4) NOT NULL AUTO_INCREMENT,
  `city_name` varchar(50) DEFAULT NULL,
  `city_code` varchar(10) DEFAULT NULL COMMENT '城市缩写',
  `is_first` smallint(4) DEFAULT '0' COMMENT '1是否开通新房',
  `is_second` smallint(4) DEFAULT '0' COMMENT '是否开通2手',
  `is_sale` smallint(4) DEFAULT '0' COMMENT '是否有出售的挂牌',
  `is_open` smallint(4) NOT NULL DEFAULT '1' COMMENT '1打开',
  `sort` int(4) NOT NULL DEFAULT '0' COMMENT '排序，越大越前面吧',
  `group_area` varchar(200) DEFAULT NULL,
  `group_price` varchar(200) DEFAULT NULL,
  `group_tprice` varchar(200) DEFAULT NULL,
  `land_group_area` varchar(200) DEFAULT NULL COMMENT '土地面积段',
  `land_group_barea` varchar(200) DEFAULT NULL COMMENT '土地建筑面积段',
  `land_group_tprice` varchar(200) DEFAULT NULL COMMENT '土地总价段',
  `land_group_price` varchar(200) DEFAULT NULL,
  `land_group_rjl` varchar(200) DEFAULT NULL COMMENT '土地容积率',
  PRIMARY KEY (`city_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dataface_city
-- ----------------------------


-- ----------------------------
-- Table structure for `dataface_developer_company`
-- ----------------------------
DROP TABLE IF EXISTS `dataface_developer_company`;
CREATE TABLE `dataface_developer_company` (
  `company_id` int(4) NOT NULL AUTO_INCREMENT,
  `short_name` varchar(100) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `first_py` char(10) DEFAULT NULL,
  PRIMARY KEY (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dataface_developer_company
-- ----------------------------


-- ----------------------------
-- Table structure for `dataface_house_guapai`
-- ----------------------------
DROP TABLE IF EXISTS `dataface_house_guapai`;
CREATE TABLE `dataface_house_guapai` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `gp_id` varchar(100) DEFAULT NULL COMMENT '挂牌房源ID',
  `gp_title` varchar(200) DEFAULT NULL COMMENT '挂牌房源标题',
  `gp_house_id` varchar(100) DEFAULT NULL COMMENT '挂牌楼盘标识',
  `gp_house_name` varchar(100) DEFAULT NULL COMMENT '挂牌楼盘名',
  `room_name` varchar(100) DEFAULT NULL COMMENT '房型',
  `room` int(4) NOT NULL DEFAULT '0',
  `area` decimal(10,2) NOT NULL,
  `direction` varchar(100) DEFAULT NULL,
  `fitment` varchar(100) DEFAULT NULL,
  `elevator` varchar(100) DEFAULT NULL,
  `gp_date` date DEFAULT NULL COMMENT '挂牌时间',
  `gp_date_year` int(4) NOT NULL DEFAULT '0',
  `gp_date_month` int(4) NOT NULL DEFAULT '0',
  `is_under` smallint(2) NOT NULL DEFAULT '0' COMMENT '是否下架 1下架',
  `is_repeat` smallint(2) NOT NULL DEFAULT '0' COMMENT '是否重复 1，重复，暂时不处理，，可能多家重复',
  `under_date` date DEFAULT NULL COMMENT '下架时间',
  `under_date_year` int(4) NOT NULL DEFAULT '0',
  `under_date_month` int(4) NOT NULL DEFAULT '0',
  `source_id` int(4) NOT NULL DEFAULT '0' COMMENT '来源：10 链家 20 中原',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dataface_house_guapai
-- ----------------------------

-- ----------------------------
-- Table structure for `dataface_house_price`
-- ----------------------------
DROP TABLE IF EXISTS `dataface_house_price`;
CREATE TABLE `dataface_house_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(4) NOT NULL,
  `city_name` varchar(50) DEFAULT NULL,
  `tbs_city` int(11) DEFAULT NULL,
  `house_id` int(4) NOT NULL,
  `house_name` varchar(200) NOT NULL,
  `cankao_dealprice` int(11) NOT NULL DEFAULT '0',
  `cankao_rentprice` int(11) NOT NULL DEFAULT '0',
  `rent_roomtype` varchar(100) DEFAULT NULL COMMENT '租金房型',
  PRIMARY KEY (`id`),
  KEY `idx_house_id` (`city_id`,`house_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=90301 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dataface_house_price
-- ----------------------------


-- ----------------------------
-- Table structure for `dataface_land`
-- ----------------------------
DROP TABLE IF EXISTS `dataface_land`;
CREATE TABLE `dataface_land` (
  `land_id` int(4) NOT NULL AUTO_INCREMENT,
  `city_id` int(4) NOT NULL COMMENT '城市ID',
  `land_no` varchar(200) DEFAULT NULL COMMENT '土地公告号',
  `dkmc` varchar(200) NOT NULL COMMENT '地块名称',
  `szfw` varchar(2000) DEFAULT NULL COMMENT '四至范围',
  `crr` varchar(200) DEFAULT NULL COMMENT '出让人',
  `crfs` varchar(200) DEFAULT NULL COMMENT '出让方式',
  `ssqx` varchar(50) DEFAULT NULL COMMENT '所属区县',
  `tdtype` varchar(1000) DEFAULT NULL COMMENT '土地用途',
  `crmj` decimal(10,2) DEFAULT NULL COMMENT '出让面积',
  `rjl` varchar(1000) DEFAULT NULL COMMENT '容积率',
  `crnx` varchar(1000) DEFAULT NULL COMMENT '出让年限',
  `blockstate` varchar(50) DEFAULT NULL COMMENT '当前交易状态',
  `jmsqrs` varchar(50) DEFAULT NULL COMMENT '竞买申请人数',
  `qsj` varchar(100) DEFAULT NULL COMMENT '起始价（万）',
  `dqjg` varchar(100) DEFAULT NULL COMMENT '当前价格（万）',
  `jmzgzsbh` varchar(100) DEFAULT NULL COMMENT '竞买资格证书编号',
  `bjls` varchar(50) DEFAULT NULL COMMENT '报价轮数',
  `bjsj` varchar(50) DEFAULT NULL COMMENT '报价时间',
  `jdj` int(10) NOT NULL DEFAULT '0' COMMENT '竞得价',
  `jdr` varchar(100) DEFAULT NULL COMMENT '竞得人',
  `jdrq` date DEFAULT NULL COMMENT '竞得日期',
  `crxz` varchar(200) DEFAULT NULL COMMENT '出让须知链接',
  `ysht` varchar(200) DEFAULT NULL COMMENT '预售合同',
  `crwj` varchar(200) DEFAULT NULL COMMENT '出让文件',
  `fbsj` date DEFAULT NULL COMMENT '发布时间',
  `tjsj` varchar(100) DEFAULT NULL COMMENT '提问截止时间',
  `dyfbsj` varchar(100) DEFAULT NULL COMMENT '答疑发布时间',
  `ffwjkssj` varchar(100) DEFAULT NULL COMMENT '发放文件开始时间',
  `ffwjjzsj` varchar(100) DEFAULT NULL COMMENT '发放文件截止时间',
  `jsjmkssj` varchar(100) DEFAULT NULL COMMENT '接受竞买开始时间',
  `jsjmjssj` varchar(100) DEFAULT NULL COMMENT '接受竞买截止时间',
  `bzjsj` varchar(100) DEFAULT NULL COMMENT '保证金时间',
  `gpbjkssj` varchar(100) DEFAULT NULL COMMENT '挂牌报价开始时间',
  `gpbjjssj` varchar(100) DEFAULT NULL COMMENT '挂牌报价结束时间',
  `fbsjyear` int(4) NOT NULL DEFAULT '0' COMMENT '发布时间年',
  `fbsjmonth` int(4) NOT NULL DEFAULT '0' COMMENT '发布时间月',
  `district_id` int(4) NOT NULL DEFAULT '0' COMMENT '区域ID',
  `plate_id` int(4) NOT NULL DEFAULT '0' COMMENT '板块ID',
  `loop_id` int(4) NOT NULL DEFAULT '0' COMMENT '环线ID',
  `build_area` int(4) DEFAULT '0' COMMENT '建筑面积',
  `green_ratio` varchar(100) DEFAULT NULL COMMENT '绿化率',
  `build_density` varchar(200) DEFAULT NULL COMMENT '建筑密度',
  `build_height` varchar(200) DEFAULT NULL COMMENT '建筑限高',
  `land_status` int(4) DEFAULT '0' COMMENT '土地现状：1，未开工，2，部分开工，3，全部开工',
  `land_zhoubian` varchar(300) DEFAULT NULL COMMENT '周边',
  `contact_tel` varchar(100) DEFAULT NULL COMMENT '联系电话',
  `contact_address` varchar(200) DEFAULT NULL COMMENT '联系地址',
  `jy_address` varchar(200) DEFAULT NULL COMMENT '交易地址',
  `lbj` int(4) NOT NULL DEFAULT '0' COMMENT '楼板价',
  `mmdj` int(4) NOT NULL DEFAULT '0' COMMENT '每亩地价',
  `zxzf` int(4) NOT NULL DEFAULT '0' COMMENT '最小增幅',
  `jmbzj` int(4) NOT NULL DEFAULT '0' COMMENT '竞买保证金',
  `tzqd` int(4) NOT NULL DEFAULT '0' COMMENT '投资强度',
  `block_state` int(4) NOT NULL DEFAULT '0' COMMENT '交易状态：1',
  `crfs_state` int(4) NOT NULL DEFAULT '0' COMMENT '出让类型状态',
  `jdlbj` int(4) NOT NULL DEFAULT '0' COMMENT '竞得楼板价',
  `jdmmdj` int(4) DEFAULT '0' COMMENT '竞得每亩地价',
  `yjl` decimal(10,2) DEFAULT '0.00' COMMENT '溢价率',
  `land_type_id` int(4) NOT NULL DEFAULT '0' COMMENT '土地类型: 1:租赁住房，2:廉租房，3:配套商品房，4:经济适用房，5:两限房，6:其他',
  `house_type_id` int(4) NOT NULL DEFAULT '0' COMMENT '房屋类型：1:住宅，2:商业，3:办公，4:商办，5:综合，6:科研，7:工业，8:其他',
  `house_type_rjl` decimal(10,2) DEFAULT '0.00' COMMENT '容积率',
  `house_id` int(4) NOT NULL DEFAULT '0',
  `house_name` varchar(200) DEFAULT NULL,
  `jdrqyear` int(4) NOT NULL DEFAULT '0' COMMENT '成交年',
  `jdrqmonth` int(4) NOT NULL DEFAULT '0' COMMENT '成交月',
  `is_state` int(4) NOT NULL DEFAULT '0' COMMENT '2是新增，1是修改，0是正常',
  `sf_land_no` varchar(200) DEFAULT NULL COMMENT '搜房土地编号-苏州',
  PRIMARY KEY (`land_id`),
  KEY `idx_city_time` (`city_id`,`fbsjyear`,`fbsjmonth`) USING BTREE,
  KEY `idx_city_jdrq` (`city_id`,`jdrqyear`,`jdrqmonth`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=21814 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dataface_land
-- ----------------------------


-- ----------------------------
-- Table structure for `dataface_land_type`
-- ----------------------------
DROP TABLE IF EXISTS `dataface_land_type`;
CREATE TABLE `dataface_land_type` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `land_id` int(4) NOT NULL,
  `land_type_id` int(4) NOT NULL DEFAULT '0' COMMENT '土地类型: 1:租赁住房，2:廉租房，3:配套商品房，4:经济适用房，5:两限房，6:其他',
  `house_type_id` int(4) NOT NULL DEFAULT '0' COMMENT '房屋类型：1:住宅，2:商业，3:办公，4:商办，5:综合，6:科研，7:工业，8:其他',
  `house_type_rjl` decimal(10,2) DEFAULT '0.00' COMMENT '容积率',
  `house_id` int(4) NOT NULL DEFAULT '0',
  `house_name` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=641 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dataface_land_type
-- ----------------------------


-- ----------------------------
-- Table structure for `dataface_setting`
-- ----------------------------
DROP TABLE IF EXISTS `dataface_setting`;
CREATE TABLE `dataface_setting` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `city_id` int(4) NOT NULL,
  `setting_des` varchar(100) DEFAULT NULL,
  `setting_name` varchar(100) NOT NULL,
  `setting_value` varchar(100) NOT NULL,
  `edit_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_city_name` (`city_id`,`setting_name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=205 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dataface_setting
-- ----------------------------
INSERT INTO `dataface_setting` VALUES ('1', '1', '首页城市宏观时间(年)', 'sh.Index.Yearbook.Date', '2017', '2018-10-30 11:52:37');
INSERT INTO `dataface_setting` VALUES ('2', '1', '首页土地时间(年-月)', 'sh.Index.Land.Date', '2020-3', '2020-04-22 02:31:55');
INSERT INTO `dataface_setting` VALUES ('3', '1', '首页新房时间(年-月)', 'sh.Index.FHouse.Date', '2020-3', '2020-04-22 02:31:59');
INSERT INTO `dataface_setting` VALUES ('4', '1', '首页二手房时间(年-月)', 'sh.Index.SHouse.Date', '2020-3', '2020-04-22 02:32:02');
INSERT INTO `dataface_setting` VALUES ('5', '1', '新房房屋类型', 'sh.FHouse.HouseType', '1,3,8,9,10,11,12,13,14', '2018-10-30 15:14:55');
INSERT INTO `dataface_setting` VALUES ('6', '1', '二手房房屋类型', 'sh.SHouse.HouseType', '1,3,9,10,11,12,13', '2018-10-30 14:53:30');
INSERT INTO `dataface_setting` VALUES ('7', '1', '新房户型是否存在', 'sh.FHouse.Room.IsExist', '1', '2018-11-01 15:52:47');
INSERT INTO `dataface_setting` VALUES ('8', '1', '二手房户型是否存在', 'sh.SHouse.Room.IsExist', '0', '2018-11-01 15:52:44');
INSERT INTO `dataface_setting` VALUES ('9', '1', '新房分组条件', 'sh.FHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('10', '1', '二手房分组条件', 'sh.SHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('11', '2', '首页城市宏观时间(年)', 'bj.Index.Yearbook.Date', '2017', '2018-10-30 11:52:37');
INSERT INTO `dataface_setting` VALUES ('12', '2', '首页土地时间(年-月)', 'bj.Index.Land.Date', '2018-8', '2018-10-30 13:01:00');
INSERT INTO `dataface_setting` VALUES ('13', '2', '首页新房时间(年-月)', 'bj.Index.FHouse.Date', '2020-3', '2020-04-22 02:32:17');
INSERT INTO `dataface_setting` VALUES ('14', '2', '首页二手房时间(年-月)', 'bj.Index.SHouse.Date', '2020-3', '2020-04-22 02:32:23');
INSERT INTO `dataface_setting` VALUES ('15', '2', '新房房屋类型', 'bj.FHouse.HouseType', '1,3,6,7,8,9,10,11,12', '2019-09-11 13:16:28');
INSERT INTO `dataface_setting` VALUES ('16', '2', '二手房房屋类型', 'bj.SHouse.HouseType', '1,6,7', '2019-09-11 13:16:34');
INSERT INTO `dataface_setting` VALUES ('17', '2', '新房户型是否存在', 'bj.FHouse.Room.IsExist', '1', null);
INSERT INTO `dataface_setting` VALUES ('18', '2', '二手房户型是否存在', 'bj.SHouse.Room.IsExist', '1', null);
INSERT INTO `dataface_setting` VALUES ('19', '2', '新房分组条件', 'bj.FHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('20', '2', '二手房分组条件', 'bj.SHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('21', '3', '首页城市宏观时间(年)', 'gz.Index.Yearbook.Date', '2017', '2018-10-30 11:52:37');
INSERT INTO `dataface_setting` VALUES ('22', '3', '首页土地时间(年-月)', 'gz.Index.Land.Date', '2018-8', '2018-10-30 13:01:00');
INSERT INTO `dataface_setting` VALUES ('23', '3', '首页新房时间(年-月)', 'gz.Index.FHouse.Date', '2018-9', '2018-10-30 10:26:23');
INSERT INTO `dataface_setting` VALUES ('24', '3', '首页二手房时间(年-月)', 'gz.Index.SHouse.Date', '2018-9', '2018-10-30 10:26:32');
INSERT INTO `dataface_setting` VALUES ('25', '3', '新房房屋类型', 'gz.FHouse.HouseType', '0', null);
INSERT INTO `dataface_setting` VALUES ('26', '3', '二手房房屋类型', 'gz.SHouse.HouseType', '0', null);
INSERT INTO `dataface_setting` VALUES ('27', '3', '新房户型是否存在', 'gz.FHouse.Room.IsExist', '1', null);
INSERT INTO `dataface_setting` VALUES ('28', '3', '二手房户型是否存在', 'gz.SHouse.Room.IsExist', '1', null);
INSERT INTO `dataface_setting` VALUES ('29', '3', '新房分组条件', 'gz.FHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('30', '3', '二手房分组条件', 'gz.SHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('31', '4', '首页城市宏观时间(年)', 'sz.Index.Yearbook.Date', '2017', '2018-10-30 11:52:37');
INSERT INTO `dataface_setting` VALUES ('32', '4', '首页土地时间(年-月)', 'sz.Index.Land.Date', '2018-8', '2018-10-30 13:01:00');
INSERT INTO `dataface_setting` VALUES ('33', '4', '首页新房时间(年-月)', 'sz.Index.FHouse.Date', '2019-12', '2020-04-22 02:32:36');
INSERT INTO `dataface_setting` VALUES ('34', '4', '首页二手房时间(年-月)', 'sz.Index.SHouse.Date', '2020-3', '2020-04-22 02:32:34');
INSERT INTO `dataface_setting` VALUES ('35', '4', '新房房屋类型', 'sz.FHouse.HouseType', '1,2,6,7,8,9,10,12,15', '2019-03-28 16:03:10');
INSERT INTO `dataface_setting` VALUES ('36', '4', '二手房房屋类型', 'sz.SHouse.HouseType', '1,2,6,7,9,10,11,12', '2019-03-28 16:03:44');
INSERT INTO `dataface_setting` VALUES ('37', '4', '新房户型是否存在', 'sz.FHouse.Room.IsExist', '1', null);
INSERT INTO `dataface_setting` VALUES ('38', '4', '二手房户型是否存在', 'sz.SHouse.Room.IsExist', '1', null);
INSERT INTO `dataface_setting` VALUES ('39', '4', '新房分组条件', 'sz.FHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('40', '4', '二手房分组条件', 'sz.SHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('41', '5', '首页城市宏观时间(年)', 'hz.Index.Yearbook.Date', '2017', '2018-10-30 11:52:37');
INSERT INTO `dataface_setting` VALUES ('42', '5', '首页土地时间(年-月)', 'hz.Index.Land.Date', '2019-2', '2019-03-18 08:51:23');
INSERT INTO `dataface_setting` VALUES ('43', '5', '首页新房时间(年-月)', 'hz.Index.FHouse.Date', '2019-12', '2020-04-22 02:32:49');
INSERT INTO `dataface_setting` VALUES ('44', '5', '首页二手房时间(年-月)', 'hz.Index.SHouse.Date', '2020-3', '2020-04-22 02:32:45');
INSERT INTO `dataface_setting` VALUES ('45', '5', '新房房屋类型', 'hz.FHouse.HouseType', '1,3,8,9,10,11,12', '2018-11-07 21:30:23');
INSERT INTO `dataface_setting` VALUES ('46', '5', '二手房房屋类型', 'hz.SHouse.HouseType', '1', '2018-11-07 21:31:13');
INSERT INTO `dataface_setting` VALUES ('47', '5', '新房户型是否存在', 'hz.FHouse.Room.IsExist', '1', '2018-11-07 21:29:16');
INSERT INTO `dataface_setting` VALUES ('48', '5', '二手房户型是否存在', 'hz.SHouse.Room.IsExist', '0', '2018-11-07 21:28:52');
INSERT INTO `dataface_setting` VALUES ('49', '5', '新房分组条件', 'hz.FHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('50', '5', '二手房分组条件', 'hz.SHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('51', '6', '首页城市宏观时间(年)', 'suzhou.Index.Yearbook.Date', '2016', '2018-11-02 13:44:17');
INSERT INTO `dataface_setting` VALUES ('52', '6', '首页土地时间(年-月)', 'suzhou.Index.Land.Date', '2019-1', '2019-02-19 15:21:01');
INSERT INTO `dataface_setting` VALUES ('53', '6', '首页新房时间(年-月)', 'suzhou.Index.FHouse.Date', '2019-10', '2019-11-26 10:01:25');
INSERT INTO `dataface_setting` VALUES ('54', '6', '首页二手房时间(年-月)', 'suzhou.Index.SHouse.Date', '2019-9', '2019-10-12 14:08:56');
INSERT INTO `dataface_setting` VALUES ('55', '6', '新房房屋类型', 'suzhou.FHouse.HouseType', '1,3,6,7,8,9,10,11,12', '2019-06-17 10:35:45');
INSERT INTO `dataface_setting` VALUES ('56', '6', '二手房房屋类型', 'suzhou.SHouse.HouseType', '1,6,7', '2019-06-17 10:35:50');
INSERT INTO `dataface_setting` VALUES ('57', '6', '新房户型是否存在', 'suzhou.FHouse.Room.IsExist', '1', '2019-06-17 10:35:27');
INSERT INTO `dataface_setting` VALUES ('58', '6', '二手房户型是否存在', 'suzhou.SHouse.Room.IsExist', '0', '2018-11-07 21:32:31');
INSERT INTO `dataface_setting` VALUES ('59', '6', '新房分组条件', 'suzhou.FHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('60', '6', '二手房分组条件', 'suzhou.SHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('61', '7', '首页城市宏观时间(年)', 'qd.Index.Yearbook.Date', '2017', '2018-10-30 11:52:37');
INSERT INTO `dataface_setting` VALUES ('62', '7', '首页土地时间(年-月)', 'qd.Index.Land.Date', '2018-8', '2018-10-30 13:01:00');
INSERT INTO `dataface_setting` VALUES ('63', '7', '首页新房时间(年-月)', 'qd.Index.FHouse.Date', '2018-9', '2018-10-30 10:26:23');
INSERT INTO `dataface_setting` VALUES ('64', '7', '首页二手房时间(年-月)', 'qd.Index.SHouse.Date', '2018-9', '2018-10-30 10:26:32');
INSERT INTO `dataface_setting` VALUES ('65', '7', '新房房屋类型', 'qd.FHouse.HouseType', '0', null);
INSERT INTO `dataface_setting` VALUES ('66', '7', '二手房房屋类型', 'qd.SHouse.HouseType', '0', null);
INSERT INTO `dataface_setting` VALUES ('67', '7', '新房户型是否存在', 'qd.FHouse.Room.IsExist', '1', null);
INSERT INTO `dataface_setting` VALUES ('68', '7', '二手房户型是否存在', 'qd.SHouse.Room.IsExist', '1', null);
INSERT INTO `dataface_setting` VALUES ('69', '7', '新房分组条件', 'qd.FHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('70', '7', '二手房分组条件', 'qd.SHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('71', '1', '宏观统计人口显示列', 'sh.Yearbook.Population.List', 'pop_live,pop_regist,pop_density,total_house', '2018-11-02 17:33:00');
INSERT INTO `dataface_setting` VALUES ('72', '2', '宏观统计人口显示列', 'bj.Yearbook.Population.List', '', '2018-10-30 11:52:37');
INSERT INTO `dataface_setting` VALUES ('73', '3', '宏观统计人口显示列', 'gz.Yearbook.Population.List', '', '2018-10-30 11:52:37');
INSERT INTO `dataface_setting` VALUES ('74', '4', '宏观统计人口显示列', 'sz.Yearbook.Population.List', '', '2018-10-30 11:52:37');
INSERT INTO `dataface_setting` VALUES ('75', '5', '宏观统计人口显示列', 'hz.Yearbook.Population.List', 'pop_live,pop_regist', '2018-11-02 17:33:18');
INSERT INTO `dataface_setting` VALUES ('76', '6', '宏观统计人口显示列', 'suzhou.Yearbook.Population.List', 'pop_live,pop_regist', '2018-11-02 17:33:25');
INSERT INTO `dataface_setting` VALUES ('77', '7', '宏观统计人口显示列', 'qd.Yearbook.Population.List', '', '2018-10-30 11:52:37');
INSERT INTO `dataface_setting` VALUES ('78', '11', '首页城市宏观时间(年)', 'nj.Index.Yearbook.Date', '2017', '2018-10-30 11:52:37');
INSERT INTO `dataface_setting` VALUES ('79', '11', '首页土地时间(年-月)', 'nj.Index.Land.Date', '2018-9', '2018-11-02 22:32:03');
INSERT INTO `dataface_setting` VALUES ('80', '11', '首页新房时间(年-月)', 'nj.Index.FHouse.Date', '2018-12', '2019-01-09 17:30:30');
INSERT INTO `dataface_setting` VALUES ('81', '11', '首页二手房时间(年-月)', 'nj.Index.SHouse.Date', '2019-8', '2019-09-24 14:30:58');
INSERT INTO `dataface_setting` VALUES ('82', '11', '新房房屋类型', 'nj.FHouse.HouseType', '1,3,8,9,10,11,12,14,15', '2018-11-07 21:24:52');
INSERT INTO `dataface_setting` VALUES ('83', '11', '二手房房屋类型', 'nj.SHouse.HouseType', '1,3,8,9,10,11,12', '2018-11-07 21:26:04');
INSERT INTO `dataface_setting` VALUES ('84', '11', '新房户型是否存在', 'nj.FHouse.Room.IsExist', '1', '2018-11-01 15:52:47');
INSERT INTO `dataface_setting` VALUES ('85', '11', '二手房户型是否存在', 'nj.SHouse.Room.IsExist', '0', '2018-11-01 15:52:44');
INSERT INTO `dataface_setting` VALUES ('86', '11', '新房分组条件', 'nj.FHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('87', '11', '二手房分组条件', 'nj.SHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('88', '11', '宏观统计人口显示列', 'nj.Yearbook.Population.List', 'pop_live,pop_regist', '2018-11-07 21:21:38');
INSERT INTO `dataface_setting` VALUES ('89', '1', '二手中介是否存在', 'sh.SHouse.Medium.IsExist', '1', '2018-10-30 11:52:37');
INSERT INTO `dataface_setting` VALUES ('90', '2', '二手中介是否存在', 'bj.SHouse.Medium.IsExist', '1', '2018-10-30 11:52:37');
INSERT INTO `dataface_setting` VALUES ('91', '3', '二手中介是否存在', 'gz.SHouse.Medium.IsExist', '1', '2018-10-30 11:52:37');
INSERT INTO `dataface_setting` VALUES ('92', '4', '二手中介是否存在', 'sz.SHouse.Medium.IsExist', '1', '2018-10-30 11:52:37');
INSERT INTO `dataface_setting` VALUES ('93', '5', '二手中介是否存在', 'hz.SHouse.Medium.IsExist', '1', '2018-10-30 11:52:37');
INSERT INTO `dataface_setting` VALUES ('94', '6', '二手中介是否存在', 'suzhou.SHouse.Medium.IsExist', '0', '2018-11-07 22:10:14');
INSERT INTO `dataface_setting` VALUES ('95', '7', '二手中介是否存在', 'qd.SHouse.Medium.IsExist', '1', '2018-10-30 11:52:37');
INSERT INTO `dataface_setting` VALUES ('96', '11', '二手中介是否存在', 'nj.SHouse.Medium.IsExist', '0', '2018-11-07 22:09:42');
INSERT INTO `dataface_setting` VALUES ('97', '8', '新房分组条件', 'xz.FHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('98', '8', '新房房屋类型', 'xz.FHouse.HouseType', '1,3,8,9,10,11,12,14,15', '2018-11-21 12:55:06');
INSERT INTO `dataface_setting` VALUES ('99', '8', '新房户型是否存在', 'xz.FHouse.Room.IsExist', '1', '2018-11-21 12:55:09');
INSERT INTO `dataface_setting` VALUES ('100', '8', '首页新房时间(年-月)', 'xz.Index.FHouse.Date', '2018-10', '2018-11-21 12:55:13');
INSERT INTO `dataface_setting` VALUES ('101', '8', '首页土地时间(年-月)', 'xz.Index.Land.Date', '2018-9', '2018-11-21 12:55:16');
INSERT INTO `dataface_setting` VALUES ('102', '8', '首页二手房时间(年-月)', 'xz.Index.SHouse.Date', '2018-10', '2018-11-21 12:55:18');
INSERT INTO `dataface_setting` VALUES ('103', '8', '首页城市宏观时间(年)', 'xz.Index.Yearbook.Date', '2017', '2018-11-21 12:55:23');
INSERT INTO `dataface_setting` VALUES ('104', '8', '二手房分组条件', 'xz.SHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('105', '8', '二手房房屋类型', 'xz.SHouse.HouseType', '1,3,8,9,10,11,12', '2018-11-21 12:55:25');
INSERT INTO `dataface_setting` VALUES ('106', '8', '二手中介是否存在', 'xz.SHouse.Medium.IsExist', '0', '2018-11-07 22:09:42');
INSERT INTO `dataface_setting` VALUES ('107', '8', '二手房户型是否存在', 'xz.SHouse.Room.IsExist', '0', '2018-11-01 15:52:44');
INSERT INTO `dataface_setting` VALUES ('108', '8', '宏观统计人口显示列', 'xz.Yearbook.Population.List', 'pop_live,pop_regist', '2018-11-21 12:55:27');
INSERT INTO `dataface_setting` VALUES ('109', '9', '新房分组条件', 'fz.FHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('110', '9', '新房房屋类型', 'fz.FHouse.HouseType', '1,3,8,9,10,11,12,14,15', '2018-11-07 21:24:52');
INSERT INTO `dataface_setting` VALUES ('111', '9', '新房户型是否存在', 'fz.FHouse.Room.IsExist', '1', '2018-11-01 15:52:47');
INSERT INTO `dataface_setting` VALUES ('112', '9', '首页新房时间(年-月)', 'fz.Index.FHouse.Date', '2018-10', '2018-11-16 20:32:30');
INSERT INTO `dataface_setting` VALUES ('113', '9', '首页土地时间(年-月)', 'fz.Index.Land.Date', '2018-9', '2018-11-02 22:32:03');
INSERT INTO `dataface_setting` VALUES ('114', '9', '首页二手房时间(年-月)', 'fz.Index.SHouse.Date', '2018-10', '2018-11-16 17:27:04');
INSERT INTO `dataface_setting` VALUES ('115', '9', '首页城市宏观时间(年)', 'fz.Index.Yearbook.Date', '2017', '2018-10-30 11:52:37');
INSERT INTO `dataface_setting` VALUES ('116', '9', '二手房分组条件', 'fz.SHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('117', '9', '二手房房屋类型', 'fz.SHouse.HouseType', '1,3,8,9,10,11,12', '2018-11-07 21:26:04');
INSERT INTO `dataface_setting` VALUES ('118', '9', '二手中介是否存在', 'fz.SHouse.Medium.IsExist', '0', '2018-11-07 22:09:42');
INSERT INTO `dataface_setting` VALUES ('119', '9', '二手房户型是否存在', 'fz.SHouse.Room.IsExist', '0', '2018-11-01 15:52:44');
INSERT INTO `dataface_setting` VALUES ('120', '9', '宏观统计人口显示列', 'fz.Yearbook.Population.List', 'pop_live,pop_regist', '2018-11-07 21:21:38');
INSERT INTO `dataface_setting` VALUES ('121', '10', '新房分组条件', 'xm.FHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('122', '10', '新房房屋类型', 'xm.FHouse.HouseType', '1,3,8,9,10,11,12,14,15', '2018-11-07 21:24:52');
INSERT INTO `dataface_setting` VALUES ('123', '10', '新房户型是否存在', 'xm.FHouse.Room.IsExist', '1', '2018-11-01 15:52:47');
INSERT INTO `dataface_setting` VALUES ('124', '10', '首页新房时间(年-月)', 'xm.Index.FHouse.Date', '2018-10', '2018-11-16 20:32:30');
INSERT INTO `dataface_setting` VALUES ('125', '10', '首页土地时间(年-月)', 'xm.Index.Land.Date', '2018-9', '2018-11-02 22:32:03');
INSERT INTO `dataface_setting` VALUES ('126', '10', '首页二手房时间(年-月)', 'xm.Index.SHouse.Date', '2018-10', '2018-11-16 17:27:04');
INSERT INTO `dataface_setting` VALUES ('127', '10', '首页城市宏观时间(年)', 'xm.Index.Yearbook.Date', '2017', '2018-10-30 11:52:37');
INSERT INTO `dataface_setting` VALUES ('128', '10', '二手房分组条件', 'xm.SHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('129', '10', '二手房房屋类型', 'xm.SHouse.HouseType', '1,3,8,9,10,11,12', '2018-11-07 21:26:04');
INSERT INTO `dataface_setting` VALUES ('130', '10', '二手中介是否存在', 'xm.SHouse.Medium.IsExist', '0', '2018-11-07 22:09:42');
INSERT INTO `dataface_setting` VALUES ('131', '10', '二手房户型是否存在', 'xm.SHouse.Room.IsExist', '0', '2018-11-01 15:52:44');
INSERT INTO `dataface_setting` VALUES ('132', '10', '宏观统计人口显示列', 'xm.Yearbook.Population.List', 'pop_live,pop_regist', '2018-11-07 21:21:38');
INSERT INTO `dataface_setting` VALUES ('133', '12', '新房分组条件', 'zz.FHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('134', '12', '新房房屋类型', 'zz.FHouse.HouseType', '1,3,8,9,10,11,12,14,15', '2018-11-23 15:26:54');
INSERT INTO `dataface_setting` VALUES ('135', '12', '新房户型是否存在', 'zz.FHouse.Room.IsExist', '1', '2018-11-01 15:52:47');
INSERT INTO `dataface_setting` VALUES ('136', '12', '首页新房时间(年-月)', 'zz.Index.FHouse.Date', '2018-9', '2018-11-27 09:01:13');
INSERT INTO `dataface_setting` VALUES ('137', '12', '首页土地时间(年-月)', 'zz.Index.Land.Date', '2018-9', '2018-11-23 15:26:58');
INSERT INTO `dataface_setting` VALUES ('138', '12', '首页二手房时间(年-月)', 'zz.Index.SHouse.Date', '2018-10', '2018-11-23 15:27:00');
INSERT INTO `dataface_setting` VALUES ('139', '12', '首页城市宏观时间(年)', 'zz.Index.Yearbook.Date', '2017', '2018-10-30 11:52:37');
INSERT INTO `dataface_setting` VALUES ('140', '12', '二手房分组条件', 'zz.SHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('141', '12', '二手房房屋类型', 'zz.SHouse.HouseType', '1,3,8,9,10,11,12', '2018-11-23 15:27:03');
INSERT INTO `dataface_setting` VALUES ('142', '12', '二手中介是否存在', 'zz.SHouse.Medium.IsExist', '0', '2018-11-07 22:09:42');
INSERT INTO `dataface_setting` VALUES ('143', '12', '二手房户型是否存在', 'zz.SHouse.Room.IsExist', '0', '2018-11-01 15:52:44');
INSERT INTO `dataface_setting` VALUES ('144', '12', '宏观统计人口显示列', 'zz.Yearbook.Population.List', 'pop_live,pop_regist', '2018-11-23 15:27:05');
INSERT INTO `dataface_setting` VALUES ('145', '13', '新房分组条件', 'ks.FHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('146', '13', '新房房屋类型', 'ks.FHouse.HouseType', '1,3,8,9,10,11,12,14,15', '2018-11-07 21:24:52');
INSERT INTO `dataface_setting` VALUES ('147', '13', '新房户型是否存在', 'ks.FHouse.Room.IsExist', '1', '2018-11-01 15:52:47');
INSERT INTO `dataface_setting` VALUES ('148', '13', '首页新房时间(年-月)', 'ks.Index.FHouse.Date', '2018-11', '2018-12-19 17:22:26');
INSERT INTO `dataface_setting` VALUES ('149', '13', '首页土地时间(年-月)', 'ks.Index.Land.Date', '2018-9', '2018-11-02 22:32:03');
INSERT INTO `dataface_setting` VALUES ('150', '13', '首页二手房时间(年-月)', 'ks.Index.SHouse.Date', '2018-11', '2018-12-19 17:22:29');
INSERT INTO `dataface_setting` VALUES ('151', '13', '首页城市宏观时间(年)', 'ks.Index.Yearbook.Date', '2017', '2018-11-27 09:10:08');
INSERT INTO `dataface_setting` VALUES ('152', '13', '二手房分组条件', 'ks.SHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('153', '13', '二手房房屋类型', 'ks.SHouse.HouseType', '1,3,8,9,10,11,12', '2018-11-07 21:26:04');
INSERT INTO `dataface_setting` VALUES ('154', '13', '二手中介是否存在', 'ks.SHouse.Medium.IsExist', '0', '2018-11-07 22:09:42');
INSERT INTO `dataface_setting` VALUES ('155', '13', '二手房户型是否存在', 'ks.SHouse.Room.IsExist', '0', '2018-11-01 15:52:44');
INSERT INTO `dataface_setting` VALUES ('156', '13', '宏观统计人口显示列', 'ks.Yearbook.Population.List', 'pop_live,pop_regist', '2018-11-07 21:21:38');
INSERT INTO `dataface_setting` VALUES ('157', '17', '新房分组条件', 'qidong.FHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('158', '17', '新房房屋类型', 'qidong.FHouse.HouseType', '1,3,8,9,10,11,12', '2019-01-03 15:20:53');
INSERT INTO `dataface_setting` VALUES ('159', '17', '新房户型是否存在', 'qidong.FHouse.Room.IsExist', '1', '2018-11-01 15:52:47');
INSERT INTO `dataface_setting` VALUES ('160', '17', '首页新房时间(年-月)', 'qidong.Index.FHouse.Date', '2018-11', '2019-01-03 15:22:28');
INSERT INTO `dataface_setting` VALUES ('161', '17', '首页土地时间(年-月)', 'qidong.Index.Land.Date', '2018-9', '2018-11-02 22:32:03');
INSERT INTO `dataface_setting` VALUES ('162', '17', '首页二手房时间(年-月)', 'qidong.Index.SHouse.Date', '2018-10', '2018-11-16 17:27:04');
INSERT INTO `dataface_setting` VALUES ('163', '17', '首页城市宏观时间(年)', 'qidong.Index.Yearbook.Date', '2017', '2018-10-30 11:52:37');
INSERT INTO `dataface_setting` VALUES ('164', '17', '二手房分组条件', 'qidong.SHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('165', '17', '二手房房屋类型', 'qidong.SHouse.HouseType', '1,3,8,9,10,11,12', '2018-11-07 21:26:04');
INSERT INTO `dataface_setting` VALUES ('166', '17', '二手中介是否存在', 'qidong.SHouse.Medium.IsExist', '0', '2018-11-07 22:09:42');
INSERT INTO `dataface_setting` VALUES ('167', '17', '二手房户型是否存在', 'qidong.SHouse.Room.IsExist', '0', '2018-11-01 15:52:44');
INSERT INTO `dataface_setting` VALUES ('168', '17', '宏观统计人口显示列', 'qidong.Yearbook.Population.List', 'pop_live,pop_regist', '2018-11-07 21:21:38');
INSERT INTO `dataface_setting` VALUES ('169', '18', '新房分组条件', 'xian.FHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('170', '18', '新房房屋类型', 'xian.FHouse.HouseType', '1,3,8,9,10,11,12,13,14', '2018-10-30 15:14:55');
INSERT INTO `dataface_setting` VALUES ('171', '18', '新房户型是否存在', 'xian.FHouse.Room.IsExist', '1', '2018-11-01 15:52:47');
INSERT INTO `dataface_setting` VALUES ('172', '18', '首页新房时间(年-月)', 'xian.Index.FHouse.Date', '2019-6', '2019-07-12 11:32:38');
INSERT INTO `dataface_setting` VALUES ('173', '18', '首页土地时间(年-月)', 'xian.Index.Land.Date', '2019-1', '2019-02-19 15:20:19');
INSERT INTO `dataface_setting` VALUES ('174', '18', '首页二手房时间(年-月)', 'xian.Index.SHouse.Date', '2019-1', '2019-09-24 14:30:44');
INSERT INTO `dataface_setting` VALUES ('175', '18', '首页城市宏观时间(年)', 'xian.Index.Yearbook.Date', '2017', '2018-10-30 11:52:37');
INSERT INTO `dataface_setting` VALUES ('176', '18', '二手房分组条件', 'xian.SHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('177', '18', '二手房房屋类型', 'xian.SHouse.HouseType', '1,3,9,10,11,12,13', '2018-10-30 14:53:30');
INSERT INTO `dataface_setting` VALUES ('178', '18', '二手中介是否存在', 'xian.SHouse.Medium.IsExist', '1', '2018-10-30 11:52:37');
INSERT INTO `dataface_setting` VALUES ('179', '18', '二手房户型是否存在', 'xian.SHouse.Room.IsExist', '0', '2018-11-01 15:52:44');
INSERT INTO `dataface_setting` VALUES ('180', '18', '宏观统计人口显示列', 'xian.Yearbook.Population.List', 'pop_live,pop_regist,pop_density,total_house', '2018-11-02 17:33:00');
INSERT INTO `dataface_setting` VALUES ('181', '19', '新房分组条件', 'hf.FHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('182', '19', '新房房屋类型', 'hf.FHouse.HouseType', '1,3,8,9,10,11,12,13,14', '2018-10-30 15:14:55');
INSERT INTO `dataface_setting` VALUES ('183', '19', '新房户型是否存在', 'hf.FHouse.Room.IsExist', '1', '2018-11-01 15:52:47');
INSERT INTO `dataface_setting` VALUES ('184', '19', '首页新房时间(年-月)', 'hf.Index.FHouse.Date', '2018-6', '2019-03-27 14:01:17');
INSERT INTO `dataface_setting` VALUES ('185', '19', '首页土地时间(年-月)', 'hf.Index.Land.Date', '2019-2', '2019-03-18 08:50:48');
INSERT INTO `dataface_setting` VALUES ('186', '19', '首页二手房时间(年-月)', 'hf.Index.SHouse.Date', '2019-8', '2019-09-24 14:30:50');
INSERT INTO `dataface_setting` VALUES ('187', '19', '首页城市宏观时间(年)', 'hf.Index.Yearbook.Date', '2017', '2018-10-30 11:52:37');
INSERT INTO `dataface_setting` VALUES ('188', '19', '二手房分组条件', 'hf.SHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('189', '19', '二手房房屋类型', 'hf.SHouse.HouseType', '1,3,9,10,11,12,13', '2018-10-30 14:53:30');
INSERT INTO `dataface_setting` VALUES ('190', '19', '二手中介是否存在', 'hf.SHouse.Medium.IsExist', '1', '2018-10-30 11:52:37');
INSERT INTO `dataface_setting` VALUES ('191', '19', '二手房户型是否存在', 'hf.SHouse.Room.IsExist', '0', '2018-11-01 15:52:44');
INSERT INTO `dataface_setting` VALUES ('192', '19', '宏观统计人口显示列', 'hf.Yearbook.Population.List', 'pop_live,pop_regist', '2019-03-27 14:00:37');
INSERT INTO `dataface_setting` VALUES ('193', '20', '新房分组条件', 'sy.FHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('194', '20', '新房房屋类型', 'sy.FHouse.HouseType', '1,3,8,9,10,11,12,13,14', '2018-10-30 15:14:55');
INSERT INTO `dataface_setting` VALUES ('195', '20', '新房户型是否存在', 'sy.FHouse.Room.IsExist', '1', '2018-11-01 15:52:47');
INSERT INTO `dataface_setting` VALUES ('196', '20', '首页新房时间(年-月)', 'sy.Index.FHouse.Date', '2019-2', '2019-03-18 08:50:52');
INSERT INTO `dataface_setting` VALUES ('197', '20', '首页土地时间(年-月)', 'sy.Index.Land.Date', '2019-2', '2019-03-18 08:50:48');
INSERT INTO `dataface_setting` VALUES ('198', '20', '首页二手房时间(年-月)', 'sy.Index.SHouse.Date', '2019-3', '2019-04-16 09:38:18');
INSERT INTO `dataface_setting` VALUES ('199', '20', '首页城市宏观时间(年)', 'sy.Index.Yearbook.Date', '2017', '2018-10-30 11:52:37');
INSERT INTO `dataface_setting` VALUES ('200', '20', '二手房分组条件', 'sy.SHouse.Group', '0', null);
INSERT INTO `dataface_setting` VALUES ('201', '20', '二手房房屋类型', 'sy.SHouse.HouseType', '1,3,9,10,11,12,13', '2018-10-30 14:53:30');
INSERT INTO `dataface_setting` VALUES ('202', '20', '二手中介是否存在', 'sy.SHouse.Medium.IsExist', '1', '2018-10-30 11:52:37');
INSERT INTO `dataface_setting` VALUES ('203', '20', '二手房户型是否存在', 'sy.SHouse.Room.IsExist', '0', '2018-11-01 15:52:44');
INSERT INTO `dataface_setting` VALUES ('204', '20', '宏观统计人口显示列', 'sy.Yearbook.Population.List', 'pop_live,pop_regist', '2018-11-02 17:33:00');

-- ----------------------------
-- Table structure for `dataface_user_browse`
-- ----------------------------
DROP TABLE IF EXISTS `dataface_user_browse`;
CREATE TABLE `dataface_user_browse` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `city_id` int(4) NOT NULL,
  `browse_id` int(4) NOT NULL COMMENT '浏览ID',
  `browse_name` varchar(200) NOT NULL COMMENT '浏览名称',
  `browse_type` int(4) NOT NULL DEFAULT '0' COMMENT '1新房，2二手，3土地',
  `user_id` int(4) NOT NULL,
  `add_time` datetime DEFAULT NULL,
  `edit_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_city_type` (`city_id`,`browse_type`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9409 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dataface_user_browse
-- ----------------------------


-- ----------------------------
-- Table structure for `dataface_user_collect`
-- ----------------------------
DROP TABLE IF EXISTS `dataface_user_collect`;
CREATE TABLE `dataface_user_collect` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `user_id` int(4) NOT NULL,
  `city_id` int(4) NOT NULL,
  `is_first` int(4) DEFAULT '0',
  `collect_name` varchar(500) NOT NULL DEFAULT '0',
  `collect_value` varchar(500) DEFAULT NULL,
  `collect_type` int(4) DEFAULT '1' COMMENT '1 楼盘，2，新房查询条件 3 二手查询条件 4，土地 ,10 小程序楼盘,20中介小程序楼盘',
  `add_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=214 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dataface_user_collect
-- ----------------------------


-- ----------------------------
-- Table structure for `dataface_user_info`
-- ----------------------------
DROP TABLE IF EXISTS `dataface_user_info`;
CREATE TABLE `dataface_user_info` (
  `user_id` int(4) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(128) CHARACTER SET utf8 DEFAULT '',
  `real_name` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `user_mobile` bigint(20) DEFAULT '0',
  `user_pass` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT '登陆密码',
  `user_company` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT '公司名',
  `user_position` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT '职位',
  `user_city` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT '用户所在城市',
  `wx_open_id` varchar(64) CHARACTER SET utf8 DEFAULT '',
  `wx_union_id` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  `city_id` int(4) DEFAULT '1' COMMENT '默认城市，当前最后一次访问城市',
  `registration_time` datetime DEFAULT NULL,
  `last_login_time` datetime DEFAULT NULL,
  `auth_type` int(11) DEFAULT '0' COMMENT '1 管理 ，0无权限，2可以登陆',
  `user_token` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `is_del` smallint(2) NOT NULL DEFAULT '0' COMMENT '是否是删除的，1是删除的',
  `user_source` int(4) NOT NULL DEFAULT '10' COMMENT '用户来源：网页版10,小程序20，H530',
  `is_dataface` smallint(2) NOT NULL DEFAULT '0' COMMENT '1为dataface内部，不参与订单计算',
  `is_bandbrowser` smallint(2) NOT NULL DEFAULT '0' COMMENT '标记是否绑定过浏览器，1为需要绑定，2为绑定过的',
  `browser_token` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT '绑定浏览器token',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2579 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dataface_user_info
-- ----------------------------


-- ----------------------------
-- Table structure for `dataface_user_power`
-- ----------------------------
DROP TABLE IF EXISTS `dataface_user_power`;
CREATE TABLE `dataface_user_power` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `city_id` int(10) NOT NULL,
  `model_id` int(10) NOT NULL COMMENT 'model_id模块分类，1，新房监测，2，二手监测，3，土地 4，排行  10, 微信新房，20 微信二手',
  `valid_date` date DEFAULT NULL COMMENT '有效日期',
  `add_time` datetime DEFAULT NULL,
  `edit_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1460 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dataface_user_power
-- ----------------------------


-- ----------------------------
-- Table structure for `dataface_user_powerinfo`
-- ----------------------------
DROP TABLE IF EXISTS `dataface_user_powerinfo`;
CREATE TABLE `dataface_user_powerinfo` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `city_id` int(10) NOT NULL,
  `model_id` int(10) NOT NULL,
  `valid_date` date DEFAULT NULL COMMENT '有效日期',
  `add_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2050 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dataface_user_powerinfo
-- ----------------------------


-- ----------------------------
-- Table structure for `dataface_user_sales`
-- ----------------------------
DROP TABLE IF EXISTS `dataface_user_sales`;
CREATE TABLE `dataface_user_sales` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `sales_no` varchar(100) NOT NULL COMMENT '订单号',
  `city_id` int(4) NOT NULL DEFAULT '0',
  `is_first` int(4) NOT NULL DEFAULT '0',
  `user_id` int(4) NOT NULL DEFAULT '0',
  `open_id` varchar(100) NOT NULL DEFAULT '0',
  `house_id` int(4) NOT NULL DEFAULT '0',
  `district_id` int(4) NOT NULL DEFAULT '0',
  `plate_id` int(4) NOT NULL DEFAULT '0',
  `sales_cost` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '费用: 单位分',
  `transaction_id` varchar(100) NOT NULL DEFAULT '0' COMMENT '微信流水帐号',
  `erro_msg` varchar(100) NOT NULL DEFAULT 'ok' COMMENT '出错描述',
  `sales_type` int(4) NOT NULL DEFAULT '0' COMMENT '1:楼盘，2：区域, 3：板块，4: 城市,5：vip',
  `body` varchar(500) DEFAULT NULL COMMENT '描述',
  `sales_num` int(4) NOT NULL DEFAULT '0' COMMENT '购买次数',
  `sales_source` int(4) NOT NULL COMMENT '来源：10 网页，20，dataface, 30 数脸',
  `status` int(4) NOT NULL DEFAULT '0' COMMENT '订单状态：0未支付，1支付，2取消 3 出错 4 未知',
  `is_web` int(4) NOT NULL DEFAULT '0' COMMENT '是否来源后台系统',
  `valid_date` date NOT NULL COMMENT '过期时间',
  `add_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=909 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dataface_user_sales
-- ----------------------------


-- ----------------------------
-- Table structure for `dataface_user_salesinfo`
-- ----------------------------
DROP TABLE IF EXISTS `dataface_user_salesinfo`;
CREATE TABLE `dataface_user_salesinfo` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `sales_no` varchar(100) NOT NULL COMMENT '订单号',
  `city_id` int(4) NOT NULL DEFAULT '0',
  `is_first` int(4) NOT NULL DEFAULT '0',
  `user_id` int(4) NOT NULL DEFAULT '0',
  `open_id` varchar(100) NOT NULL DEFAULT '0',
  `house_id` int(4) NOT NULL DEFAULT '0',
  `district_id` int(4) NOT NULL DEFAULT '0',
  `plate_id` int(4) NOT NULL DEFAULT '0',
  `sales_cost` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '费用: 单位分',
  `transaction_id` varchar(100) NOT NULL DEFAULT '0' COMMENT '微信流水帐号',
  `erro_msg` varchar(100) NOT NULL DEFAULT 'ok' COMMENT '出错描述',
  `sales_type` int(4) NOT NULL DEFAULT '0' COMMENT '1:楼盘，2：区域, 3：板块，4: 城市,5：vip',
  `body` varchar(500) DEFAULT NULL COMMENT '描述',
  `sales_num` int(4) NOT NULL DEFAULT '0',
  `sales_source` int(4) NOT NULL COMMENT '来源：10 网页，20，dataface, 30 数脸',
  `status` int(4) NOT NULL DEFAULT '0' COMMENT '订单状态：0未支付，1支付，2取消 3 出错 4 未知',
  `is_web` int(4) NOT NULL DEFAULT '0' COMMENT '是否来源后台系统',
  `valid_date` date NOT NULL COMMENT '过期时间',
  `add_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=871 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dataface_user_salesinfo
-- ----------------------------


-- ----------------------------
-- Table structure for `dataface_user_salesnum`
-- ----------------------------
DROP TABLE IF EXISTS `dataface_user_salesnum`;
CREATE TABLE `dataface_user_salesnum` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `user_id` int(4) NOT NULL DEFAULT '0',
  `city_id` int(4) NOT NULL DEFAULT '0',
  `is_first` int(4) NOT NULL DEFAULT '0',
  `sales_num` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dataface_user_salesnum
-- ----------------------------


-- ----------------------------
-- Table structure for `dataface_user_scan`
-- ----------------------------
DROP TABLE IF EXISTS `dataface_user_scan`;
CREATE TABLE `dataface_user_scan` (
  `scan_id` int(4) NOT NULL AUTO_INCREMENT,
  `scan_key` varchar(64) NOT NULL DEFAULT '' COMMENT '扫描生成的唯一key',
  `create_time` datetime NOT NULL COMMENT '创造的时间',
  `wx_token` varchar(256) NOT NULL DEFAULT '' COMMENT '扫描后微信的token',
  PRIMARY KEY (`scan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of dataface_user_scan
-- ----------------------------

-- ----------------------------
-- Table structure for `dataface_user_setting`
-- ----------------------------
DROP TABLE IF EXISTS `dataface_user_setting`;
CREATE TABLE `dataface_user_setting` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `user_id` int(4) NOT NULL,
  `city_id` int(4) NOT NULL,
  `group_area` varchar(200) DEFAULT NULL COMMENT '面积段',
  `group_price` varchar(200) DEFAULT NULL COMMENT '单价段',
  `group_tprice` varchar(200) DEFAULT NULL COMMENT '总价段',
  `land_group_area` varchar(200) DEFAULT NULL COMMENT '土地面积段',
  `land_group_barea` varchar(200) DEFAULT NULL COMMENT '土地建筑面积段',
  `land_group_tprice` varchar(200) DEFAULT NULL COMMENT '土地总价段',
  `land_group_price` varchar(200) DEFAULT NULL,
  `land_group_rjl` varchar(200) DEFAULT NULL COMMENT '土地容积率',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dataface_user_setting
-- ----------------------------

-- ----------------------------
-- Table structure for `dataface_yearbook_district`
-- ----------------------------
DROP TABLE IF EXISTS `dataface_yearbook_district`;
CREATE TABLE `dataface_yearbook_district` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `city_id` int(4) NOT NULL DEFAULT '0',
  `district_id` int(4) NOT NULL,
  `district_name` varchar(100) NOT NULL,
  `district_area` decimal(10,2) DEFAULT NULL COMMENT '行政面积，单位平方公里',
  `resident_population` decimal(10,2) DEFAULT NULL COMMENT '常住人口 单位万',
  `external_population` decimal(10,2) DEFAULT NULL COMMENT '外来人口 单位万',
  `population_density` int(10) NOT NULL DEFAULT '0' COMMENT '人口密度 单位 人/平方公里',
  `district_des` varchar(1000) DEFAULT NULL,
  `edit_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dataface_yearbook_district
-- ----------------------------


-- ----------------------------
-- Table structure for `dataface_yearbook_fixedassets`
-- ----------------------------
DROP TABLE IF EXISTS `dataface_yearbook_fixedassets`;
CREATE TABLE `dataface_yearbook_fixedassets` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `city_id` int(4) NOT NULL DEFAULT '0',
  `fa_year` int(4) NOT NULL DEFAULT '0' COMMENT '固定资产年',
  `fa_quarter` int(4) NOT NULL DEFAULT '0',
  `fa_month` int(4) NOT NULL DEFAULT '0',
  `fa_value_total` int(4) NOT NULL DEFAULT '0' COMMENT '自年初累计值（亿）',
  `fa_value_month` int(4) NOT NULL DEFAULT '0' COMMENT '当月值（亿）',
  `fa_value_quarter` int(4) NOT NULL DEFAULT '0' COMMENT '当季值（亿）',
  `fixe_assets_value` int(4) NOT NULL DEFAULT '0' COMMENT '固定资产投资',
  `infrastructure_value` int(4) NOT NULL DEFAULT '0' COMMENT '基础设置投资(亿)',
  `fixe_assets_house` int(4) NOT NULL DEFAULT '0' COMMENT '固定投资-房地产(亿)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=974 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dataface_yearbook_fixedassets
-- ----------------------------


-- ----------------------------
-- Table structure for `dataface_yearbook_gdp`
-- ----------------------------
DROP TABLE IF EXISTS `dataface_yearbook_gdp`;
CREATE TABLE `dataface_yearbook_gdp` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `city_id` int(4) NOT NULL DEFAULT '0',
  `gdp_year` int(4) NOT NULL DEFAULT '0' COMMENT '年',
  `gdp_quarter` int(4) NOT NULL DEFAULT '0' COMMENT '季',
  `gdp_value_total` int(10) NOT NULL DEFAULT '0' COMMENT '自年初累计值(亿)',
  `gdp_value_quarter` int(10) NOT NULL DEFAULT '0' COMMENT '当季值(亿)',
  `first_value` int(10) NOT NULL DEFAULT '0' COMMENT '第一产业值(亿)',
  `second_value` int(10) NOT NULL DEFAULT '0' COMMENT '第二产业值(亿)',
  `third_value` int(10) NOT NULL DEFAULT '0' COMMENT '第三产业值(亿)',
  `total_value` int(10) NOT NULL DEFAULT '0' COMMENT '总值(亿）',
  `per_gdp` int(10) NOT NULL DEFAULT '0' COMMENT '人均国内生成总值(元)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=327 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dataface_yearbook_gdp
-- ----------------------------


-- ----------------------------
-- Table structure for `dataface_yearbook_population`
-- ----------------------------
DROP TABLE IF EXISTS `dataface_yearbook_population`;
CREATE TABLE `dataface_yearbook_population` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `city_id` int(4) NOT NULL,
  `pop_year` int(4) NOT NULL DEFAULT '0' COMMENT '年',
  `pop_total` int(4) NOT NULL DEFAULT '0' COMMENT '总人口(万)',
  `pop_regist` int(4) NOT NULL DEFAULT '0' COMMENT '户籍人口(万)',
  `pop_live` int(4) NOT NULL DEFAULT '0' COMMENT '常住人口(万)',
  `pop_urban` int(4) NOT NULL DEFAULT '0' COMMENT '城镇人口(万)',
  `urbanization` int(4) NOT NULL DEFAULT '0' COMMENT '城市化率%',
  `pop_density` int(4) NOT NULL DEFAULT '0' COMMENT '人口密度（人/平方公里）',
  `total_house` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总户数（万户）',
  PRIMARY KEY (`id`),
  KEY `idx_city_year` (`city_id`,`pop_year`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=155 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dataface_yearbook_population
-- ----------------------------


-- ----------------------------
-- Table structure for `dataface_yearbook_qol`
-- ----------------------------
DROP TABLE IF EXISTS `dataface_yearbook_qol`;
CREATE TABLE `dataface_yearbook_qol` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `city_id` int(4) NOT NULL,
  `qol_year` int(4) NOT NULL DEFAULT '0' COMMENT '年',
  `build_q_area` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '建成区面积(平方公里)',
  `live_use_area` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '居住用地面积(平方公里)',
  `city_area` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '全市面积(平方公里)',
  `per_use_area` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '居民人均居住用地面积(平方米)',
  `per_build_area` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '居民人均居住建筑面积(平方米)',
  `per_disposable_income` int(10) NOT NULL DEFAULT '0' COMMENT '人均可支配收入(元)',
  `per_consumer_spending` int(10) NOT NULL DEFAULT '0' COMMENT '人均消费性支出',
  `savings_surplus` int(10) NOT NULL DEFAULT '0' COMMENT '居民储蓄余额(元)',
  `pcs_food` int(10) NOT NULL DEFAULT '0' COMMENT '人均消费-食品',
  `pcs_clothes` int(10) NOT NULL DEFAULT '0' COMMENT '人均消费-衣服',
  `pcs_home_kits` int(10) NOT NULL DEFAULT '0' COMMENT '人均消费-家庭设备及服务',
  `pcs_medical_care` int(10) NOT NULL DEFAULT '0' COMMENT '人均消费-医疗保健',
  `pcs_traffic_tel` int(10) NOT NULL DEFAULT '0' COMMENT '人均消费-交通通讯',
  `pcs_education` int(10) NOT NULL DEFAULT '0' COMMENT '人均消费-教育',
  `pcs_live` int(10) NOT NULL DEFAULT '0' COMMENT '人均消费-居住',
  `pcs_other` int(10) NOT NULL DEFAULT '0' COMMENT '人均消费-其他',
  PRIMARY KEY (`id`),
  KEY `idx_city_year` (`city_id`,`qol_year`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=162 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dataface_yearbook_qol
-- ----------------------------

-- ----------------------------
-- Table structure for `dataface_yearbook_realtybuildarea`
-- ----------------------------
DROP TABLE IF EXISTS `dataface_yearbook_realtybuildarea`;
CREATE TABLE `dataface_yearbook_realtybuildarea` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `city_id` int(4) NOT NULL DEFAULT '0',
  `realty_year` int(4) NOT NULL DEFAULT '0' COMMENT '年',
  `realty_month` int(4) NOT NULL DEFAULT '0',
  `realty_spf_total_buildarea` int(10) NOT NULL DEFAULT '0' COMMENT '商品房累计值(万平米)',
  `realty_spf_month_buildarea` int(10) NOT NULL DEFAULT '0' COMMENT '商品房当前值(万平米)',
  `realty_zz_total_buildarea` int(10) NOT NULL DEFAULT '0' COMMENT '住宅累计值(万平米)',
  `realty_zz_month_buildarea` int(10) NOT NULL DEFAULT '0' COMMENT '住宅当前值(万平米)',
  `realty_jsf_total_buildarea` int(10) NOT NULL DEFAULT '0' COMMENT '经适房累计值(万平米）',
  `realty_jsf_month_buildarea` int(10) NOT NULL DEFAULT '0' COMMENT '经适房当前值(万平米）',
  `realty_bs_total_buildarea` int(10) NOT NULL DEFAULT '0' COMMENT '别墅累计值(万平米）',
  `realty_bs_month_buildarea` int(10) NOT NULL DEFAULT '0' COMMENT '别墅当前值(万平米）',
  `realty_bg_total_buildarea` int(10) NOT NULL DEFAULT '0' COMMENT '办公累计值(万平米）',
  `realty_bg_month_buildarea` int(10) NOT NULL DEFAULT '0' COMMENT '办公当前值(万平米）',
  `realty_sy_total_buildarea` int(10) NOT NULL DEFAULT '0' COMMENT '商业累计值(万平米）',
  `realty_sy_month_buildarea` int(10) NOT NULL DEFAULT '0' COMMENT '商业当前值(万平米）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=698 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dataface_yearbook_realtybuildarea
-- ----------------------------


-- ----------------------------
-- Table structure for `dataface_yearbook_realtycompletedarea`
-- ----------------------------
DROP TABLE IF EXISTS `dataface_yearbook_realtycompletedarea`;
CREATE TABLE `dataface_yearbook_realtycompletedarea` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `city_id` int(4) NOT NULL DEFAULT '0',
  `realty_year` int(4) NOT NULL DEFAULT '0' COMMENT '年',
  `realty_month` int(4) NOT NULL DEFAULT '0',
  `realty_spf_total_completedarea` int(10) NOT NULL DEFAULT '0' COMMENT '商品房累计值(万平米)',
  `realty_spf_month_completedarea` int(10) NOT NULL DEFAULT '0' COMMENT '商品房当前值(万平米)',
  `realty_zz_total_completedarea` int(10) NOT NULL DEFAULT '0' COMMENT '住宅累计值(万平米)',
  `realty_zz_month_completedarea` int(10) NOT NULL DEFAULT '0' COMMENT '住宅当前值(万平米)',
  `realty_jsf_total_completedarea` int(10) NOT NULL DEFAULT '0' COMMENT '经适房累计值(万平米）',
  `realty_jsf_month_completedarea` int(10) NOT NULL DEFAULT '0' COMMENT '经适房当前值(万平米）',
  `realty_bs_total_completedarea` int(10) NOT NULL DEFAULT '0' COMMENT '别墅累计值(万平米）',
  `realty_bs_month_completedarea` int(10) NOT NULL DEFAULT '0' COMMENT '别墅当前值(万平米）',
  `realty_bg_total_completedarea` int(10) NOT NULL DEFAULT '0' COMMENT '办公累计值(万平米）',
  `realty_bg_month_completedarea` int(10) NOT NULL DEFAULT '0' COMMENT '办公当前值(万平米）',
  `realty_sy_total_completedarea` int(10) NOT NULL DEFAULT '0' COMMENT '商业累计值(万平米）',
  `realty_sy_month_completedarea` int(10) NOT NULL DEFAULT '0' COMMENT '商业当前值(万平米）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=653 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dataface_yearbook_realtycompletedarea
-- ----------------------------

-- ----------------------------
-- Table structure for `dataface_yearbook_realtynewstartarea`
-- ----------------------------
DROP TABLE IF EXISTS `dataface_yearbook_realtynewstartarea`;
CREATE TABLE `dataface_yearbook_realtynewstartarea` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `city_id` int(4) NOT NULL DEFAULT '0',
  `realty_year` int(4) NOT NULL DEFAULT '0' COMMENT '年',
  `realty_month` int(4) NOT NULL DEFAULT '0',
  `realty_spf_total_newstartarea` int(10) NOT NULL DEFAULT '0' COMMENT '商品房累计值(万平米)',
  `realty_spf_month_newstartarea` int(10) NOT NULL DEFAULT '0' COMMENT '商品房当前值(万平米)',
  `realty_zz_total_newstartarea` int(10) NOT NULL DEFAULT '0' COMMENT '住宅累计值(万平米)',
  `realty_zz_month_newstartarea` int(10) NOT NULL DEFAULT '0' COMMENT '住宅当前值(万平米)',
  `realty_jsf_total_newstartarea` int(10) NOT NULL DEFAULT '0' COMMENT '经适房累计值(万平米）',
  `realty_jsf_month_newstartarea` int(10) NOT NULL DEFAULT '0' COMMENT '经适房当前值(万平米）',
  `realty_bs_total_newstartarea` int(10) NOT NULL DEFAULT '0' COMMENT '别墅累计值(万平米）',
  `realty_bs_month_newstartarea` int(10) NOT NULL DEFAULT '0' COMMENT '别墅当前值(万平米）',
  `realty_bg_total_newstartarea` int(10) NOT NULL DEFAULT '0' COMMENT '办公累计值(万平米）',
  `realty_bg_month_newstartarea` int(10) NOT NULL DEFAULT '0' COMMENT '办公当前值(万平米）',
  `realty_sy_total_newstartarea` int(10) NOT NULL DEFAULT '0' COMMENT '商业累计值(万平米）',
  `realty_sy_month_newstartarea` int(10) NOT NULL DEFAULT '0' COMMENT '商业当前值(万平米）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=604 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dataface_yearbook_realtynewstartarea
-- ----------------------------

-- ----------------------------
-- Table structure for `dataface_yearbook_realtyprice`
-- ----------------------------
DROP TABLE IF EXISTS `dataface_yearbook_realtyprice`;
CREATE TABLE `dataface_yearbook_realtyprice` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `city_id` int(4) NOT NULL DEFAULT '0',
  `realty_year` int(4) NOT NULL DEFAULT '0' COMMENT '年',
  `realty_month` int(4) NOT NULL DEFAULT '0',
  `realty_spf_total_price` int(10) NOT NULL DEFAULT '0' COMMENT '商品房累计值(亿)',
  `realty_spf_month_price` int(10) NOT NULL DEFAULT '0' COMMENT '商品房当前值(亿)',
  `realty_zz_total_price` int(10) NOT NULL DEFAULT '0' COMMENT '住宅累计值(亿)',
  `realty_zz_month_price` int(10) NOT NULL DEFAULT '0' COMMENT '住宅当前值(亿)',
  `realty_jsf_total_price` int(10) NOT NULL DEFAULT '0' COMMENT '经适房累计值(亿）',
  `realty_jsf_month_price` int(10) NOT NULL DEFAULT '0' COMMENT '经适房当前值(亿）',
  `realty_bs_total_price` int(10) NOT NULL DEFAULT '0' COMMENT '别墅累计值(亿）',
  `realty_bs_month_price` int(10) NOT NULL DEFAULT '0' COMMENT '别墅当前值(亿）',
  `realty_bg_total_price` int(10) NOT NULL DEFAULT '0' COMMENT '办公',
  `realty_bg_month_price` int(10) NOT NULL DEFAULT '0',
  `realty_sy_total_price` int(10) NOT NULL DEFAULT '0',
  `realty_sy_month_price` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=913 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dataface_yearbook_realtyprice
-- ----------------------------
