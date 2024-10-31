<?php
session_start();
include 'db.php';

// Redirect to dashboard if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? ''); // Trim whitespace
    $password = $_POST['password'] ?? '';

    // Prepare and execute the statement to fetch user
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify the password
    if ($user && password_verify($password, $user['password'])) {
        // Regenerate session ID to prevent session fixation
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['akses'] = $user['akses']; // Assuming you want to store user access level
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Login</h2>
        <form method="POST" class="mt-4">
            <div class="mb-3">
                <input type="text" name="username" required class="form-control" placeholder="Username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
            </div>
            <div class="mb-3">
                <input type="password" name="password" required class="form-control" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger mt-3"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>