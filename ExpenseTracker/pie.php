<?php
// Database connection parameters
session_start();
$HOSTNAME = 'localhost';
$USERNAME = 'root';
$PASSWORD = '';
$DATABASE = 'signupforms';
$user = $_SESSION['username'];
// Create a database connection
$mysqli = new mysqli($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Query to fetch data (replace 'your_table' and 'value_column' with your table and column names)
$query = "SELECT type, SUM(amount) as total FROM expenses where user='$user' GROUP BY type";

$result = $mysqli->query($query);

// Create arrays to hold the data
$labels = array();
$data = array();

while ($row = $result->fetch_assoc()) {
    $labels[] = $row['type'];
    $data[] = $row['total'];
}

// Close the database connection
$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Expense Tracker Pie Chart</title>
    <!-- Include Chart.js library via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <!-- Create a container div with a fixed size or use CSS to size it according to the window -->
   <center> <div style="width: 80%; max-width: 500px;">
        <!-- Create an HTML canvas element to render the pie chart with width and height set to 100% -->
        <canvas id="pieChart" style="width: 100%; height: auto;"></canvas>
    </div></center>

    <script type="text/javascript">
        // Get the data from PHP
        var labels = <?php echo json_encode($labels); ?>;
        var data = <?php echo json_encode($data); ?>;

        // Create the pie chart
        var ctx = document.getElementById('pieChart').getContext('2d');
        var pieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        // Add more colors as needed
                    ],
                }],
            },
            options: {
                title: {
                    display: true,
                    text: 'My Pie Chart',
                },
            },
        });
    </script>
</body>
</html>
