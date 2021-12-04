<body class="h-100 overflow-hidden">
  <div class="border d-flex p-5 justify-content-between" style="height:70px;">
    <div class="align-self-center">
      <a class="h1 fw-bold text-decoration-none text-dark" href="<?php echo base_url(); ?>/admin/dashboard">MED MAPPING</a>
    </div>
    <div class="align-self-center d-flex justify-content-end align-items-center" style="height:50px;">
      <p class="mb-0 fs-5" ><?php echo $username; ?></p>
      <div class="" style="width:50px;">
      </div>
      <a href="<?php echo base_url(); ?>/login" class="btn btn-outline-primary">Sign out</a>
    </div>
  </div>
  <!-- BODY -->
  <div class="h-100 d-flex flex-row">
    <!-- Side menu -->
    <div class="col-3 p-4 sidemenu">
      <div class="border mb-2">
        <a href="<?php echo base_url(); ?>/admin/log" class="btn btn-outline-secondary w-100 d-flex align-items-center active" style="height:55px;">
          Activity Logs
        </a>
      </div>
      <hr>
      <div class="mb-2">
        <a href="<?php echo base_url(); ?>/admin/medicine" class="btn btn-outline-secondary w-100 d-flex align-items-center " style="height:55px;">
          Medicine
        </a>
      </div>
      <div class="">
        <a href="<?php echo base_url(); ?>/admin/pharmacy" class="btn btn-outline-secondary w-100 d-flex align-items-center" style="height:55px;">
          Pharmacy
        </a>
      </div>
    </div>
    <div class="col-3 d-none" id="tempSpace"></div>
    <div class=" col">
      <!-- table -->
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col">#ID</th>
            <th scope="col">Admin</th>
            <th scope="col">Description</th>
            <th scope="col">Date</th>
          </tr>
        </thead>
        <tbody>
          <?php
            foreach ($logs as $key => $value) {
              $id = $value['LOG_ID'];
              $desc = $value['LOG_DESC'];
              $date = $value['CREATED_AT'];
              $admin = (empty($value['ADMIN']))? "SYSTEM":$value['ADMIN'];
              ?>
              <tr>
                <th scope="row"><?php echo "$id"; ?></th>
                <td ><?php echo "$admin"; ?></td >
                <td ><?php echo "$desc"; ?></td >
                <td ><?php echo "$date"; ?></td >
              </tr>
              <?php
            }
           ?>

        </tbody>
      </table>
    </div>
  </div>
</body>
