<?php
include "../include/header.php";
include "../../config.php";

$obj = new Database();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Fetch the specific record for the given ID
    $obj->select('post_data', '*', null, "id=$id", null, null);
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
    $deleted_slide_imgs = $_POST['delete_slide_img'] ?? [];

    // Folder paths
    $folder = "../../upload_images/";

    // Handle deletion of selected slide images
    $existing_slide_imgs = explode(',', $row['slide_img']);
    foreach ($deleted_slide_imgs as $img_to_delete) {
        if (in_array($img_to_delete, $existing_slide_imgs)) {
            // Remove the image from the server
            unlink($folder . $img_to_delete);
            // Remove the image from the array
            $existing_slide_imgs = array_diff($existing_slide_imgs, [$img_to_delete]);
        }
    }

    // Update data array
    $updateData = [
        'apn_id' => $apn_id,
        'title' => $title,
        'description' => $description,
        'status' => $status,
        'state' => $state,
        'area_size' => $area_size,
        'sale_price' => $sale_price,
    ];

    // Handle main image
    if (!empty($filename)) {
        $updateData['images'] = $filename;
        move_uploaded_file($tempfile, $folder . basename($filename));
    } else {
        $updateData['images'] = $_POST['old_image'];
    }

    // Handle slide images
    foreach ($slide_filenames as $index => $slide_filename) {
        if (!empty($slide_filename)) {
            $slide_target = $folder . basename($slide_filename);
            if (move_uploaded_file($slide_tempfiles[$index], $slide_target)) {
                $existing_slide_imgs[] = $slide_filename;
            }
        }
    }
    $updateData['slide_img'] = implode(',', $existing_slide_imgs);

    // Update database
    $updateResult = $obj->update('post_data', $updateData, "id=$id");
    $result = $obj->getResult();

    if ($updateResult) {
        echo "<script>
                alert('Data updated successfully');
                window.open('http://localhost/land/admin/pages/landPost/list_post.php', '_self');
              </script>";
    } else {
        $error = json_encode($result);
        echo "<script>
                alert('Please try again. Error: $error');
              </script>";
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
                    
                    <form class="forms-sample" action="edit_post.php?id=<?php echo $row['id'] ?>" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="exampleInputName1">Title</label>
                        <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($row['title']); ?>">
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-6">
                          <label for="exampleInputEmail3">APN ID</label>
                          <input type="text" name="apn_id" class="form-control"value="<?php echo htmlspecialchars($row['apn_id']); ?>">
                          </div>
                          <div class="col-md-6">
                          <label for="exampleInputEmail3">State</label>
                          <input type="text" name="state" class="form-control" value="<?php echo htmlspecialchars($row['state']); ?>">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                      <div class="row">
                          <div class="col-md-4">
                          <label for="exampleInputEmail3">Area Size</label>
                          <input type="text" name="area_size" class="form-control" value="<?php echo htmlspecialchars($row['area_size']); ?>">
                          </div>
                          <div class="col-md-4">
                          <label for="exampleInputEmail3">Sale Price</label>
                          <input type="text" name="sale_price" class="form-control" value="<?php echo htmlspecialchars($row['sale_price']); ?>">
                          </div>
                          <div class="col-md-4">
                              <label>Image</label>
                              <input type="file" class="form-control" name="images" id="">
                              <input type="hidden" name="old_image" value="<?php echo htmlspecialchars($row['images']); ?>">
                              <?php if (!empty($row['images'])): ?>
                                <img src="<?php echo "../../upload_images/" . htmlspecialchars($row['images']); ?>" 
                                style="width: 35px; height: 35px; border-radius: 0;" alt="">
                              <?php endif; ?>
                          </div>
                        </div>
                      </div>
                     
                      <div class="form-group">
                      <label for="exampleInputEmail3">Status</label>
                         <div class="row">
                         <div class="col-md-2">
                              <div class="form-check">
                                <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="status" 
                                value="available" <?php echo ($row['status'] == 'available') ? 'checked' : ''; ?>> Available </label>
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-check">
                                <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="status"
                                 value="unavailable" <?php echo ($row['status'] == 'unavailable') ? 'checked' : ''; ?>> Unavailable </label>
                              </div>
                            </div>
                         </div>
                      </div>
                      <div class="form-group">
                        <label for="exampleTextarea1">Textarea</label>
                        <textarea class="form-control" name="description" rows="6"><?php echo htmlspecialchars($row['description']); ?></textarea>
                      </div>
                      <div class="form-group">
                                <label>Slide Images</label>
                                <input type="file" class="form-control" name="slide_img[]" id="" multiple>
                                <div class="d-flex pt-2">
                                <?php if (!empty($row['slide_img'])): ?>
                                    <?php foreach (explode(',', $row['slide_img']) as $slide_image): ?>
                                        <div class="pl-2">
                                            <img src="<?php echo "../../upload_images/" . htmlspecialchars($slide_image); ?>" 
                                            style="width: 50px; height: 50px; border-radius: 0;" alt="">
                                            <label class="d-flex pt-2 align-items-center">
                                                <input type="checkbox" name="delete_slide_img[]" value="<?php echo htmlspecialchars($slide_image); ?>">
                                                Del
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
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
include '../include/footer.php';
?>
