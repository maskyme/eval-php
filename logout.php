<?php
    function logout() {
        session_start();
        session_unset();
        session_destroy();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
        logout();
        header('Location: index.php');
        exit;
    }
?>
<form action="" method="post">
    <input type="hidden" name="logout" value="1"/>
    <button type="submit" class="bg-red-500 absolute bottom-10 right-10 text-white py-2 px-4 rounded-full font-bold hover:bg-red-400 transition-all duration-300 cursor-pointer">
        Logout
    </button>
</form>