<body class="h-100 overflow-hidden">
  <div class="row h-100">
    <div class="col">
    </div>
    <div class="col h-100 d-flex align-items-center">
      <div class="container">
        <form class="" action="" method="" id="loginForm">
          <div class="mb-3 row">
            <label for="" class="col-sm-2 col-form-label">Username</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="username" required id="inputUsername" value="">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
              <input aria-describedby="inputPasswordFeedback" type="password" class="form-control" name="password" required id="inputPassword">
              <div id="inputPasswordFeedback" class="invalid-feedback">
                Invalid username or password.
              </div>
            </div>

          </div>
          <div class="mt-5 mb-3 row d-flex justify-content-center">
            <input type="submit" name="submit" value="Sign in" class="btn btn-primary w-50">
          </div>
        </form>
      </div>
    </div>
    <div class="col">
    </div>
  </div>

</body>
<script src="<?php echo base_url(); ?>/assets/js/login.js?v=5" charset="utf-8"></script>
