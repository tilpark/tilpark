CREATE TABLE `{prefix}accounts` (
  `id`       INT(11)        NOT NULL AUTO_INCREMENT,
  `status`   INT(1)         NOT NULL DEFAULT '1',
  `date`     DATETIME       NOT NULL,
  `type`     VARCHAR(10)    NOT NULL,
  `code`     VARCHAR(32)    NOT NULL,
  `name`     VARCHAR(32)    NOT NULL,
  `email`    VARCHAR(100)   NOT NULL,
  `gsm`      VARCHAR(20)    NOT NULL,
  `phone`    VARCHAR(20)    NOT NULL,
  `address`  VARCHAR(500)   NOT NULL,
  `city`     VARCHAR(20)    NOT NULL,
  `district` VARCHAR(20)    NOT NULL,
  `country`  VARCHAR(20)    NOT NULL,
  `tax_no`   VARCHAR(20)    NOT NULL,
  `tax_home` VARCHAR(20)    NOT NULL,
  `balance`  DECIMAL(15, 4) NOT NULL,
  `profit`   DECIMAL(15, 4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `code` (`code`),
  KEY `name` (`name`),
  KEY `gsm` (`gsm`),
  KEY `name_2` (`name`),
  KEY `gsm_2` (`gsm`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;