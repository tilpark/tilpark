CREATE TABLE IF NOT EXISTS `{prefix}users` (
  `id`             INT(11)         NOT NULL AUTO_INCREMENT,
  `date`           DATETIME        NOT NULL,
  `status`         INT(1)          NOT NULL DEFAULT '1',
  `username`       VARCHAR(255)    NOT NULL,
  `password`       CHAR(32)        NOT NULL,
  `name`           VARCHAR(20)     NOT NULL,
  `surname`        VARCHAR(20)     NOT NULL,
  `gsm`            VARCHAR(10)     NOT NULL,
  `role`           INT(1)          NOT NULL,
  `avatar`         VARCHAR(255)    NOT NULL,
  `gender`         ENUM ('0', '1') NOT NULL,
  `citizenship_no` VARCHAR(20)     NOT NULL,
  `til_login`      TINYINT(1)      NOT NULL DEFAULT '0',
  `account_id`     INT(11)         NOT NULL,
  `email`          VARCHAR(255)    NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
)
  ENGINE = INNODB
  DEFAULT CHARSET = UTF8;