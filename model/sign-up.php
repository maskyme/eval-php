<?php
session_start(); // Démarrer la session

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../bdd.php'; // Inclure la connexion à la base de données

    $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
    $prenom = isset($_POST['prenom']) ? trim($_POST['prenom']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $tel = isset($_POST['tel']) ? trim($_POST['tel']) : '';
    $adresse = isset($_POST['adresse']) ? trim($_POST['adresse']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $user_categ = 3;

    // Vérifier si tous les champs sont remplis
    if (empty($nom) || empty($prenom) || empty($email) || empty($tel) || empty($adresse) || empty($password)) {
        $_SESSION['error'] = "Erreur : Tous les champs sont obligatoires.";
        header('Location: ../sign-up.php');
        exit;
    }

    // Vérifier si l'email existe déjà dans la base de données
    $checkEmail = $db->prepare("SELECT COUNT(*) FROM user WHERE email = :email");
    $checkEmail->bindParam(':email', $email);
    $checkEmail->execute();
    $emailExists = $checkEmail->fetchColumn();

    if ($emailExists > 0) {
        $_SESSION['error'] = "Erreur : Cette adresse email est déjà utilisée.";
        header('Location: ../sign-up.php');
        exit;
    }

    // Hasher le mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insérer l'utilisateur dans la base de données
    $stmt = $db->prepare("INSERT INTO user (last_name, first_name, email, phone, adress, user_category_id, password) 
                          VALUES (:nom, :prenom, :email, :tel, :adresse, :user_categ, :password)");
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':tel', $tel);
    $stmt->bindParam(':adresse', $adresse);
    $stmt->bindParam(':user_categ', $user_categ);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->execute();

    // Récupérer l'ID de l'utilisateur inséré
    $user_id = $db->lastInsertId();

    // Stocker les informations de l'utilisateur dans la session
    $_SESSION['user'] = [
        'id' => $user_id,
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
        'tel' => $tel,
        'adresse' => $adresse,
        'user_categ' => $user_categ
    ];

    // Redirection après inscription
    header('Location: ../index.php');
    exit;
}
