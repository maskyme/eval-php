<?php
require_once "./bdd.php";

// Requete pour modifier user
if (isset($_POST['edit-user']) && !empty($_POST['edit-user'])) {
    $sql = "UPDATE user u SET ";
    $params = [];
    $updates = [];

    if (!empty($_POST['edit-lastName-user'])) {
        $updates[] = "last_name = :lastNameEdit";
        $params['lastNameEdit'] = $_POST['edit-lastName-user'];
    }

    if (!empty($_POST['edit-firstName-user'])) {
        $updates[] = "first_name = :firstNameEdit";
        $params['firstNameEdit'] = $_POST['edit-firstName-user'];
    }

    if (!empty($_POST['edit-phone-user'])) {
        $updates[] = "phone = :phoneEdit";
        $params['phoneEdit'] = $_POST['edit-phone-user'];
    }

    if (!empty($_POST['edit-mail-user'])) {
        $updates[] = "email = :emailEdit";
        $params['emailEdit'] = $_POST['edit-mail-user'];
    }

    if (!empty($_POST['edit-adress-user'])) {
        $updates[] = "adress = :adressEdit";
        $params['adressEdit'] = $_POST['edit-adress-user'];
    }

    if (!empty($_POST['edit-category-user'])) {
        $updates[] = "user_category_id = :categoryEdit";
        $params['categoryEdit'] = $_POST['edit-category-user'];
    }


    if (!empty($updates)) {
        $sql .= implode(", ", $updates) . " WHERE id = :idUser";
        $params['idUser'] = $_POST['edit-id-user'];

        $editUsers = $db->prepare($sql);
        $editUsers->execute($params);
    }
    header("Location: list_employe.php");
}

if (isset($_POST['delete-id-user']) && !empty($_POST['delete-id-user'])) {
    $deleteUsers = $db->prepare('DELETE FROM user WHERE id = :idUser');
    $deleteUsers->execute([
        "idUser" => $_POST['delete-id-user']
    ]);
    header('Location: list_employe.php');
}


