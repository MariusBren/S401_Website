<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bikestore - Legal Notice</title>
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
        .container {
          max-width: 800px;
          margin: auto;
        }
        h1 {
          text-align: center;
          margin-bottom: 15px;
        }
        h2 {
          margin-top: 30px;
        }
        p {
          margin-bottom: 20px;
        }
    </style>
    <!--couleur naver dashboard-->
    <script type="text/javascript">
      /**
       * Generates a map based on client IP and store locations.
       */
      $(document).ready(function(){
        var ip;
        var addresses = [];

        /**
         * Retrieves the client's IP address.
         */
        function getClientIp() {
          $.getJSON("https://api.bigdatacloud.net/data/client-ip",{},function (data) {
            ip = data.ipString;
            getClientLocation(ip);
          });
        }

        /**
         * Retrieves the client's location based on IP.
         * @param {string} ip - The client's IP address.
         */
        function getClientLocation(ip) {
          $.getJSON("https://api.apibundle.io/ip-lookup?apikey=aee4a30e51774edba7e5a11a863f0fb5&ip="+ip,{},function (data) {
            var storeAd = {
              name: "Your location",
              coords: [parseFloat(data.latitude), parseFloat(data.longitude)]
            };
            addresses.push(storeAd);
            getStoresLocations();
          });  
        }

        /**
         * Retrieves locations of stores.
         */
        function getStoresLocations() {
          $.getJSON("https://dev-brennet222.users.info.unicaen.fr/bikestores/api/Addresses", {}, function(data) {
            var requests = [];
            $.each(data, function(index) {
              var request = $.getJSON("https://geocode.xyz/" + data[index].addresse + "?json=1&auth=215880901580060813457x762")
                .then(function(data) {
                  var storeAd = {
                    name: "Store of " + data.standard.addresse,
                    coords: [parseFloat(data.latt), parseFloat(data.longt)]
                  };
                  addresses.push(storeAd);
                });
              requests.push(request);
            });
            $.when.apply($, requests).then(function() {
              displayMap();
            });
          });
        }
          
        /**
         * Displays the map with client location and store locations.
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
        
        getClientIp();
        
      });
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
  <br>

  <div class="container">
        <h1>Legal Notice</h1>
        <p>This website is operated by BikStore, a chain of retail stores specializing in bicycles, with its headquarters located in the United States.</p>
        
        <h2>Terms and Conditions of Use:</h2>
        <p>By accessing this website, you agree to comply with and be bound by the following terms and conditions of use. If you do not agree with any part of these terms and conditions, please do not use our website.</p>
        
        <h2>Intellectual Property:</h2>
        <p>All content included on this website, such as text, graphics, logos, button icons, images, audio clips, digital downloads, data compilations, and software, is the property of BikStore or its content suppliers and is protected by United States and international copyright laws. The compilation of all content on this site is the exclusive property of BikStore and protected by U.S. and international copyright laws.</p>
        
        <h2>Limitation of Liability:</h2>
        <p>BikStore shall not be liable for any special or consequential damages that result from the use of, or the inability to use, the materials on this site or the performance of the products, even if BikStore has been advised of the possibility of such damages.</p>
        
        <h2>Governing Law:</h2>
        <p>This website is controlled by BikStore from its offices located in the state of [insert state], United States of America. By accessing this website, you agree that the laws of the state of [insert state], without regard to principles of conflict of laws, will govern these terms and conditions and any dispute of any sort that might arise between you and BikStore.</p>
        
        <h2>Changes to Terms:</h2>
        <p>BikStore reserves the right to change these terms and conditions from time to time at its sole discretion. Your continued use of this site constitutes your agreement to any modified terms and conditions.</p>
        
        <h2>Contact Information:</h2>
        <p>If you have any questions or concerns regarding these terms and conditions, please contact us at:</p>
        <ul>
            <li>BikStore Headquarters</li>
            <li>123 Main Street</li>
            <li>Anytown, USA</li>
        </ul>
        <p>Email: <a href="mailto:info@bikstore.com">info@bikstore.com</a></p>
        <p>Phone: +1 (555) 123-4567</p>
        
        <p>Nous vous encourageons également à suivre notre page sur les réseaux sociaux pour les dernières mises à jour et offres spéciales :</p>
        <ul>
            <li>Facebook: <a href="https://www.facebook.com/bikstore" target="_blank">@bikstore</a></li>
            <li>LinkedIn: <a href="https://linkedin.com/bikstore_usa" target="_blank">@bikstore_usa</a></li>
            <li>Instagram: <a href="https://www.instagram.com/bikstore_official" target="_blank">@bikstore_official</a></li>
        </ul>
    </div>

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
