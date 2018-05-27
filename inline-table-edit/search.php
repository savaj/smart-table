<?php
require_once("dbcontroller.php");
$db_handle = new DBController();
if(isset($_POST['result'])){
$query = "select * from users WHERE 
		name LIKE '%"$_POST['result']"%'";
} else{
	$query = "select * from users ORDER BY id";
}
$result = $db_handle->Queryrun($query);
if($db_handle->numRows($result) > 0){
 $output .= '
  <table class="tbl-qa" id="myTable">
		  <thead>
			  <tr>
				<th class="table-header" width="10%">Sr.No.</th>
				<th class="table-header">Name</th>
			  </tr>
		  </thead>
 ';
 while($row = mysqli_fetch_array($result)){
 	$output .= '
   <tr>
    <td>'.$row["id"].'</td>
    <td>'.$row["name"].'</td>
   </tr>
  ';
 }
 echo $output;
}
else
{
 echo 'Data Not Found';
}

?>