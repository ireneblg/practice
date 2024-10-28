<?php
include 'db.php'; // Database connection file
session_start();

// Function to check if student exists
function isValidStudent($studID, $conn) {
    $result = $conn->query("SELECT * FROM Student WHERE studID = $studID");
    return $result->num_rows > 0;
}

// Check if student has already taken the exam
function hasTakenExam($studID, $conn) {
    $result = $conn->query("SELECT * FROM StudentTaker WHERE studID = $studID");
    return $result->num_rows > 0;
}

// Start the exam
if (isset($_POST['startExam'])) {
    $studID = $_POST['studID'];

    // Verify student ID and if eligible for exam
    if (isValidStudent($studID, $conn) && !hasTakenExam($studID, $conn)) {
        $_SESSION['studID'] = $studID;
        $_SESSION['score'] = 0;
        $_SESSION['started'] = date("Y-m-d H:i:s");
        $_SESSION['question_number'] = 1;
        header("Location: take_exam.php");
        exit();
    } else {
        echo "<p>Invalid Student ID or you have already taken the exam.</p>";
    }
}

// Fetch a random question for the exam
if (isset($_SESSION['studID']) && $_SESSION['question_number'] <= 5) {
    $question = $conn->query("SELECT * FROM Question ORDER BY RAND() LIMIT 1")->fetch_assoc();
    $_SESSION['current_question_id'] = $question['queID'];
}

// Submit an answer
if (isset($_POST['submitAnswer']) && isset($_SESSION['studID'])) {
    $answer = $_POST['answer'];
    $studID = $_SESSION['studID'];
    $queID = $_SESSION['current_question_id'];

    // Record the answer
    $stmt = $conn->prepare("INSERT INTO StudentAnswer (studID, queID, stAnswer) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $studID, $queID, $answer);
    $stmt->execute();

    // Check if the answer is correct
    $correct_answer = $conn->query("SELECT queAns FROM Question WHERE queID = $queID")->fetch_assoc()['queAns'];
    if ($answer === $correct_answer) {
        $_SESSION['score']++;
    }

    // Move to the next question or end the exam
    $_SESSION['question_number']++;
    if ($_SESSION['question_number'] > 5) {
        $_SESSION['finished'] = date("Y-m-d H:i:s");

        // Record the exam results
        $stmt = $conn->prepare("INSERT INTO StudentTaker (studID, started, finished, score) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issi", $studID, $_SESSION['started'], $_SESSION['finished'], $_SESSION['score']);
        $stmt->execute();

        // Display the result
        $result = $_SESSION['score'];
        session_unset(); // Clear session data
        header("Location: take_exam.php?result=$result");
        exit();
    } else {
        header("Location: take_exam.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Take Examination</title>
</head>
<body>

<?php if (!isset($_SESSION['studID']) && !isset($_GET['result'])): ?>
    <h2>Enter Your Student ID to Start Exam</h2>
    <form method="post" action="">
        <input type="number" name="studID" placeholder="Student ID" required>
        <button type="submit" name="startExam">Start Exam</button>
    </form>

<?php elseif (isset($_SESSION['studID']) && $_SESSION['question_number'] <= 5): ?>
    <h3>Question <?php echo $_SESSION['question_number']; ?></h3>
    <p><?php echo $question['queMain']; ?></p>

    <form method="post" action="">
        <input type="radio" name="answer" value="A" required> <?php echo $question['queOpt1']; ?><br>
        <input type="radio" name="answer" value="B"> <?php echo $question['queOpt2']; ?><br>
        <input type="radio" name="answer" value="C"> <?php echo $question['queOpt3']; ?><br>
        <input type="radio" name="answer" value="D"> <?php echo $question['queOpt4']; ?><br>
        <button type="submit" name="submitAnswer">Submit Answer</button>
    </form>

<?php elseif (isset($_GET['result'])): ?>
    <h2>Examination Complete</h2>
    <p>Your Score: <?php echo $_GET['result']; ?> out of 5</p>
    <a href="menu.php">Return to Menu</a>

<?php endif; ?>

</body>
</html>
