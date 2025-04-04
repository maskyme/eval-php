<?php
session_start();
$user = $_SESSION['user'];

if (isset($user['user_categ'])) {
    $_SESSION['role'] = $user['user_categ'];
} else {
    $_SESSION['role'] = 0;
}

$role = $_SESSION['role'];
?>

<header class="header flex  items-center bg-blue-600 text-white">
    <div class="flex w-full max-w-[1600px] mx-auto justify-between items-center py-3 px-3">
        <div class="logo">
            <a href="#" class="text-2xl font-bold hidden sm:block">Garage Attens</a>
            <a href="#" class="text-2xl font-bold block sm:hidden">GA</a>
        </div>
        <nav class="nav">
            <ul class="nav-list flex gap-5 sm:gap-10">
                <?php
                if ($role == 1) {
                    echo '<li><a href="./list_employe.php" class="text-sm sm:text-xl font-bold hover:opacity-90">Employés</a></li>';
                    echo '<li><a href="./list_client.php" class="text-sm sm:text-xl font-bold hover:opacity-90">Clients</a></li>';
                }

                ?>
                <li><a href="./list_intervention.php" class="text-sm sm:text-xl font-bold hover:opacity-90">Interventions</a></li>
                <li><a href="./account.php" class="text-sm sm:text-xl font-bold hover:opacity-90">Account</a></li>
            </ul>
        </nav>
    </div>
</header>