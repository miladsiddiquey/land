<?php

// session_start();
include "../include/header.php";
include "../../config.php";

if($_SESSION['role'] == 'editor'){
    header("Location: http://localhost/land/admin/index.php");
  }

// Ensure CSRF token is set
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$obj = new Database();

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    if ($id === false) {
        die('Invalid ID');
    }
    
    // Fetch the specific record for the given ID
    $obj->select('admin_data', '*', null, "id=$id", null, null);
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
    // Validate CSRF token
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Invalid CSRF token');
    }

    // Sanitize and validate inputs
    $userName = filter_var($_POST['username'] ?? '', FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';
    $role = filter_var($_POST['role'] ?? '', FILTER_SANITIZE_STRING);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Invalid email format');
    }

    // Prepare data for update
    $updateData = [
        'username' => $userName,
        'email' => $email,
        'role' => $role,
    ];

    // Hash the password only if it's not empty
    if (!empty($password)) {
        $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
    }

    // Update data and handle result
    $updateResult = $obj->update('admin_data', $updateData, "id=$id");
    $result = $obj->getResult();

    if ($updateResult) {
        echo "<script>
                alert('Data updated successfully');
                window.open('http://localhost/land/admin/pages/admin/list_admin.php', '_self');
              </script>";
    } else {
        $error = htmlspecialchars(json_encode($result), ENT_QUOTES, 'UTF-8');
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
            <a href="./list_admin.php" class="btn btn-primary mr-2">List Admin</a>
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
                        <h4 class="card-title">Edit Admin</h4>
                        
                        <form class="forms-sample" action="edit_admin.php?id=<?php echo $row['id']; ?>" method="post">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <div class="form-group row">
                                <label for="exampleInputUsername2" class="col-sm-3 col-form-label">User Name</label>
                                <div class="col-sm-9">
                                    <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($row['username']); ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($row['email']); ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Password</label>
                                <div class="col-sm-9">
                                    <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="exampleInputConfirmPassword2" class="col-sm-3 col-form-label">role</label>
                                <div class="col-sm-9">
                                    <select name="role" class="form-control" id="exampleInputConfirmPassword2" required>
                                        <option value="main admin" <?php echo ($row['role'] === 'main admin') ? 'selected' : ''; ?>>Main Admin</option>
                                        <option value="editor" <?php echo ($row['role'] === 'editor') ? 'selected' : ''; ?>>Editor</option>
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


<?php include '../include/footer.php'; ?>
