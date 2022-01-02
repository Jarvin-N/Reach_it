var sort_type;
var check_category = "All";

function appendProducts(arr){
    /*
    SAMPLE HTML
    <li class="list-group-item">
        <div class="media align-items-lg-center flex-column flex-lg-row p-3">
        <div class="media-body order-2 order-lg-1">
        <h5 class="mt-0 font-weight-bold mb-2">Awesome product</h5>
    <p class="font-italic text-muted mb-0 small">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit fuga autem maiores necessitatibus.</p>
    <div class="d-flex align-items-center justify-content-between mt-1">
        <h6 class="font-weight-bold my-2">$120.00</h6>
    <ul class="list-inline small">
        <li class="list-inline-item m-0"><i class="fa fa-star text-success"></i></li>
    </ul>
    </div>
    </div><img src="https://res.cloudinary.com/mhmd/image/upload/v1556485076/shoes-1_gthops.jpg" alt="Generic placeholder image" width="200" class="ml-lg-5 order-1 order-lg-2">
    </div>
    </li>
    */
    for(let elem in arr){
        let prod = arr[elem];
        let category = prod["category"];
        if(category == check_category || check_category == "All") {

            let id = prod["id"];
            let name = prod["title"];
            let desc = prod["description"];
            let rating = prod["rating"];
            let price = prod["price"];
            let img = prod["img"];
            if (img == null || img == "") {
                img = "http://www.stonyelectrical.com/wp-content/uploads/2018/04/Product_Icon.png";
            }

            document.getElementById("listings").innerHTML +=
                "<li class='list-group-item'> " +
                "<div class='media align-items-lg-center flex-column flex-lg-row p-3'> " +
                "<div class='media-body order-2 order-lg-1'> " +
                "<h5 class='mt-0 font-weight-bold mb-2'><a href='product.php?id=" + id + "'> " + name + "</a></h5> " +
                "<p class='font-italic text-muted mb-0 small'><b>" + category + "</b> - " + desc + "</p> " +
                "<div class='d-flex align-items-center justify-content-between mt-1'> " +
                "<h6 class='font-weight-bold my-2'>$" + price + " / day</h6> <ul class='list-inline small'> " +
                "<li class='list-inline-item m-0'><i class='fa fa-star text-warning'> " + rating + "</i></li> " +
                "</ul> </div> </div>" +
                "<img src='" + img + "' height='150px' width='150px' class='ml-lg-5 order-1 order-lg-2'> </div> </li>";
        }
    }

}

function changeCategory(cat){
    check_category = cat;
    sortProducts(sort_type);
}

function sortProducts(type){
    document.getElementById("listings").innerHTML = "";
    sort_type = type;
    document.getElementById("sortDrop").innerText = type;
    appendProducts(sorted_products[type]);
}

sortProducts("Latest");