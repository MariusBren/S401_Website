<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bikestore - My store - Employees</title>
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
        #employeeTab {
          margin-bottom: 300px;
        }
    </style>
    <!--couleur naver dashboard-->
    <script type="text/javascript">
      /**
       * Function executed when the document is fully loaded.
       */
      $(document).ready(function(){
        // Reset filter values
        $('#yearFilter').val('');
        $('#minPriceFilter').val('');
        $('#maxPriceFilter').val('');

        /**
         * Object containing methods for handling cookies.
         * @constant
         */
        let GestCookie = {
          /**
           * Checks if a cookie with the specified name exists.
           * @param {string} name - The name of the cookie to check.
           * @returns {boolean} - True if the cookie exists, otherwise false.
           */
          hasItem: function(name) {
            const verif = new RegExp('(?:^|;\\s*)' + name.replace(/[\-\.\+\*]/g, '\\$&') + '\\s*\\=').test(document.cookie);
            return verif;
          },
          /**
           * Retrieves the value of the specified cookie.
           * @param {string} name - The name of the cookie to retrieve.
           * @returns {(string|boolean)} - The value of the cookie if found, otherwise false.
           */
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
            }
            return false;
          },
        }

        if (GestCookie.hasItem("employeeRole") && GestCookie.getItem("employeeRole") == "chief") {
          let storeId = GestCookie.getItem("employeeStore");
          // Fetch employees from the chief's store via AJAX
          $.ajax({
            url: 'https://dev-brennet222.users.info.unicaen.fr/bikestores/api/Store/Employee/',
            type: 'GET',
            dataType: 'json',
            data: {
              store_id: storeId
            },
            /**
             * Success callback function for AJAX request.
             * Populates employee list with data from the chief's store.
             * @param {Object[]} data - Array of employee objects
             */
            success: function(data) {
              var table = $('#employeeList');
              $.each(data, function(index) {
                table.append('<tr><td>'+data[index].employee_id+'</td><td>'+data[index].employee_name+'</td><td>'+data[index].employee_email+'</td><td>'
                +data[index].employee_role+'</td><td>'+data[index].employee_store+'</td></tr>');
              });
            },
            /**
             * Error callback function for AJAX request.
             * Logs the error to the console.
             * @param {Object} error - Error object
             */
            error: function(error) {
              console.error('Error during the retrieval of all employees from your store: ', error);
            }
          })

        } else if(GestCookie.hasItem("employeeRole") && GestCookie.getItem("employeeRole") == "it") {
          // Fetch all employees via AJAX for IT department
          $.ajax({
            url: 'https://dev-brennet222.users.info.unicaen.fr/bikestores/api/Employee',
            type: 'GET',
            dataType: 'json',
            /**
             * Success callback function for AJAX request.
             * Populates employee list with all employees.
             * @param {Object[]} data - Array of employee objects
             */
            success: function(data) {
              var table = $('#employeeList');
              $.each(data, function(index) {
                table.append('<tr><td>'+data[index].employee_id+'</td><td>'+data[index].employee_name+'</td><td>'+data[index].employee_email+'</td><td>'
                +data[index].employee_role+'</td><td>'+data[index].employee_store+'</td></tr>');
              });
            },
            /**
             * Error callback function for AJAX request.
             * Logs the error to the console.
             * @param {Object} error - Error object
             */
            error: function(error) {
              console.error('Error during the retrieval of all employees: ', error);
            }
          })
          
        } else {
          alert("You don't have access to this page.");
          window.location.href = "index.php?action=addForm";
        }
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

  <!--Employee Tab Start-->
    <div class="container mt-4" id="employeeTab">
      <div class="table-responsive">
        <table class="table table-striped table-hover border">
          <thead class="table-dark">
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Store</th>
            </tr>
          </thead>
          <tbody id="employeeList">
            <!--Content generated by jquery-->
          </tbody>
        </table>
      </div>
    </div>
    <!--Employee Tab End-->
    
    <br>
    <br>
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
