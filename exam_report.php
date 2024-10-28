<?php
include 'db.php'; // Database connection

// Fetch all students' exam results
$results = $conn->query("SELECT Student.studID, studFName, studMName, studLName, score, started, finished 
                         FROM Student
                         JOIN StudentTaker ON Student.studID = StudentTaker.studID
                         ORDER BY score DESC, started ASC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Examination Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>

<h2>Examination Report</h2>
<table>
    <tr>
        <th>Student ID</th>
        <th>First Name</th>
        <th>Middle Name</th>
        <th>Last Name</th>
        <th>Score</th>
        <th>Started</th>
        <th>Finished</th>
    </tr>

    <?php while ($row = $results->fetch_assoc()): ?>
        <tr>
            <td><?= $row['studID'] ?></td>
            <td><?= $row['studFName'] ?></td>
            <td><?= $row['studMName'] ?></td>
            <td><?= $row['studLName'] ?></td>
            <td><?= $row['score'] ?></td>
            <td><?= $row['started'] ?></td>
            <td><?= $row['finished'] ?></td>
        </tr>
    <?php endwhile; ?>
</table>

<a href="menu.php">Return to Menu</a>

</body>
</html>
