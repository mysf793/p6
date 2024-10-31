<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Prepare and execute the statement
$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Dashboard</h2>
        <a href="logout.php" class="btn btn-danger mb-3">Logout</a>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-info"><?php echo htmlspecialchars($_SESSION['message']); ?></div>
            <?php unset($_SESSION['message']); // Clear the message after displaying it ?>
        <?php endif; ?>

        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($datauser = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($datauser["id"]) . "</td>";
                    echo "<td>" . htmlspecialchars($datauser["username"]) . "</td>";
                    echo "<td>";
                    echo "<a href='./proses_delete.php?username=" . urlencode($datauser['username']) . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this user?');\">Hapus</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>