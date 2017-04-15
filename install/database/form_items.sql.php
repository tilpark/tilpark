CREATE TABLE IF NOT EXISTS `{prefix}form_items` (
  `id`          INT(11)        NOT NULL AUTO_INCREMENT,
  `status`      INT(1)         NOT NULL DEFAULT '1',
  `date`        DATETIME       NOT NULL,
  `type`        VARCHAR(20)    NOT NULL DEFAULT 'item',
  `in_out`      INT(1)         NOT NULL DEFAULT '1',
  `form_id`     INT(11)        NOT NULL,
  `account_id`  INT(11)        NOT NULL,
  `item_id`     INT(11)        NOT NULL,
  `item_code`   VARCHAR(32)    NOT NULL,
  `item_name`   VARCHAR(50)    NOT NULL,
  `item_p_purc` DECIMAL(15, 4) NOT NULL,
  `item_p_sale` DECIMAL(15, 4) NOT NULL,
  `price`       DECIMAL(15, 4) NOT NULL,
  `quantity`    INT(11)        NOT NULL,
  `vat`         INT(2)         NOT NULL,
  `vat_total`   DECIMAL(15, 4) NOT NULL,
  `total`       DECIMAL(15, 4) NOT NULL,
  `profit`      DECIMAL(15, 4) NOT NULL,
  `val_1`       VARCHAR(32)    NOT NULL,
  `val_2`       VARCHAR(512)   NOT NULL,
  `val_3`       VARCHAR(1024)  NOT NULL,
  `val_int`     INT(11)        NOT NULL,
  `val_date`    DATETIME       NOT NULL,
  `val_decimal` DECIMAL(15, 4) NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = INNODB
  DEFAULT CHARSET = UTF8;