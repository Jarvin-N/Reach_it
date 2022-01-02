<?php
session_start();
include "php/db.php";

$uid = $_SESSION["user"];

$pid = $_GET['id'];
$pid = (int) $pid;
$conn = db();

// Grabbing all products from database
$sqlP = "SELECT * FROM products";
$resultP = $conn->query($sqlP) or die($conn->error);

$products = array();
// Fetching the associative array for each row in the table
while ($row = $resultP->fetch_assoc()){
    // Product array (associative) --> contains product information
    $prod = array();
    // Setting each key with the retrieved value
    foreach ($row as $key => $value){
        // Cast integer values
        if($key == "id" || $key == "rating" || $key == "sales"){
            $value = (int) $value;
        }
        $prod[$key] = $value;
    }
    // Adding the new product array to the total products array
    array_push($products, $prod);
}

// Getting all users
$sqlU = "SELECT * FROM users WHERE id = " . $uid;
$resultU = $conn->query($sqlU) or die($conn->error);

$user = array();
while ($selection = $resultU->fetch_assoc()) {
    // For each loop
    foreach ($selection as $property => $value) {
        if($property == "id"){
            $value = (int) $value;
        }
        $user[$property] = $value;
    }
}

$orders = json_decode($user["orders"]);
array_push($orders, $pid);
$orders_updated = json_encode($orders, JSON_PRETTY_PRINT);
clog($orders_updated);

// Sending to javascript
echo "<script>\n";
echo "let products = " . json_encode($products, JSON_PRETTY_PRINT) . ";";
echo "let pid = " . json_encode($pid, JSON_PRETTY_PRINT) . ";";
echo "\n</script>";

if (isset($_POST["bttnOrder"])){

    $sql = "UPDATE users SET orders='$orders_updated' WHERE id=$uid";
    if (!mysqli_query($conn, $sql)) {

    } else {
        echo "<script>\n";
        echo "window.location = 'account.php'";
        echo "\n</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- SEO and Metadata-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>View Product - ReachIt</title>

    <!-- Core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <link rel="stylesheet" href="css/core.css">

    <!-- Core JS -->
    <script src="js/core.js"></script>

    <!-- Individual CSS and JS -->
    <link rel="stylesheet" href="css/product.css">

</head>

<!-- Start of BODY -->
<body onload="changeProperties()">

    <!-- Insert NAVBAR template -->
    <?php
    readfile("nav.html");
    ?>

    <div class="container">

        <div class="row mt-4 mb-4" id="displayPage">
            <div class="col-lg-12 mb-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="listings.php">All</a></li>
                        <li class="breadcrumb-item active" id="category" aria-current="page"></li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-4 text-center">
                <img id="pimg" height="300" width="300" src="http://placehold.it/900x400" alt="">
            </div>
            <div class="col-lg-6">
                <h3 id="title" class="card-title">Product Name</h3>
                <h4 id="price">$24.99</h4>
                <hr style="width: 100%; color: black; height: 1px;"/>
                <p id="desc" class="card-text">Product Description</p>
                <span id="rating" class="text-warning"></span>
            </div>
            <div class="col-lg-2">
                <form action="" method="post">
                    <button type="submit" name="bttnOrder" class="button" style="vertical-align:middle"><span>Order</span> </button>
                </form>
            </div>
        </div>
        <div class="row mb-4" id="related">
            <hr style="width: 100%; color: black; height: 10px;" class="mt-4 mb-4"/>
            <div class="col-lg-12 mb-2 text-center">
                <h5>Check out some of our other rental items:</h5>
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

    <script src="js/product.js"></script>

</body>

</html>