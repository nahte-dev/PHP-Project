<?php
declare(strict_types = 1);

abstract class AbstractDB 
{
	abstract function  __construct(string $host, string $userName, string $password, string $dbName);
}