<?php
/*Ian Taylor
CS 290 Web Dev
Assignment 4 Pt 2
*/
/* This script sends the appropriate changes to the database, and displays the queries*/
error_reporting(E_ALL);
ini_set("display_errors",1);

echo "Click <a href='interface.php'>here to return to the interface page.</a><br>";

$db = new mysqli('oniddb.cws.oregonstate.edu', 'taylori-db', 'VW7JzS651xzzxZJU', 'taylori-db');

//CHECK CONNECTION
if(!$db || $db->connect_errno){
    echo "Connection error" . $db->connect_errno . "" . $db->connect_error;
}
else 
    echo "Successful connection!<br>";

/* DELETE ALL OPTION */
if(isset($_POST['DeleteAll']) && ($_POST['DeleteAll'] == "Delete ALL Videos")){
    $db->query("DELETE FROM video_store");
    die("<br>All records deleted");
}
else
    echo "<br> Nothing to delete today!";

$missingInfo = false; //boolean to check for missing parameters
if($_POST){

    if(!isset($_POST['vidName']) || $_POST['vidName'] == ''){
        echo "<br>ERROR: missing video name";
        $missingInfo = true;
    }
    else{
        $name = $_POST['vidName'];
        echo "<br>", $name;
    }
    
    if(!isset($_POST['vidCategory']) || $_POST['vidCategory'] == ''){
        echo "<br>No category specified. Video filed under 'Misc'";
        $category = "Misc"; //a category is not required to add a movie. movies can be default-added to miscellaneous
    }
    else{
        $category = $_POST['vidCategory'];
        echo "<br>", $category;
    }
    
    
    if(!isset($_POST['vidLength']) || $_POST['vidLength'] == ''){
        echo "<br>ERROR: missing video length";
        $missingInfo = true;
    }
    else{
        $length = $_POST['vidLength'];
        echo "<br>",$length;
    }
}
if($missingInfo)
    echo"<br>ERROR: Missing required information";



/* INSERT the newly added video into the database using prepared statements */
$stmt = $db->prepare("INSERT INTO video_store(name, category, length) VALUES(?, ?, ?)");
$stmt->bind_param('ssi', $name, $category, $length);
$stmt->execute();

$filter = '';
if(isset($_GET['filters']) && ($_GET['filters'] != NULL) && ($_GET['filters'] != '')){
    if($_GET['filters'] == 'all'){
        $filter = '';  
    }
    else{
        $filter = $_GET['filters'];
    }
}
echo "<br>FILTER BY: $filter<br>";

/* CREATING THE TABLE OF MOVIES */
echo "<table border='1' style='width:50%'>"; //open the table, set style

echo "<tr>"; //open top row with header fields
echo "<th>Name</th>";
echo "<th>Cateogry</th>";
echo "<th>Length</th>";
echo "<th>Availability</th>";
echo "</tr>"; //close top row

if($filter == ''){
    $result = $db->query("SELECT * FROM video_store"); //get the database contents  
}
else{
    $stmt = $db->prepare("SELECT * FROM video_store WHERE category=?"); //get the database contents
    $stmt->bind_param('s', $filter);
    $stmt->execute();
    $result = $stmt->get_result();
}
while($row = $result->fetch_object()){
    echo "<tr>"; // create one row per movie
    echo "<td>" . $row->name . "</td><td>" . $row->category . "</td><td>" . $row->length . "</td>";

    if($row->rented)
        echo "<td>Available</td>";
    else
        echo "<td>Checked Out</td>";

    echo "</tr>";
}
echo "</table>"; //close the table
$result->free(); // frees memory associated with the returned result



//header("Location: http://web.engr.oregonstate.edu/~taylori/CS290_Assignment4pt2/interface.php");
?>







