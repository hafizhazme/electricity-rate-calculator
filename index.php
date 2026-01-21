<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electricity Rate Calculator</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        h1, h3 {
            color: #007bff;
        }
        .card {
            background-color: #ffffff;
            border-radius: 8px;
        }
        .table th, .table td {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Calculate</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="voltage">Voltage (V):</label>
                <input type="number" name="voltage" step="0.01" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="current">Current (A):</label>
                <input type="number" name="current" step="0.01" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="rate">Current Rate (sen/kWh):</label>
                <input type="number" name="rate" step="0.01" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Calculate</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // input value
            $voltage = $_POST['voltage'];
            $current = $_POST['current'];
            $rate = $_POST['rate'];

            // calculation
            $power = ($voltage * $current) / 1000; 
            $rate_per_hour = $power * ($rate / 100); 
            $rate_per_day = $rate_per_hour * 24;

            // calculation result
            echo "<div class='mt-5'>";
            echo "<div class='card shadow-lg p-4 mb-4'>";
            echo "<h3>Result</h3>";
            echo "<ul class='list-group list-group-flush'>";
            echo "<li class='list-group-item'><strong>Power:</strong> " . number_format($power, 5) . " kW</li>"; 
            echo "<li class='list-group-item'><strong>Rate per Hour:</strong> RM " . number_format($rate_per_hour, 2) . "</li>"; 
            echo "<li class='list-group-item'><strong>Rate per Day:</strong> RM " . number_format($rate_per_day, 2) . "</li>";
            echo "</ul>";
            echo "</div>";

            // electricity rate per hour
            echo "<h3 class='mb-3'>Rate Per Hour</h3>";
            echo "<table class='table table-bordered table-striped'>";
            echo "<thead class='thead-dark'><tr><th>Hour</th><th>Energy (kWh)</th><th>Total (RM)</th></tr></thead><tbody>";
            for ($hour = 1; $hour <= 24; $hour++) {
                $energy = $power * $hour;
                $total_rm = $energy * ($rate / 100);
                echo "<tr><td>$hour</td><td>" . number_format($energy, 5) . "</td><td>" . number_format($total_rm, 2) . "</td></tr>";
            }
            echo "</tbody></table>";
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>