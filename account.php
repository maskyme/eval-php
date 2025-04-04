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
    
</body>
</html>