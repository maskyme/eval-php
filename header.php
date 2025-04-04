<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.tailwindcss.com"></script>   

</head>

<body>
    <header class="header flex  items-center bg-blue-600 text-white">
        <div class="flex w-full max-w-[1600px] mx-auto justify-between items-center py-3 px-3">
            <div class="logo">
                <a href="#" class="text-2xl font-bold hidden sm:block">Garage Attens</a>
                <a href="#" class="text-2xl font-bold block sm:hidden">GA</a>
            </div>
            <nav class="nav">
                <ul class="nav-list flex gap-5 sm:gap-10">
                    <?php
                        echo '<li><a href="#employees" class="text-sm sm:text-xl font-bold hover:opacity-90">Employés</a></li>';
                    ?>
                    <li><a href="#interventions" class="text-sm sm:text-xl font-bold hover:opacity-90">Interventions</a></li>
                    <li><a href="#account" class="text-sm sm:text-xl font-bold hover:opacity-90">Account</a></li>
                </ul>
            </nav>
        </div>
    </header>
</body>

</html>