-- --------------------------------------------------------
--
-- Table structure for table `ds_auth`
--
DROP TABLE IF EXISTS `push_service`;
CREATE TABLE IF NOT EXISTS `ds_user` (
  `userID` varchar(20) NOT NULL default '',
  `token` varchar(300) NOT NULL default '',
  `storeNumber` varchar(20) NOT NULL default '',
  `reqDate` timestamp  NOT NULL default CURRENT_TIMESTAMP,
  `mb_id` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`userID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ds_push`;
CREATE TABLE IF NOT EXISTS `ds_push` (
  `userID` varchar(20) NOT NULL default '',
  `message` varchar(20) NOT NULL default '',
  `isAndroid` varchar(20) NOT NULL default '',
  `isIOS` varchar(20) NOT NULL default '',
  `success` varchar(20) NOT NULL default '',
  `fail` varchar(20) NOT NULL default '',
  `reqDate` timestamp  NOT NULL default CURRENT_TIMESTAMP,
 PRIMARY KEY  (`userID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ds_connect`;
CREATE TABLE IF NOT EXISTS `ds_connect` (
  `userID` varchar(20) NOT NULL default '',
  `storeNumber` varchar(20) NOT NULL default '',
  `reqDate` timestamp  NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`userID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ds_visit`;
CREATE TABLE IF NOT EXISTS `ds_visit` (
  `userID` varchar(20) NOT NULL default '',
  `storeNumber` varchar(20) NOT NULL default '',
  `reqDate` timestamp  NOT NULL default CURRENT_TIMESTAMP,
 PRIMARY KEY  (`userID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ds_push_history`;
CREATE TABLE IF NOT EXISTS `ds_push_history` (
  `success` varchar(20) default '',
  `text` varchar(200) NOT NULL default '',
  `fail` varchar(20) default '',
  `reqDate` timestamp  NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`text`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
