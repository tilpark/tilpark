CREATE TABLE IF NOT EXISTS `{prefix}logs` (
  `id`         INT(11)      NOT NULL AUTO_INCREMENT,
  `date`       DATETIME     NOT NULL,
  `uniquetime` CHAR(15)     NOT NULL,
  `table_id`   VARCHAR(20)  NOT NULL,
  `user_id`    INT(11)      NOT NULL,
  `log_url`    VARCHAR(250) NOT NULL,
  `log_key`    VARCHAR(64)  NOT NULL,
  `log_text`   VARCHAR(500) NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = INNODB
  DEFAULT CHARSET = UTF8;