ALTER TABLE "meta_boards"
  ADD "perm_read" int NOT NULL default '0',
  ADD "perm_write" int NOT NULL default '0',
  ADD "perm_comment" int NOT NULL default '0',
  ADD "perm_delete" int NOT NULL default '255';

ALTER TABLE "meta_posts"
  ADD "user_id" int NOT NULL default '0';
