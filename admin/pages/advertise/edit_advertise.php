<?php

include "../include/header.php";
include "../../config.php";

$obj = new Database();

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    if ($id === false) {
        die('Invalid ID');
    }
    
    // Fetch the specific record for the given ID
    $obj->select('advertise', '*', null, "id=$id", null, null);
    $result = $obj->getResult();
    if (count($result) > 0) {
        $row = $result[0];
    } else {
        echo "No record found for the given ID";
        exit;
    }
} else {
    echo "ID parameter is missing";
    exit;
}

if (isset($_POST['submit'])) {
    // Sanitize and validate the inputs
    $link = $_POST['link'] ?? '';
    $filename = $_FILES['ad_img']['name'] ?? '';
    $tempfile = $_FILES['ad_img']['tmp_name'] ?? '';
    $folder = "../../upload_images/" . $filename;

    // Check for required fields
    if ( empty($link)) {
        echo "<script>alert('Please fill in all required fields.');</script>";
    } else {
        $insertData = [
            'link' => $link,
            'ad_img' => $filename
        ];
        
        $insertResult = $obj->update('advertise', $insertData, "id=$id");
        $result = $obj->getResult();

        if ($insertResult) {
            move_uploaded_file($tempfile, $folder);
            echo "<script>
                    alert('Data added successfully');
                    window.open('http://localhost/land/admin/pages/advertise/list_advertise.php', '_self');
                  </script>";
        } else {
            $error = json_encode($result);
            echo "<script>
                    alert('Please try again. Error: $error');
                  </script>";
        }
    }
}
?>


 <!-- partial -->
 <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
            <a href="./list_advertise.php" class="btn btn-primary mr-2">List Advertise </a>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Forms</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Form elements</li>
                </ol>
              </nav>
            </div>
            <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Advertise</h4>
                    
                    <form class="forms-sample" action="edit_advertise.php?id=<?php echo $row['id']; ?>" method="post" enctype="multipart/form-data">
                      <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Ad Images</label>
                        <div class="col-sm-9">
                          <input type="file" name="ad_img"  class="form-control">
                          <input type="hidden" name="old_image" value="<?php echo htmlspecialchars($row['ad_img']); ?>">
                              <?php if (!empty($row['ad_img'])): ?>
                                <img src="<?php echo "../../upload_images/" . htmlspecialchars($row['ad_img']); ?>" 
                                style="width: 35px; height: 35px; border-radius: 0;" alt="">
                              <?php endif; ?>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Website Link</label>
                        <div class="col-sm-9">
                          <input type="text" name="link" value="<?php echo htmlspecialchars($row['link']); ?>" class="form-control"  required>
                        </div>
                      </div>

                      <button type="submit" name="submit" class="btn btn-primary mr-2">Update</button>
                      
                    </form>
                  </div>
                </div>
              </div>
            </div>
            </div>


<?php
include '../include/footer.php'
?>