<?php
$authentication_code = "";
$authentication_code = session()->getTempdata('authentication_code');
$button_status = "";
if(session()->get('button')){
  $button_status = session()->get('button');
}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/authentication/style.css">
    <title>Pharmacy</title>
  </head>
  <body>
      <div class="">
        <nav class="navbar navbar-expand-md navbar-light " style="background: #1d9feb; height:50px;" >
              <div class="" style="">
              </div>

        </nav>
      </div>
        <form class="myForm " method="post" action="Dashboard/dashboard">
          <div class="form-group">
            <label for="email">Authentication </label>
            <div class="" style="margin-left:auto; margin-right:auto;">
            <input class="form-control input-lg d-flex d-row" type="text" name="authentication_code" id="authentication_code" placeholder="Enter your authentication code here" required>
            <input class="form-control input-lg" type="hidden" name="code" id="code" placeholder="" value ="<?php echo "$authentication_code"; ?>"/>
            </div>
            <div class=" ">
              <button type="submit" id = "button1" name="" class="btn btn-success" style="width:250px; background:#76cc02;"><span class="glyphicon glyphicon-edit" style=""></span>Proceed</button>
            </div>
          </div>
        </form>
      <br>
      <div class="container mt-1">
        <form class="resendAuthentication mt-2" action="Authentication/resendAuthentication" method="post">

          <button type="submit" name="" id = "btn" class="button btn btn-primary"  style="width:250px;"> <span class="glyphicon glyphicon-edit"></span>Resend Code</button>
        </form>
      </div>

  </body>
</html>

<script type="text/javascript">
    var authentication_code = document.getElementById("authentication_code")
    , code = document.getElementById("code");

    function validatePassword(){
    if(authentication_code.value != code.value) {
      authentication_code.setCustomValidity("Wrong Authentication Code");
    } else {
      authentication_code.setCustomValidity('');
    }
    }
    authentication_code.onchange = validatePassword;
    authentication_code.onkeyup = validatePassword;

    <?php if($button_status == ""): ?>
      document.getElementById("btn").disabled = false;

    <?php  else:?>
      document.getElementById("btn").disabled = true;
      setInterval(function(){ document.getElementById("btn").disabled = false;} , 30000);
    <?php endif; ?>

</script>
