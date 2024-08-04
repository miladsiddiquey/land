<?php
include "../include/header.php";
include "../../config.php";

$obj = new Database();

if (isset($_POST['submit'])) {
    // Sanitize and validate the inputs
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $filename = $_FILES['images']['name'] ?? '';
    $tempfile = $_FILES['images']['tmp_name'] ?? '';
    $folder = "../../upload_images/" . $filename;

    // Check for required fields
    if ( empty($title) || empty($description) || empty($filename)) {
        echo "<script>alert('Please fill in all required fields.');</script>";
    } else {
        $insertData = [
            'title' => $title,
            'description' => $description,
            'images' => $filename
        ];
        
        $insertResult = $obj->insert('about_data', $insertData);
        $result = $obj->getResult();

        if ($insertResult) {
            move_uploaded_file($tempfile, $folder);
            echo "<script>
                    alert('Data added successfully');
                    window.open('http://localhost/land/admin/pages/about/list_about.php', '_self');
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
            <a href="./list_about.php" class="btn btn-primary mr-2">List About Post </a>
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
                    <h4 class="card-title">About Post Area</h4>
                    
                    <form class="forms-sample" action="about_post.php" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="exampleInputName1">Title</label>
                        <input type="text" name="title" class="form-control" id="exampleInputName1" placeholder="Title">
                      </div>
                      <div class="form-group">
                        <label for="exampleTextarea1">Uplode Image</label>
                        <input type="file" class="form-control" name="images" id="">
                      </div>
                      <div class="form-group">
                        <label for="exampleTextarea1">Textarea</label>
                        <textarea name="description" class="form-control" id="exampleTextarea1" rows="4"></textarea>
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