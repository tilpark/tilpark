CREATE TABLE IF NOT EXISTS `{prefix}extra` (
  `id`          INT(11)         NOT NULL AUTO_INCREMENT,
  `taxonomy`    VARCHAR(64)     NOT NULL,
  `name`        VARCHAR(128)    NOT NULL,
  `val`         TEXT            NOT NULL,
  `val_1`       VARCHAR(128)    NOT NULL,
  `val_2`       VARCHAR(128)    NOT NULL,
  `val_3`       VARCHAR(128)    NOT NULL,
  `val_4`       VARCHAR(256)    NOT NULL,
  `val_5`       VARCHAR(256)    NOT NULL,
  `val_6`       VARCHAR(256)    NOT NULL,
  `val_7`       VARCHAR(512)    NOT NULL,
  `val_8`       VARCHAR(512)    NOT NULL,
  `val_9`       VARCHAR(512)    NOT NULL,
  `val_text`    TEXT            NOT NULL,
  `val_int`     INT(11)         NOT NULL,
  `val_decimal` DECIMAL(15, 4)  NOT NULL,
  `val_date`    DATETIME        NOT NULL,
  `val_enum`    ENUM ('0', '1') NOT NULL,
  UNIQUE KEY `id` (`id`)
)
  ENGINE = INNODB
  DEFAULT CHARSET = UTF8;