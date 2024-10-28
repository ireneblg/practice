<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Online Examination System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        h1 {
            color: #333;
        }
        .menu {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }
        .menu a {
            text-decoration: none;
            padding: 15px 25px;
            color: white;
            background-color: #007BFF;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .menu a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<h1>Online Examination System</h1>
<p>Welcome to the online examination system. Please choose an option below to manage students, questions, or take an exam.</p>

<div class="menu">
    <a href="students.php">Student Management</a>
    <a href="questions.php">Question Management</a>
    <a href="take_exam.php">Take Examination</a>
    <a href="exam_report.php">Examination Report</a>
</div>

</body>
</html>
