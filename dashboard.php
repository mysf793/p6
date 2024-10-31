<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Prepare and execute the statement to fetch users
$stmt = $conn->prepare("SELECT id, username FROM users"); // Exclude password for security
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                // Initialize ID for display
                while ($datauser = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($datauser["id"]) . "</td>"; // Display user ID
                    echo "<td>" . htmlspecialchars($datauser["username"]) . "</td>"; // Display username
                    echo "<td>";
                    echo "<a href='./proses_delete.php?username=" . urlencode($datauser['username']) . "' class='btn btn-danger btn-sm'>Hapus</a>"; // Delete action
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>