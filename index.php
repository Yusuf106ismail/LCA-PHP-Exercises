<?php
require_once 'db_connect.php';

$searchDept = trim($_GET['search_dept'] ?? '');

if (!empty($searchDept)) {
    $stmt = $conn->prepare("SELECT id, name, email, department FROM employees WHERE department LIKE ? ORDER BY id DESC");
    $searchTerm = "%" . $searchDept . "%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT id, name, email, department FROM employees ORDER BY id DESC");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TechVibe - Employee Management System</title>
</head>
<body>
    <h1>TechVibe Employee Management System</h1>

    <p><a href="create.php"><strong>+ Add New Employee</strong></a> | <a href="setup.php">Run DB Setup</a></p>

    <!-- Search Form (Stretch Goal) -->
    <form action="index.php" method="GET" style="margin-bottom: 15px;">
        <label>Filter by Department:</label>
        <input type="text" name="search_dept" value="<?php echo htmlspecialchars($searchDept); ?>" placeholder="e.g. IT, HR">
        <button type="submit">Search</button>
        <?php if (!empty($searchDept)): ?>
            <a href="index.php">Clear Filter</a>
        <?php endif; ?>
    </form>

    <h2>Employee Records</h2>

    <?php if ($result && $result->num_rows > 0): ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['department']); ?></td>
                        <td>
                            <a href="update.php?id=<?php echo $row['id']; ?>">Edit</a> | 
                            <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this record?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No records found.</p>
    <?php endif; ?>
</body>
</html>

