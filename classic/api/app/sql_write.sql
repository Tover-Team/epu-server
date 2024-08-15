CREATE TABLE `push_index` (
  `id` BIGINT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `push_1` BIGINT(11) UNSIGNED NOT NULL DEFAULT '0',
  `push_2` BIGINT(11) UNSIGNED NOT NULL DEFAULT '0',
  `push_3` BIGINT(11) UNSIGNED NOT NULL DEFAULT '0',
  `push_4` BIGINT(11) UNSIGNED NOT NULL DEFAULT '0',
  `push_5` BIGINT(11) UNSIGNED NOT NULL DEFAULT '0',
  `push_6` BIGINT(11) UNSIGNED NOT NULL DEFAULT '0',
  `push_7` BIGINT(11) UNSIGNED NOT NULL DEFAULT '0',
  `push_8` BIGINT(11) UNSIGNED NOT NULL DEFAULT '0',
  `push_9` BIGINT(11) UNSIGNED NOT NULL DEFAULT '0',
  `push_10` BIGINT(11) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
-- INSERT INTO `push_index`(`id`, `push_1`, `push_2`, `push_3`, `push_4`, `push_5`, `push_6`, `push_7`, `push_8`, `push_9`, `push_10`) VALUES (0,0,0,0,0,0,0,0,0,0,0)

CREATE TABLE `push_message` (
  `id` BIGINT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `to` VARCHAR(255) NOT NULL,
  `from` VARCHAR(255) NOT NULL,
  `message` VARCHAR(255) NOT NULL,
  `type` VARCHAR(255) NOT NULL,
  `page` VARCHAR(255) NOT NULL,
  `timestamp` DATETIME NOT NULL,
  `wr_1` VARCHAR(255),
  `wr_2` VARCHAR(255),
  `wr_3` VARCHAR(255),
  `wr_4` VARCHAR(255),
  `wr_5` VARCHAR(255),
  `wr_6` VARCHAR(255),
  `wr_7` VARCHAR(255),
  `wr_8` VARCHAR(255),
  `wr_9` VARCHAR(255),
  `wr_10` VARCHAR(255),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `push_notice` (
  `id` BIGINT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `to` VARCHAR(255) NOT NULL,
  `from` VARCHAR(255) NOT NULL,
  `message` VARCHAR(255) NOT NULL,
  `type` VARCHAR(255) NOT NULL,
  `page` VARCHAR(255) NOT NULL,
  `timestamp` DATETIME NOT NULL,
  `wr_1` VARCHAR(255),
  `wr_2` VARCHAR(255),
  `wr_3` VARCHAR(255),
  `wr_4` VARCHAR(255),
  `wr_5` VARCHAR(255),
  `wr_6` VARCHAR(255),
  `wr_7` VARCHAR(255),
  `wr_8` VARCHAR(255),
  `wr_9` VARCHAR(255),
  `wr_10` VARCHAR(255),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `app_update_history` (
  `id` BIGINT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `app_name` VARCHAR(255) NOT NULL,
  `version` VARCHAR(255) NOT NULL,
  `timestamp` DATETIME NOT NULL,
  `wr_1` VARCHAR(255),
  `wr_2` VARCHAR(255),
  `wr_3` VARCHAR(255),
  `wr_4` VARCHAR(255),
  `wr_5` VARCHAR(255),
  `wr_6` VARCHAR(255),
  `wr_7` VARCHAR(255),
  `wr_8` VARCHAR(255),
  `wr_9` VARCHAR(255),
  `wr_10` VARCHAR(255),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `app_info` (
  `id` BIGINT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `app_name` VARCHAR(255) NOT NULL,
  `platform` VARCHAR(255) NOT NULL,
  `latest_version` VARCHAR(255) NOT NULL,
  `minimum_version` VARCHAR(255) NOT NULL,
  `wr_1` VARCHAR(255),
  `wr_2` VARCHAR(255),
  `wr_3` VARCHAR(255),
  `wr_4` VARCHAR(255),
  `wr_5` VARCHAR(255),
  `wr_6` VARCHAR(255),
  `wr_7` VARCHAR(255),
  `wr_8` VARCHAR(255),
  `wr_9` VARCHAR(255),
  `wr_10` VARCHAR(255),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- INSERT INTO `app_info`(`app_name`, `platform`, `latest_version`, `minimum_version`) VALUES ("epu", "iOS", "0.1.0", "0.1.0")

-- Alter table g5_member add (push_1 int(255) default '0', push_2 int(255) default '0');
-- Alter table g5_member add (push_3 int(255) default '0', push_4 int(255) default '0', push_5 int(255) default '0', push_6 int(255) default '0', push_7 int(255) default '0', push_8 int(255) default '0', push_9 int(255) default '0', push_10 int(255) default '0');