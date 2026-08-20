<?php
require_once 'db_connect.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $department = trim($_POST['department'] ?? '');

    // Server-side validation
    if (empty($name) || empty($email) || empty($department)) {
        $error = "All fields (Name, Email, Department) are required.";
    } else {
        $stmt = $conn->prepare("INSERT INTO employees (name, email, department) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $department);

        if ($stmt->execute()) {
            $stmt->close();
            header("Location: index.php");
            exit;
        } else {
            $error = "Error adding record: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TechVibe - Add Employee</title>
</head>
<body>
    <h1>Add New Employee</h1>

    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="create.php" method="POST">
        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Department:</label><br>
        <input type="text" name="department" required><br><br>

        <button type="submit">Add Employee</button>
        <a href="index.php">Cancel</a>
    </form>
</body>
</html>

