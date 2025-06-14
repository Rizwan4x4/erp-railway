<?php

namespace App\Database\Connectors;
use Illuminate\Database\Connectors\SqlServerConnector;
use PDO;



class CustomSqlServerConnector extends \Illuminate\Database\Connectors\SqlServerConnector
{
    protected $options = [
        PDO::ATTR_CASE => PDO::CASE_NATURAL,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL,
        PDO::SQLSRV_ATTR_FETCHES_NUMERIC_TYPE => true,
    ];
}
