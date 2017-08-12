<?php
require_once(dirname(__FILE__).'/../../../../Connections/local_i.php');
require_once(dirname(__FILE__).'/../../../../webassist/mysqli/rsobj.php');

class Query {

  public static function getAll($table) {
    global $local_i;
    $query = new WA_MySQLi_RS($table, $local_i, 0);
    $query->setQuery("SELECT * FROM ".$table);
    $query->execute();
    return $query->Results;
  }

  public static function getWhere($table,$where) {
    global $local_i;
    $str = "";
    foreach ($where as $key => $val) {
      $str .= $key."='".$val."',";
    }
    $str = rtrim($str,',');

    $query = new WA_MySQLi_RS($table, $local_i, 0);
    $query->setQuery("SELECT * FROM ".$table." WHERE ".$str);
    $query->execute();
    return $query->Results;
  }
  public static function create($table) {
    global $local_i;
    $str = "";
    foreach ($where as $key => $val) {
      $str .= $key."='".$val."',";
    }
    $str = rtrim($str,',');

    $query = new WA_MySQLi_RS($table, $local_i, 0);
    $query->insertQuery("INSERT INTO ".$table." ".$str."");
	
    $query->execute();
    return $query->Results;
  }
}
?>
