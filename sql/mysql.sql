#
# Table structure for table `tdmmoney_account`
#

CREATE TABLE `tdmmoney_account` (
  `account_id`       INT(8)         NOT NULL  AUTO_INCREMENT,
  `account_name`     VARCHAR(255)   NOT NULL,
  `account_bank`     VARCHAR(255)   NOT NULL,
  `account_adress`   TEXT           NOT NULL,
  `account_balance`  DECIMAL(10, 2) NOT NULL  DEFAULT '0.00',
  `account_currency` VARCHAR(10)    NOT NULL,
  PRIMARY KEY (`account_id`)
)
  ENGINE = MyISAM;

#
# Table structure for table `tdmmoney_category`
#

CREATE TABLE `tdmmoney_category` (
  `cat_cid`    INT(5) UNSIGNED NOT NULL  AUTO_INCREMENT,
  `cat_pid`    INT(5) UNSIGNED NOT NULL,
  `cat_title`  VARCHAR(255)    NOT NULL,
  `cat_desc`   TEXT            NOT NULL,
  `cat_weight` INT(5)          NOT NULL,
  PRIMARY KEY (`cat_cid`)
)
  ENGINE = MyISAM;

#
# Table structure for table `tdmmoney_operation`
#

CREATE TABLE `tdmmoney_operation` (
  `operation_id`           INT(8)         NOT NULL  AUTO_INCREMENT,
  `operation_account`      INT(8)         NOT NULL,
  `operation_category`     INT(8)         NOT NULL,
  `operation_type`         INT(8)         NOT NULL,
  `operation_sender`       INT(8)         NOT NULL,
  `operation_outsender`    VARCHAR(50)    NOT NULL,
  `operation_date`         INT(10)        NOT NULL,
  `operation_amount`       DECIMAL(10, 2) NOT NULL  DEFAULT '0.00',
  `operation_description`  TEXT           NOT NULL,
  `operation_submitter`    INT(10)        NOT NULL  DEFAULT '0',
  `operation_date_created` INT(10)        NOT NULL  DEFAULT '0',
  PRIMARY KEY (`operation_id`)
)
  ENGINE = MyISAM;

