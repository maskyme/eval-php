<?php
session_start();

require_once '../bdd.php'; // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // Vérifier que les champs sont remplis
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Veuillez remplir tous les champs.";
        header('Location: '. $_SERVER['HTTP_REFERER']);
        exit;
    }

    // Vérifier si l'utilisateur existe dans la base de données
    $stmt = $db->prepare("SELECT * FROM user WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $_SESSION['error'] = "Aucun compte trouvé avec cet email.";
        header('Location: '. $_SERVER['HTTP_REFERER']);
        exit;
    }

    // Vérifier si le mot de passe est correct
    if (!password_verify($password, $user['password'])) {
        $_SESSION['error'] = "Mot de passe incorrect.";
        header('Location: '. $_SERVER['HTTP_REFERER']);
        exit;
    }

    // Stocker les informations de l'utilisateur dans la session
    $_SESSION['user'] = [
        'id' => $user['id'],
        'nom' => $user['last_name'],
        'prenom' => $user['first_name'],
        'email' => $user['email'],
        'tel' => $user['phone'],
        'adresse' => $user['adress'],
        'user_categ' => $user['user_category_id']
    ];

    // Rediriger vers la page d'accueil après connexion
    header('Location: ../index.php');
    exit;
}
