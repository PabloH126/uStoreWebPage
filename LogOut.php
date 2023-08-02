<?php
    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if(ini_get("session.use_cookies"))
    {
        $params = session_get_cookie_params();

        setcookie(session_name(), '', time() - 42000,
        '/',
        $params["domain"],
        $params["secure"],
        $params["httponly"]);

        if(isset($_COOKIE['SessionData'])) 
        {
            setcookie('SessionData', '', time() - 42000, '/');
        }
    }

    session_unset();
    session_destroy();

    header("Location: index.php");
    exit;
?>