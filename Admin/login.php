  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>E - Books</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
    <!-- Custom Font Icons CSS-->
    <link rel="stylesheet" href="css/font.css">
    <!-- Google fonts - Muli-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="../Images/logo.png">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>

<body>
  <div class="login-page">
    <div class="container d-flex flex-column align-items-center justify-content-center">
      
    

      <div class="form-holder has-shadow">
        <div class="form d-flex align-items-center justify-content-center">
          <div class="content">
              <div class="login-header-text text-center text-white mb-4">
        <!-- <img src="./img/logo-edit3.png" alt="" width="20%"> -->
        <h1>E - Books</h1>
        <p class="mb-1">Carry a thousand worlds with you.</p>
        <p class="mb-1">Read anytime, anywhere, on any device.</p>
        <p class="mb-1">Your personalized bookstore, open 24/7.</p>
      </div>
            <form method="post" action="checkLogin.php" class="form-validate">
              <div class="form-group">
                <input id="login-username" type="text" name="aname" required data-msg="Please enter your username" class="input-material">
                <label for="login-username" class="label-material input-field">User Name</label>
              </div>
              <div class="form-group">
                <input id="login-password" type="password" name="apass" required data-msg="Please enter your password" class="input-material">
                <label for="login-password" class="label-material input-field">Password</label>
              </div>
              <input type="submit" class="btn btn-primary w-100" name="btnlogin" value="Login">
            </form>
          </div>
        </div>
      </div>

    </div>
    
    <!-- <div class="copyrights text-center">
      <p>2018 &copy; Your company. Download From <a target="_blank" href="https://templateshub.net">Templates Hub</a>.</p>
    </div> -->
  </div>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/popper.js/umd/popper.min.js"> </script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
  <script src="js/front.js"></script>
</body>

  </html>