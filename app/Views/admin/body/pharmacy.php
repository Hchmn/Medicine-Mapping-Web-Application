<?php

 ?>
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
  <div class="border h-100 d-flex flex-row">
    <!-- Side menu -->
    <div class="border col-3 p-4 sidemenu">
      <div class="border mb-2">
        <a href="<?php echo base_url(); ?>/admin/pharmacy" class="btn btn-outline-secondary w-100 d-flex align-items-center active" style="height:55px;">
          Pharmacy
        </a>
      </div>
      <div class="border mb-2">
        <a href="<?php echo base_url(); ?>/admin/pharmacy/to_verify" class="btn btn-outline-secondary w-100 d-flex align-items-center" style="height:55px;">
          To verify
        </a>
      </div>
      <hr>
      <div class="border mb-2">
        <a href="<?php echo base_url(); ?>/admin/medicine" class="btn btn-outline-secondary w-100 d-flex align-items-center " style="height:55px;">
          Medicine
        </a>
      </div>
      <div class="border">
        <a href="<?php echo base_url(); ?>/admin/log" class="btn btn-outline-secondary w-100 d-flex align-items-center" style="height:55px;">
          Activity log
        </a>
      </div>
    </div>
    <div class="col-3 d-none" id="tempSpace"></div>
    <!-- Content -->
    <div class="border col">
      <div class="border p-3 d-flex justify-content-between">
        <div class="">
        </div>
        <div class="">
          <input type="text" name="" value="" class="form-control" placeholder="Search">
        </div>
      </div>
      <!-- table -->
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col">#ID</th>
            <th scope="col">Name</th>
            <th scope="col">Options</th>
          </tr>
        </thead>
        <tbody>
          <?php
            foreach ($verifiedPharmacy as $key => $value) {
              $id = $value['ID'];
              $name = $value['NAME'];
              ?>
              <tr>
                <th scope="row"><?php echo $id; ?></th>
                <td ><?php echo "$name"; ?></td >
                <td ><a class="btn btn-primary text-center w-100" href="<?php echo base_url(); ?>/admin/pharmacy/<?php echo $id; ?>">View</a></td >
              </tr>
              <?php
            }
           ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
<script src="<?php echo base_url(); ?>/assets/js/admin.js" charset="utf-8"></script>
