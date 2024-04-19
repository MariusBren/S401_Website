<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bikestore - Change Login</title>
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
       * Object for managing cookies.
       * @type {Object}
       */
      let GestCookie = {
        /**
         * Checks if a cookie with a specified name exists.
         * @param {string} name - The name of the cookie to check.
         * @returns {boolean} - True if the cookie exists, otherwise false.
         */
        hasItem: function(name) {
          const verif = new RegExp('(?:^|;\\s*)' + name.replace(/[\-\.\+\*]/g, '\\$&') + '\\s*\\=').test(document.cookie);
          return verif;
        },
        /**
         * Gets the value of a cookie with a specified name.
         * @param {string} name - The name of the cookie to retrieve.
         * @returns {string|boolean} - The value of the cookie if it exists, otherwise false.
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
      };

      /**
       * Changes the login details via AJAX.
       * @param {Event} event - The event triggering the function.
       */
      function changeLoginSave(event) {
        event.preventDefault();

        var email=$("#email").val();
        var pwd=$("#pwd").val();
        var id=GestCookie.getItem("employeeId");

        $.ajax({
          url: "https://dev-brennet222.users.info.unicaen.fr/bikestores/api/Login/edit/e8f1997c763",
          method: "PUT",
          data: JSON.stringify({
            id: id,
            email: email,
            pwd: pwd,
          }),
          success: function(response) {
            alert("Request sent successfully: "+response);
            window.location.href = "index.php?action=products";
          },
          error: function(xhr, status, error) {
            alert("Error: "+error);
            window.location.href = "index.php?action=storeAdd";
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
  
  <!--Add Form Start-->
  <section id="changeLoginSection">
    <div class="container">
        <h2>Change your login</h2>
        <form>
            <div class="mb-3">
                <label for="email" class="form-label">Enter a new email:</label>
                <input id="email" type="text" size="255"/>
                <br>

                <label for="pwd" class="form-label">Enter a new password:</label>
                <input id="pwd" type="text" size="255"/>
                <br>
                <br>
            </div>
            <button class="btn btn-primary" onclick="changeLoginSave(event)">Save</button>
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
