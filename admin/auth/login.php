<?php
session_start();
include '../config.php';

// Check if the user is already logged in
if (isset($_SESSION['email'])) {
    header("Location: http://localhost/land/admin/index.php");
    exit();
}

// Handle form submission
if (isset($_POST['submit'])) {
    // Create an instance of the Database class
    $db = new Database();

    // Get and escape user input
    $email = $db->escapeString($_POST['email']);
    $password = $_POST['password'];

    // Prepare and execute the select query
    $table = 'admin_data';
    $rows = 'id,username, email, password, role';
    $where = "email = '$email'";
    
    if ($db->select($table, $rows, null, $where)) {
        $result = $db->getResult();

        // Check if the user exists and password is correct
        if (!empty($result)) {
            $user = $result[0];

            // Verify password
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION["username"] = $user['username'];
                $_SESSION["email"] = $user['email'];
                $_SESSION["id"] = $user['id'];
                $_SESSION["role"] = $user['role'];

                // Redirect based on user role
                header("Location: http://localhost/land/admin/index.php");
                exit();
            } else {
                echo "<div class='alert alert-danger'>User name and password do not match.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>No user found with this email.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Database query failed: " . implode(", ", $db->getResult()) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Corona Admin</title>
    <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/images/favicon.png" />
</head>
<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="row w-100 m-0">
                <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
                    <div class="card col-lg-4 mx-auto">
                        <div class="card-body px-5 py-5">
                            <h3 class="card-title text-left mb-3">Login</h3>
                            <form action="login.php" method="post">
                                <div class="form-group">
                                    <label>Username or email *</label>
                                    <input type="email" name="email" class="form-control p_input" required>
                                </div>
                                <div class="form-group">
                                    <label>Password *</label>
                                    <input type="password" name="password" class="form-control p_input" required>
                                </div>
                                <div class="form-group d-flex align-items-center justify-content-between">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input"> Remember me
                                        </label>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" name="submit" class="btn btn-primary btn-block enter-btn">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="../assets/js/off-canvas.js"></script>
    <script src="../assets/js/hoverable-collapse.js"></script>
    <script src="../assets/js/misc.js"></script>
    <script src="../assets/js/settings.js"></script>
    <script src="../assets/js/todolist.js"></script>
</body>
</html>
