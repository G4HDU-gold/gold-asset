CREATE TABLE gold_asset_cat (
  gasset_cat_id int(11) unsigned NOT NULL auto_increment,
  gasset_cat_name varchar(25) default NULL,
  gasset_cat_class int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (gasset_cat_id)
) TYPE=MyISAM COMMENT='Gold Asset Categories';
CREATE TABLE gold_asset (
  gpresy_id int(11) unsigned NOT NULL auto_increment,
  gasset_user_id int(11) unsigned NOT NULL default '0',
  gasset_asset varchar(100) NOT NULL default '',
  gasset_bought int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (gpresy_id),
  KEY gasset_Asset (gasset_asset),
  KEY gasset_User (gasset_user_id)
) TYPE=MyISAM COMMENT='Gold Assets';


