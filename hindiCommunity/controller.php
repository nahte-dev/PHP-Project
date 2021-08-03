<?php
//Syntax Portfolio: Strict Types, Include, include_once, Properties, visibility, constructor, user defined functions, arguments, return values, arrays
declare(strict_types = 1);
require_once('database\mysql.php');
include('post.php');
include('view.php');
include_once('session.php');

class Controller 
{   
    private string $host = 'localhost';
    private string $user = 'root';
    private string $pass = '';
    private string $databaseName = 'hindiDB';

    private Database $db;
    private View $view;
    private Session $s;

    private $cfg;

    private bool $setup = false;

    function __construct() 
    {
        $this->db = new Database($this->host, $this->user, $this->pass, $this->databaseName);
        $this->s = new Session();

        $this->cfg = parse_ini_file('hindi.ini', true); 

        //$this->db->dropDatabase();
        $this->db->createDatabase();
        $this->db->selectDatabase();

        //$this->setupDatabase();
    }

    function setupDatabase()
    {
        $this->createTables();

        // Adding foreign keys
        $this->db->addForeignKey('UserAccount', 'profileID', 'UserProfile', 'profileID', 'UserAccount_ProfileID');
        $this->db->addForeignKey('Post', 'profileID', 'UserProfile', 'profileID', 'Post_ProfileID');
        $this->db->addForeignKey('Friendship', 'friendID1', 'UserProfile', 'profileID', 'Friendship_UserID1');
        $this->db->addForeignKey('Friendship', 'friendID2', 'UserProfile', 'profileID', 'Friendship_UserID2');

        $this->createUser('admin@admin.com', 'AdminPass123!', 1, 'Ethan', 'Morris');
        $this->createUser('test@test.com', 'BigPass1!', 2, 'Pardeep', 'Kaur');
        $this->createFriendship(1, 2);

        $this->setup = true;
    }

    function createTables()
    {
        // Creating UserAccount table
        $this->db->createTable(
            'UserAccount',
            [
                "userID" => "SMALLINT AUTO_INCREMENT NOT NULL",
                "emailAddress" => "VARCHAR(40) NOT NULL",
                "userPassword" => "VARCHAR(255) NOT NULL",
                "profileID" => "SMALLINT NOT NULL",
            ],
            'userID',
        );
        
        // Creating UserProfile table
        $this->db->createTable(
            'UserProfile',
            [
                "profileID" => "SMALLINT AUTO_INCREMENT NOT NULL",
                "firstName" => "VARCHAR(35) NOT NULL",
                "lastName" => "VARCHAR(35) NOT NULL",
                "city" => "CHAR(20)",
                "country" => "CHAR(50) NOT NULL",
                "postcount" => "SMALLINT",
            ],
            'profileID',
        );
        
        // Creating Post table
        $this->db->createTable(
            'Post',
            [
                "postID" => "SMALLINT AUTO_INCREMENT NOT NULL",
                "postTitle" => "VARCHAR(35) NOT NULL",
                "postContent" => "TINYTEXT NOT NULL",
                "postAuthor" => "VARCHAR(70) NOT NULL",
                "postType" => "INT NOT NULL",
                "profileID" => "SMALLINT NOT NULL",
            ],
            'postID',
        );

        // Creating Friendship table
        $this->db->createTable(
            'Friendship',
            [
                "friendshipID" => "SMALLINT AUTO_INCREMENT NOT NULL",
                "friendID1" => "SMALLINT NOT NULL",
                "friendID2" => "SMALLINT NOT NULL",
            ],
            'friendshipID',
        );
    }
    // Syntax Portfolio: Passwords, BD(MySQLI)
    function createUser(string $email, string $pass, int $profileID, string $firstName, string $lastName)
    {
        $hashLogin = password_hash($pass, PASSWORD_DEFAULT);

        // Inserting admin profile into DB
        $sql = "INSERT INTO UserProfile (profileID, firstName, lastName, city, country, postCount) 
                VALUES ($profileID, '$firstName', '$lastName', 'Christchurch', 'New Zealand', 0);";
        $this->db->query($sql);

        // Inserting admin user account into DB
        $sql = "INSERT INTO UserAccount (emailAddress, userPassword, profileID) VALUES ('$email', '$hashLogin', $profileID)";
        $this->db->query($sql);
    }

    function createFriendship(int $friend1, int $friend2)
    {
        $sql = "INSERT INTO Friendship (friendID1, friendID2) VALUES ($friend1, $friend2);";

        $this->db->query($sql);
    }

    function displayFriendship()
    {
        $sql = "SELECT p.profileID, P.firstName, P.lastName 
                    FROM Friendship F
                    JOIN UserProfile P ON P.profileID = F.friendID1
                    WHERE F.friendID2 = 1
                    UNION
                    SELECT P.profileID, P.firstName, P.lastName
                    FROM Friendship F
                    JOIN UserProfile P ON P.profileID = F.friendID2
                    WHERE F.friendID1 = 1;";

        $result = $this->db->query($sql);

        while ($row = $result->fetch())
        {
            $firstName = $row['firstName'];
            $lastName = $row['lastName'];

            $this->s->set('friendName', $firstName . ' ' . $lastName);
        }

        //$this->s->unsetKey('friendName');
    }

    function insertPost(array $postData) 
    {   
        $announceFlag = $postData['announceBox'];

        if (!$announceFlag)
        {
            $post = new Post($postData['title'], $postData['content']);
        }
        else if ($announceFlag)
        {
            $post = new Announcement($postData['title'], $postData['content']);
        }

        $sql = "INSERT INTO Post (postTitle, postContent, postAuthor, postType, profileID) 
                VALUES ('$post->postTitle', '$post->postContent', 'Ethan Morris', $post->postType, 1);";

        $this->db->query($sql);    
    }

