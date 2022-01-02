document.getElementById("welcome").innerHTML = "Welcome back, <i>" + user["username"] + "</i>";
document.getElementById("username").innerText = "Username: " + user["username"];
document.getElementById("email").innerText = "Email: " + user["email"];
document.getElementById("password").innerText = "Password: " + toAsterisk(user["password"]);

function toAsterisk(word){
    return Array(word.length+1).join("*");
}

document.getElementById("order-count").innerText += " (" + orders.length + ")";
if(orders.length == 0 || orders == null){
    document.getElementById("orders").innerHTML =
        "<p>Looks like you don't have any orders. <a class='font-weight-bold' href='listings.php'>Let's change that!</a></p>"
}
else {
    for (let ID in orders) {
        let index = orders[ID];
        let product = products[index];
        /*
        <li class="list-group-item">
                            <img src="https://res.cloudinary.com/mhmd/image/upload/v1556485076/shoes-1_gthops.jpg" alt="Generic placeholder image" height="150" width="150" class="ml-lg-5">
                            <div class="media align-items-lg-center flex-column flex-lg-row p-2">
                                <div class="media-body">
                                    <h5 class="font-weight-bold"><a id="title" href="">Awesome product</a></h5>
                                    <h6 class="font-weight-bold" id="price">$120.00</h6>
                                </div>
                            </div>
                        </li>
         */
        let product_name = product["title"];
        let product_price = product["price"];
        let product_img = product["img"];
        document.getElementById("orders").innerHTML +=
            "<li class='list-group-item'> " +
            "<img src='" + product_img + "' height='150' width='150' class='ml-lg-5 mt-2'> " +
            "<div class='media align-items-lg-center p-2'> " +
            "<div class='media-body '> " +
            "<h5 style='font-size: 16px;' class='font-weight-bold'><a href='product.php?id=" + ID + "'>" + product_name + "</a></h5> " +
            "<h6 class='font-weight-bold'>$" + product_price + " / day</h6> " +
            "</div> </div> </li>"
    }
}