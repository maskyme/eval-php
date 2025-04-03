<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beautiful Header Menu</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="header">
        <div class="logo">
            <a href="#">MyLogo</a>
        </div>
        <nav class="nav">
            <ul class="nav-list">
                <?php
                    echo '<li><a href="#employees">Employés</a></li>';
                ?>
                <li><a href="#interventions">Interventions</a></li>
                <li><a href="#account">Account</a></li>
            </ul>
        </nav>
    </header>
</body>
</html>