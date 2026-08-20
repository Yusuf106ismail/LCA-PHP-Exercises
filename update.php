<?php
require_once 'db_connect.php';

$error = '';
$employee = null;

// Handle Form Submission (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $department = trim($_POST['department'] ?? '');

    if (empty($name) || empty($email) || empty($department)) {
        $error = "All fields are required.";
    } else {
        $stmt = $conn->prepare("UPDATE employees SET name = ?, email = ?, department = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $email, $department, $id);

        if ($stmt->execute()) {
            $stmt->close();
            header("Location: index.php");
            exit;
        } else {
            $error = "Failed to update record: " . $stmt->error;
        }
    }
}

// Fetch record details via $_GET
$id = intval($_GET['id'] ?? 0);
if ($id > 0) {
    $stmt = $conn->prepare("SELECT id, name, email, department FROM employees WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $employee = $res->fetch_assoc();
    $stmt->close();
}

if (!$employee && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Employee not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TechVibe - Edit Employee</title>
</head>
<body>
    <h1>Edit Employee Record</h1>

    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($employee['id'] ?? $_POST['id']); ?>">

        <label>Name:</label><br>
        <input type="text" name="name" value="<?php echo htmlspecialchars($employee['name'] ?? $_POST['name']); ?>" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($employee['email'] ?? $_POST['email']); ?>" required><br><br>

        <label>Department:</label><br>
        <input type="text" name="department" value="<?php echo htmlspecialchars($employee['department'] ?? $_POST['department']); ?>" required><br><br>

        <button type="submit">Update Record</button>
        <a href="index.php">Cancel</a>
    </form>
</body>
</html>

