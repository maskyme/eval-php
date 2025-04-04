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

<body>
    <?php
    require_once 'header.php';
    require_once 'logout.php';
    ?>
    <main class='px-40 pt-10'>
        <h2 class="pb-5">Désolé, vous n'êtes pas authorisé sur cette page</h2>
        <a href="./list_intervention.php" class="bg-blue-500 text-white py-2 px-4 rounded-full font-bold hover:bg-red-400 transition-all duration-300 cursor-pointer">retourner à l'accueil</a>
    </main>

    <script src='script.js'></script>
</body>

</html>