CREATE TABLE `meta_boards` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) NOT NULL default '',
  `posts_per_page` int(10) unsigned NOT NULL default '0',
  `skin` varchar(45) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `use_attachment` enum('0','1') NOT NULL default '0',
  `perm_read` int(10) unsigned NOT NULL default '0',
  `perm_write` int(10) unsigned NOT NULL default '0',
  `perm_comment` int(10) unsigned NOT NULL default '0',
  `perm_delete` int(10) unsigned NOT NULL default '255',
  PRIMARY KEY  (`id`),
  KEY `NAME` (`name`)
);

CREATE TABLE `meta_comments` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `post_id` int(10) unsigned NOT NULL default '0',
  `user_id` int(10) unsigned NOT NULL default '0',
  `name` varchar(45) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `body` text NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `POST` (`post_id`)
);

CREATE TABLE `meta_posts` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `board_id` int(10) unsigned NOT NULL default '0',
  `name` varchar(45) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `body` longtext NOT NULL,
  `password` varchar(32) NOT NULL default '',
  `created_at` timestamp NOT NULL,
  `user_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `BOARD` (`board_id`)
);

CREATE TABLE `meta_attachments` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `post_id` int(10) unsigned NOT NULL default '0',
  `filename` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `POST` (`post_id`)
);

CREATE TABLE `meta_trackbacks` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `blog_name` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `excerpt` text NOT NULL,
  `url` varchar(255) NOT NULL default '',
  `post_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `POST` (`post_id`)
);

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
