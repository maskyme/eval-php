<?php
require_once "./bdd.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interventions</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <style>
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            border: 1px solid #ccc;
            padding: 20px;
            z-index: 1000;
        }

        .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2>Interventions List</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Durée</th>
                    <th>Intervenant</th>
                    <th>Client</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="interventionTable">
                <!-- Rows will be dynamically generated -->
                <?php
                try {
                    $stmt = $db->prepare("SELECT * FROM intervention");
                    $stmt->execute();
                    $interventions = $stmt->fetchAll();
                } catch (\Throwable $th) {
                    echo "Error: " . $th->getMessage();
                    exit;
                }

                foreach ($interventions as $index => $intervention) {
                    echo "<tr>";
                    echo "<td>{$intervention['start_date']}</td>";
                    echo "<td>{$intervention['end_date']}</td>";
                    echo "<td>{$intervention['duration']}</td>";
                    echo "<td>{$intervention['intervenant']}</td>";
                    echo "<td>{$intervention['client']}</td>";
                    echo "<td><button class='btn btn-primary' onclick='showPopup($index)'>Details</button></td>";
                    echo "</tr>";

                    // Hidden popup content
                    echo "<div id='popup-$index' class='popup card'>

                                <div class='card-body'>
                                    <p><strong>Date de début:</strong> {$intervention['start_date']}</p>
                            <p><strong>Date de fin:</strong> {$intervention['end_date']}</p>
                            <p><strong>Durée:</strong> {$intervention['duration']}</p>
                            <p><strong>Intervenant:</strong> {$intervention['intervenant']}</p>
                            <p><strong>Client:</strong> {$intervention['client']}</p>
                            <p><strong>Description courte:</strong> {$intervention['short_desc']}</p>
                            <p><strong>Description longue:</strong> {$intervention['long_desc']}</p>
                            <button><span class='material-symbols-outlined'>
                                            edit
                                        </span></button>
                                    <button class='btn btn-danger' onclick='closePopup($index)'>Close</button>
                                </div>
                            
                          </div>";
                }
                ?>
            </tbody>
        </table>

        <!-- Overlay -->
        <div id="popupOverlay" class="popup-overlay"></div>
    </div>

    <!-- JavaScript -->
    <script>
        function showPopup(index) {
            document.getElementById(`popup-${index}`).style.display = 'block';
            document.getElementById('popupOverlay').style.display = 'block';
        }

        function closePopup(index) {
            document.getElementById(`popup-${index}`).style.display = 'none';
            document.getElementById('popupOverlay').style.display = 'none';
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>

</html>