<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inscription</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
<form action="./model/sign-up.php" method="post" class="p-6 gap-3 rounded-lg flex flex-col w-full max-w-[600px] absolute top-1/2 shadow left-1/2 -translate-x-1/2 -translate-y-1/2">
    <div class="text-4xl font-bold">
        Bienvenue au Garage Attens !
        <span class="text-2xl block font-bold mt-2 text-blue-600">S'inscrire</span>
    </div>
    <?php
        session_start();
        if (isset($_SESSION['error'])) {
            echo '<div class="text-red-500">' . htmlspecialchars($_SESSION['error']) . '</div>';
            unset($_SESSION['error']);
        }
    ?>
    <div class="flex gap-4">
        <fieldset class="flex flex-col w-1/2">
            <label for="nom" class="block mb-2 text-sm opacity-70 font-bold">Nom</label>
            <input type="text" name="nom" id="nom" class="border border-gray-300 rounded-lg p-2">
        </fieldset>
        <fieldset class="flex flex-col w-1/2">
            <label for="prenom" class="block mb-2 text-sm opacity-70 font-bold">Prénom</label>
            <input type="text" name="prenom" id="prenom" class="border border-gray-300 rounded-lg p-2">
        </fieldset>
    </div>
    <fieldset class="flex flex-col">
        <label for="email" class="block mb-2 text-sm opacity-70 font-bold">E-mail</label>
        <input type="email" name="email" id="email" class="border border-gray-300 rounded-lg p-2">
    </fieldset>
    <fieldset class="flex flex-col">
        <label for="tel" class="block mb-2 text-sm opacity-70 font-bold">Téléphone</label>
        <input type="tel" name="tel" id="tel" class="border border-gray-300 rounded-lg p-2">
    </fieldset>
    <fieldset class="flex flex-col">
        <label for="adresse" class="block mb-2 text-sm opacity-70 font-bold">Adresse</label>
        <input type="adresse" name="adresse" id="adresse" class="border border-gray-300 rounded-lg p-2">
    </fieldset>
    <fieldset class="flex flex-col">
        <label for="password" class="block mb-2 text-sm opacity-70 font-bold">Mot de passe</label>
        <input type="password" name="password" id="password" class="border border-gray-300 rounded-lg p-2">
    </fieldset>
    <button type="submit" class="bg-blue-600  mt-2 text-white rounded-lg p-2 font-bold cursor-pointer hover:bg-blue-500 transition duration-300">S'inscrire</button>
    <span class="text-sm opacity-70">Vous avez déjà un compte ? <a href="./sign-in.php" class="text-blue-600 font-bold">Se connecter</a></span>
</form>
</body>
</html>