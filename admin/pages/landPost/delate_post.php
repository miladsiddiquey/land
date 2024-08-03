<?php
include "../../config.php";
$obj = new Database();

$id = (int)$_GET['id'];
if ($id > 0) {
    
    $obj->select('post_data', '*', null, "id='$id'", null, null);
    $result = $obj->getResult();

    if ($result && count($result) > 0) {
        $row = $result[0];
        $images = $row['images'];

        $deleteQuery = "DELETE FROM post_data WHERE id='$id'";

        // Delete the record from the database
        $deleteResult = $obj->delete('post_data', "id='$id'");

        if ($deleteResult) {
            // Delete the image file from the server
            if (file_exists("../../upload_images/".$images)) {
                unlink("../../upload_images/".$images);
            }
            ?>
            <script>
                alert("Data deleted successfully");
                window.open('http://localhost/land/admin/pages/landPost/list_post.php', '_self');
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