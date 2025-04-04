<?php
    require_once './bdd.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel='stylesheet' href='style.css'/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<?php
    require_once './header.php';
    require_once './logout.php';
?>

    <div class="flex w-full max-w-[1600px] mx-auto mt-10">
        <div class="flex justify-between w-full items-center">
            <div class="text-4xl font-bold text-blue-600">
                <?php
                    echo $user['nom'] . ' ' . $user['prenom']
                ?>
                <span class="block text-lg text-black font-medium opacity-80">
                    <?php echo $user['email'] ?>
                </span>
            </div>
            <div class="text-xl">
                <?php
                    echo 'Adresse : ' . $user['adresse'];
                ?>
                    <span class="block">
                        <?php
                            echo 'Téléphone : ' . $user['tel'];
                        ?>
                    </span>
                
            </div>
        </div>
    </div>
    <div class="max-w-[1600px] mx-auto mt-10">

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
                $user_id = $user['id'];
                $sqlInterventions = $db->prepare("SELECT 
                    i.id AS id_intervention,
                    i.start_time AS startTime_intervention, 
                    i.end_time AS endTime_intervention, 
                    i.long_description AS longDescription_intervention, 
                    i.employee_id as employee_id,
                    ic.label AS category_label, 
                    ic.duration AS duration,
                    ue.first_name AS employee_first_name,
                    ue.last_name AS employee_last_name,
                    uc.first_name AS client_first_name,
                    uc.last_name AS client_last_name 
                    FROM intervention i
                    INNER JOIN intervention_category ic ON i.short_description_id = ic.id
                    INNER JOIN user ue ON i.employee_id = ue.id
                    INNER JOIN user uc ON i.client_id = uc.id
                    WHERE employee_id = $user_id OR client_id = $user_id
                    ORDER BY i.start_time 
                    ");
                $sqlInterventions->execute();

                while($sqlIntervention = $sqlInterventions->fetch()) {
                    $id = $sqlIntervention['id_intervention'];
                    $clientName = ucfirst($sqlIntervention['client_first_name']) . ' ' . ucfirst($sqlIntervention['client_last_name']);
                    $startTime = date('d/m/Y H:i', $sqlIntervention['startTime_intervention']);;
                    $endTime = date('d/m/Y H:i', $sqlIntervention['endTime_intervention']);
                    $employeeName = ucfirst($sqlIntervention['employee_first_name']) . ' ' . ucfirst($sqlIntervention['employee_last_name']);
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
                                <button onclick='editIntervention()' class='text-xs px-3 py-2 rounded-xl border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition'>Modifier</button>
    
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

                        while ($interventionClient = $interventionClients->fetch()) {
                            $fullName = ucfirst($interventionClient['firstName']) . ' ' . ucfirst($interventionClient['lastName']);
                            echo "<option value='" . $interventionClient['idClient'] . "'>" . $fullName . "</option>";
                        }
                    ?>
                </select>
             </fieldset>
        </form>
    </div>

</body>
<script src="./script.js"></script>
</html>