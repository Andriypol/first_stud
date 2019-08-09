<?php
/**
 * Created by PhpStorm.
 * User: андре
 * Date: 06.08.2019
 * Time: 13:18
 */

/* image edit settings*/

require 'intervention/vendor/autoload.php';

use Intervention\Image\ImageManager;

$manager = new ImageManager(array('driver' => 'gd'));
$image = $manager->make('images/pinguin.jpg')->resize(100,100);

$image->save('images/pinguin.jpg');

/* connection server*/

$servername = "localhost";
   $username = "root";
   $password = "";
   $myDB = "stud_php";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$myDB", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully" . '</br>';

    }

    catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}

 $stmt = $conn->prepare("SELECT name, surname FROM stud");
    $stmt->execute();

    /* pure array*/

  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);;

    /* conversion into string, but the only one column*/

  $result_string = $stmt->fetchColumn();


    /* get string*/

   print_r($result);
   print_r("<br>" . $result[0]['name'] . ' ' .$result[0]['surname']);
    print_r("<br>" . $result_string);


    /* add new column*/

    $col2 = $conn->prepare("SHOW COLUMNS FROM stud LIKE code");
    $exists = ($col2) ? TRUE : FALSE;
    if (!$exists) {
        $new_column = $conn->prepare("ALTER TABLE stud ADD code int(20)");

        $new_column->execute();
    }

        /* FOREACH Example*/


foreach($result as $value) {


        echo $value['name'].' ' . '</br>';

}

/* Regular expressions*/

$image_string = $conn->prepare("SELECT img FROM stud");
$image_string->execute();
$img_result = $image_string->fetchAll(PDO::FETCH_ASSOC);

$pure_img = $img_result[0]['img'];

print_r($pure_img . '   ');

$regexp_img = preg_replace('#\[[^\]]+\]#', '', $pure_img);
print_r($regexp_img . ' </br>');


/*  Replacing of substrings */


$count = $image_string->rowCount();
print_r($count . '   ');



for($countf = 0 ; $countf <= $count-1; $countf++ ) {

   $subst = $img_result[$countf]['img'];
    $new_str = preg_replace('#\[[^\]]+\]#', '', $subst);
    $updated_link = $conn->prepare("UPDATE stud SET img = '$new_str'");
    $updated_link->execute();


}


?>