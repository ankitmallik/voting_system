<?php

define("client","localhost");
define("username","root");
define("password","123456");
define("db_name","voting");

$con = mysqli_connect(client,username,password,db_name);

if(!$con)
{
    echo "error";
    die(mysqli_error($con));
}
