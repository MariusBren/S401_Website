<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bikestore - Add Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/styles.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
     <!--<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://kit.fontawesome.com/557ee1c1cd.js" crossorigin="anonymous"></script>
    <!--<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>-->
    <style>
      h2 {
        margin-top: 50px;
        margin-bottom: 50px;
      }
      form {
        margin-bottom: 300px;
      }

      label, input {
        margin-top: 15px;
        margin-bottom: 15px;
        width: 100%;
      }
    </style>
    <script type="text/javascript">

    let GestCookie = {
      hasItem: function(name) {
        const verif = new RegExp('(?:^|;\\s*)' + name.replace(/[\-\.\+\*]/g, '\\$&') + '\\s*\\=').test(document.cookie);
        if (verif == true) {
          return true;
        } else {
          return false;
        }
      },
      getItem: function(name) {
        if (this.hasItem(name)) {
          const decodedCookie = decodeURIComponent(document.cookie);
          const cookies = decodedCookie.split(';');
          for (let cookie of cookies) {
            cookie = cookie.trim();
            if (cookie.startsWith(name + '=')) {
              const cookieValue = cookie.substring(name.length + 1);
              return atob(cookieValue);
            }
          }
        } else {
          return false;
        }
      },
    }

      $( document ).ready(function() {
        if (GestCookie.hasItem("employeeId")) {
          storeId = GestCookie.getItem("employeeStore");
          console.log(storeId);
        } else {
          alert("You don't have access to this page.")
          window.location.href = "index.php?action=products";
        }
      });

      function hideSections() {
        document.getElementById("addProductSection").style.display = "none";
        document.getElementById("addBrandSection").style.display = "none";
        document.getElementById("addCategorySection").style.display = "none";
        document.getElementById("addStockSection").style.display = "none";
        document.getElementById("addStoreSection").style.display = "none";
      }

      function displayData(event) {
        event.preventDefault();

        document.getElementById("selectData").style.display = "none";
        var selectedData=$("#dataType").val();

        if (selectedData=="product") {
          //afficher
          document.getElementById("addProductSection").style.display = "block";
        } else if (selectedData=="brand") {
          //afficher
          document.getElementById("addBrandSection").style.display = "block";
        } else if (selectedData=="category") {
          //afficher
          document.getElementById("addCategorySection").style.display = "block";
        } else if (selectedData=="stock") {
          //afficher
          document.getElementById("addStockSection").style.display = "block";
        } else if (selectedData=="store") {
          //afficher
          document.getElementById("addStoreSection").style.display = "block";
        }

      }

      function addProduct() {
        event.preventDefault();

        var productName=$("#productName").val();
        var brandId=$("#brandId").val();
        var categoryId=$("#categoryId").val();
        var modelYear=$("#modelYear").val();
        var listPrice = parseFloat($("#listPrice").val());

        $.ajax({
          url: "https://dev-brennet222.users.info.unicaen.fr/DEV_S4/SAE401/bikestores/Product/e8f1997c763",
          method: "POST",
          data: {
            product_name: productName,
            brand_id: brandId,
            category_id: categoryId,
            model_year: modelYear,
            list_price: listPrice,
            auth_key: "e8f1997c763",
          },
          success: function(response) {
            alert("Request send successfully: "+response);
            window.location.href = "index.php?action=products";
          },
          error: function(xhr, status, error) {
            alert("Error: "+error);
            window.location.href = "index.php?action=addForm";
          }
        });
      }

      function addBrand() {
        event.preventDefault();

        var brandName=$("#brandName").val();

        $.ajax({
          url: "https://dev-brennet222.users.info.unicaen.fr/DEV_S4/SAE401/bikestores/Brand/e8f1997c763",
          method: "POST",
          data: {
            brand_name: brandName,
            //auth_key: "e8f1997c763",
          },
          success: function(response) {
            alert("Request send successfully: "+response);
            window.location.href = "index.php?action=products";
          },
          error: function(xhr, status, error) {
            alert("Error: "+error);
            window.location.href = "index.php?action=addForm";
          }
        });
      }

      function addCategory() {
        event.preventDefault();

        var categoryName=$("#categoryName").val();

        $.ajax({
          url: "https://dev-brennet222.users.info.unicaen.fr/DEV_S4/SAE401/bikestores/Category/e8f1997c763",
          method: "POST",
          data: {
            category_name: categoryName,
            //auth_key: "e8f1997c763",
          },
          success: function(response) {
            alert("Request send successfully: "+response);
            window.location.href = "index.php?action=products";
          },
          error: function(xhr, status, error) {
            alert("Error: "+error);
            window.location.href = "index.php?action=addForm";
          }
        });
      }

      function addStore() {
        event.preventDefault();

        var storeName=$("#storeName").val();
        var phone=$("#phone").val();
        var email=$("#email").val();
        var street=$("#street").val();
        var city=$("#city").val();
        var state=$("#state").val();
        var zipCode=$("#zipCode").val();

        $.ajax({
          url: "https://dev-brennet222.users.info.unicaen.fr/DEV_S4/SAE401/bikestores/Store/e8f1997c763",
          method: "POST",
          data: {
            store_name: storeName,
            phone: phone,
            email: email,
            street: street,
            city: city,
            state: state,
            zip_code: zipCode,
            //auth_key: "e8f1997c763",
          },
          success: function(response) {
            alert("Request send successfully: "+response);
            window.location.href = "index.php?action=products";
          },
          error: function(xhr, status, error) {
            alert("Error: "+error);
            window.location.href = "index.php?action=addForm";
          }
        });
      }

      function addStock() {
        event.preventDefault();

        var productId=$("#productId").val();
        var quantity=$("#quantity").val();
        console.log(storeId);

        $.ajax({
          url: "https://dev-brennet222.users.info.unicaen.fr/DEV_S4/SAE401/bikestores/Stock/e8f1997c763",
          method: "POST",
          data: {
            store_id: storeId,
            product_id: productId,
            quantity: quantity,
            //auth_key: "e8f1997c763",
          },
          success: function(response) {
            alert("Request send successfully: "+response);
            window.location.href = "index.php?action=products";
          },
          error: function(xhr, status, error) {
            alert("Error: "+error);
            window.location.href = "index.php?action=addForm";
          }
        });
      }
	  </script>
