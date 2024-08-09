<?php
include "../../config.php";

if($_SESSION['role'] == 'editor'){
    header("Location: http://localhost/land/admin/index.php");
  }

$obj = new Database();

$id = (int)$_GET['id'];
if ($id > 0) {
    
    $obj->select('admin_data', '*', null, "id='$id'", null, null);
    $result = $obj->getResult();

    if ($result && count($result) > 0) {
        $row = $result[0];
        

        $deleteQuery = "DELETE FROM admin_data WHERE id='$id'";

        // Delete the record from the database
        $deleteResult = $obj->delete('admin_data', "id='$id'");

        if ($deleteResult) {
            // Delete the image file from the server
            ?>
            <script>
                alert("Data deleted successfully");
                window.open('http://localhost/land/admin/pages/admin/list_admin.php', '_self');
            </script>
            <?php
        } else {
            ?>
            <script>
                alert("Error deleting data. Please try again.");
            </script>
            <?php
        }
    } else {
        ?>
        <script>
            alert("Record not found.");
        </script>
        <?php
    }
} else {
    ?>
    <script>
        alert("Invalid ID.");
    </script>
    <?php
}
?>