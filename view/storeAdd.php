<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bikestore - My Store - Add an employee</title>
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

      /**
       * Function executed when the document is fully loaded.
       */
      $(document).ready(function() {
        if (GestCookie.hasItem("employeeRole")) {
          const role = GestCookie.getItem("employeeRole");
          if (role === "it") {
            document.getElementById("addEmployeeItSection").style.display = "block";
          } else if (role === "chief") {
            document.getElementById("addEmployeeChiefSection").style.display = "block";
            storeIdChief = GestCookie.getItem("employeeStore");
          } else {
            alert("You don't have access to this page.");
            window.location.href = "index.php?action=products";
          }
        } else {
          alert("You don't have access to this page.");
          window.location.href = "index.php?action=products";
        }
      });

      /**
       * Function to hide employee sections.
       */
      function hideSections() {
        document.getElementById("addEmployeeItSection").style.display = "none";
        document.getElementById("addEmployeeChiefSection").style.display = "none";
      }

      /**
       * Function to add an IT employee.
       */
      function addEmployeeIt() {
        event.preventDefault();

        var employeeNameIt=$("#employeeNameIt").val();
        var employeeEmailIt=$("#employeeEmailIt").val();
        var employeePwdIt=$("#employeePwdIt").val();
        var employeeRoleIt=$("#employeeRoleIt").val();
        var storeIdIt = $("#storeIdIt").val();

        $.ajax({
          url: "https://dev-brennet222.users.info.unicaen.fr/bikestores/api/Employee/e8f1997c763",
          method: "POST",
          data: {
            store_id: storeIdIt,
            employee_name: employeeNameIt,
            employee_email: employeeEmailIt,
            employee_password: employeePwdIt,
            employee_role: employeeRoleIt,
          },
          success: function(response) {
            alert("Request sent successfully: " + response);
            window.location.href = "index.php?action=products";
          },
          error: function(xhr, status, error) {
            alert("Error: " + error);
            window.location.href = "index.php?action=storeAdd";
          }
        });
      }

      /**
       * Function to add a chief employee.
       */
      function addEmployeeChief() {
        event.preventDefault();

        var employeeNameChief=$("#employeeNameChief").val();
        var employeeEmailChief=$("#employeeEmailChief").val();
        var employeePwdChief=$("#employeePwdChief").val();
        var employeeRoleChief=$("#employeeRoleChief").val();

        $.ajax({
          url: "https://dev-brennet222.users.info.unicaen.fr/bikestores/api/Employee/e8f1997c763",
          method: "POST",
          data: {
            store_id: storeIdChief,
            employee_name: employeeNameChief,
            employee_email: employeeEmailChief,
            employee_password: employeePwdChief,
            employee_role: employeeRoleChief,
          },
          success: function(response) {
            alert("Request sent successfully: " + response);
            window.location.href = "index.php?action=products";
          },
          error: function(xhr, status, error) {
            alert("Error: " + error);
            window.location.href = "index.php?action=storeAdd";
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
  <section id="addEmployeeItSection">
    <div class="container">
        <h2>Add an employee</h2>
        <form>
            <div class="mb-3">
                <label for="employeeNameIt" class="form-label">Enter a name:</label>
                <input id="employeeNameIt" type="text" size="255"/>
                <br>

                <label for="storeIdIt" class="form-label">Enter a store id:</label>
                <input id="storeIdIt" type="number" size="255"/>
                <br>

                <label for="employeeEmailIt" class="form-label">Enter an email:</label>
                <input id="employeeEmailIt" type="text" size="255"/>
                <br>

                <label for="employeePwdIt" class="form-label">Enter a password:</label>
                <input id="employeePwdIt" type="text" size="255"/>
                <br>

                <label for="employeeRoleIt" class="form-label">Choose a role:</label>
                <select class="form-select" name="employeeRoleIt" id="employeeRoleIt">
                    <option value="employee">Employee</option>
                    <option value="chief">Chief</option>
                    <option value="it">IT</option>
                </select>
                <br>
            </div>
            <button class="btn btn-primary" onclick="addEmployeeIt(event)">Next</button>
        </form>
    </div>
  </section>

  <section id="addEmployeeChiefSection">
    <div class="container">
        <h2>Add an employee</h2>
        <form>
            <div class="mb-3">
                <label for="employeeNameChief" class="form-label">Enter a name:</label>
                <input id="employeeNameChief" type="text" size="255"/>
                <br>

                <label for="employeeEmailChief" class="form-label">Enter an email:</label>
                <input id="employeeEmailChief" type="text" size="255"/>
                <br>

                <label for="employeePwdChief" class="form-label">Enter a password:</label>
                <input id="employeePwdChief" type="text" size="255"/>
                <br>

                <label for="employeeRoleChief" class="form-label">Choose a role:</label>
                <select class="form-select" name="dataType" id="employeeRoleChief">
                    <option value="employee">Employee</option>
                    <option value="chief">Chief</option>
                    <option value="it">IT</option>
                </select>
                <br>
            </div>
            <button class="btn btn-primary" onclick="addEmployeeChief(event)">Next</button>
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
