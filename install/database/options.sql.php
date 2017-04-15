CREATE TABLE IF NOT EXISTS `{prefix}options` (
  `id`           INT(11)     NOT NULL AUTO_INCREMENT,
  `option_name`  VARCHAR(64) NOT NULL DEFAULT '',
  `option_value` TEXT        NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = INNODB
  DEFAULT CHARSET = UTF8;