    function editPost(string $id)
    {
        $sql = "SELECT * FROM Post WHERE postID = $id";
        $result = $this->db->query($sql);

        if ($result->size() == 1)
        {
            $row = $result->fetch();
            $postID = $row['postID'];
            $postTitle = $row['postTitle'];
            $postContent = $row['postContent'];
        }

        $this->s->set('id', $postID);
        $this->s->set('title', $postTitle);
        $this->s->set('content', $postContent);
    }

    function updatePost(array $updatedPost)
    {
        $post = new Post($updatedPost['title'], $updatedPost['content']);
        $id = $updatedPost['id'];

        $sql = "UPDATE Post SET postTitle = '$post->postTitle', postContent = '$post->postContent' WHERE postID = $id;";

        $this->db->query($sql);
    }

    function deletePost(string $id)
    {
        $sql = "DELETE FROM Post WHERE postID = $id;";

        $this->db->query($sql);
    }

    // Syntax Portfolio: While loop, Switch case
    function displayPost() 
    {
        if ($this->s->get('sortPosts'))
        {
            $sql = "SELECT * FROM Post ORDER BY postID DESC LIMIT 5;";
        }
        else 
        {
            $sql = "SELECT * FROM Post LIMIT 5;";
        }

        $result = $this->db->query($sql);

        $editLabel = $this->cfg['PostInfo']['editLabel'];
        $deleteLabel = $this->cfg['PostInfo']['deleteLabel'];

        while ($row = $result->fetch())
        {
            $editBtn = new ButtonDisplay();
            $delBtn = new ButtonDisplay();

            $postID = $row['postID'];
            $typeFlag = $row['postType'];
            
            switch ($typeFlag)
            {
                case 1:
                    $view = new PostDisplay();
                    break;
                case 2:
                    $view = new AnnounceDisplay();
                    break;
            }

            if ($this->s->get('hideContent'))
            {
                $view->addRow([$row['postTitle']]);
            }
            else
            {
                $view->addRow([$row['postTitle']]);
                $view->addRow([$row['postContent']]);
            }

            //$view->addRow([$row['postAuthor']]);

            echo $view->get();

            // Creates button with current query result ID assigned to variable
            // This 'assigns' the correct button to the correct post
            echo $editBtn->get('editButton', $postID, $editLabel);
            echo $delBtn->get('deleteButton', $postID, $deleteLabel);
        }
        
        $this->s->unsetKey('hideContent');
        $this->s->unsetKey('sortPosts');
    }

    function queryProfile()
    {
        $email = $this->s->get('userEmail');

        $sql = "SELECT CONCAT(firstName, ' ', lastName) AS fullName, city, country, postcount FROM userprofile 
                INNER JOIN useraccount ON userprofile.profileID = useraccount.profileID WHERE emailAddress = '$email';";
        $result = $this->db->query($sql);

        $fullName = $result->fetch()['fullName'];
        //$city = $result->fetch()['city'];
        $country = $result->fetch()['country'];
        //$postCount = $result->fetch()['postcount'];

        $this->s->set('fullName', $fullName);
        //$this->s->set('city', $city);
        $this->s->set('country', $country);
        //$this->s->set('postCount', $postCount);
    }

    // Syntax Portfolio: Header(REST),
    function verifyLogin()
    {
        $email = $this->s->get('email');
        $pass = $this->s->get('password');

        $uppercase = preg_match('@[A-Z]@', $pass);
        $lowercase = preg_match('@[a-z]@', $pass);
        $number    = preg_match('@[0-9]@', $pass);
        $specialChars = preg_match('@[^\w]@', $pass);

        $sql = "SELECT userID, emailAddress, userPassword FROM useraccount WHERE emailAddress = '$email';";
        $result = $this->db->query($sql);

        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($pass) < 8)
        {
            echo 'Password should be at least 8 characters in length and should 
                    include at least one upper case letter, one number, and one special character.';
        }
        else 
        {
            if ($result->size() == 1)
            {
                $hashedPass = $result->fetch()['userPassword'];

                if (password_verify($pass, $hashedPass))
                {
                    session_regenerate_id();
                    $this->s->set('logged_in', TRUE);
                    $this->s->set('lastLogin', time());
                    $this->s->set('ip', $_SERVER['REMOTE_ADDR']);
                    $this->s->set('userEmail', $email);
                }
                else
                {
                    echo 'Incorrect username/password';
                }   
            }
            else 
            {
                echo 'Incorrect username/password';
            }

        $this->s->unsetKey('email');
        $this->s->unsetKey('password');

        header("Location: homepage.php");
        }
    }

    function logout()
    {
        $this->s->set('logged_in', FALSE);
        $this->s->unsetKey('userID');

        header("Location: login.php");
    }
    
    function lastLoginCheck() 
    {
        $max_elapsed = 60 * 60 * 24;

        if (!$this->s->isKeySet(['lastLogin'])) 
        {
            return false;
        }
        if (($this->s->get(['lastLogin']) + $max_elapsed) >= time()) 
        {
            return true;
        } 
        else 
        {
            return false;
        }
    }

    function ipMatchSession() 
    {
        if (!isset($_SESSION['ip']) || !isset($_SERVER['REMOTE_ADDR'])) 
        {
            return false;
        }
        if ($_SESSION['ip'] === $_SERVER['REMOTE_ADDR']) 
        {
            return true;
        } 
        else 
        {
            return false;
        }
    }
}


