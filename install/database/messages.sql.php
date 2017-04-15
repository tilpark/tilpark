CREATE TABLE IF NOT EXISTS `{prefix}messages` (
  `id`                INT(11)         NOT NULL AUTO_INCREMENT,
  `date`              DATETIME        NOT NULL,
  `status`            INT(1)          NOT NULL DEFAULT '1',
  `type`              VARCHAR(12)     NOT NULL DEFAULT '',
  `top_id`            INT(11)         NOT NULL,
  `sen_u_id`          INT(11)         NOT NULL,
  `rec_u_id`          INT(11)         NOT NULL,
  `title`             VARCHAR(255)    NOT NULL,
  `message`           TEXT            NOT NULL,
  `read_it`           ENUM ('0', '1') NOT NULL DEFAULT '0',
  `inbox_u_id`        INT(11)         NOT NULL,
  `outbox_u_id`       INT(11)         NOT NULL,
  `date_update`       DATETIME        NOT NULL,
  `sen_trash_u_id`    INT(11)         NOT NULL,
  `rec_trash_u_id`    INT(11)         NOT NULL,
  `date_start`        DATETIME        NOT NULL,
  `date_end`          DATETIME        NOT NULL,
  `choice`            TEXT            NOT NULL,
  `type_status`       VARCHAR(10)     NOT NULL,
  `writing`           VARCHAR(255)    NOT NULL DEFAULT '',
  `notification_seen` INT(2)          NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = INNODB
  DEFAULT CHARSET = UTF8;