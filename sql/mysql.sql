#
# Table structure for table `tdmmoney_account`
#
		
CREATE TABLE  `tdmmoney_account` (
`account_id` int (8)   NOT NULL  auto_increment,
`account_name` varchar (255)   NOT NULL ,
`account_bank` varchar (255)   NOT NULL ,
`account_adress` text   NOT NULL ,
`account_balance` decimal(10,2) NOT NULL DEFAULT '0.00',
`account_currency` varchar (10)   NOT NULL ,
PRIMARY KEY (`account_id`)
) ENGINE=MyISAM;

#
# Table structure for table `tdmmoney_category`
#
		
CREATE TABLE  `tdmmoney_category` (
`cat_cid` int (5) unsigned NOT NULL  auto_increment,
`cat_pid` int (5) unsigned NOT NULL ,
`cat_title` varchar (255)   NOT NULL ,
`cat_desc` text   NOT NULL ,
`cat_weight` int (5)   NOT NULL ,
PRIMARY KEY (`cat_cid`)
) ENGINE=MyISAM;

#
# Table structure for table `tdmmoney_operation`
#
		
CREATE TABLE  `tdmmoney_operation` (
`operation_id` int (8)   NOT NULL  auto_increment,
`operation_account` int (8)   NOT NULL ,
`operation_category` int (8)   NOT NULL ,
`operation_type` int (8)   NOT NULL ,
`operation_sender` int (8)   NOT NULL ,
`operation_outsender` varchar (50)   NOT NULL ,
`operation_date` int (10)   NOT NULL ,
`operation_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
`operation_description` text   NOT NULL ,
`operation_submitter` int (10)   NOT NULL default '0',
`operation_date_created` int (10)   NOT NULL default '0',
PRIMARY KEY (`operation_id`)
) ENGINE=MyISAM;

