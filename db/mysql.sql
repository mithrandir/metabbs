CREATE TABLE `meta_boards` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) NOT NULL default '',
  `posts_per_page` int(10) unsigned NOT NULL default '0',
  `skin` varchar(45) NOT NULL default '',
  PRIMARY KEY  (`id`)
);

CREATE TABLE `meta_posts` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `board_id` int(10) unsigned NOT NULL default '0',
  `name` varchar(45) NOT NULL default '',
  `subject` varchar(255) NOT NULL default '',
  `body` longtext NOT NULL,
  `password` varchar(32) NOT NULL default '',
  `created_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`,`board_id`)
);

CREATE TABLE `meta_comments` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `post_id` int(10) unsigned NOT NULL default '0',
  `name` varchar(45) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `body` text NOT NULL,
  `created_at` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`,`post_id`)
);

