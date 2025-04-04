<header class="header flex  items-center bg-blue-600 text-white">
    <div class="flex w-full max-w-[1600px] mx-auto justify-between items-center py-3 px-3">
        <div class="logo">
            <a href="#" class="text-2xl font-bold hidden sm:block">Garage Attens</a>
            <a href="#" class="text-2xl font-bold block sm:hidden">GA</a>
        </div>
        <nav class="nav">
            <ul class="nav-list flex gap-5 sm:gap-10">
                <?php
                    echo '<li><a href="./list_employe.php" class="text-sm sm:text-xl font-bold hover:opacity-90">Employés</a></li>';
                ?>
                <li><a href="./interventions.php" class="text-sm sm:text-xl font-bold hover:opacity-90">Interventions</a></li>
                <li><a href="./account.php" class="text-sm sm:text-xl font-bold hover:opacity-90">Account</a></li>
            </ul>
        </nav>
    </div>
</header>