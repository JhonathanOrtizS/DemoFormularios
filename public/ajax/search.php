<?php
    $key=$_GET['key'];
    $array = array();
    $con=mysql_connect("localhost","root","");
    $db=mysql_select_db("database evaluacion",$con);
    $query=mysql_query("select * from users where name LIKE '%{$key}%'");
    while($row=mysql_fetch_assoc($query))
    {
      $array[] = $row['title'];
    }
    echo json_encode($array);