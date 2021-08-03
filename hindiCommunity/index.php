<!DOCTYPE html>
<html>
    <?php 
    require_once('session.php');
    require_once('controller.php');

    $cfg = parse_ini_file('hindi.ini', true); 

    // Syntax Portfolio: Sessions
    $s = new Session();
    $controller = new Controller();
    $s->start();
    
    $s->unsetKey('email');
    $s->unsetKey('password');

    // Syntax Portfolio: GLOBAL(Variables)
    if (isset($_POST['login']))
    {
        $s->set('email', $_POST['login']['email']);
        $s->set('password', $_POST['login']['password']);
        
        $controller->verifyLogin();
        $controller->queryProfile();
    }
    ?>
        <head>
            <link rel = "stylesheet" type = "text/css" href = "hindiCommunity.css">
            <title><?= $cfg['HeadInfo']['title']?></title>
        </head>

        <body>
            <div class = "loginBox">
                <h2><?php echo $cfg['Login']['loginmsg']?></h2>
                <form action = "index.php" method = "POST">
                    <label for = "email">Email Address</label><br>
                    <input type = "text" id = "emailAdd" name = "login[email]"><br>
                    <label for = "password">Password</label><br>
                    <input type = "password" id = "passwordField" name = "login[password]"><br>
                    <br>
                    <input type = "submit" value = <?php echo $cfg['Login']['loginbutton']?>> 
                </form>
            </div>
        </body>
</html>