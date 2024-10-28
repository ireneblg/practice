<?php
include 'db.php';

// ADD Question
if(isset($_POST['addQuestion'])) {
    $sql = "INSERT INTO Question (queMain, queOpt1, queOpt2, queOpt3, queOpt4, queAns) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $_POST['queMain'], $_POST['queOpt1'], $_POST['queOpt2'], $_POST['queOpt3'], $_POST['queOpt4'], $_POST['queAns']);
    $stmt->execute();
}

// VIEW Questions
$questions = $conn->query("SELECT * FROM Question");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Question Management</title>
</head>
<body>
<h2>Question Management</h2>
<form method="post" action="">
    <textarea name="queMain" placeholder="Question" required></textarea>
    <input type="text" name="queOpt1" placeholder="Option 1" required>
    <input type="text" name="queOpt2" placeholder="Option 2" required>
    <input type="text" name="queOpt3" placeholder="Option 3" required>
    <input type="text" name="queOpt4" placeholder="Option 4" required>
    <input type="text" name="queAns" placeholder="Answer" required>
    <button type="submit" name="addQuestion">Add Question</button>
</form>

<h3>Question List</h3>
<table border="1">
    <tr><th>ID</th><th>Question</th><th>Option 1</th><th>Option 2</th><th>Option 3</th><th>Option 4</th><th>Answer</th></tr>
    <?php while($row = $questions->fetch_assoc()): ?>
        <tr>
            <td><?= $row['queID'] ?></td>
            <td><?= $row['queMain'] ?></td>
            <td><?= $row['queOpt1'] ?></td>
            <td><?= $row['queOpt2'] ?></td>
            <td><?= $row['queOpt3'] ?></td>
            <td><?= $row['queOpt4'] ?></td>
            <td><?= $row['queAns'] ?></td>
        </tr>
    <?php endwhile; ?>
</table>

<a href="menu.php">Return to Menu</a>
</body>
</html>
