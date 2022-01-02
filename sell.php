<?php
session_start();
include "php/db.php";

if(!isset($_SESSION["logged"])){
    header("Location: login.php");
}

$conn = db();

// Get the user table
$sqlProducts = "SELECT COUNT(*) FROM products;";
$resultProducts = $conn->query($sqlProducts) or die($conn->error);

$row = mysqli_fetch_array($resultProducts);
$total = (int) $row[0];

//Creating variables from the form
if (isset($_POST["pName"]) && isset($_POST["pPrice"]) && isset($_POST["pDesc"]) && isset($_POST["pImg"]) && isset($_POST["pCat"])) {
    $pName = $_POST["pName"];
    $pPrice= (int) $_POST["pPrice"];
    $pDesc = $_POST["pDesc"];
    $pCat = $_POST["pCat"];
    $pImg = $_POST["pImg"];
}

else {
    $pName = null;
    $pPrice= null;
    $pDesc = null;
    $pCat = null;
    $pImg = null;
}

//Check if the form is empty
if(empty($pName) || empty($pPrice) || empty($pDesc) || empty($pImg) || empty($pCat)) {

}

//Inserting the user to the database
else {
    $pRating = 0;
    $pSales = 0;
    $sql = "INSERT INTO products (id, title, description, category, rating, sales, price, img) VALUES ('$total', '$pName', '$pDesc', '$pCat', '$pRating', '$pSales', '$pPrice', '$pImg')";
    if (!mysqli_query($conn, $sql)) {

    } else {
        header("Location: listings.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <!-- SEO and Metadata-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sell - ReachIt</title>

    <!-- Core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <link rel="stylesheet" href="css/core.css">

    <!-- Core JS -->
    <script src="js/core.js"></script>

    <!-- Individual CSS and JS -->
    <link rel="stylesheet" href="css/product.css">
    <link rel="stylesheet" href="css/sell.css">

</head>

<!-- Start of BODY -->
<body>

<!-- Insert NAVBAR template -->
<?php
readfile("nav.html");
?>

<div class="container">

    <form action="" method="post">
    <div class="row mt-4 mb-4" id="displayPage">
        <div class="col-lg-4 text-center">
            <img id="prod-img" height="300" width="300" src="http://placehold.it/300x300" alt="">
            <div class="form-label-group mt-2 mb-2">
                <input name="pImg" type="text" id="pImg" class="form-control" placeholder="Image URL" required>
                <label for="pImg"><i style="font-size: 14px;" class="fas fa-link"></i> Image URL</label>
            </div>
            <button type="button" class="btn btn-secondary" onclick="updateImg();">Update</button>
        </div>
        <div class="col-lg-6">
            <style>
                input {
                    font-family: 'Raleway', sans-serif;
                }
            </style>

                <div class="col-lg-12">
                    <input name="pName" type="text" id="pName" class="form-control mt-2 mb-2" placeholder="Product Name" required style="font-size: 1.8em;">
                </div>


                <div class="col-lg-4">
                    <input name="pPrice" type="number" id="pPrice" class="form-control mb-2" placeholder="Price" required style="font-size: 1.5em;">
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <select class="form-control" name="pCat" id="pCat">
                            <option>Outdoor Living</option>
                            <option>Smart Technology</option>
                            <option>Home & Essentials</option>
                            <option>Tools & Hardware</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12">
                    <hr style="width: 100%; color: black; height: 1px;"/>
                    <input name="pDesc" type="text" id="pDesc" class="form-control mb-2" placeholder="Product Description" required style="font-size: 1.0em; height: 100px; ">
                    <button class="button float-right" type="submit"><span>Create</span> </button>
                </div>

        </div>
    </div>
    </form>
</div>


<!-- Insert FOOTER template -->
<?php
readfile("footer.html");
?>

<!-- Framework JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

<script src="js/sell.js"></script>

</body>

</html>