#
# Table structure for table `earnings`
#
# Creation: Aug 29, 2004 at 12:39 AM
# Last update: Aug 29, 2004 at 01:41 AM
# Last check: Aug 29, 2004 at 12:39 AM
#

CREATE TABLE `earnings` (
  `earnings_id` int(11) NOT NULL auto_increment,
  `earnings_user_id` int(11) NOT NULL default '0',
  `earnings_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `earnings_num` varchar(35) NOT NULL default '',
  `earnings_submit_company_id` int(10) NOT NULL default '0',
  `earnings_submit_contact` varchar(50) NOT NULL default '',
  `earnings_submit_email` varchar(200) NOT NULL default '',
  `earnings_submit_address1` varchar(50) NOT NULL default '',
  `earnings_submit_address2` varchar(50) NOT NULL default '',
  `earnings_submit_city` varchar(30) NOT NULL default '',
  `earnings_submit_state` varchar(30) NOT NULL default '',
  `earnings_submit_zip` varchar(11) NOT NULL default '',
  `earnings_submit_phone` varchar(20) NOT NULL default '',
  `earnings_terms` varchar(10) NOT NULL default 'NET30',
  `earnings_comments` varchar(250) NOT NULL default '',
  `earnings_total` int(20) NOT NULL default '0',
  `earnings_submitted` datetime NOT NULL default '0000-00-00 00:00:00',
  `earnings_submitted_comment` varchar(250) NOT NULL default '',
  `earnings_approved` datetime NOT NULL default '0000-00-00 00:00:00',
  `earnings_approved_comment` varchar(250) NOT NULL default '',
  `earnings_paid` datetime NOT NULL default '0000-00-00 00:00:00',
  `earnings_paid_comment` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`earnings_id`),
  UNIQUE KEY `earnings_num` (`earnings_num`),
  KEY `earnings_user_id` (`earnings_user_id`)
) TYPE=MyISAM AUTO_INCREMENT=15 ;
# --------------------------------------------------------

#
# Table structure for table `earnings_items`
#
# Creation: Aug 02, 2004 at 11:31 PM
# Last update: Aug 29, 2004 at 01:17 AM
# Last check: Aug 25, 2004 at 02:23 PM
#

CREATE TABLE `earnings_items` (
  `earnings_items_id` int(11) NOT NULL auto_increment,
  `earnings_parent_id` int(11) default NULL,
  `earnings_tasklog_id` int(11) default NULL,
  `earnings_item_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `earnings_item_description` text NOT NULL,
  `earnings_item_hours` float NOT NULL default '0',
  `earnings_item_costcode` varchar(8) NOT NULL default '',
  `earnings_item_rate` float NOT NULL default '0',
  PRIMARY KEY  (`earnings_items_id`),
  KEY `earnings_parent_id` (`earnings_parent_id`)
) TYPE=MyISAM AUTO_INCREMENT=57 ;