?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel='stylesheet' href='style.css' />
    <link rel="stylesheet" href="https://cdn.hugeicons.com/font/hgi-stroke-rounded.css" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class='px-40 pt-10'>
    <h2 class='text-2xl font-bold pb-4'>Liste des employé</h2>
    <table class='min-w-full table-auto bg-white rounded-xl shadow-md overflow-hidden text-sm text-center'>
        <thead class="bg-blue-600 text-white uppercase text-xs tracking-wide">
            <tr class='bg-blue-600 text-white'>
                <th class='py-4 px-10'>Nom</th>
                <th class='py-4 px-10'>Prénom</th>
                <th class='py-4 px-10'>Téléphone</th>
                <th class='py-4 px-10'>Email</th>
                <th class='py-4 px-10'>Adresse</th>
                <th class='py-4 px-10'>Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php
            $sqlEmployes = $db->prepare("SELECT 
            u.id AS idUser, 
            u.last_name AS lastName, 
            u.first_name AS firstName, 
            u.phone as phone, 
            u.email AS email, 
            u.adress AS adress, 
            u.user_category_id AS idCategory
            FROM user u  
            WHERE u.user_category_id IS NULL");
            $sqlEmployes->execute();

            while ($sqlEmploye = $sqlEmployes->fetch()) {
                $id = $sqlEmploye['idUser'];
                $lastName = htmlspecialchars($sqlEmploye['lastName']);
                $firstName = htmlspecialchars($sqlEmploye['firstName']);
                $phone = htmlspecialchars($sqlEmploye['phone']);
                $email = htmlspecialchars($sqlEmploye['email']);
                $adress = htmlspecialchars($sqlEmploye['adress']);
                $id_category = $sqlEmploye['idCategory'];

                echo "<tr class='hover:bg-gray-100 transition'>
                    <td >" . $sqlEmploye['lastName'] . "</td>
                    <td >" . $sqlEmploye['firstName'] . "</td>
                    <td>" . $sqlEmploye['phone'] . "</td>
                    <td >" . $sqlEmploye['email'] . "</td>
                    <td >" . $sqlEmploye['adress'] . "</td>
                    <td class='py-4 flex items-center justify-center gap-4'>
                        <button onclick='editUser($id, \"$lastName\", \"$firstName\", \"$phone\", \"$email\", \"$adress\", $id_category)' class='text-xs px-3 py-2 rounded-xl border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition'>Modifier</button>
                        <form method='POST' action='list_intervention.php'>
                            <input type='hidden' name='filter_user_id' value='" . $sqlEmploye['idUser'] . "'/>
                            <input type='submit' value='Intervention' name='btn-intervention' class='text-xs px-3 py-2 rounded-xl border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition cursor-pointer'/>
                        </form>
                        <form method='POST'>
                            <input type='hidden' name='delete-id-user' value='" . $sqlEmploye['idUser'] . "'/>
                            <input type='submit' value='Supprimer' name='delete-user' class='text-xs px-3 py-2 rounded-xl border-2 border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition cursor-pointer'/>
                        </form>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Popup edit user -->
    <div id="edit-user-popup" class='hidden bg-white p-6 gap-3 rounded-lg flex flex-col w-full max-w-[600px] px-10 absolute top-1/2 shadow left-1/2 -translate-x-1/2 -translate-y-1/2'>
        <button onclick='closePopupEditUser()'><i class="hgi hgi-stroke hgi-cancel-01 absolute right-10 top-4 text-xl cursor-pointer"></i></button>
        <h2 class='text-center text-2xl font-bold mb-4'>Modifier les informations</h2>
        <form method='POST' class='flex flex-col items-center gap-4'>
            <input type="hidden" id="edit-id-user" name="edit-id-user" />
            <div class="flex gap-4 w-full">
                <fieldset class="flex flex-col w-1/2">
                    <label for="edit-lastName-user" class="mb-2 text-sm opacity-70 font-bold">Nom</label>
                    <input type='text' placeholder='Nom' name='edit-lastName-user' id='edit-lastName-user' class="border border-gray-300 rounded-lg p-2" />
                </fieldset>
                <fieldset class="flex flex-col w-1/2">
                    <label for="edit-firstName-user" class="mb-2 text-sm opacity-70 font-bold">Prénom</label>
                    <input type='text' placeholder='Prénom' name='edit-firstName-user' id='edit-firstName-user' class="border border-gray-300 rounded-lg p-2" />
                </fieldset>
            </div>
            <div class="flex gap-4 w-full">
                <fieldset class="flex flex-col w-full">
                    <label for="edit-phone-user" class="mb-2 text-sm opacity-70 font-bold">Téléphone</label>
                    <input type='text' placeholder='Téléphone' name='edit-phone-user' id='edit-phone-user' class="border border-gray-300 rounded-lg p-2" />
                </fieldset>
                <fieldset class="flex flex-col w-full">
                    <label for="edit-mail-user" class="mb-2 text-sm opacity-70 font-bold">Email</label>
                    <input type='text' placeholder='Email' name='edit-mail-user' id='edit-mail-user' class="border border-gray-300 rounded-lg p-2" />
                </fieldset>
            </div>
            <fieldset class="flex flex-col w-full">
                <label for="edit-adress-user" class="mb-2 text-sm opacity-70 font-bold">Adresse</label>
                <input type='text' placeholder='Adresse' name='edit-adress-user' id='edit-adress-user' class="border border-gray-300 rounded-lg p-2" />
            </fieldset>
            <fieldset class="flex flex-col w-full">
                <label for="edit-category-user" class="mb-2 text-sm opacity-70 font-bold">Catégorie</label>
                <select name='edit-category-user' id="edit-category-user" class="border border-gray-300 rounded-lg p-2">
                    <?php
                    $categorys = $db->prepare('SELECT * FROM user_category');
                    $categorys->execute();

                    while ($category = $categorys->fetch()) {
                        echo "<option value='" . $category['id'] . "'>" . ucfirst($category['label']) . "</option>";
                    }
                    ?>
                </select>
            </fieldset>
            <input type='submit' value='Modifier' name='edit-user' class="bg-blue-600  mt-2 text-white rounded-lg p-2 font-bold cursor-pointer hover:bg-blue-500 transition duration-300 w-full" />
        </form>
    </div>

    <!-- Popup edit user -->
    <div id="popup-intervention" class='hidden fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white border-2 rounded-xl shadow py-10 px-10'>
        <button onclick='closePopupIntervention()'><i class="hgi hgi-stroke hgi-cancel-01 absolute right-10 top-4 text-xl cursor-pointer"></i></button>
        <h2 class='text-center text-2xl mb-4'>Intervention</h2>
    </div>


    <script src='script.js'></script>
</body>

</html>