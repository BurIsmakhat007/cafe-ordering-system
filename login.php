<!DOCTYPE html>
<html>

<head>
  <title>Login and Registration</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400&display=swap" rel="stylesheet">

  <style>
    body {
      
  font-family: 'Roboto Mono', monospace;
  background-image: url('https://wallpaperbat.com/img/143711-food-illustrations-on-blue-background-minimalism-hd-wallpaper.jpg');
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: -1;
  background-size: cover;
  background-repeat: no-repeat;
  background-color: rgba(0, 0, 0, 0.5); /* Adjust the alpha value (0.5) as per your preference */
}

    
  </style>
</head>

<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <img src="https://play-lh.googleusercontent.com/NlzmKukv1mYdkgUZw8GpCO_cLalJtymfJ8tzEtaRlZQLFZUirjagjNypoJu3nwapmGo" class="card-img-top" alt="Image" style="width:250px; height:250px; margin-left:130px; margin-top:20px">
          <div class="card-body">
            <h2 class="card-title text-center"> Suza Cafeteria </h2>
            <form method="post" action="includes/login.php">
              <div class="form-group mt-5">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
              </div>
              <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <button type="submit" class="btn btn-outline-success btn-sm" name="loginBtn">Login</button>
            </form>
            <a type="button" class="btn btn-outline-secondary btn-sm mt-5 text-center ml-5" href="registration.php"">Dont you have account? Click here to register</a>

          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>