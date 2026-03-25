<?php

    function conexion(){

    $host = "host=dpg-d71v8h0gjchc739qbh80-a.oregon-postgres.render.com";
    $port = "port=5432";
    $dbname = "dbname=test_m769";
    $user = "user=test_m769_user";
    $password = "password=LPEdZMH9wAw54CbbEUVLjMQLJMgzJhT6";

    $db = pg_connect("$host $port $dbname $user $password");

    return $db;
}
?>