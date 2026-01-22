<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electricity Rate Calculator</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f1f1f1;
            font-family: 'Poppins', sans-serif;
        }
        h1, h3 {
            color: #007bff;
            font-weight: 600;
        }
        .container {
            max-width: 900px;
            margin-top: 40px;
        }
        .card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .form-control {
            border-radius: 50px;
            box-shadow: none;
        }
        .btn {
            border-radius: 50px;
            padding: 10px 30px;
        }
        .table thead th {
            background-color: #007bff;
            color: #ffffff;
        }
        .table th, .table td {
            padding: 15px;
            text-align: center;
        }
        .table td {
            font-size: 0.95rem;
        }
        .table-bordered {
            border: 1px solid #e1e1e1;
        }
        .section-divider {
            border-top: 2px solid #007bff;
            margin-top: 40px;
            margin-bottom: 40px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Electricity Rate Calculator</h1>
        <div class="card p-4">
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
                    <label for="rate">Current Rate (per kWh):</label>
                    <input type="number" name="rate" step="0.01" class="form-control" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Calculate</button>
                </div>
            </form>
        </div>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $voltage = $_POST['voltage'];
            $current = $_POST['current'];
            $rate = $_POST['rate'];

            function calculateElectricityRate($voltage, $current, $rate) {
                $power = $voltage * $current;
                $energy = ($power * 24) / 1000;  
                $totalCharge = $energy * ($rate / 100);  
                $energyPerHour = $energy / 24;
                $chargePerHour = $energyPerHour * ($rate / 100);

                return array(
                    'power' => $power,
                    'energy' => $energy,
                    'totalCharge' => $totalCharge,
                    'chargePerHour' => $chargePerHour,
                    'energyPerHour' => $energyPerHour,
                    'chargePerHour' => $chargePerHour
                );
            }

            $result = calculateElectricityRate($voltage, $current, $rate);

            // results
            echo '<div class="card p-4 mt-4">';
            echo '<h3>Results</h3>';
            echo '<table class="table table-bordered">';
            echo '<tr><th>Power (Wh)</th><td>' . number_format($result['power'], 2) . '</td></tr>';
            echo '<tr><th>Energy (kWh)</th><td>' . number_format($result['energy'], 2) . '</td></tr>';
            echo '<tr><th>Total Charge (RM) for 24 hours</th><td>' . number_format($result['totalCharge'], 2) . '</td></tr>';
            echo '<tr><th>Charge (RM) per Hour</th><td>' . number_format($result['chargePerHour'], 2) . '</td></tr>';
            echo '</table>';
            echo '</div>';

            // forecast
            echo '<div class="card p-4 mt-4">';
            echo '<h3>24-Hour Forecast</h3>';
            echo '<table class="table table-bordered">';
            echo '<thead><tr><th>Hour</th><th>Energy (kWh)</th><th>Total (RM)</th></tr></thead>';
            echo '<tbody>';
            for ($hour = 1; $hour <= 24; $hour++) {
                $hourlyEnergy = $result['energyPerHour'] * $hour;
                $hourlyCharge = $hourlyEnergy * ($rate / 100);
                echo '<tr>';
                echo '<td>' . $hour . '</td>';
                echo '<td>' . number_format($hourlyEnergy, 5) . ' kWh</td>';
                echo '<td>' . 'RM ' . number_format($hourlyCharge, 2) . '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        }
        ?>
        
        <div class="section-divider"></div>
    </div>
</body>
</html>
