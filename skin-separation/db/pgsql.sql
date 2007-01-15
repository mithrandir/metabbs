CREATE TABLE meta_boards (
  id serial,
  name varchar(45) NOT NULL default '',
  posts_per_page integer NOT NULL default 0,
  skin varchar(45) NOT NULL default '',
  title varchar(255) NOT NULL default '',
  use_attachment smallint NOT NULL default '0',
  PRIMARY KEY  (id)
);
CREATE INDEX NAME on meta_boards(name);

CREATE TABLE meta_comments (
  id serial,
  post_id integer NOT NULL default 0,
  user_id integer NOT NULL default 0,
  name varchar(45) NOT NULL default '',
  password varchar(32) NOT NULL default '',
  body text NOT NULL,
  created_at timestamp NOT NULL,
  PRIMARY KEY  (id)
);
CREATE INDEX POST_COMMENTS on meta_comments(post_id);

CREATE TABLE meta_posts (
  id serial,
  board_id integer NOT NULL default 0,
  name varchar(45) NOT NULL default '',
  title varchar(255) NOT NULL default '',
  body text NOT NULL,
  password varchar(32) NOT NULL default '',
  created_at timestamp NOT NULL,
  PRIMARY KEY  (id)
);
CREATE INDEX BOARD on meta_posts(board_id);

CREATE TABLE meta_attachments (
  id serial,
  post_id integer NOT NULL default 0,
  filename varchar(255) NOT NULL default '',
  PRIMARY KEY  (id)
);
CREATE INDEX POST on meta_attachments(post_id);

CREATE TABLE meta_trackbacks (
  id serial,
  blog_name varchar(255) NOT NULL default '',
  title varchar(255) NOT NULL default '',
  excerpt text NOT NULL,
  url varchar(255) NOT NULL default '',
  post_id integer NOT NULL default 0,
  PRIMARY KEY  (id)
);
CREATE INDEX POST_TRACKBACK on meta_trackbacks(post_id);

CREATE TABLE "meta_users" (
  "id" serial ,
  "user" varchar(45) NOT NULL default '',
  "password" varchar(32) NOT NULL default '',
  "name" varchar(45) NOT NULL default '',
  "email" varchar(255) NOT NULL default '',
  "url" varchar(255) NOT NULL default '',
  "level" int NOT NULL default '0',
  PRIMARY KEY  ("id")
);
