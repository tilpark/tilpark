CREATE TABLE IF NOT EXISTS `{prefix}log_meta` (
  `id`       INT(11) NOT NULL AUTO_INCREMENT,
  `log_id`   INT(11) NOT NULL,
  `meta_val` TEXT    NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = INNODB
  DEFAULT CHARSET = UTF8;