CREATE TABLE IF NOT EXISTS "igrok" (
  "uid" INTEGER PRIMARY KEY NOT NULL default "0",
  "imia" varchar(50) NOT NULL default "",
  "famil" varchar(50) NOT NULL default "",
  "born" date NOT NULL default "1900-00-00",
  "sex" char(1) NOT NULL default "m",
  "city" varchar(50) default NULL,
  "country" varchar(50) NOT NULL default "",
  "email" varchar(50) default NULL,
  "url" varchar(255) default NULL,
  "icq" varchar(10) default NULL,
  "stamp" timestamp NOT NULL,
  "foto" varchar(50) default NULL,
  "status" char(11) NOT NULL default "o",
  "historical" char(1) default NULL
);

CREATE TABLE IF NOT EXISTS "igrok_team" (
  "rid" INTEGER PRIMARY KEY,
  "uid" int(11) NOT NULL default '0',
  "tid" int(11) NOT NULL default '0',
  "turnir" int(11) NOT NULL default '0',
  "stamp" timestamp NOT NULL,
  "status" char(1) NOT NULL default 'o'
);

CREATE TABLE "same_team" (
  "name" varchar(255) NOT NULL default '',
  "ids" varchar(255) default NULL,
  "stamp" timestamp NOT NULL,
  "tid" int(11) NOT NULL default '0',
  "clubid" int(11) NOT NULL default '0',
  "old_turnir" tinyint(1) NOT NULL default '0'
);

CREATE TABLE "team" (
  "tid" INTEGER PRIMARY KEY NOT NULL default '0',
  "imia" varchar(50) NOT NULL default '',
  "url" varchar(255) default NULL,
  "list" varchar(50) default NULL,
  "kap" int(11) NOT NULL default '0',
  "stamp" timestamp NOT NULL,
  "regno" char(3) NOT NULL default '',
  "turnir" int(11) NOT NULL default '0',
  "second_email" varchar(50) default NULL,
  "channel" varchar(20) default NULL
);
CREATE table users (
	"email" varchar(255) not null,
	"password" varchar(255) not null,
	"role" varchar(255) not null,
	"tid" varchar(255) not null
);
