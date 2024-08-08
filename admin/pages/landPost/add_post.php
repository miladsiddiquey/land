<?php
include "../include/header.php";
include "../../config.php";

$obj = new Database();

if (isset($_POST['submit'])) {
    // Sanitize and validate the inputs
    $apn_id = $_POST['apn_id'] ?? '';
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $status = $_POST['status'] ?? '';
    $state = $_POST['state'] ?? '';
    $area_size = $_POST['area_size'] ?? '';
    $sale_price = $_POST['sale_price'] ?? '';
    $filename = $_FILES['images']['name'] ?? '';
    $tempfile = $_FILES['images']['tmp_name'] ?? '';
    $slide_filenames = $_FILES['slide_img']['name'] ?? [];
    $slide_tempfiles = $_FILES['slide_img']['tmp_name'] ?? [];

    // Folder paths
    $folder = "../../upload_images/";
    $upload_status = true;

    // Check for required fields
    if (empty($apn_id) || empty($title) || empty($status) || empty($state) || empty($area_size) || empty($sale_price) || empty($filename)) {
        echo "<script>alert('Please fill in all required fields.');</script>";
    } else {
        // Check if the main image file already exists
        $img_target = $folder . basename($filename);
        if (file_exists($img_target)) {
            $upload_status = false;
            echo "<script>alert('An image with the same name already exists. Please rename the file and try again.');</script>";
        } else {
            // Handle single image upload
            if (!move_uploaded_file($tempfile, $img_target)) {
                $upload_status = false;
                echo "<script>alert('Failed to upload the main image.');</script>";
            }
        }

        // Handle multiple slide image uploads
        $slide_image_paths = [];
        foreach ($slide_filenames as $index => $slide_filename) {
            if (!empty($slide_filename)) {
                $slide_target = $folder . basename($slide_filename);
                if (file_exists($slide_target)) {
                    $upload_status = false;
                    echo "<script>alert('A slide image with the same name already exists. Please rename the file: " . htmlspecialchars($slide_filename) . ".');</script>";
                } else {
                    if (move_uploaded_file($slide_tempfiles[$index], $slide_target)) {
                        $slide_image_paths[] = $slide_filename;
                    } else {
                        $upload_status = false;
                        echo "<script>alert('Failed to upload slide image: " . htmlspecialchars($slide_filename) . "');</script>";
                    }
                }
            }
        }

        // Insert data into database if all uploads succeeded
        if ($upload_status) {
            $insertData = [
                'apn_id' => $apn_id,
                'title' => $title,
                'description' => $description,
                'status' => $status,
                'state' => $state,
                'area_size' => $area_size,
                'sale_price' => $sale_price,
                'images' => $filename,
                'slide_img' => implode(',', $slide_image_paths) // Store filenames as a comma-separated string
            ];

            $insertResult = $obj->insert('post_data', $insertData);
            $result = $obj->getResult();

            if ($insertResult) {
                echo "<script>
                        alert('Data added successfully');
                        window.open('http://localhost/land/admin/pages/landPost/list_post.php', '_self');
                      </script>";
            } else {
                $error = json_encode($result);
                echo "<script>
                        alert('Please try again. Error: $error');
                      </script>";
            }
        }
    }
}
?>


        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
            <a href="./list_post.php" class="btn btn-primary mr-2">List Post </a>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Forms</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Form elements</li>
                </ol>
              </nav>
            </div>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Lands Post Area</h4>
                    
                    <form class="forms-sample" action="add_post.php" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="exampleInputName1">Title</label>
                        <input type="text" name="title" class="form-control" id="exampleInputName1" placeholder="Title">
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-6">
                          <label for="exampleInputEmail3">APN ID</label>
                          <input type="text" name="apn_id" class="form-control" id="exampleInputEmail3" placeholder="APN ID">
                          </div>
                          <div class="col-md-6">
                          <label for="exampleInputEmail3">State</label>
                          <input type="text" name="state" class="form-control" id="exampleInputEmail3" placeholder="State">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                      <div class="row">
                          <div class="col-md-4">
                          <label for="exampleInputEmail3">Area Size</label>
                          <input type="text" name="area_size" class="form-control" id="exampleInputEmail3" placeholder="Area Size">
                          </div>
                          <div class="col-md-4">
                          <label for="exampleInputEmail3">Sale Price</label>
                          <input type="text" name="sale_price" class="form-control" id="exampleInputEmail3" placeholder="Sale Price">
                          </div>
                          <div class="col-md-4">
                          
                          <label>Image</label>
                          <input type="file" class="form-control" name="images" id="">
                          </div>
                        </div>
                      </div>
                     
                      <div class="form-group">
                      <label for="exampleInputEmail3">Status</label>
                         <div class="row">
                         <div class="col-md-2">
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input type="radio" class="form-check-input" name="status" id="membershipRadios1" value="available" checked> Available </label>
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input type="radio" class="form-check-input" name="status" id="membershipRadios2" value="unavailable"> Unavailable </label>
                              </div>
                            </div>
                            <div class="col-md-4">
                          <label>Slide Images</label>
                          <input type="file" class="form-control" name="slide_img[]" id="" multiple>
                          </div>
                         </div>
                         
                      </div>
                      <div class="form-group">
                        <label for="exampleTextarea1">Textarea</label>
                        <textarea class="form-control" name="description" id="" rows="6"></textarea>
                      </div>
                      <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php
          include '../include/footer.php';
          ?>