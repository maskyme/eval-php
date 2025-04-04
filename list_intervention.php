<?php
require_once './bdd.php';


$interventions = [];
$filtered = false;

// Si on reçoit un filtre via POST (depuis list_employe)
// if (isset($_POST['filter_user_id'])) {
//     $filtered = true;
//     $userId = $_POST['filter_user_id'];

//     $sql = $db->prepare("
//         SELECT 
//             i.*, 
//             ic.label AS category_label, 
//             ic.duration,
//             u1.first_name AS employee_firstname,
//             u1.last_name AS employee_lastname,
//             u2.first_name AS client_firstname,
//             u2.last_name AS client_lastname
//         FROM intervention i
//         LEFT JOIN intervention_category ic ON i.short_description_id = ic.id
//         LEFT JOIN user u1 ON i.employee_id = u1.id
//         LEFT JOIN user u2 ON i.client_id = u2.id
//         WHERE i.employee_id = :id OR i.client_id = :id
//         ORDER BY i.start_time DESC
//     ");
//     $sql->execute(['id' => $userId]);
//     $interventions = $sql->fetchAll();
// } else {
//     // Sinon, on affiche tout
//     $sql = $db->prepare("
//         SELECT 
//             i.*, 
//             ic.label AS category_label, 
//             ic.duration,
//             u1.first_name AS employee_firstname,
//             u1.last_name AS employee_lastname,
//             u2.first_name AS client_firstname,
//             u2.last_name AS client_lastname
//         FROM intervention i
//         LEFT JOIN intervention_category ic ON i.short_description_id = ic.id
//         LEFT JOIN user u1 ON i.employee_id = u1.id
//         LEFT JOIN user u2 ON i.client_id = u2.id
//         ORDER BY i.start_time DESC
//     ");
//     $sql->execute();
//     $interventions = $sql->fetchAll();
// }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel='stylesheet' href='style.css'/>
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
                        INNER JOIN user_category uc ON u.user_category_id = uc.id 
                        WHERE uc.id = 3');
                    $interventionClients->execute();

                    while($interventionClient = $interventionClients->fetch()) {
                        $fullName = ucfirst($interventionClient['firstName']) . ' ' . ucfirst($interventionClient['lastName']);
                        echo "<option value='" . $interventionClient['idClient'] . "'>" . $fullName . "</option>";
                    }
                ?>
            </select>
        </fieldset>

        <fieldset class="flex flex-col">
            <label for="intervention-startTime" class="mb-2 text-sm opacity-70 font-bold">Date de début</label>
            <input type='text' name='intervention-startTime' class="border border-gray-300 rounded-lg p-2 w-40"/>
        </fieldset>

        <fieldset class="flex flex-col">
            <label for="intervention-name" class="mb-2 text-sm opacity-70 font-bold">Intervention</label>
            <select name='intervention-name' id="intervention-name" class="border border-gray-300 rounded-lg p-2 w-48">
                <option value='0'></option>
                <?php
                    $interventionClients = $db->prepare('SELECT 
                       * FROM intervention_category');
                    $interventionClients->execute();

                    while($interventionClient = $interventionClients->fetch()) {
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
                        WHERE uc.id = 2');
                    $interventionClients->execute();

                    while($interventionClient = $interventionClients->fetch()) {
                        $fullName = ucfirst($interventionClient['firstName']) . ' ' . ucfirst($interventionClient['lastName']);
                        echo "<option value='" . $interventionClient['idEmploye'] . "'>" .  $fullName . "</option>";
                    }
                ?>
            </select>
        </fieldset>
        <input type='submit' value='Ajouter' name='add-intervention' class="bg-blue-600  mt-2 text-white rounded-lg py-2 px-10 font-bold cursor-pointer hover:bg-blue-500 transition duration-300 "/>
    </form>
    
    <table class='min-w-full table-auto bg-white rounded-xl shadow-md overflow-hidden text-sm text-center'>
        <thead class="bg-blue-600 text-white uppercase text-xs tracking-wide">
            <tr class='bg-blue-600 text-white'>
                <th class='py-4 px-10'>Client</th>
                <th class='py-4 px-10'>Date de début</th>
                <th class='py-4 px-10'>Date de fin</th>
                <th class='py-4 px-10'>Intervenant</th>
                <th class='py-4 px-10'>Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            
        </tbody>
    </table>

    <!-- Popup create intervention -->
    <div id='popup-intervention' class='hidden bg-white p-6 gap-3 rounded-lg flex flex-col w-full max-w-[600px] px-10 absolute top-1/2 shadow left-1/2 -translate-x-1/2 -translate-y-1/2'>
        <button onclick='closePopupIntervention()'><i class="hgi hgi-stroke hgi-cancel-01 absolute right-10 top-4 text-xl cursor-pointer"></i></button>
        <h2 class='text-center text-2xl mb-4'>Ajouter une intervention</h2>

        <form method='POST' class='flex flex-col items-center gap-4'>
            <fieldset class="flex flex-col w-full">
                <label for="intervention-client" class="mb-2 text-sm opacity-70 font-bold">Catégorie</label>
                <select name='intervention-client' id="intervention-client" class="border border-gray-300 rounded-lg p-2">
                    <?php
                        $interventionClients = $db->prepare('SELECT 
                            u.first_name AS firstName,
                            u.last_name AS lastName,
                            u.id AS idClient
                            FROM user u
                            INNER JOIN user_category uc ON u.user_category_id = uc.id 
                            WHERE uc.id = 3');
                        $interventionClients->execute();

                        while($interventionClient = $interventionClients->fetch()) {
                            $fullName = ucfirst($interventionClient['firstName']) . ' ' . ucfirst($interventionClient['lastName']);
                            echo "<option value='" . $interventionClient['idClient'] . "'>" . $fullName . "</option>";
                        }
                    ?>
                </select>
             </fieldset>
        </form>
    </div>
    </main>
    <script src='script.js'></script>
</body>
</html>