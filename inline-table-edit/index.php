<?php
require_once("dbcontroller.php");
$db_handle = new DBController();
$sql = "SELECT * from users";
$faq = $db_handle->runQuery($sql);
if(isset($_POST["submit"])){
	$name =  $_POST["name"];
$sql1 = "INSERT INTO users(name) VALUES('".$name."')";
$result1 = $db_handle->Queryrun($sql1);	
header("Location:index.php");
}
if(isset($_POST['bulk_delete_submit'])){
	$idArr = $_POST['checked_id'];
	foreach($idArr as $id){
            $db_handle->Queryrun("DELETE FROM users WHERE id=".$id);
            echo $id;
            header("Location:index.php");
        }
}
?>
<html>
    <head>
      <title>PHP MySQL Inline Editing using jQuery Ajax</title>
		<style>
			body{width:610px;}
			.current-row{background-color:#B24926;color:#FFF;}
			.current-col{background-color:#1b1b1b;color:#FFF;}
			.tbl-qa{width: 100%;font-size:0.9em;background-color: #f5f5f5;}
			.tbl-qa th.table-header {padding: 5px;text-align: left;padding:10px;}
			.tbl-qa .table-row td {padding:10px;background-color: #FDFDFD;}
		</style>
		<script src="../inline-table-edit/assets/js/jquery-1.10.2.js"></script>
		<script>
		function showEdit(editableObj) {
			$(editableObj).css("background","#FFF");
		} 
		
		function saveToDatabase(editableObj,column,id) {
			$(editableObj).css("background","#FFF url(loaderIcon.gif) no-repeat right");
			$.ajax({
				url: "saveedit.php",
				type: "POST",
				data:'column='+column+'&editval='+editableObj.innerHTML+'&id='+id,
				success: function(data){
					$(editableObj).css("background","#FDFDFD");
				}        
		   });
		}
		</script>
    </head>
    <body>
    <form name="form" action="" method="post">
    <label>Name:</label>
    <input type="text" name="name">
    <input type="submit" name="submit" class="btn btn-primary" id="submit" value="submit">
    </form>		
    <input type="text" id="search"  placeholder="Search for names.." title="Type in a name">
    <form name="bulk_action_form" action="index.php" method="post" />
	   <table class="tbl-qa">
			  <tr>
			    <th><input type="checkbox" name="selectall" id="select_all" value="" /></th>
				<th class="table-header" width="10%">Sr.No.</th>
				<th class="table-header">Name</th>
			  </tr>
		  <?php
		  if(!empty($faq)){
		  foreach($faq as $k=>$v) {
		  ?>
			  <tr class="table-row">
			  <td align="center"><input type="checkbox" name="checked_id[]" class="checkbox" value="<?php echo $faq[$k]['id']; ?>"/></td>
				<td><?php echo $k+1; ?></td>
				<td contenteditable="true" onBlur="saveToDatabase(this,'name','<?php echo $faq[$k]["id"]; ?>')" onClick="showEdit(this);"><?php echo $faq[$k]["name"]; ?></td>
			  </tr>
		<?php
		  } 
		  } else{
		?>
		<tr>
		<td colspan="3"><?php echo "No Record Found." ?></td>
		</tr>
		<?php } ?>
		</table>
		<input type="submit" class="btn btn-danger" name="bulk_delete_submit" id="delete" value="Delete"/>
		</form>
		<script>
		$(document).ready(function(){
			$('#select_all').on('click',function(){
		        if ($(this).is(":checked")) {
				    $('.checkbox').prop("checked", true);
				  } else {
				    $('.checkbox').prop("checked", false);
				  }
		    });
		    $('.checkbox').on('click',function(){
		        if($('.checkbox:checked').length == $('.checkbox').length){
		            $('#select_all').prop('checked',true);
		        }else{
		            $('#select_all').prop('checked',false);
		        }
		    });
					$("#search").keyup(function () {
					    var value = this.value.toLowerCase().trim();

					    $("table tr").each(function (index) {
					        if (!index) return;
					        $(this).find("td").each(function () {
					            var id = $(this).text().toLowerCase().trim();
					            var not_found = (id.indexOf(value) == -1);
					            $(this).closest('tr').toggle(!not_found);
					            return not_found;
					        });
					    });
					});
				});
			function deleteConfirm(){
				var result = confirm("Are you sure to delete users?");
				if(result){
				        return true;
				}else{
				        return false;
				}
			}
		</script>

    </body>
</html>
