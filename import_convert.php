<?
include_once "includes/bootstrap.inc";
include_once "includes/common.inc";

function generate_prepare_feed($feed) {
    $node->uid = 1;
    $node->type = 'feed';
    $node->title = $feed->title;
    $node->body = $feed->description;
    $node->status = 1;
    $node->url = $feed->url;
    $node->refresh = $feed->refresh;
    $node->link = $feed->link;
    $node->promote = 0;
    $node->comment = 2;
    $node->created = $feed->checked;
    $node->changed = $feed->modified;
  return $node;
}

db_query("TRUNCATE TABLE `item`");

db_query("ALTER TABLE `item` 
	CHANGE `iid` `nid` INT( 10 ) DEFAULT '0' NOT NULL ,
	CHANGE `fid` `parent` INT( 10 ) DEFAULT '0' NOT NULL,
	DROP `author` ,
	DROP `description` ,
	DROP `timestamp` ,
	DROP `attributes`,
	ADD `weight` INT( 10 ) DEFAULT '0' NOT NULL AFTER `parent`,
	ADD `guid` VARCHAR( 255 ) AFTER `link`,
	ADD `data` TEXT AFTER `guid` ,
	DROP PRIMARY KEY ,
	ADD PRIMARY KEY ( nid, parent ) ,
	ADD KEY link( link ) ,
	ADD KEY guid( guid )");

db_query("ALTER TABLE `feed` RENAME `old_feed`");

db_query("CREATE TABLE feed (
  nid int(10) unsigned NOT NULL default '0',
  url varchar(255) NOT NULL default '',
  refresh int(10) NOT NULL default '0',
  link varchar(255) NOT NULL default '',
  data text,
  expire int(10) NOT NULL default '0',
  PRIMARY KEY  (nid),
  KEY link (link),
  KEY url (url)
) TYPE=MyISAM");
db_query("TRUNCATE TABLE `feed`");

$result = db_query("SELECT * FROM `old_feed`");

while($feed = db_fetch_object($result)){
  $node = generate_prepare_feed($feed);
  $node->nid = node_save($node);
  db_query("INSERT INTO feed (nid, url, refresh, link, expire, data) VALUES('%d', '%s', '%d', '%s', '%d', '%s')", $node->nid, $node->url, $node->refresh, $node->link, $node->expire, $data);
  print "inserted feed ".$nid." : ".$node->title."<br/>\n";
}
?>