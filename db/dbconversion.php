<?php
$dbname = 'rfknew';
mysql_connect('localhost', 'root', '');
mysql_query("ALTER DATABASE `$dbname` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
$result = mysql_query("SHOW TABLES FROM `$dbname`");
while($row = mysql_fetch_row($result)) {
 $query = "ALTER TABLE {$dbname}.`{$row[0]}` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci";
 mysql_query($query);
 $query = "ALTER TABLE {$dbname}.`{$row[0]}` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
 mysql_query($query);
}
echo 'All the tables have been converted successfully';
?>
