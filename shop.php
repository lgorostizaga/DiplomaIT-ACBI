<!DOCTYPE html>
<html lang="en">
<head>
    <!--Set up charset to be used on webpage-->
    <meta charset="utf-8">
    <!--Defines initial scale for viewport-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--Describes webpage content-->
    <meta name="description" content="Luca’s Loaves webpage">
    <!--Load bootstrap CSS-->
    <link rel="stylesheet" href="bootstrap-5/css/bootstrap.min.css">
    <!--Load custom CSS-->
    <link rel="stylesheet" href="css/main.css">
    <!--Webpage title to be displayed on browser tab-->
    <title>Luca’s Loaves</title>
    <!--Favicon Image to be displayed on browser tab-->
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
</head>
<body>
    <!--Set up responsive container-->
    <div class="container-md">
    <!--Company logo-->
    <div class="logo">
      <img src="images/logo.png" class="logo-empresa mx-auto d-block" alt="luca's logo">
    </div>
    <!--Set up responsive navbar-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
            <a class="nav-link" href="index.html">Home</a>
            <a class="nav-link active" aria-current="shop.php">Shop Now!</a>
            <a class="nav-link" href="about.html">About</a>
            <a class="nav-link" href="careers.html">Careers</a>
            <a class="nav-link" href="contact.html">Contact</a>
            </div>
          </div>    
        </div>
      </nav>
    <!--Webpage Content-->
    <div class="background">
    <div class="container"> 
    <?php
      // connect with DB
      // variables for db connection
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "lgluca";
      //create connection
      $conn = new mysqli($servername,$username,$password,$dbname);
      //check connectio is success of not
      if($conn->connect_error){
          die("Connection failed ".$conn->connect_error);
      }
      //Cart Table
      // declare and assign 0 to qty
      $qty1=0;
      $qty2=0;
      $qty3=0;
      $qty4=0;
      $qty5=0;
      // read values of qty from user input
      if(!EMPTY($_POST['qty1'])){
          $qty1 = $_POST['qty1'];
      }
      if(!EMPTY($_POST['qty2'])){
          $qty2 = $_POST['qty2'];
      }
      if(!EMPTY($_POST['qty3'])){
          $qty3 = $_POST['qty3'];
      }
      if(!EMPTY($_POST['qty4'])){
          $qty4 = $_POST['qty4'];
      }
      if(!EMPTY($_POST['qty5'])){
          $qty5 = $_POST['qty5'];
      }
      // sql statement to select all data from products table    
      $sql = "SELECT * FROM products";
      // run sql statement and put all data in $results
      $results = $conn->query($sql);
      // check there are records
      if($results->num_rows >0){
          echo "<h1>My Cart</h1>";
          echo "<form method='POST' action='shop.php'>";
          echo "<table class='table'>";
          // table heading
          echo "<tr>
                  <th>ID</th>
                  <th>NAME</th>
                  <th>UNIT PRICE</th>
                  <th>QUANTITY</th>
                  <th>PRICE</th>
                  </tr> ";
                  // declare variable for row number and total
                  $i = 0;
                  $total = 0;
                  $price = 0;
                  // read record by record
                  while($row = $results->fetch_assoc()){
                      $i++; // increment for rows
                      // check qty is not 0
                      if(${"qty$i"}>0){
                          // calculate price multiply unit price by qty
                          $price = $row['price'] * ${"qty$i"};
                          // calculate running total
                          //$total += $price;
                          $total = $total + $price;
                          // format price to 2 decimal
                          $myprice = number_format($price,2);
                          //put data into table cells
                          echo "<tr>
                              <td>{$row['ID']}</td>
                              <td>{$row['name']}</td>
                              <td>\${$row['price']}</td>
                              <td>${"qty$i"}</td>
                              <td>\${$myprice}</td>
                          </tr>";

                      }
                  }
                  // format total
                  $total= number_format($total,2);
                  // leave three cells blank and add total
                  echo "<tfoot><tr><td></td><td></td><td></td><td>TOTAL</td><td>\${$total}</td></tr></tfoot>";
                  echo "</table>
                        <input class='btn btn-secondary' type='submit' value='Empty My Cart'>        
                  </form>";

      }else{
          echo "No records";
      }            
      //Product Selection
      // sql statement to select all data from products table    
      $sql = "SELECT * FROM products";
      // run sql statement and put all data in $results
      $results = $conn->query($sql);
      // create form and table for products
      echo "<form method='POST' action='shop.php'>";
      echo "<h1>Select Products</h1>";
      echo "<table class='table'>";
      echo "<tr>
            <th>ID</th>
            <th>NAME</th>
            <th>DESCRIPTION</th>
            <th>IMAGE</th>
            <th>PRICE</th>
            <th>QUANTITY</th>
            </tr>";
      // declare variable for row number
      $i=0;
      while($row = $results->fetch_assoc()){
          $i++; // increment
          echo "<tr>
                  <td>{$row['ID']}</td>
                  <td>{$row['name']}</td>
                  <td>{$row['description']}</td>
                  <td><img src='images/{$row['image']}' class='logo-empresa'></td>
                  <td>\${$row['price']}</td>
                  <td><input type='number' min=0 max=10 value=0 name ='qty$i'></td>
                </tr>";
      }
      echo "</table><br><input type='submit' class='btn btn-secondary' value='Add to Cart'></form>"; 
    ?>
    </div>
  </div>  
    <!--Copyright Footer-->
    <footer class="page-footer"> 
      <div class="footer-copyright text-center">© 2021 Copyright: Luca's Loaves</div>
    </footer>
    <!--Closing tag for responsive container-->
    </div>
    
    <!--Load Bootstrap's JS scripts-->
    <script src="bootstrap-5/js/bootstrap.min.js"></script>
    <!--Load jQuery-->
    <script src="jquery-3.6.0.min.js"></script>
    <!--Load custom js code-->
    <script src="js/main.js"></script>
</body>
</html>