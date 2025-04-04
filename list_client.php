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
    <!-- Tableau clients -->
    <?php
      require_once 'header.php';
      require_once 'logout.php';
    ?>
    <h2>Liste des clients</h2>
    <table>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Téléphone</th>
            <th>Email</th>
            <th>Adresse</th>
        </tr>
    <?php
        $sqlEmployes = $db->prepare("SELECT u.id AS idUser, u.last_name AS lastName, u.first_name AS firstName, u.phone as phone, u.email AS email, u.adress AS adress, uc.id AS idCategory, uc.label AS nameCategory FROM user u INNER JOIN user_category uc ON u.user_category_id = uc.id  WHERE uc.label = 'client'");
        $sqlEmployes->execute();

        
        while($sqlEmploye = $sqlEmployes->fetch()) {
            $id = $sqlEmploye['idUser'];
            $lastName = htmlspecialchars($sqlEmploye['lastName']);
            $firstName = htmlspecialchars($sqlEmploye['firstName']);
            $phone = htmlspecialchars($sqlEmploye['phone']);
            $email = htmlspecialchars($sqlEmploye['email']);
            $adress = htmlspecialchars($sqlEmploye['adress']);
            $id_category = $sqlEmploye['idCategory'];

            echo "<tr>
                    <td>" . $sqlEmploye['lastName'] . "</td>
                    <td>" . $sqlEmploye['firstName'] . "</td>
                    <td>" . $sqlEmploye['phone'] . "</td>
                    <td>" . $sqlEmploye['email'] . "</td>
                    <td>" . $sqlEmploye['adress'] . "</td>
                    <td>
                        <form method='POST'>
                            <input type='hidden' name='delete-id-user' value='" . $sqlEmploye['idUser'] . "'/>
                            <input type='submit' value='Supprimer' name='delete-user'/>
                        </form>
                        <button onclick='editUser($id, \"$lastName\", \"$firstName\", \"$phone\", \"$email\", \"$adress\", $id_category)'><i class='hgi hgi-stroke hgi-file-edit'></i></button>
                    </td>
                </tr>";
        }
    ?>
    </table>

    <!-- Popup edit client -->
    <div id="edit-user-popup" class='hidden fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white border-2 rounded-xl shadow py-10 px-10'>
        <button onclick='closePopupEditUser()'><i class="hgi hgi-stroke hgi-cancel-01 absolute right-10 top-4 text-xl cursor-pointer"></i></button>
        <h2 class='text-center text-2xl mb-4'>Modifier les informations</h2>
        <form method='POST' class='flex flex-col items-center gap-4'>
            <input type="hidden" id="edit-id-user" name="edit-id-user"/>
            <input type='text' placeholder='Nom' name='edit-lastName-user' id='edit-lastName-user' class='border-2 rounded-xl py-2 pl-4 w-96'/>
            <input type='text' placeholder='Prénom' name='edit-firstName-user' id='edit-firstName-user' class='border-2 rounded-xl py-2 pl-4 w-full'/>
            <input type='text' placeholder='Téléphone' name='edit-phone-user' id='edit-phone-user' class='border-2 rounded-xl py-2 pl-4 w-full'/>
            <input type='text' placeholder='Email' name='edit-mail-user' id='edit-mail-user' class='border-2 rounded-xl py-2 pl-4 w-full'/>
            <input type='text' placeholder='Adresse' name='edit-adress-user' id='edit-adress-user' class='border-2 rounded-xl py-2 pl-4 w-full'/>
            <select name='edit-category-user' id="edit-category-user">
                <?php
                    $categorys = $db->prepare('SELECT * FROM user_category');
                    $categorys->execute();

                    while($category = $categorys->fetch()) {
                        echo "<option value='" . $category['id'] . "'>" . $category['label'] . "</option>";
                    }
                ?>
            </select>
            <input type='submit' value='Modifier' name='edit-user' class='cursor-pointer bg-blue-600 w-full text-white rounded-md py-2'/>
        </form>
    </div>

</body>
</html>