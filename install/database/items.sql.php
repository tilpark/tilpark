CREATE TABLE IF NOT EXISTS `{prefix}items` (
  `id`             INT(11)        NOT NULL AUTO_INCREMENT,
  `status`         INT(1)         NOT NULL DEFAULT '1',
  `date`           DATETIME       NOT NULL,
  `type`           VARCHAR(10)    NOT NULL,
  `code`           VARCHAR(32)    NOT NULL,
  `name`           VARCHAR(100)   NOT NULL,
  `p_purc_out_vat` DECIMAL(15, 4) NOT NULL,
  `p_sale_out_vat` DECIMAL(15, 4) NOT NULL,
  `vat`            INT(2)         NOT NULL,
  `p_purc`         DECIMAL(15, 4) NOT NULL,
  `p_sale`         DECIMAL(15, 4) NOT NULL,
  `quantity`       INT(11)        NOT NULL,
  `total_purc`     DECIMAL(15, 4) NOT NULL,
  `total_sale`     DECIMAL(15, 4) NOT NULL,
  `profit`         DECIMAL(15, 4) NOT NULL,
  UNIQUE KEY `id` (`id`)
)
  ENGINE = INNODB
  DEFAULT CHARSET = UTF8;