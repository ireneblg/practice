<?php
include 'db.php'; // Your database connection file

// ADD Student
if(isset($_POST['addStudent'])) {
    $sql = "INSERT INTO Student (studID, studFName, studMName, studLName) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $_POST['studID'], $_POST['studFName'], $_POST['studMName'], $_POST['studLName']);
    $stmt->execute();
}

// DELETE Student (only if orphan)
if(isset($_GET['deleteStudID'])) {
    $studID = $_GET['deleteStudID'];
    $sql = "DELETE FROM Student WHERE studID = $studID AND NOT EXISTS (SELECT * FROM StudentTaker WHERE studID = $studID)";
    $conn->query($sql);
}

$search = isset($_POST['search']) ? $_POST['search'] : '';  // Set default value for search
$students = $conn->query("SELECT * FROM Student WHERE studFName LIKE '%$search%'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Management</title>
</head>
<body>
<h2>Student Management</h2>
<form method="post" action="">
    <input type="number" name="studID" placeholder="ID" required>
    <input type="text" name="studFName" placeholder="First Name" required>
    <input type="text" name="studMName" placeholder="Middle Name">
    <input type="text" name="studLName" placeholder="Last Name" required>
    <button type="submit" name="addStudent">Add Student</button>
</form>

<h3>Search Student</h3>
<form method="post" action="">
    <input type="text" name="search" placeholder="Search by First Name">
    <button type="submit">Search</button>
</form>

<h3>Student List</h3>
<table border="1">
    <tr><th>ID</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Actions</th></tr>
    <?php while($row = $students->fetch_assoc()): ?>
        <tr>
            <td><?= $row['studID'] ?></td>
            <td><?= $row['studFName'] ?></td>
            <td><?= $row['studMName'] ?></td>
            <td><?= $row['studLName'] ?></td>
            <td>
                <a href="?deleteStudID=<?= $row['studID'] ?>">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>



<a href="menu.php">Return to Menu</a>
</body>
</html>
