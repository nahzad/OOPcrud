<?php

require_once 'database.php';


$obj = new Database();
/*$obj->insert("students",["name" =>"Hashim Amla", "age"=>"22", "city"=>"Chottogram"]);
echo "Insert result is : ";
echo "<pre>";
print_r($obj->get_result());*/

/*$obj->update("students",["city" => "Cumilla"], "city = 'Chottogram'");
echo "Update result is : ";
echo "<pre>";
print_r($obj->get_result());*/

/*$obj->delete("students", 'id = "3"');
echo "Delete result is : ";
echo "<pre>";
print_r($obj->get_result());*/

/*$obj->sql("SELECT * FROM students");
echo "Query result is : ";
echo "<pre>";
print_r($obj->get_result());*/

$obj->select ("students","*",null, null, null,null);
echo "<br>Select result is : ";
echo "<pre>";
print_r($obj->get_result());

?>