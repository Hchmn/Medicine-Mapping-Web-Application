<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/login_only/fonts/icomoon/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/login_only/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/login_only/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/login_only/css/style.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <title>Pharmacy</title>
    <style media="screen">
    .topnav-centered small {
        float: none;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
      }
      body{
        background-image: url('<?php echo base_url(); ?>/static_images/1621379.jpg');
        background-size:cover;
      }
    </style>
  </head>
  <body class="" style="overflow:hidden; ">
  <div class="d-md-flex flex-row half" style="">
    <div class="col" style="background-color: rgba(104, 177, 245, 0.75);">
    </div>
    <div class="col-lg-5 col-md-8 bg-white" style="height: 100vh;">
      <div class="container h-auto" style="overflow: hidden;">
        <div class="row align-items-center justify-content-center"  style="">

          <div class="col-md-7">
            <div class="mb-4">
              <h3 style="" class="fw-bold fs-2">Medicine Mapping</h3 >
            </div>
            <div class="mb-4">
              <h4 style="">Sign In</h4 >
            </div>
            <form action="/" method="post">
              <?php if(session()->get('success')): ?>
                <script type="text/javascript">
                  alert("Thank you for your submission. Our team will review the submitted information. We will send confirmation via email or text message to the contact information submitted");
                </script>
              <?php endif; ?>
              <div class="form-group first mb-3">
                <label for="username"> <i class="fas fa-user" style="margin-right: 5px;">  Username</i></label>
                <input type="text" class="form-control" id="username" name="USERNAME" value="">
              </div>

              <div class="form-group last mb-3 ">
                <label for="password"> <i class="fas fa-key" style="margin-right: 5px;">  Password</i></label>
                <input type="password" class="form-control" id="password" name="PASSWORD" value="">
              </div>
              <?php if(session()->get('invalid')): ?>
                <div class="col-12 mt-2">
                  <div class="alert alert-danger" role="alert">
                    Invalid Username or Password
                  </div>
                </div>
              <?php endif; ?>
              <div class="d-flex mb-5 align-items-center" style="float:right;">
                <span class="mr-1">Register your Pharmacy?</span>
                <span class=""><a href="/register" class="text-primary" >Register</a></span>

              </div>
              <input type="submit" value="Log In" class="btn btn-block btn-primary">
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
    <script src="<?php echo base_url(); ?>/login_only/js/jquery-3.3.1.min.js"></script>
    <script src="<?php echo base_url(); ?>/login_only/js/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>/login_only/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>/login_only/js/main.js"></script>
  </body>
</html>
