<?php 
require_once("dbcontroller.php");
$db_handle = new DBController();
if(isset($_POST['bulk_delete_submit'])){
	$idArr = $_POST['checked_id'];
	foreach($idArr as $id){
            $db_handle->Queryrun("DELETE FROM users WHERE id=".$id);
            echo $id;
            header("Location:index.php");
        }
}

?>