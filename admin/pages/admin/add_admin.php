<?php
include "../include/header.php";
include "../../config.php";

$obj = new Database();

if (isset($_POST['submit'])) {
        // Sanitize and validate inputs
        $userName = filter_var($_POST['user_name'] ?? '', FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';
        $rule = filter_var($_POST['rule'] ?? '', FILTER_SANITIZE_STRING);
    
        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die('Invalid email format');
        }
    
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        // Prepare data for insertion
        $insertData = [
            'user_name' => $userName,
            'email' => $email,
            'password' => $hashedPassword,
            'rule' => $rule,
        ];
    
        // Insert data and handle result
        $insertResult = $obj->insert('admin_data', $insertData);
        $result = $obj->getResult();

        if ($insertResult) {
            
            echo "<script>
                    alert('Data added successfully');
                    window.open('http://localhost/land/admin/pages/admin/list_admin.php', '_self');
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
            <a href="./list_admin.php" class="btn btn-primary mr-2">List Admin </a>
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
                    <h4 class="card-title">Make Admin</h4>
                    
                    <form class="forms-sample" action="add_admin.php" method="post">
                      <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">User Name</label>
                        <div class="col-sm-9">
                          <input type="text" name="user_name" class="form-control" id="exampleInputUsername2" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                          <input type="email" name="email" class="form-control" id="exampleInputEmail2" required>
                        </div>
                      </div>
                    
                      <div class="form-group row">
                        <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                          <input type="password" name="password" class="form-control" id="exampleInputPassword2" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="exampleInputConfirmPassword2" class="col-sm-3 col-form-label">Rule</label>
                        <div class="col-sm-9">
                           <select name="rule" class="form-control" id="exampleInputConfirmPassword2" required>
                              <option value="main admin">Main Admin</option>
                              <option value="editor">Editor</option>
                            </select>
                        </div>
                      </div>
                      
                      <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                      
                    </form>
                  </div>
                </div>
              </div>
            </div>
            </div>

<?php include '../include/footer.php'?>