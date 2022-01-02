<?php
session_start();
include "php/db.php";

if(!isset($_SESSION["logged"])){
    header("Location: login.php");
}

$conn = db();

$UID = $_SESSION["user"];

// Getting all users
$sql = "SELECT * FROM users WHERE id=$UID";
$result = $conn->query($sql) or die($conn->error);

$user = array();
while ($selection = $result->fetch_assoc()) {
    // For each loop
    foreach ($selection as $property => $value) {
        if($property == "id"){
            $value = (int) $value;
        }
        if($property == "orders"){
            $value = json_decode($value);
        }
        $user[$property] = $value;
    }
}

$sqlP = "SELECT * FROM products";
$resultP = $conn->query($sqlP) or die($conn->error);

$products = array();
while ($row = $resultP->fetch_assoc()){
    $prod = array();
    foreach ($row as $key => $value){
        if($key == "id" || $key == "rating" || $key == "sales"){
            $value = (int) $value;
        }
        $prod[$key] = $value;
    }
    array_push($products, $prod);
}

$orders = $user["orders"];

echo "<script>\n";
echo "let user = " . json_encode($user, JSON_PRETTY_PRINT) . ";";
echo "let orders = " . json_encode($orders, JSON_PRETTY_PRINT) . ";";
echo "let products = " . json_encode($products, JSON_PRETTY_PRINT) . ";";
echo "\n</script>";


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <!-- SEO and Metadata-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>My Account - ReachIt</title>

    <!-- Core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <link rel="stylesheet" href="css/core.css">

    <!-- Core JS -->
    <script src="js/core.js"></script>

    <!-- Individual CSS and JS -->
    <link rel="stylesheet" href="css/account.css">

</head>

<!-- Start of BODY -->
<body>

<!-- Insert NAVBAR template -->
<?php
readfile("nav.html");
?>

    <div class="container">
        <div id="columns" class="row mt-4 mb-4">
            <div class="col-lg-12 text-center">
                <img src="img/user.png" width="100" height="100">
                <h1 id="welcome" class="h3 mt-2 font-weight-bold">Welcome back, </h1>
            </div>
            <hr style="width: 100%; color: black; height: 10px;"/>
            <div class="col-lg-12 text-center">
                <h5 class="font-weight-bold">Your details:</h5>
                <p id="username">Username: </p>
                <p id="email">Email: </p>
                <p id="password">Password: </p>
            </div>
            <hr style="width: 100%; color: black; height: 10px;"/>
            <div class="col-lg-12 text-center">
                <h5 id="order-count" class="font-weight-bold mb-4">Your order history:</h5>
                <div id="orders">

                </div>
            </div>
        </div>
    </div>


<!-- Insert FOOTER template -->
<?php
readfile("footer.html");
?>

<!-- Framework JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

<script src="js/account.js"></script>

</body>

</html>