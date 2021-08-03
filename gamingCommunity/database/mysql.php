<?php
//Syntax Porfolio: Include_Once
declare(strict_types = 1);
include_once 'abstractDB.php';
include_once 'abstractQueryResult.php';
include_once 'dbInterface.php';
include_once 'queryInterface.php';


class Database extends AbstractDB implements DBInterface {
    var $host;
    var $userName;
    var $password;
    var $dbName;
    var $dbConnection;
    var $dbConnectError;

    function __construct(string $theHost, string $theUserName, string $thePassword, string $theDBName)
    {
        $this->host = $theHost;
        $this->userName = $theUserName;
        $this->password = $thePassword;
        $this->dbName = $theDBName;
        $this->dbConnection;
        $this->createConnection();
    }

    function createConnection() : void 
    {
        $this->dbConnection = mysqli_connect($this->host, $this->userName, $this->password);

        if (! $this->dbConnection) 
        {
            die("Connection Failed: " . $this->dbConnectError);
        }
    }

    function dropDatabase() : void 
    {
        $sql = "DROP DATABASE IF EXISTS $this->dbName";
        $this->query($sql);
    }

    function createDatabase() : void 
    {
        $sql = "CREATE DATABASE IF NOT EXISTS $this->dbName";
        $this->query($sql);
    }

    function selectDatabase() : void 
    {
        $sql = "USE $this->dbName";
        $this->query($sql);
    }

    function isError() : bool
    {
        if ($this->dbConnectError)
        {
            return true;
        }
        $error = mysqli_error($this->dbConnectError);

        if (empty($error))
        {
            return false;
        }
        else 
        {
            return true;
        }
    }

    function query(string $sql)
    {
        if (!$queryResource = mysqli_query($this->dbConnection, $sql))
        {
            trigger_error("Query Failed: " . mysqli_error($this->dbConnection) . "SQL: " . $sql);
            return false;
        }
        return new SQLQuery($this, $queryResource);   
    }

    
    function createTable(string $tableName, array $columns, string $primaryKeyColumn, string $extraModifiers = null)
    {
        $sql = "CREATE TABLE IF NOT EXISTS $tableName (";
        foreach ($columns as $columnName => $columnDetails) 
        {
            $sql .= "$columnName $columnDetails, ";
        }
        $sql .= "PRIMARY KEY ($primaryKeyColumn)";
        if (!empty($extraModifiers)) 
        {
            $sql .= ", $extraModifiers";
        }   
        $sql .= ") engine = InnoDB;";
        return $this->query($sql);
    }

    function addForeignKey(string $primaryTable, string $foreignKeyColumn, string $foreignTable, 
                            string $primaryKeyColumn, string $foreignKeyName)
    {
        $sql = "ALTER TABLE $primaryTable ADD CONSTRAINT FK_$foreignKeyName 
                FOREIGN KEY ($foreignKeyColumn) REFERENCES $foreignTable($primaryKeyColumn);";
        return $this->query($sql);
    }
}
//Syntax Portfolio: Abstract, Interfaces, Inheritance
class SQLQuery extends AbstractQueryResult
{
    var $db;
    var $queryResource;

    function __construct($theDB, $theQueryResource)
    {
        $this->db = $theDB;
        $this->queryResource = $theQueryResource;
    }

    function size() : int 
    {
        return mysqli_num_rows($this->queryResource);
    }

    function fetch()
    {
        if ($row = mysqli_fetch_array($this->queryResource, MYSQLI_ASSOC))
        {
            return $row;
        }
        else if ($this->size() > 0)
        {
            mysqli_data_seek($this->queryResource, 0);
            return false;
        }
        else 
        {
            return false;
        }
    }

    function isError() : bool
    {
        return $this->db->isError();
    }

    function prepStmt() 
    {
        $stmt = $this->db->prepare($this->queryResource);
        return $stmt;
    }
}