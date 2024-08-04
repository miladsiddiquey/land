<?php
include "../../config.php";
$obj = new Database();

$id = (int)$_GET['id'];
if ($id > 0) {
    
    $obj->select('user_info', '*', null, "id='$id'", null, null);
    $result = $obj->getResult();

    if ($result && count($result) > 0) {
        $row = $result[0];
       
        $deleteQuery = "DELETE FROM user_info WHERE id='$id'";

        // Delete the record from the database
        $deleteResult = $obj->delete('user_info', "id='$id'");

        if ($deleteResult) {
            // Delete the image file from the server
            ?>
            <script>
                alert("Data deleted successfully");
                window.open('http://localhost/land/admin/pages/userdata/user_form_data.php', '_self');
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