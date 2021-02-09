<?php 
session_start();
include_once('sstm_db.inc');

$ID = $_GET['id'];
$db->where('ID', $ID);
$suite = $db->getOne('suite');


?>
<p>&nbsp;<br>&nbsp;</p>

<h1><?php echo $suite['Name']; ?></h1>