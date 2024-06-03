<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="SweetAlert/sweetalert2.min.css"></script>
    <script src="SweetAlert/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="fontawesome-free-6.5.2-web/css/all.min.css" />
    <script src="jquery/jquery.js"></script>
    <link rel="stylesheet" href="css/login.css" />
    <title>Login</title>
  </head>

  <body>
    <nav>
      <h1>Parking System</h1>
    </nav>
    <section>
      <form action="php/register.php" method="POST">
        
      
        <h1>Register</h1>

        <div class="input-wrapper">

         <div class="inputbox">
            <input type="text" name="Name" placeholder="Name" />
          </div>

          <div class="inputbox">
            <input type="email" name="Email" placeholder="Email" />
          </div>

          <div class="inputbox">
            <input type="password" name="Password" placeholder="Password" />
          </div>

           <div class="inputbox">
                <select name="account_type" id="">
                    <option value="1">ADMIN</option>
                    <option value="2">USER</option>
                </select>
          </div>

          <div class="inputsubmit">
            <input type="submit" value="Submit" />
          </div>

          <div class="inputregister">
            <a href="login.php">Already Have an Account</a>
          </div>
        </div>
      </form>
    </section>
  </body>
</html>
