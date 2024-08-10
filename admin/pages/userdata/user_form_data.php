<?php
include '../include/header.php';

?>

        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
            <a href="./about_post.php" class="btn btn-primary mr-2">User Data</a>
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
                            <th> APN ID </th>
                            <th> Name </th>
                            <th> Email </th>
                            <th> Phone </th>
                            <th> Message </th>
                            <th> Action </th>
                          </tr>
                        </thead>
                        <?php 
                    include "../../config.php";
                    $obj = new Database();
                    $limit = 5;
                    $obj->select('user_info', '*', null, null, 'id DESC', $limit);
                    $result = $obj->getResult();
                    
                    foreach ($result as $row) {
                  ?>

                    <tbody>
                          <tr>
                            <td><?php echo $row['apnId']?></td>
                            <td><?php echo $row['name']?></td>
                            <td> <?php echo $row['email']?> </td>
                            <td> <?php echo $row['phone']?> </td>
                            <td> <?php echo $row['message']?> </td>              
                            <td> 
                            <!-- <a href="#" style="font-size: 20px; padding-right: 10px;"><i class="mdi mdi-lead-pencil"></i></a> -->
                            <a onclick="return confirm('Are you sure!')" href="./user_data_delate.php?id=<?php echo $row['id'];?>" style="font-size: 20px; padding-left: 10px;"><i class="mdi mdi-delete-forever"></i></a>
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
                       echo $obj->pagination('user_info', null, null, $limit);
                    ?>
                  </ul>
            </nav>
          </div>
      <?php
      include '../include/footer.php';

      ?>

