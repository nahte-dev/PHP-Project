<?php
declare(strict_types = 1);

interface QueryResultInterface 
{
    function size() : int;
    function fetch() : array;
	function isError() : bool;
}