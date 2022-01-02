<?php
include "php/db.php";

$conn = db();

// Grabbing all products from database
$sqlP = "SELECT * FROM products";
$resultP = $conn->query($sqlP) or die($conn->error);

// Products array (indexed) --> contains every singular product array
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
// Log the total products array (for testing)
clog($products);

// FUNCTION: Sort the products by a numerical property (descending order --> 5 to 1 star)
function numsort_products(&$arr, $sort_param){
    // Temporary variables for looping
    $arr_prods = $arr;
    $arr_rem = $arr_prods;
    $arr_property = array();

    // Copying every product property to the properties array (which is to be sorted)
    for($i = 0; $i < count($arr_prods); $i++){
        $prod = $arr_prods[$i];
        $property = $prod[$sort_param];
        array_push($arr_property, $property);
    }
    // Quicksort the ratings array in ascending order
    quicksort($arr_property, 0, count($arr_property) - 1);
    // Loop through the sorted ratings
    $arr_prods = array();
    for($j = 0; $j < count($arr_property); $j++){
        $property = $arr_property[$j];
        // Loop through every product that hasn't been matched with the sorted property
        for($k = 0; $k < count($arr_rem); $k++){
            $prod_compare = $arr_rem[$k];
            $property_compare = $prod_compare[$sort_param];
            // If the rating of the product from the original array matches the sorted array's property
            if($property_compare == $property){
                // Add the matched product to the total products array (in order of the sort)
                array_push($arr_prods, $prod_compare);
                // Remove the matched product from the loop array to prevent duplications
                array_splice($arr_rem, $k, 1);
            }
        }
    }
    // Reverse the array so that it's in descending order (the quicksort was done in ascending order)
    $arr_descend = array_reverse($arr_prods);
    return $arr_descend;
}

function compareByName($a, $b) {
    return strcmp($a["title"], $b["title"]);
}

function sort_products(&$arr, $type){
    // A -> Z
    if ($type == "A -> Z"){
        $temp = $arr;
        usort($temp, 'compareByName');
        return $temp;
    }
    elseif($type == "Price"){
        return numsort_products($arr, "price");
    }
    // Highest -> Lowest (rating)
    elseif($type == "Rating"){
        return numsort_products($arr, "rating");
    }
    // Highest -> Lowest (sales)
    elseif($type == "Trending"){
        return numsort_products($arr, "sales");
    }
    // Latest
    else {
        return array_reverse($arr);
    }
}

$products_rating = numsort_products($products, "rating");
$products_sales = numsort_products($products, "sales");

$prod_rating = $products_rating[0];
$prod_sales = $products_sales[0];
$prod_latest = $products[count($products)-1];

echo "<script>\n";
echo "let rated = " . json_encode($prod_rating, JSON_PRETTY_PRINT) . ";";
echo "let trending = " . json_encode($prod_sales, JSON_PRETTY_PRINT) . ";";
echo "let latest = " . json_encode($prod_latest, JSON_PRETTY_PRINT) . ";";
echo "\n</script>";

if (isset($_POST["searchform"])) {
    $searchform = $_POST["searchform"];
}

else {
    $searchform = null;
}

//Check if the form is empty
if(empty($searchform) ) {

}

else {
    echo "<script>\n";
    echo "window.location = 'listings.php'";
    echo "\n</script>";
}

?>

<!DOCTYPE html>
<html>

<head>
    <!-- SEO and Metadata-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Home - ReachIt</title>

    <!-- Core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <link rel="stylesheet" href="css/core.css">

    <!-- Core JS -->
    <script src="js/core.js"></script>

    <!-- Individual CSS and JS -->
    <link rel="stylesheet" href="css/index.css">
</head>

<body class="back" onload="update();">
    <!--div for puting image in the background behind semi-trasparent color-->
    <!-- source to js -->

    <!-- for navigation bar once it is made-->
    <?php include "nav.html"; ?>

    <div class="container" style="padding-top: 175px; padding-bottom: 175px;">
        <div class="row">
            <div class="col-lg-12">
                <form class="form-inline bg-search mb-2" id="searchform" action="" method="post">
                    <input id="searchbar" type="search" placeholder="ENTER ITEM TO SEARCH" aria-label="Search" class="bg-search" name="searchform">
                    <button class="btn bg-search text-dark" type="submit" id="searchbtn"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>
    </div>

    <div class="container" style="padding-bottom: 100px;">
        <div class="row">
            <div class="col-lg-4 text-center">
                <div class="card" id="latest">
                    <h2 class="mt-4 mb-4 font-weight-bold"><i class='fa fa-plus text-warning'></i> LATEST</h2>
                    <img id="latest-img" src="" class="card-img-top bordered rounded-circle img-fluid mx-auto d-block">
                    <div class="card-body mb-4">
                        <h5 class="card-title"><a href='product.php?id=' id="latest-title">Card title</a></h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <div class="card" id="trending">
                    <h2 class="mt-4 mb-4 font-weight-bold"><i class='fa fa-fire text-danger'></i> TRENDING</i></h2>
                    <img src="img/user.png" class="card-img-top bordered rounded-circle img-fluid mx-auto d-block" id="trending-img">
                    <div class="card-body mb-4">
                        <h5 class="card-title"><a href='product.php?id=' id="trending-title">Card title</a></h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <div class="card" id="rated">
                    <h2 class="mt-4 mb-4 font-weight-bold"><i class='fa fa-check-circle text-success'></i> TOP RATED</h2>
                    <img src="img/user.png" class="card-img-top bordered rounded-circle img-fluid mx-auto d-block" id="rated-img">
                    <div class="card-body mb-4">
                        <h5 class="card-title"><a href='product.php?id=' id="rated-title">Card title</a></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--
    <div class="rest"> </div>
    <div class="products">
        <div class="block">
            <h1 class="nameTopic">TOP RATED ITEMS</h1>
        </div>
        <div class="spacebt"></div>
        <div class="block">
            <h1 class="nameTopic">NEW ITEMS</h1>
        </div>
        <div class="spacebt"></div>
        <div class="block">
            <h1 class="nameTopic">TECHNOLOGY</h1>
        </div>
    </div>
    <div class="space2"></div>
    <div class="products">
        <div class="block2">
            <h1 class="nameTopic">GAMING</h1>
        </div>
        <div class="spacebt"></div>
        <div class="block">
            <h1 class="nameTopic">LIFESTYLE</h1>
        </div>
    </div>
    <div class="space2"></div>
    <div class="products">
        <div class="block">
            <h1 class="nameTopic">SERVICES</h1>
        </div>
        <div class="spacebt"></div>
        <div class="block2">
            <h1 class="nameTopic">ATIRE</h1>
        </div>
    </div>
    -->
    <?php include "footer.html"; ?>

    <!-- Framework JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

    <script src="js/index.js"></script>

</body>

</html>
