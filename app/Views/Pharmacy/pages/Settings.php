<?php
$db = \Config\Database::connect();
$pharmacist_id = session()->get('id');
$first_name = session()->get('pharmacist_fname');
$last_name = session()->get('pharmacist_lname');
$address = "";
$email = "";
$query = $db->query("SELECT * FROM PHARMACIST WHERE ID LIKE '$pharmacist_id'");
foreach ($query->getResult() as $result) {
  $address = $result->ADDRESS;
}
$contact = $db->query("SELECT * FROM contact WHERE PHARMACIST_ID LIKE '$pharmacist_id'");
foreach ($contact->getResult() as $result) {
  $ID = $result->ID;
  $contact_details = $db->query("SELECT * FROM contact_details WHERE CONTACT_ID LIKE '$ID' AND TYPE LIKE '1'");
  foreach ($contact_details->getResult() as $details ) {
    $email = $details->DETAIL;
  }
}
?>

      <div class="col-8 flex-column d-flex h-100 mt-5 " style="margin-left:auto; margin-right:auto; font-family:Helvetica">
        <div class="account_details container border border h-auto w-100  mt-2 mb-3" style="border-radius: 45px 45px 45px 45px;">
            <div class="container h-75 " style="margin-right:auto; margin-left:auto; width:90%;">
              <div class=""style="text-align:center;">
                <small style="font-size: 30px; font-family:Times;">Account Details</small>
              </div>
              <div class="container" style=" border-bottom-width: 2px; border-bottom-style: solid; border-bottom-color:#1d9feb;">
              </div>

              <div class="form-group first mt-3">
                <div class="" style="text-align:justify; font-size:17px;">
                  <label for="">Name: <?php echo " ".$first_name." ".$last_name; ?></label>
                  <br>
                  <label for="">Email: <?php echo " ".$email;?></label>
                  <br>
                  <label for="" style="">Address: <?php echo " ".$address; ?></label>
                  <br>
                </div>
              </div>

            </div>
        </div>

        <div class="change_username container border border h-auto w-100 mt-2" style="border-radius: 45px 45px 45px 45px;">
          <p class="mt-4 ml-5 " style="color:black; font-size:160%; text-align:left; font-family:Helvetica; font-weight:bolder;">
            <div class="new_username container h-75" style="margin-right:auto; margin-left:auto; width:90%;">
              <small style="font-size: 30px; font-family:Times; ">Change Username</small>
              <div class="container" style=" border-bottom-width: 2px; border-bottom-style: solid; border-bottom-color:#1d9feb;">
              </div>
              <form class="" action="settings/change_username" method="post">
              <br>
              <?php if(session()->get('changeusername')): ?>
                <div class="form-group first">
                  <div class="alert alert-success" role="alert">
                    Successfully Changed Username
                  </div>
                </div>
              <?php endif; ?>
              <div class="form-group first">
                <input type="text" class="form-control" id="new_username" name = "new_username" placeholder="Enter New Username"
                style="font-size:15px;border-radius: 30px 30px 30px 30px; border-color:#1d9feb;">
                <input type="hidden" name="pharmacist_id" value="<?php echo "$pharmacist_id"; ?>">
              </div>
                <button type="submit" class="btn btn-primary mt-2 mb-2" style="float:right; width:80px;">Save</button>
              </form>
            </div>
          </p>
        </div>
        <div class="change_password container border border h-auto w-100  mt-4" style="border-radius: 45px 45px 45px 45px;">
          <p class="mt-4 ml-5 " style="color:black; font-size:160%; text-align:left; font-family:Helvetica; font-weight:bolder;">
            <div class="new_password container h-75" style="margin-right:auto; margin-left:auto; width:90%;">
              <small style="font-size: 30px; font-family:Times; ">Change Password</small>

              <div class="container" style=" border-bottom-width: 2px; border-bottom-style: solid; border-bottom-color:#1d9feb;">
              </div>
              <form class="" action="settings/change_password" method="post">
              <br>
              <?php if(session()->get('changepass')): ?>
                <div class="form-group first">
                  <div class="alert alert-success" role="alert">
                    Successfully Changed Password
                  </div>
                </div>
              <?php endif; ?>
              <?php if(session()->get('changepassfail')): ?>
                <div class="form-group first">
                  <div class="alert alert-danger" role="alert">
                    Invalid Current Password Input
                  </div>
                </div>
              <?php endif; ?>
              <div class="form-group first">
                <input type="password" class="form-control" id="old_password" name = "old_password" placeholder="Enter Old Password"
                style="font-size:15px; border-radius: 30px 30px 30px 30px; border-color:#1d9feb;" required>
              </div>

              <div class="form-group second">
                <input type="password" class="form-control" id="password" name = "new_password" placeholder="Enter New Password"
                style="font-size:15px; border-radius: 30px 30px 30px 30px; border-color:#1d9feb;" required>
              </div>

              <div class="form-group mb-3">
                <input type="password" class="form-control" id="confirm_password"  placeholder="Confirm New Password"
                style="font-size:15px; border-radius: 30px 30px 30px 30px; border-color:#1d9feb;" required>
                <input type="hidden" name="pharmacist_id" value="<?php echo "$pharmacist_id"; ?>">
              </div>
                <button type="submit" class="btn btn-primary mt-2 mb-2" style="float:right; width:80px;">Save</button>
              </form>
            </div>
          </p>
        </div>
      </div>
<script type="text/javascript">
    var password = document.getElementById("password")
    , confirm_password = document.getElementById("confirm_password");

    function validatePassword(){
    if(password.value != confirm_password.value) {
      confirm_password.setCustomValidity("New Password Don't Match");
    } else {
      confirm_password.setCustomValidity('');
    }
    }

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;
</script>
