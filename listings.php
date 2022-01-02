<?php
include 'php/db.php';

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

// Sending PHP variables to the JS components
echo "<script>\n";
echo "let products = " . json_encode($products, JSON_PRETTY_PRINT) . ";";
echo "\n</script>";

$sorted_products = array();
$sorted_products["A -> Z"] = sort_products($products, "A -> Z");
$sorted_products["Price"] = sort_products($products, "Price");
$sorted_products["Rating"] = sort_products($products, "Rating");
$sorted_products["Trending"] = sort_products($products, "Trending");
$sorted_products["Latest"] = sort_products($products, "Latest");
echo "<script>\n";
echo "let sorted_products = " . json_encode($sorted_products, JSON_PRETTY_PRINT) . ";";
echo "\n</script>";

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <!-- SEO and Metadata-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>View Listings - ReachIt</title>

    <!-- Core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <link rel="stylesheet" href="css/core.css">

    <!-- Core JS -->
    <script src="js/core.js"></script>

    <!-- Individual CSS and JS -->
    <link rel="stylesheet" href="css/listings.css">

</head>

<!-- Start of BODY -->
<body>

    <!-- Insert NAVBAR template -->
    <?php
    readfile("nav.html");
    ?>

    <div class="row mt-5 mb-5">
        <div class="col-lg-8 mx-auto">

            <!-- List group-->
            <ul class="list-group shadow" id="columns">

                <div class="row mt-3 mb-3" id="header">
                    <div class="col-lg-8">
                        <div class="text-center">
                            <h1 class="h3 font-weight-bold">Filter listings:</h1>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="btn-group">
                            <button type="button" id="sortCat" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Category</button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" onclick="changeCategory('All');">All</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" onclick="changeCategory('Outdoor Living');">Outdoor Living</a>
                                <a class="dropdown-item" onclick="changeCategory('Smart Technology');">Smart Technology</a>
                                <a class="dropdown-item" onclick="changeCategory('Home & Essentials');">Home & Essentials</a>
                                <a class="dropdown-item" onclick="changeCategory('Tools & Hardware');">Tools & Hardware</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div class="btn-group">
                            <button type="button" id="sortDrop" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sort</button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" onclick="sortProducts('Trending');">Trending</a>
                                <a class="dropdown-item" onclick="sortProducts('Latest');">Latest</a>
                                <a class="dropdown-item" onclick="sortProducts('A -> Z');">A -> Z</a>
                                <a class="dropdown-item" onclick="sortProducts('Price');">Price</a>
                                <a class="dropdown-item" onclick="sortProducts('Rating');">Rating</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="listings">
                    <!-- Dynamic building -->
                </div>
            </ul>
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

    <script src="js/listings.js"></script>

</body>

</html>