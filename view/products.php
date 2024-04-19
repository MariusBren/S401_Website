<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bikestore - Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/styles.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://kit.fontawesome.com/557ee1c1cd.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <style>
        #map { height: 500px; }
    </style>
    <!--couleur naver dashboard-->
    <script type="text/javascript">
		  /**
       * Function that initializes the page by populating the product list, brand filter, and category filter via AJAX.
       * @function
       */
      $(document).ready(function(){
        // Reset filter values
        $('#yearFilter').val('');
        $('#minPriceFilter').val('');
        $('#maxPriceFilter').val('');

        // Fetch product data via AJAX
        $.ajax({
          url: 'https://dev-brennet222.users.info.unicaen.fr/bikestores/api/Products',
          type: 'GET',
          dataType: 'json',
          /**
           * Success callback function for AJAX request.
           * Populates product list, brand filter, and category filter.
           * @param {Object[]} data - Array of product objects
           */
          success: function(data) {
            var table = $('#productList');
            var brandFilter = $('#brandFilter');
            var categoryFilter = $('#categoryFilter');
            var allBrands = {};
            var allCategories = {};

            $.each(data, function(index) {
              // Display product information in table rows
              table.append('<tr><td>'+data[index].id+'</td><td>'+data[index].name+'</td><td>'+data[index].brand
                +'</td><td>'+data[index].category+'</td><td>'+data[index].model_year+'</td><td>'+data[index].list_price+'</td></tr>');

              // Populate brand filter
              if (!allBrands[data[index].brand]) {
                allBrands[data[index].brand] = true;                          
                brandFilter.append('<option value="' + data[index].brand + '">' + data[index].brand + '</option>')
              }

              // Populate category filter
              if (!allCategories[data[index].category]) {
                allCategories[data[index].category] = true;                          
                categoryFilter.append('<option value="' + data[index].category + '">' + data[index].category + '</option>')
              }
            });
          },
          /**
           * Error callback function for AJAX request.
           * Logs the error to the console.
           * @param {Object} error - Error object
           */
          error: function(error) {
            console.error('Error during the retrieval of all products:', error);
          }
        })
      });

      /**
       * Function to fetch client IP address and display map with client and store locations.
       */
      $(document).ready(function(){
        var ip;
        var addresses = [];

        /**
         * Function to retrieve client IP address.
         */
        function getClientIp() {
          $.getJSON("https://api.bigdatacloud.net/data/client-ip",{},function (data) {
            ip = data.ipString;
            getClientLocation(ip);
          })
        }
        
        /**
         * Function to retrieve client location based on IP address.
         * @param {string} ip - Client IP address
         */
        function getClientLocation(ip) {
          $.getJSON("https://api.apibundle.io/ip-lookup?apikey=aee4a30e51774edba7e5a11a863f0fb5&ip="+ip,{},function (data) {
            var storeAd = {
              name: "Your location",
              coords: [parseFloat(data.latitude), parseFloat(data.longitude)]
            };
            addresses.push(storeAd);
            getStoresLocations();
          })  
        }   

        /**
         * Function to fetch store locations and display map.
         */
        function getStoresLocations() {
          $.getJSON("https://dev-brennet222.users.info.unicaen.fr/bikestores/api/Addresses", {}, function(data) {
            var requests = [];
            $.each(data, function(index) {
              var request = $.getJSON("https://geocode.xyz/" + data[index].addresse + "?json=1&auth=215880901580060813457x762")
                .then(function(data) {
                  var storeAd = {
                    name: "Store of " + data.standard.city,
                    coords: [parseFloat(data.latt), parseFloat(data.longt)]
                  };
                  addresses.push(storeAd);
                })
              requests.push(request);
            });
            $.when.apply($, requests).then(function() {
              displayMap();
            });
          })
        }
          
        /**
         * Function to display map with client and store locations.
         */
        function displayMap() {
          var map = L.map('map').setView(addresses[0].coords, 12);
          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
          }).addTo(map);

          addresses.forEach(function(address) {
            L.marker(address.coords).addTo(map).bindPopup(address.name);
          });
        }
        
        // Initialize by fetching client IP address
        getClientIp();
      });

      /**
       * Function to filter products based on selected options.
       */
      function changeFilter(){
        var selectedBrand = $('#brandFilter').val();
        var selectedCategory = $('#categoryFilter').val();
        var selectedYear = parseInt($('#yearFilter').val());
        var minPrice = parseFloat($('#minPriceFilter').val());
        var maxPrice = parseFloat($('#maxPriceFilter').val());

        $('#productList tr').each(function(index, element) {
          var productId = $(this).find('td:eq(0)').text();
          var productName = $(this).find('td:eq(1)').text();
          var productBrand = $(this).find('td:eq(2)').text();
          var productCategory = $(this).find('td:eq(3)').text();
          var productYear = parseInt($(this).find('td:eq(4)').text());
          var productPrice = parseFloat($(this).find('td:eq(5)').text());

          var showProduct = true;

          if (selectedBrand !== "all" && productBrand !== selectedBrand) {
            showProduct = false;
          } else if (selectedCategory !== "all" && productCategory !== selectedCategory) {
            showProduct = false;
          } else if (!isNaN(selectedYear) && productYear !== selectedYear) {
            showProduct = false;
          } else if (!isNaN(minPrice) && productPrice < minPrice) {
            showProduct = false;
          } else if (!isNaN(maxPrice) && productPrice > maxPrice) {
            showProduct = false;
          } 
          
          if (showProduct) {
            $(this).show();
          } else {
            $(this).hide();
          }
        
        });
      }
	  </script>
</head>
<body>
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

    <!--Filter Start-->
    <div class="container mt-4">
      <div class="row">
        <div class="col-md-3">
          <label class="fw-bold mb-2" for="brandFilter">Brand:</label>
          <select id="brandFilter" class="form-select" onchange="changeFilter()">
            <option value="all">All</option>
            <!-- Options for brands will be populated dynamically -->
          </select>
        </div>
        <div class="col-md-3">
          <label class="fw-bold mb-2" for="categoryFilter">Category:</label>
          <select id="categoryFilter" class="form-select" onchange="changeFilter()">
            <option value="all">All</option>
            <!-- Options for categories will be populated dynamically -->
          </select>
        </div>
        <div class="col-md-3">
          <label class="fw-bold mb-2" for="yearFilter">Model Year:</label>
          <input type="number" id="yearFilter" class="form-control" onchange="changeFilter()">
        </div>
        <div class="col-md-3">
          <label class="fw-bold mb-2" for="priceFilter">Price Range (min-max):</label>
          <div class="row">
            <div class="col-md-6"><input type="number" id="minPriceFilter" class="form-control" placeholder="Min" onchange="changeFilter()"></div>
            <div class="col-md-6"><input type="number" id="maxPriceFilter" class="form-control" placeholder="Max" onchange="changeFilter()"></div>
          </div>
        </div>
      </div>
    </div>
  <!--Filter End-->

  <!--Product Tab Start-->
    <div class="container mt-4">
      <div class="table-responsive">
        <table class="table table-striped table-hover border">
          <thead class="table-dark">
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Brand</th>
              <th>Category</th>
              <th>Model year</th>
              <th>List price ($)</th>
            </tr>
          </thead>
          <tbody id="productList">
            <!--Content generated by jquery-->
          </tbody>
        </table>
      </div>
    </div>
    <!--Product Tab End-->
    
    <br>
    <br>
    <br>

    <!--Map-->
    <div id="map"></div>

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
