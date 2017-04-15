CREATE TABLE IF NOT EXISTS `{prefix}form_meta` (
  `id`         INT(11)     NOT NULL AUTO_INCREMENT,
  `form_id`    INT(11)     NOT NULL,
  `meta_key`   VARCHAR(32) NOT NULL,
  `meta_value` TEXT        NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = INNODB
  DEFAULT CHARSET = UTF8;