<?php
include '../include/header.php';

if($_SESSION['role'] == 'editor'){
  header("Location: http://localhost/land/admin/index.php");
}


?>

        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
            <a href="./about_post.php" class="btn btn-primary mr-2">Add About Post</a>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Tables</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Basic tables</li>
                </ol>
              </nav>
            </div>
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Bordered table</h4>
                    <p class="card-description"> Add class <code>.table-bordered</code>
                    </p>
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th> Title </th>
                            <th> Description </th>
                            <th> Image </th>
                            <th> Action </th>
                          </tr>
                        </thead>
                        <?php 
                    include "../../config.php";
                    $obj = new Database();
                    $limit = 5;
                    $obj->select('about_data', '*', null, null, null, $limit);
                    $result = $obj->getResult();
                    
                    foreach ($result as $row) {
                  ?>

                      <tbody>
                          <tr>
                            <td><?= $row['title']; ?></td>
                            <td><?= substr($row['description'],0,25); ?></td>
                            <td><img src="<?php echo "../../upload_images/" .$row['images']; ?>" 
                            style = "width: 35px; height: 35px; border-radius: 0;" alt=""></td>             
                            <td> 
                            <a href="./edit_about.php?id=<?php echo $row['id'];?>" style="font-size: 20px; padding-right: 10px;"><i class="mdi mdi-lead-pencil"></i></a>
                            <a onclick="return confirm('Are you sure!')" href="./delate_about.php?id=<?php echo $row['id'];?>" style="font-size: 20px; padding-left: 10px;"><i class="mdi mdi-delete-forever"></i></a>
                            </td>
                          </tr>
                        </tbody>
                        
                  <?php } ?>
                      </table>
                    </div>
                  </div>
                    

                </div>
              </div>
            </div>
             <!-- pagination nav  -->
            <nav aria-label="Page navigation">
                 <ul class="pagination justify-content-end">
                    <?php
                       echo $obj->pagination('about_data', null, null, $limit);
                    ?>
                  </ul>
            </nav>
          </div>
           
<?php
include '../include/footer.php';

?>

