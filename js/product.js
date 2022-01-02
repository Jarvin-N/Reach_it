let product = products[pid];

let productName = product["title"];
let productDesc = product["description"];
let productCategory = product["category"];
let productPrice = product["price"];
let productImg = product["img"];
let productRate = product["rating"];

function changeProperties(){
    // For the product itself
    document.getElementById("title").innerText = productName;
    document.getElementById("price").innerText = "$" + productPrice + " / day";
    document.getElementById("category").innerText = productCategory;
    document.getElementById("desc").innerText = productDesc;
    document.getElementById("rating").innerHTML = stars(productRate);
    document.getElementById("pimg").src = productImg;

    // For the related 3 products to display
    let randoms = random3();
    for(let rand in randoms){
        let p = products[randoms[rand]];
        let p_title = p["title"];
        let p_desc = p["description"];
        let p_img = p["img"];
        let p_id = p["id"];
        document.getElementById("related").innerHTML +=
            "<div class='col-4 text-center'> " +
            "<div class='card'> " +
            "<img width='200' height='200' src='" + p_img + "' class='card-img-top'> " +
            "<div class='card-body'> " +
            "<h5 class='card-title'>" +
            "<a href='product.php?id=" + p_id + "'>" + p_title + "</a></h5> " +
            "<p class='card-text'>" + p_desc + "</p> " +
            "</div> </div> </div>";
    }

}

function stars(num){
    if (num == 5){
        return "&#9733; &#9733; &#9733; &#9733; &#9733;";
    }
    else if(num == 4){
        return "&#9733; &#9733; &#9733; &#9733; &#9734;";
    }
    else if(num == 3){
        return "&#9733; &#9733; &#9733; &#9734; &#9734;"
    }
    else if (num == 2){
        return "&#9733; &#9733; &#9734; &#9734; &#9734;"
    }
    return "&#9733; &#9734; &#9734; &#9734; &#9734;"
}

function random3(){
    let arr = [];
    for(let i = 0; i < 3; i++){
        let rand = Math.floor(Math.random() * (products.length - 1));
        while(rand == pid || arr.includes(rand)){
            rand = Math.floor(Math.random() * (products.length - 1));
        }
        arr.push(rand);
    }
    return arr;
}

