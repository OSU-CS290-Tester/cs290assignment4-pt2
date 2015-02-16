<?php
/*Ian Taylor
CS 290 Web Dev
Assignment 4 Pt 2
*/
/* This page provides the user interface for interacting with the database */
error_reporting(E_ALL);
ini_set("display_errors",1);
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"> <!--Always define the character set-->
        <title>Login</title>
    </head>
    <body>

        <h1>Ian Taylor: Video Store Interface</h1>
        <br>

        <?php

/* CONNECT TO DATABASE */
$db = new mysqli('oniddb.cws.oregonstate.edu', 'taylori-db', 'VW7JzS651xzzxZJU', 'taylori-db');

//CHECK CONNECTION
if(!$db || $db->connect_errno){
    echo "Connection error" . $db->connect_errno . "" . $db->connect_error;
}
else{ 
    echo "Successful connection!<br>";
}
        ?>


        <form action="database.php" method="post">
            <input type="text" name="vidName"> Name<br>
            <input type="text" name="vidCategory"> Category<br>
            <input type="text" name="vidLength"> Length<br>
            <input type="submit" name="Add Video"> Click Submit to Add Video     
            <input type="submit" name="DeleteAll" value="Delete ALL Videos"><br>
        </form>
        <br>

        <form action="database.php" method="get">
           
                <?php
/* CREATE DROPDOWN MENU */
$result = $db->query("SELECT DISTINCT category FROM video_store"); //query to get all distinct column values
echo"<select name='filters'>";
echo "<option value='all'>ALL Movies</option>"; // provide option for all movies

while($row = $result->fetch_object()){
    echo "<option value='$row->category'>" . $row->category . "</option>";
}
echo"</select>"; //closing dropdown tag

$result->free();
                ?>
           
            
            <input type="submit" name="filtersclick">
        </form>            
    </body>
</html>