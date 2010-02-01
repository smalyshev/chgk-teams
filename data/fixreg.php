<?
$m = mysql_connect("localhost", "chgk", "chgk");
mysql_select_db("chgk");
$res = mysql_query(" select distinct tid,clubid,name from same_team where tid>0 AND clubid!=0 and clubid!=-1 order by clubid");

while ($row = mysql_fetch_assoc($res)) {
	echo "{$row["tid"]} {$row["clubid"]}\n";
	mysql_query("update team set regno={$row["clubid"]} where tid={$row["tid"]}");
}
