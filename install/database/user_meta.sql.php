CREATE TABLE IF NOT EXISTS `{prefix}user_meta` (
  `id`         BIGINT(20)  NOT NULL AUTO_INCREMENT,
  `user_id`    BIGINT(20)  NOT NULL,
  `meta_key`   VARCHAR(32) NOT NULL,
  `meta_value` TEXT        NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = INNODB
  DEFAULT CHARSET = UTF8;