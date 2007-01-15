ALTER TABLE `meta_boards`
  ADD `perm_read` int(10) unsigned NOT NULL default '0',
  ADD `perm_write` int(10) unsigned NOT NULL default '0',
  ADD `perm_comment` int(10) unsigned NOT NULL default '0',
  ADD `perm_delete` int(10) unsigned NOT NULL default '255';

ALTER TABLE `meta_posts`
  ADD `user_id` int(10) unsigned NOT NULL default '0';

ALTER TABLE `meta_comments`
  ADD `user_id` int(10) unsigned NOT NULL default '0';

CREATE TABLE `meta_users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user` varchar(45) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `name` varchar(45) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `level` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
);
