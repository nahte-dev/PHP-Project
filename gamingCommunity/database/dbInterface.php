<?php
declare(strict_types = 1);

interface  DBInterface
{
	function createConnection() : void;
	function selectDatabase() : void;
    function createDatabase() : void;
    function dropDatabase() : void;
	function isError() : bool;
	function query(string $sql);
}