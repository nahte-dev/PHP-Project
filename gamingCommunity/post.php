<?php
declare(strict_types = 1);
include('postinterface.php');

// Syntax Porfolio: Abstract, Constructors, Classes, Properties
abstract class AbstractPost 
{
    abstract function __construct(string $postTitle, string $postContent);
}

class Post extends AbstractPost implements PostInterface
{
    var $postTitle;
    var $postContent;
    var $postType;

    function __construct(string $thePostTitle, string $thePostContent)
    {
        $this->postTitle = $thePostTitle;
        $this->postContent = $thePostContent;
        $this->postType = 1;
    }
}

class Announcement extends Post implements PostInterface
{
    var $postTitle;
    var $postContent;
    var $postType;

    function __construct(string $thePostTitle, string $thePostContent)
    {
        parent::__construct($thePostTitle, $thePostContent);
        $this->postType = 2;
    }
}

