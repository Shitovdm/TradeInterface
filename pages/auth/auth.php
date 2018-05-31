<?php

    require_once("../other/encodeORdecode.php");
    require_once("../service/dbconnect.php");
    session_start();

    $username = $_POST['tusername'];
    $password = $_POST['tpassword'];

    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $username = mysql_real_escape_string($username);
    $password = mysql_real_escape_string($password);

    if ($username != '' && $password != '') {
        $select_data = mysql_query("SELECT * 
                                                                    FROM login_users 
                                                                    WHERE username = '$username' AND password = '$password' 
                                                                    LIMIT 1");
        if (mysql_num_rows($select_data) > 0) {
            while ($row = mysql_fetch_assoc($select_data)) {
                // Создание сессионных файлов	
                $_SESSION["priority_access"] = $row['priority'];
                echo("Login is OK! You priority: " . $_SESSION['priority_access']);
            }
        } else {
            echo("Data is uncorrect!");
        }
    } else {
        echo "Enter login and password!";
    }
    
?>