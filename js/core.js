// User object
function User(id, un, em, pw){
    // Initial properties
    this.UID = id;
    this.userName = un;
    this.email = em;
    this.password = pw;
    this.orders = "";
}

// Product object
function Product(id){
    // Initial properties
    this.PID = id;
    this.name = "";
    this.description = "";
    this.category = "";
    this.rating = 0;
    this.sales = 0;
}

// Order object
function Order(id){
    // Initial properties
    this.OID = id;
    this.product = "";
    this.date = "";
    this.price = 0;
    this.isComplete = false;
}