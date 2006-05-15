-- Not Support auto_increment sql keyword
-- INTEGER PRIMARY KEY is auto_increment
-- timestamp type is only a string type need to process on php
CREATE TABLE 'meta_boards' (
  'id' INTEGER PRIMARY KEY,
  'name' varchar(45) NOT NULL default '',
  'posts_per_page' unsigned int NOT NULL default '0',
  'skin' varchar(45) NOT NULL default '',
  'title' varchar(255) NOT NULL default '',
  'use_attachment' int NOT NULL default '0'
);
CREATE index 'NAME_boards' ON 'meta_boards' ('name');

CREATE TABLE 'meta_comments' (
  'id' INTEGER PRIMARY KEY,
  'post_id' unsigned int NOT NULL default '0',
  'name' varchar(45) NOT NULL default '',
  'password' varchar(32) NOT NULL default '',
  'body' text NOT NULL,
  'created_at' timestamp NOT NULL
);
CREATE index 'POST_comments' ON 'meta_comments' ('post_id');

CREATE TABLE 'meta_posts' (
  'id' INTEGER PRIMARY KEY,
  'board_id' unsigned int NOT NULL default '0',
  'name' varchar(45) NOT NULL default '',
  'title' varchar(255) NOT NULL default '',
  'body' longtext NOT NULL,
  'password' varchar(32) NOT NULL default '',
  'created_at' timestamp NOT NULL
);
CREATE index 'BOARD_posts' ON 'meta_posts' ('board_id');

CREATE TABLE 'meta_attachments' (
  'id' INTEGER PRIMARY KEY,
  'post_id' unsigned int unsigned NOT NULL default '0',
  'filename' varchar(255) NOT NULL default ''
);
CREATE index 'POST_attachments' ON 'meta_attachments' ('post_id');

CREATE TABLE 'meta_trackbacks' (
  'id' INTEGER PRIMARY KEY,
  'blog_name' varchar(255) NOT NULL default '',
  'title' varchar(255) NOT NULL default '',
  'excerpt' text NOT NULL,
  'url' varchar(255) NOT NULL default '',
  'post_id' unsigned int NOT NULL default '0'
);
CREATE index 'POST_trackbacks' ON 'meta_trackbacks' ('post_id');