</head>
<body onload="hideSections()">
  <!--Navbar Start-->
  <nav class="navbar navbar-expand-lg navbar-scroll fixed-top shadow-0 border-bottom border-dark">
    <div class="mx-5 container-fluid">
      <a class="navbar-brand text-center fw-bold fs-2" href="index.php?action=products">BIKESTORE</a>      
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
        data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
        aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item mx-2">
            <a class="nav-link nav-hover" href="index.php?action=products">Products</a>
          </li>
            <?php
              if (isset($_COOKIE["employeeId"])) {
                echo '<li class="nav-item dropdown mx-2">
                  <a class="nav-link dropdown-toggle nav-hover" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                   Employee
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item nav-hover-bg" href="index.php?action=addForm">Add data</a></li>
                    <li><a class="dropdown-item nav-hover-bg" href="index.php?action=editForm">Edit data</a></li>
                    <li><a class="dropdown-item nav-hover-bg" href="index.php?action=deleteForm">Delete data</a></li>
                    <li><a class="dropdown-item nav-hover-bg" href="index.php?action=changeLogin">Change login</a></li>';
                echo '</ul>
                </li>';
              }
            ?>
          <li class="nav-item mx-2">
            <a class="nav-link nav-hover" href="index.php?action=legalNotice">Legal Notice</a>
          </li>
          <li>
            <?php
              if (isset($_COOKIE["employeeRole"]) && (base64_decode($_COOKIE["employeeRole"]) == "chief" || base64_decode($_COOKIE["employeeRole"]) == "it")) {
                echo '<li class="nav-item dropdown mx-2">
                <a class="nav-link dropdown-toggle nav-hover" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                 My store
                </a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item nav-hover-bg" href="index.php?action=storeDisplay">Display employees</a></li>
                <li><a class="dropdown-item nav-hover-bg" href="index.php?action=storeAdd">Add an employee</a></li>
                </ul>';
              }
            ?>
          </li>
            <?php
              if (isset($_COOKIE["employeeId"])) {
                echo "<button class='btn btn-dark ms-3'><a href='index.php?action=deco' class='text-white text-decoration-none'>Log out<a/></button>";
              } else {
                echo "<button class='btn btn-dark ms-3'><a href='index.php?action=newLogin' class='text-white text-decoration-none'>Login<a/></button>";
              }
            ?>
        </ul>
      </div>
    </div>
  </nav>
  <!--Navbar End-->
  <main>
  <br>
  <br>
  <br>
  
  <!--Add Form Start-->
  <section id="selectData">
    <div class="container">
      <h2>Add a data</h2>
        <form onsubmit="return false;">
            <div class="mb-3">
                <label for="dataType" class="form-label">Select the type data:</label>
                <select class="form-select" name="dataType" id="dataType">
                    <option value="product">Product</option>
                    <option value="brand">Brand</option>
                    <option value="category">Category</option>
                    <option value="store">Store</option>
                    <option value="stock">Stock</option>
                </select>
            </div>
            <button class="btn btn-primary" onclick="displayData(event)">Next</button>
        </form>
    </div>
  </section>

  <section id="addProductSection">
    <div class="container">
        <h2>Add a product</h2>
        <form>
            <div class="mb-3">
                <label for="productName" class="form-label">Choose a name:</label>
                <input id="productName" type="text" size="255"/>
                <br>

                <label for="brandId" class="form-label">Enter a brand id:</label>
                <input id="brandId" type="number" size="255"/>
                <br>

                <label for="categoryId" class="form-label">Enter a category id:</label>
                <input id="categoryId" type="number" size="255"/>
                <br>

                <label for="modelYear" class="form-label">Choose a model year:</label>
                <input id="modelYear" type="number" size="255"/>
                <br>

                <label for="listPrice" class="form-label">Choose a price:</label>
                <input id="listPrice" type="number" size="255"/>
                <br>
            </div>
            <button class="btn btn-primary" onclick="addProduct(event)">Next</button>
        </form>
    </div>
  </section>

  <section id="addBrandSection">
    <div class="container">
        <h2>Add a brand</h2>
        <form>
            <div class="mb-3">
                <label for="brandName" class="form-label">Choose a name:</label>
                <input id="brandName" type="text" size="255"/>
                <br>
            </div>
            <button class="btn btn-primary" onclick="addBrand(event)">Next</button>
        </form>
    </div>
  </section>

  <section id="addCategorySection">
    <div class="container">
        <h2>Add a category</h2>
        <form>
            <div class="mb-3">
                <label for="categoryName" class="form-label">Choose a name:</label>
                <input id="categoryName" type="text" size="255"/>
                <br>
            </div>
            <button class="btn btn-primary" onclick="addCategory(event)">Next</button>
        </form>
    </div>
  </section>

  <section id="addStockSection">
    <div class="container">
        <h2>Add a stock</h2>
        <form>
            <div class="mb-3">
                <label for="productId" class="form-label">Enter a product id:</label>
                <input id="productId" type="number" size="255"/>
                <br>

                <label for="quantity" class="form-label">Choose a quantity:</label>
                <input id="quantity" type="number" size="255"/>
                <br>
            </div>
            <button class="btn btn-primary" onclick="addStock(event)">Next</button>
        </form>
    </div>
  </section>

  <section id="addStoreSection">
    <div class="container">
        <h2>Add a store</h2>
        <form>
            <div class="mb-3">
                <label for="storeName" class="form-label">Choose a name:</label>
                <input id="storeName" type="text" size="255"/>
                <br>

                <label for="phone" class="form-label">Choose a phone number:</label>
                <input id="phone" type="text" size="25"/>
                <br>

                <label for="email" class="form-label">Choose a email:</label>
                <input id="email" type="text" size="255"/>
                <br>

                <label for="street" class="form-label">Choose a street:</label>
                <input id="street" type="text" size="255"/>
                <br>

                <label for="city" class="form-label">Choose a city:</label>
                <input id="city" type="text" size="255"/>
                <br>

                <label for="state" class="form-label">Choose a state:</label>
                <input id="state" type="text" size="10"/>
                <br>

                <label for="zipCode" class="form-label">Choose a zip code:</label>
                <input id="zipCode" type="text" size="5"/>
                <br>
            </div>
            <button class="btn btn-primary" onclick="addStore()">Next</button>
        </form>
    </div>
  </section>

  <!--Add Form End-->

  <br>
  
  </main>

  <!--Footer Start-->
  <footer class="bg-dark text-center text-white">
    <div class="container p-4 pb-0">
      <section class="mb-4">
        <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-facebook-f"></i></a>
          <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-instagram"></i></a>
          <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-linkedin-in"></i></a>
        </section>
      </div>
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
          <p>©<?=date("Y")?> Copyright Bikestore</p>
        </div>
    </div>
  </footer>
  <!--Footer End-->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
