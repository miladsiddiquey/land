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
                            <th> Name </th>
                            <th> Email </th>
                            <th> Phone </th>
                            <th> Description </th>
                            <th> Action </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td> Herman Beck </td>
                            <td> Herman Beck </td>
                            <td> Herman Beck </td>
                            <td> $ 77.99 </td>              
                            <td> 
                            <!-- <a href="#" style="font-size: 20px; padding-right: 10px;"><i class="mdi mdi-lead-pencil"></i></a> -->
                            <a onclick="return confirm('Are you sure!')" href="#" style="font-size: 20px; padding-left: 10px;"><i class="mdi mdi-delete-forever"></i></a>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
<?php
include '../include/footer.php';

?>

