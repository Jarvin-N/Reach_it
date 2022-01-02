function update() {
    document.getElementById("latest-img").src = latest["img"];
    document.getElementById("latest-title").innerText = latest["title"];
    document.getElementById("latest-title").href = "product.php?id=" + latest["id"];

    document.getElementById("trending-img").src = trending["img"];
    document.getElementById("trending-title").innerText = trending["title"];
    document.getElementById("trending-title").href = "product.php?id=" + trending["id"];

    document.getElementById("rated-img").src = rated["img"];
    document.getElementById("rated-title").innerText = rated["title"];
    document.getElementById("rated-title").href = "product.php?id=" + rated["id"];
}