<?php
include "../include/header.php";
include "../../config.php";

$obj = new Database();

if (isset($_POST['submit'])) {
    // Sanitize and validate the inputs
    $link = $_POST['link'] ?? '';
    $filename = $_FILES['ad_img']['name'] ?? '';
    $tempfile = $_FILES['ad_img']['tmp_name'] ?? '';
    $folder = "../../upload_images/" . $filename;

    // Check for required fields
    if ( empty($link) || empty($filename)) {
        echo "<script>alert('Please fill in all required fields.');</script>";
    } else {
        $insertData = [
            'link' => $link,
            'ad_img' => $filename
        ];
        
        $insertResult = $obj->insert('advertise', $insertData);
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
                    
                    <form class="forms-sample" action="advertise.php" method="post" enctype="multipart/form-data">
                      <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Ad Images</label>
                        <div class="col-sm-9">
                          <input type="file" name="ad_img" class="form-control"  required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Website Link</label>
                        <div class="col-sm-9">
                          <input type="text" name="link" class="form-control"  required>
                        </div>
                      </div>

                      <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                      
                    </form>
                  </div>
                </div>
              </div>
            </div>
            </div>


<?php include '../include/footer.php' ?>