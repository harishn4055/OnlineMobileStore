<?php
session_start();
require_once 'includes/db.php';
include 'includes/header2.php';
// Assume all necessary user authentication checks are in place

// Fetch users
$stmt = $conn->prepare("SELECT id, username, email FROM users");
$stmt->execute();
$users = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <?php
        if (isset($_SESSION['message'])) {
            echo "<div class='alert alert-success'>" . $_SESSION['message'] . "</div>";
            unset($_SESSION['message']);  // Clear the message so it doesn't persist
        }
        if (isset($_SESSION['error'])) {
            echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
            unset($_SESSION['error']);  // Clear the error message so it doesn't persist
        }
        ?>
        <h1>Manage Users</h1>
        <a href="add_user.php" class="btn btn-primary">Add New User</a>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $users->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td>
                            
                            <a href="delete_user.php?id=<?= $user['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php include 'includes/footer2.php'; ?>