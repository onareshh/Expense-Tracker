<?php
    
    session_start();
    if (!isset($_SESSION['username'])) {
    // Redirect the user back to the login page if not logged in
    header("Location: login.php");
    exit();
}
// Database configuration
$hostname='localhost';
$username='root';
$password='';
$database='signupforms';
$user = $_SESSION['username'];
// Create a database connection
$con = mysqli_connect($hostname, $username, $password, $database);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}



// PHP code for handling form submission and storing expenses
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        $type = $_POST['type'];
        $name = $_POST['name'];
        $date = $_POST['date'];
        $amount = $_POST['amount'];
        if ($type !== 'chooseOne' && !empty($name) && !empty($date) && !empty($amount) && is_numeric($amount)) {
            // Insert the expense data into the database
            $insertSql = "INSERT INTO expenses (type, name, date, amount,user) VALUES ('$type', '$name', '$date', '$amount','$user')";
            mysqli_query($con, $insertSql);
           
        }
    }
}

// Retrieve expenses from the database
$selectSql = "SELECT * FROM expenses where user='$user'";
$result = mysqli_query($con, $selectSql);

$expenses = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $expenses[] = $row;
    }
}

?>
<?php
// Function to delete an expense by ID
function deleteExpense($con, $expenseId) {
    $expenseId = mysqli_real_escape_string($con, $expenseId);

    // Delete the expense from the database
    $deleteSql = "DELETE FROM expenses WHERE id = '$expenseId'";

    if (mysqli_query($con, $deleteSql)) {
        return true; // Deletion successful
    } else {
        return false; // Deletion failed
    }
}

?>
<?php
if (isset($_GET['delete'])) {
    $expenseId = $_GET['delete'];
    deleteExpense($con, $expenseId);
}
$selectSql = "SELECT * FROM expenses where user='$user'";
$result = mysqli_query($con, $selectSql);

$expenses = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $expenses[] = $row;
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Expense Tracker App</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <center>
        <h1 class="title">Expense Tracker</h1>
    </center>

    <section class="content">
        <h3 class="secondTitle">Add a new item:</h3>
        <div class="form">
            <form id="expForm" method="POST">
                <div class="formLine left">
                    <span for="type">Type:</span>
                    <select id="type" name="type">
                        <option value="chooseOne">Choose one...</option>
                        <option value="Entertainment">Entertainment</option>
                        <option value="Food">Food</option>
                        <option value="Utilities">Utilities</option>
                        <option value="Transportation">Transportation</option>
                        <option value="Healthcare">Healthcare</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="formLine right">
                    <span for="name">Name:</span>
                    <input type="text" id="name" name="name">
                </div>

                <div class="formLine left">
                    <span for="date">Date:</span>
                    <input type="date" id="date" name="date">
                </div>
                <div class="formLine right">
                    <span for="amount">Amount:</span>
                    <input type="text" id="amount" name="amount">
                </div>
                <button type="submit" name="submit" class="buttonSave">Add a new expense</button>
            </form>
        </div>

       <!-- Display expenses in a table -->
<table class="table">
    <thead>
        <tr>
            <th>Type</th>
            <th>Name</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Options</th>
        </tr>
    </thead>
    <tbody id="expenseTable">
        <?php foreach ($expenses as $expense): ?>
            <tr>
                <td><?= $expense['type'] ?></td>
                <td><?= $expense['name'] ?></td>
                <td><?= $expense['date'] ?></td>
                <td><?= $expense['amount'] ?></td>
                <td>
                    <a href="?delete=<?= $expense['id'] ?>" class="deleteButton" onclick="return confirm('Are you sure you want to delete this expense?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

    </section>
    <center><form action = "pie.php">
    <button>
        Tabulate
    </button>
</form>
</center>

</body>
</html>
