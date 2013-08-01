<style>
    * { font-family: Calibri}
</style>
<h1>Database Facade 1</h1>

<?php
require_once("database.class.php");

echo "<h3> Available methods </h3>";
var_dump(get_class_methods(Database::createConnection()));

//----
$db = Database::createConnection();

var_dump($db->fetchAll('tbl_country'));
