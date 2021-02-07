<?php
//Turn on error reporting
ini_set('display_errors',1);
error_reporting(E_ALL);

//start session
session_start();

//require the autoload file
require_once ('vendor/autoload.php');
require_once ('model/data-layer.php');

//create an instance of th Base class
$f3 = Base::instance();

//set a debug for fat free
$f3 -> set('DEBUG',3);

// define a default route
$f3 -> route('GET /', function ()
{
    $view = new Template();
    echo $view -> render('views/pet-home.html');
}
);

//set a route for order
$f3 -> route('GET|POST /order', function ($f3)
{
        //CHECK IF THE FORM HAS BEEN POSTED
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //validate the data
            if(empty($_POST['pet'])){
                echo "please choose a pet";
            }else {
                echo $_POST['pet'];
            }
        }
    $colors = getColor();
    $f3 ->set('color' ,$colors) ;
    $view = new Template();
    echo $view -> render('views/pet-order.html');
}
);

//set a route for order2
$f3 -> route('POST /order2', function ($f3)
{
    $sizes = getSize();
    $f3 -> set('sizes', $sizes);
    $f3->set('accessories', getAccessories());
    //var_dump($_POST);
    if(isset($_POST['pet'])) {
        $_SESSION['pet'] = $_POST['pet'];
    }

    if(isset($_POST['color'])) {
        $_SESSION['color'] = $_POST['color'];
    }
    $view = new Template();
    echo $view -> render('views/pet-order2.html');
}
);

//summary route
$f3 -> route ('POST /summary', function ()

{

   if (isset($_POST['petName'])) {
       $_SESSION['petName'] = $_POST['petName'];
   }

    if (isset($_POST['sizes'])) {
        $_SESSION['sizes'] = $_POST['sizes'];
    }

    if (isset($_POST['accessories'])) {

        $_SESSION['accessories'] = implode(", ", $_POST['accessories']);
      //  $_SESSION['accessories'] =  $_POST['accessories'];
    }



    //Display a view
    $view = new Template();
    echo $view->render('views/order-summary.html');

});
//run fat free
$f3 -> run();
