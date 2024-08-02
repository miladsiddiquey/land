<?php
include '../include/header.php';

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
                    
                    <form class="forms-sample">
                      <div class="form-group">
                        <label for="exampleInputName1">Title</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Title">
                      </div>
                      <div class="form-group">
                        <label for="exampleTextarea1">Uplode Image</label>
                        <input type="file" class="form-control" name="images" id="">
                      </div>
                      <div class="form-group">
                        <label for="exampleTextarea1">Textarea</label>
                        <textarea class="form-control" id="exampleTextarea1" rows="4"></textarea>
                      </div>
                      <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php
          include '../include/footer.php';
          ?>