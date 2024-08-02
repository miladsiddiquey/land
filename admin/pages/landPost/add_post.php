<?php
include '../include/header.php';

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
                    
                    <form class="forms-sample">
                      <div class="form-group">
                        <label for="exampleInputName1">Title</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Title">
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-6">
                          <label for="exampleInputEmail3">APN ID</label>
                          <input type="text" class="form-control" id="exampleInputEmail3" placeholder="APN ID">
                          </div>
                          <div class="col-md-6">
                          <label for="exampleInputEmail3">State</label>
                          <input type="text" class="form-control" id="exampleInputEmail3" placeholder="State">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                      <div class="row">
                          <div class="col-md-4">
                          <label for="exampleInputEmail3">Area Size</label>
                          <input type="text" class="form-control" id="exampleInputEmail3" placeholder="Area Size">
                          </div>
                          <div class="col-md-4">
                          <label for="exampleInputEmail3">Sale Price</label>
                          <input type="text" class="form-control" id="exampleInputEmail3" placeholder="Sale Price">
                          </div>
                          <div class="col-md-4">
                          
                          <label>File upload</label>
                          <input type="file" class="form-control" name="images" id="">
                          </div>
                        </div>
                      </div>
                     
                      <div class="form-group">
                      <label for="exampleInputEmail3">State</label>
                         <div class="row">
                         <div class="col-md-2">
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input type="radio" class="form-check-input" name="membershipRadios" id="membershipRadios1" value="" checked> Available </label>
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input type="radio" class="form-check-input" name="membershipRadios" id="membershipRadios2" value="option2"> Unavailable </label>
                              </div>
                            </div>
                         </div>
                      </div>
                      <div class="form-group">
                        <label for="exampleTextarea1">Textarea</label>
                        <textarea class="form-control " id="" rows="6"></textarea>
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