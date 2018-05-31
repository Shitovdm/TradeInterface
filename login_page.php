<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Login in Trade Interface</title>
        <link href="css/loginpage.css" rel="stylesheet" type="text/css">

    </head>

    <body>

        <div class="login-page">
            <div class="login-logo">
                <img src="images/image.png" width="128px;" alt="Logo">
                <b>Trade Interface</b>
            </div>
            <div class="login-screen">
                <h3>Inter login and password</h3>
                    <?php
                        session_start();
                        if ($_SESSION['error_login'] == "true") {
                            echo("<div class='incorrect-data'><b>" . $_SESSION['error_desc'] . "</b></div>");
                        }
                        unset($_SESSION['error_login']);
                        unset($_SESSION['error_desc']);
                    ?>
                <form action="index.php" method="post" name="login form" id="loginform">
                    <div class="input_field">
                        <input type="text" name="username" id="username" value="" placeholder="Username">
                    </div>
                    <div class="input_field">
                        <input type="password" name="password" id="password" value="" placeholder="Password">
                    </div>
                    <div class="input_field login-capcha">
                        <input type="text" name="capcha" />
                        <img style="border: 1px solid gray; background: url('pages/other/capcha/bg_capcha.png');" src = "pages/other/capcha/generator.php" width="120" height="40"/>

                    </div>
                    <div class="input_field">
                        <button class="login-btn" type="submit">Login</button>
                    </div>
                    <div>
                        <small>For access please contact shitov.dm@gmail.com</small>
                    </div>
                </form>
            </div>
            <div class="login-footer"></div>
        </div>
    </body>
</html>
