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
    <script src="https://cdn.tailwindcss.com"></script>
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

    <?php
      require_once 'header.php';
      require_once 'logout.php';
    ?>
    <div class="mt-5 flex items-center flex-col w-full w-full max-w-[1600px] mx-auto">
        <div class="flex items-center justify-between w-full mb-5">
            <h2>Interventions List</h2>
            <button type="button" class="bg-blue-600 px-3 py-2 text-white font-bold w-fit">Créer une intervention</button>
        </div>
        <table class="w-full text-sm text-left rtl:text-right">
            <thead class="text-xs text-white uppercase bg-blue-600">
                <tr>
                    <th class="px-6 py-3">Date de début</th>
                    <th class="px-6 py-3">Date de fin</th>
                    <th class="px-6 py-3">Durée</th>
                    <th class="px-6 py-3">Intervenant</th>
                    <th class="px-6 py-3">Client</th>
                    <th class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody id="interventionTable">
                <!-- Rows will be dynamically generated -->
                
                <?php
                require_once 'header.php';
                try {
                    $stmt = $db->prepare("SELECT * FROM intervention");
                    $stmt->execute();
                    $interventions = $stmt->fetchAll();
                } catch (\Throwable $th) {
                    echo "Error: " . $th->getMessage();
                    exit;
                }

                foreach ($interventions as $index => $intervention) {
                    echo "<tr class='bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200'>";
                    echo "<td class='px-6 py-4'>{$intervention['start_date']}</td>";
                    echo "<td class='px-6 py-4'>{$intervention['end_date']}</td>";
                    echo "<td class='px-6 py-4'>{$intervention['duration']}</td>";
                    echo "<td class='px-6 py-4'>{$intervention['intervenant']}</td>";
                    echo "<td class='px-6 py-4'>{$intervention['client']}</td>";
                    echo "<td class='px-6 py-4'><button class='btn btn-primary' onclick='showPopup($index)'>Details</button></td>";
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