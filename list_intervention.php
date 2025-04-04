<?php
    require_once './bdd.php';

     if (isset($_POST['add-intervention']) && !empty($_POST['add-intervention'])) {
    $shortDescriptionId = $_POST['intervention-name'];
    $date = $_POST['intervention-dateTime'];
    $time = $_POST['intervention-startTime'];
    $longDescription = $_POST['intervention-longDescription'];

    $startDatetime = "$date $time:00"; // Y-m-d H:i:s
    $startTime = strtotime($startDatetime);   // => timestamp UNIX (ex: 1712143200)

    // Récupérer la durée
     $stmt = $db->prepare("SELECT duration FROM intervention_category WHERE id = :id");
    $stmt->execute(['id' => $shortDescriptionId]);
    $category = $stmt->fetch();

    if ($category) {
        $duree = $category['duration']; // en minutes

        // Calcul date de fin
        $endTime = $startTime + ($duree * 3600);

        // Insertion
        $insert = $db->prepare("INSERT INTO intervention (start_time, end_time, employee_id, client_id, short_description_id, long_description) 
            VALUES (:start_time, :end_time, :employee, :client, :short_desc, :long_desc)");

        $insert->execute([
            'start_time' => $startTime,
            'end_time' => $endTime,
            'employee' => $_POST['intervention-employe'],
            'client' => $_POST['intervention-client'],
            'short_desc' => $shortDescriptionId,
            'long_desc' => $longDescription
        ]);
    }
    header("Location: list_intervention.php");
}

    if (isset($_POST['delete-id-intervention']) && !empty($_POST['delete-id-intervention'])) {
        $deleteInterventions = $db->prepare('DELETE FROM intervention WHERE id = :idIntervention');
        $deleteInterventions->execute([
            "idIntervention" => $_POST['delete-id-intervention']
        ]);
        header('Location: list_intervention.php');
    }

    if (isset($_POST['edit-intervention']) && !empty($_POST['edit-intervention'])) {
    $id = $_POST['edit-id-intervention'];
    $client = $_POST['edit-client'];
    $employe = $_POST['edit-employe'];
    $short_description_id = $_POST['edit-intervention'];
    $longDescription = $_POST['edit-longDescription'];
    $date = $_POST['edit-startDate']; // input date
    $heure = $_POST['edit-startHour']; // input time

    $startDatetime = "$date $heure:00";
    $startTime = strtotime($startDatetime);

    // On récupère la durée de l’intervention (en heures)
    $stmt = $db->prepare("SELECT duration FROM intervention_category WHERE id = :id");
    $stmt->execute(['id' => $short_description_id]);
    $category = $stmt->fetch();

    if ($category) {
        $duree = $category['duration'];
        $endTime = $startTime + ($duree * 3600);

        // Mise à jour
        $update = $db->prepare("UPDATE intervention 
            SET start_time = :start_time, 
                end_time = :end_time,
                client_id = :client, 
                employee_id = :employee,
                short_description_id = :short_desc,
                long_description = :long_desc 
            WHERE id = :id");

        $update->execute([
            'start_time' => $startTime,
            'end_time' => $endTime,
            'client' => $client,
            'employee' => $employe,
            'short_desc' => $short_description_id,
            'long_desc' => $longDescription,
            'id' => $id
        ]);
    }

    header("Location: list_intervention.php");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel='stylesheet' href='style.css' />
    <link rel="stylesheet" href="https://cdn.hugeicons.com/font/hgi-stroke-rounded.css" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <?php
      require_once 'header.php';
      require_once 'logout.php';
    ?>
    <main class='px-40 pt-10'>

    <div class='w-full flex items-center justify-between pb-4'>
        <h2 class='text-2xl font-bold '>Liste des interventions</h2>
        <button onclick='popupIntervention()' class='text-xs px-3 py-2 rounded-xl border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition'>+ Ajouter une intervention</button>
    </div>

        <form method='POST' class='flex items-end justify-start gap-10 mb-10'>
            <fieldset class="flex flex-col">
                <label for="intervention-client" class="mb-2 text-sm opacity-70 font-bold">Client</label>
                <select name='intervention-client' id="intervention-client" class="border border-gray-300 rounded-lg p-2 w-40">
                    <option value='0'></option>
                    <?php
                    $interventionClients = $db->prepare('SELECT 
                        u.first_name AS firstName,
                        u.last_name AS lastName,
                        u.id AS idClient
                        FROM user u
                    ');
                    $interventionClients->execute();

                    while ($interventionClient = $interventionClients->fetch()) {
                        $fullName = ucfirst($interventionClient['firstName']) . ' ' . ucfirst($interventionClient['lastName']);
                        echo "<option value='" . $interventionClient['idClient'] . "'>" . $fullName . "</option>";
                    }
                    ?>
                </select>
            </fieldset>

        <fieldset class="flex flex-col">
            <label for="intervention-dateTime" class="mb-2 text-sm opacity-70 font-bold">Date de début</label>
            <input type='date' name='intervention-dateTime' class="border border-gray-300 rounded-lg p-2 w-40"/>
        </fieldset>

        <fieldset class="flex flex-col">
            <label for="intervention-startTime" class="mb-2 text-sm opacity-70 font-bold">Heure de début</label>
            <input type='time' name='intervention-startTime' class="border border-gray-300 rounded-lg p-2 w-40"/>
        </fieldset>

            <fieldset class="flex flex-col">
                <label for="intervention-name" class="mb-2 text-sm opacity-70 font-bold">Intervention</label>
                <select name='intervention-name' id="intervention-name" class="border border-gray-300 rounded-lg p-2 w-48">
                    <option value='0'></option>
                    <?php
                    $interventionClients = $db->prepare('SELECT 
                       * FROM intervention_category');
                    $interventionClients->execute();

                    while ($interventionClient = $interventionClients->fetch()) {
                        echo "<option value='" . $interventionClient['id'] . "'>" .  ucfirst($interventionClient['label']) . "</option>";
                    }
                    ?>
                </select>
            </fieldset>

            <fieldset class="flex flex-col">
                <label for="intervention-employe" class="mb-2 text-sm opacity-70 font-bold">Employé</label>
                <select name='intervention-employe' id="intervention-employe" class="border border-gray-300 rounded-lg p-2 w-48">
                    <option value='0'></option>
                    <?php
                    $interventionClients = $db->prepare('SELECT 
                        u.first_name AS firstName,
                        u.last_name AS lastName,
                        u.id AS idEmploye
                        FROM user u
                        INNER JOIN user_category uc ON u.user_category_id = uc.id 
                        WHERE uc.id = 1 OR uc.id = 2');
                    $interventionClients->execute();

                    while ($interventionClient = $interventionClients->fetch()) {
                        $fullName = ucfirst($interventionClient['firstName']) . ' ' . ucfirst($interventionClient['lastName']);
                        echo "<option value='" . $interventionClient['idEmploye'] . "'>" .  $fullName . "</option>";
                    }
                ?>
            </select>
        </fieldset>
        <fieldset class="flex flex-col">
            <label for="intervention-longDescription" class="mb-2 text-sm opacity-70 font-bold">Longue description</label>
            <textarea name='intervention-longDescription' class="border border-gray-300 rounded-lg p-2 w-40"></textarea>
        </fieldset>
        <input type='submit' value='Ajouter' name='add-intervention' class="bg-blue-600  mt-2 text-white rounded-lg py-2 px-10 font-bold cursor-pointer hover:bg-blue-500 transition duration-300 "/>
    </form>
    
    <table class='min-w-full table-auto bg-white rounded-xl shadow-md overflow-hidden text-sm text-center'>
        <thead class="bg-blue-600 text-white uppercase text-xs tracking-wide">
            <tr class='bg-blue-600 text-white'>
                <th class='py-4 px-10'>Client</th>
                <th class='py-4 px-10'>Date de début</th>
                <th class='py-4 px-10'>Date de fin</th>
                <th class='py-4 px-10'>Employé</th>
                <th class='py-4 px-10'>Intervention</th>
                <th class='py-4 px-10'>Durée</th>
                <th class='py-4 px-10'>Description</th>
                <th class='py-4 px-10'>Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php
                $sqlInterventions = $db->prepare("SELECT 
                    i.id AS id_intervention,
                    i.start_time AS startTime_intervention, 
                    i.end_time AS endTime_intervention, 
                    i.short_description_id AS short_description_id,
                    i.long_description AS longDescription_intervention, 
                    ic.label AS category_label, 
                    ic.duration AS duration,
                    ue.id AS employee_id,
                    ue.first_name AS employee_first_name,
                    ue.last_name AS employee_last_name,
                    uc.id AS client_id,
                    uc.first_name AS client_first_name,
                    uc.last_name AS client_last_name 
                    FROM intervention i
                    INNER JOIN intervention_category ic ON i.short_description_id = ic.id
                    INNER JOIN user ue ON i.employee_id = ue.id
                    INNER JOIN user uc ON i.client_id = uc.id
                    ORDER BY i.start_time 
                    ");
                $sqlInterventions->execute();

                while($sqlIntervention = $sqlInterventions->fetch()) {
                    $id = $sqlIntervention['id_intervention'];
                    $clientId = $sqlIntervention['client_id'];
                    $clientName = ucfirst($sqlIntervention['client_first_name']) . ' ' . ucfirst($sqlIntervention['client_last_name']);
                    $startTime = date('d/m/Y H:i', $sqlIntervention['startTime_intervention']);;
                    $endTime = date('d/m/Y H:i', $sqlIntervention['endTime_intervention']);
                    $startDate = date('Y-m-d', $sqlIntervention['startTime_intervention']);
                    $startHour = date('H:i', $sqlIntervention['startTime_intervention']);
                    $employeeId = $sqlIntervention['employee_id'];
                    $employeeName = ucfirst($sqlIntervention['employee_first_name']) . ' ' . ucfirst($sqlIntervention['employee_last_name']);
                    $interventionId = $sqlIntervention['short_description_id'];
                    $interventionName = htmlspecialchars($sqlIntervention['category_label']);
                    $duration = $sqlIntervention['duration'] . 'h';
                    $longDescription = htmlspecialchars($sqlIntervention['longDescription_intervention']);

                    echo "<tr class='hover:bg-gray-100 transition'>
                            <td class='px-6 py-4'>" . $clientName . "</td>
                            <td class='px-6 py-4'>" . $startTime . "</td>
                            <td class='px-6 py-4'>" . $endTime . "</td>
                            <td class='px-6 py-4'>" . $employeeName . "</td>
                            <td class='px-6 py-4'>" . $interventionName . "</td>
                            <td class='px-6 py-4'>" . $duration . "</td>
                            <td class='px-6 py-4'>" . $longDescription . "</td>
                            <td class='py-4 flex items-center justify-center gap-4'>
                                <button onclick='editIntervention($id, $clientId, \"$startDate\", \"$startHour\", $employeeId, $interventionId, \"$longDescription\")' class='text-xs px-3 py-2 rounded-xl border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition'>Modifier</button>
    
                                <form method='POST'>
                                    <input type='hidden' value='" . $id . "' name='delete-id-intervention'/>
                                    <input type='submit' value='Supprimer' name='delete-intervention' class='text-xs px-3 py-2 rounded-xl border-2 border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition cursor-pointer'/>
                                </form>
                            </td>
                        </tr>";
                }
            ?>
        </tbody>
    </table>

        <!-- Popup create intervention -->
        

    <div id="edit-intervention-popup" class='hidden bg-white p-6 gap-3 rounded-lg flex flex-col w-full max-w-[600px] px-10 absolute top-1/2 shadow left-1/2 -translate-x-1/2 -translate-y-1/2'>
        <button onclick='closePopupIntervention()'><i class="hgi hgi-stroke hgi-cancel-01 absolute right-10 top-4 text-xl cursor-pointer"></i></button>
        <h2 class='text-center text-2xl font-bold mb-4'>Modifier les informations</h2>
        <form method='POST' class='flex flex-col items-center gap-4'>
            <input type="hidden" id="edit-id-intervention" name="edit-id-intervention"/>
            <fieldset class="flex flex-col w-full">
                <label for="edit-client" class="mb-2 text-sm opacity-70 font-bold">Clients</label>
                <select name='edit-client' id="edit-client" class="border border-gray-300 rounded-lg p-2">
                <?php
            $clients = $db->query("SELECT id, first_name, last_name FROM user");
            while ($c = $clients->fetch()) {
                $fullName = ucfirst($c['first_name']) . ' ' . ucfirst($c['last_name']);
                echo "<option value='{$c['id']}'>$fullName</option>";
            }
        ?>
            </select>
                </fieldset>

                <fieldset class="flex flex-col w-full">
  <label for="edit-startDate" class="mb-2 text-sm opacity-70 font-bold">Date de début</label>
  <input type="date" name="edit-startDate" id="edit-startDate" class="border border-gray-300 rounded-lg p-2" />
</fieldset>


                <fieldset class="flex flex-col w-full">
    <label for="edit-startHour" class="mb-2 text-sm opacity-70 font-bold">Heure de début</label>
    <input type="time" name="edit-startHour" id="edit-startHour" class="border border-gray-300 rounded-lg p-2" />
</fieldset>



<fieldset class="flex flex-col w-full">
    <label for="edit-intervention" class="mb-2 text-sm opacity-70 font-bold">Intervention</label>
    <select name="edit-intervention" id="edit-intervention" class="border border-gray-300 rounded-lg p-2">
        <?php
            $interventionCats = $db->query('SELECT id, label FROM intervention_category');
            while ($cat = $interventionCats->fetch()) {
                echo "<option value='{$cat['id']}'>" . ucfirst($cat['label']) . "</option>";
            }
        ?>
    </select>
</fieldset>

<fieldset class="flex flex-col w-full">
    <label for="edit-employe" class="mb-2 text-sm opacity-70 font-bold">Employé</label>
    <select name="edit-employe" id="edit-employe" class="border border-gray-300 rounded-lg p-2">
        <?php
            $employes = $db->query("SELECT id, first_name, last_name FROM user WHERE user_category_id = 1 OR user_category_id = 2");
            while ($e = $employes->fetch()) {
                $fullName = ucfirst($e['first_name']) . ' ' . ucfirst($e['last_name']);
                echo "<option value='{$e['id']}'>$fullName</option>";
            }
        ?>
    </select>
</fieldset>

<fieldset class="flex flex-col w-full">
    <label for="edit-longDescription" class="mb-2 text-sm opacity-70 font-bold">Description</label>
    <textarea name="edit-longDescription" placeholder='Description' id="edit-longDescription" class="border border-gray-300 rounded-lg p-2"></textarea>
</fieldset>
<input type='submit' value='Modifier' name='edit-intervention' class="bg-blue-600  mt-2 text-white rounded-lg p-2 font-bold cursor-pointer hover:bg-blue-500 transition duration-300 w-full"/>
        </form>
    </div>
    <script src='script.js'></script>
</body>

</html>