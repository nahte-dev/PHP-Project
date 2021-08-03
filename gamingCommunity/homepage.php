<!DOCTYPE html>
<html>
        <?php 
        require_once('controller.php');
        $s = new Session();
        $s->start();

        $cfg = parse_ini_file('gaming.ini', true); 
        
        $controller = new Controller();
        $clear = false;
        $hide = false;
        $sort = false;

        $controller->displayFriendship();

        /*if (isset($_POST['logout']) || $controller->lastLoginCheck())
        {
            $controller->logout();
        }*/
        
        if (isset($_POST['postButton']))
        {
            $postData = $_POST['post'];
            $controller->insertPost($postData);

            header('Location: ' . $_SERVER["PHP_SELF"], true, 303);
        }
       
        if (isset($_POST['editButton']))
        {
            $id = $_POST['editButton'];
            $controller->editPost($id);
        }
        else if (isset($_POST['deleteButton']))
        {
            $id = $_POST['deleteButton'];
            $controller->deletePost($id);
        }

        if (isset($_POST['updateButton']))
        {
            $updatedPostData = $_POST['update'];
            $controller->updatePost($updatedPostData);
        }
        else if (isset($_POST['clearButton']))
        {
            $clear = true;
            $id = '';
            $postTitle = '';
            $postContent = '';
        }

        if (isset($_POST['hide']))
        {
            $hide = true;
            $s->set('hideContent', true);
        }
        else if (isset($_POST['show']))
        {
            $hide = false;
        }

        if (isset($_POST['sort']))
        {
            $sort = true;
            $s->set('sortPosts', true);
        }
        else if (isset($_POST['resetSort']))
        {
            $sort = false;
        }

        // Gets sessions variables from controller function and assigns them for use inside form
        if ($s->isKeySet('title') && $s->isKeySet('content'))
        {   
            $id = $s->get('id');
            $postTitle = $s->get('title');
            $postContent = $s->get('content');

            $s->unsetKey('id');
            $s->unsetKey('title');
            $s->unsetKey('content');
        }

        if ($s->isKeySet('fullName'))
        {
            $name = $s->get('fullName');
            $city = $s->get('city');
            $country = $s->get('country');
            $postCount = $s->get('postCount');
        }
        ?>

        <head>
            <link rel = "stylesheet" type = "text/css" href = "gamingCommunity.css">
            <title><?= $cfg['HeadInfo']['title']?></title>
        </head>

        <body>
            <div class = "main">
                <div class = "leftSectionDiv">
                    <div class = "yourProfileDiv">
                        <table class = "yourProfile">
                            <tr>
                                <td class = "imgCell" rowspan = "4">
                                    <img src = "../imgs/2.png" alt = "Profile Picture" class = "myProfileImg">
                                </td>
                                <td id = "myProfileName" colspan = "2"><?= $name;?></td>
                            </tr>
                            <tr>
                                <td colspan = "2"><?php echo $cfg['ProfileInfo']['lives']; echo $city . ', ' . $country;?></td>
                            </tr>
                            <tr>
                            <td id = "dateJoined" colspan = "2"><?php echo $cfg['ProfileInfo']['joined']?> 29 September 2020</td>  
                            </tr>
                            <tr class = "profileInfoRow">
                                <td><?= $postCount . ' Posts';?></td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class = "yourFriendsDiv">
                        <table class = "yourFriends">
                            <th><?= $cfg['SectionHeadings']['friends']?></th>
                            <table class = "yourIndividualFriend">
                                <tr>
                                </tr>
                                <tr>
                                    <td id = "friendsName"><?= $s->get('friendName');?></td>
                                </tr>
                            </table>
                        </table>
                    </div>

                    <div class = "yourAchievementsDiv">
                        <table class = "yourAchievements">
                            <th><?= $cfg['SectionHeadings']['achievements']?></th>
                                <table class = "yourIndividualAchievement">
                                    <tr>
                                        <td>You reached level 4! You're now a Power User!</td>
                                    </tr>
                                </table>
                                <table class = "yourIndividualAchievement">
                                    <tr>
                                        <td>You've reached 50 posts! You've been busy. Keep it up!</td>
                                    </tr>
                                </table>
                        </table>
                    </div>
                </div>
            

                <div class = "rightSectionDiv">
                    <div class = "navigation">
                        <ul>
                            <li><a href = "index.html">Home</a></li>
                            <input type = "submit" name = "logout" value = "Logout">
                        </ul>
                    </div>
                        <div class = "rightContainer">
                            <div class = "statusPostDiv">
                                <h2><?= "Welcome $name!"?></h2>
                                <h3><?= $cfg['PostInfo']['postquestion']?></h3>
                                <form action = "homepage.php" method = "POST" autocomplete="off">
                                    <?php
                                    $titleLabel = $cfg['PostInfo']['titleLabel'];
                                    $contentLabel = $cfg['PostInfo']['contentLabel'];
                                    $postLabel = $cfg['PostInfo']['postLabel'];
                                    $updateLabel = $cfg['PostInfo']['updateLabel'];
                                    $clearLabel = $cfg['PostInfo']['clearLabel'];
                                    $announceLabel = $cfg['PostInfo']['announceLabel'];
                                    $sortLabel = $cfg['PostInfo']['sortLabel'];
                                    $hideLabel = $cfg['PostInfo']['hideLabel'];
                                    $showLabel = $cfg['PostInfo']['showLabel'];
                                    $resetSortLabel = $cfg['PostInfo']['resetSortLabel'];

                                    if (isset($postTitle) && isset($postContent) && !$clear)
                                    {
                                        echo "<input type = 'hidden' name = 'update[id]' value = '$id'>";
                                        echo "<p style = 'font-size: 16px; color: white; margin-left: 15px; font-family: Helvetica;'>$titleLabel</p>";
                                        echo "<input type = 'text' name = 'update[title]' id = 'titleBox' value = '$postTitle'>";
                                        echo "<br>";
                                        echo "<p style = 'font-size: 16px; color: white; margin-left: 15px; font-family: Helvetica;'>$contentLabel</p>";
                                        echo "<input type = 'text' name = 'update[content]' id = 'contentBox' value = '$postContent'>";
                                        echo "<br>";
                                        echo "<input id = 'postButton' type = 'submit' name ='updateButton' value = '$updateLabel'>";
                                        echo "<input id = 'postButton' type = 'submit' name ='clearButton' value = '$clearLabel'>";
                                    }
                                    else
                                    {
                                        echo "<p style = 'font-size: 16px; color: white; margin-left: 15px; font-family: Helvetica;'>$titleLabel</p>";
                                        echo "<input type = 'text' name = 'post[title]' id = 'titleBox'>";
                                        echo "<br>";
                                        echo "<p style = 'font-size: 16px; color: white; margin-left: 15px; font-family: Helvetica;'>$contentLabel</p>";
                                        echo "<input type = 'text' name = 'post[content]' id = 'contentBox'>";
                                        echo "<br>";
                                        echo "<input id = 'postButton' type = 'submit' name ='postButton' value = '$postLabel'>";
                                        echo "<input type = 'checkbox' name = 'post[announceBox]' value = '1'>";
                                        echo "<label for = 'announceBox' style = 'color: white'>$announceLabel</label>";
                                    }
                                    ?>
                                </form> 
                            </div>
                            <div class = "recentPostsDiv">
                                <table class ="recentPosts">
                                    <th><?= $cfg['SectionHeadings']['recentposts']?></th>
                                    <form action = "homepage.php" method = "POST">
                                        <?php
                                        if ($sort)
                                        {
                                            echo "<input id = 'postButton' type = 'submit' name = 'resetSort' value = '$resetSortLabel'>";   
                                        }
                                        else
                                        {
                                            echo "<input id = 'postButton' type = 'submit' name = 'sort' value = '$sortLabel'>";   
                                        }

                                        if ($hide)
                                        {
                                            echo "<input id = 'postButton' type = 'submit' name = 'show' value = '$showLabel'>";
                                            $controller->displayPost();
                                        }
                                        else
                                        {
                                            echo "<input id = 'postButton' type = 'submit' name = 'hide' value = '$hideLabel'>";   
                                            $controller->displayPost();
                                        }
                                        ?>
                                    </form>
                                </table>

                            </div>
                        </div>
                </div>
            </div>
        </div>
    </body>
</html>