<?php
include "../include/header.php";
include "../../config.php";

if($_SESSION['role'] == 'editor'){
  header("Location: http://localhost/land/admin/index.php");
}


$obj = new Database();

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    if ($id === false) {
        die('Invalid ID');
    }

    // Fetch the specific record for the given ID
    $obj->select('about_data', '*', null, "id=$id", null, null);
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
    $title = filter_var($_POST['title'] ?? '', FILTER_SANITIZE_STRING);
    $description = filter_var($_POST['description'] ?? '', FILTER_SANITIZE_STRING);
    $filename = $_FILES['images']['name'] ?? '';
    $tempfile = $_FILES['images']['tmp_name'] ?? '';

    // Determine the folder for the image
    $folder = "../../upload_images/";

    // If no new file is uploaded, keep the old image
    if (empty($filename)) {
        $filename = $_POST['old_image'];
    } else {
        // Move the uploaded file to the desired folder
        $folder .= $filename;
        if (!move_uploaded_file($tempfile, $folder)) {
            echo "<script>alert('Failed to upload image.');</script>";
            exit;
        }
    }

    // Check for required fields
    if (empty($title) || empty($description)) {
        echo "<script>alert('Please fill in all required fields.');</script>";
    } else {
        $updateData = [
            'title' => $title,
            'description' => $description,
            'images' => $filename
        ];

        // Update data and handle result
        $updateResult = $obj->update('about_data', $updateData, "id=$id");
        $result = $obj->getResult();

        if ($updateResult) {
            echo "<script>
                    alert('Data updated successfully');
                    window.open('http://localhost/land/admin/pages/about/list_about.php', '_self');
                  </script>";
        } else {
            $error = htmlspecialchars(json_encode($result), ENT_QUOTES, 'UTF-8');
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
                    
                    <form class="forms-sample" action="edit_about.php?id=<?php echo $row['id'];?>" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="exampleInputName1">Title</label>
                        <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($row['title']); ?>">
                      </div>
                      <div class="form-group">
                        <label for="exampleTextarea1">Uplode Image</label>
                        <input type="file" class="form-control" name="images" id="">
                        <input type="hidden" name="old_image" value="<?php echo htmlspecialchars($row['images']); ?>">
                            <img src="<?php echo "../../upload_images/" . htmlspecialchars($row['images']); ?>" 
                            style="width: 35px; height: 35px; border-radius: 0;" alt="">
                      </div>
                      <div class="form-group">
                        <label for="exampleTextarea1">Textarea</label>
                        <textarea name="description" class="form-control" id="exampleTextarea1" rows="4"><?php echo htmlspecialchars($row['description']); ?></textarea>
                      </div>
                      <button type="submit" name="submit" class="btn btn-primary mr-2">Update</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php
          include '../include/footer.php';
          ?>