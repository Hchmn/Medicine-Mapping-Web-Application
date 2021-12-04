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
        <a href="<?php echo base_url(); ?>/admin/pharmacy" class="btn btn-outline-secondary w-100 d-flex align-items-center <?php echo ($pharmacy['IS_VERIFIED'] == 1)? "active":""; ?>" style="height:55px;">
          Pharmacy
        </a>
      </div>
      <div class="border mb-2">
        <a href="<?php echo base_url(); ?>/admin/pharmacy/to_verify" class="btn btn-outline-secondary w-100 d-flex align-items-center <?php echo ($pharmacy['IS_VERIFIED'] == 1)? "":"active"; ?>" style="height:55px;">
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
    <div class="col">
      <div class="p-3 flex-column">
        <p class="h2 m-0"><?php echo $pharmacy['NAME']; ?></p>
        <div class="d-flex align-items-center">
          <?php
            if($pharmacy['IS_VERIFIED'] == 1){
              ?>
                <div class="bg-success rounded-circle me-1" style="width:10px; height:10px;"></div><small>Verified</small>
              <?php
            }else{
              ?>
                <div class="bg-warning rounded-circle me-1" style="width:10px; height:10px;"></div><small>Not Verified</small>
              <?php
            }
           ?>
        </div>
      </div>
      <!-- Pharmacy Information -->
      <div class="p-3">
        <p>Address: <?php echo $pharmacy['ADDRESS']; ?></p>
        <p>Geocoordinates: (<?php echo $pharmacy['LAT']; ?>, <?php echo $pharmacy['LNG']; ?>)</p>
        <p>Contact Details:</p>
        <ul>
          <?php
            foreach ($contactInfo as $key => $value) {
              $type = '';
              if($value['TYPE'] == 1){
                $type = 'Email';
              }else if($value['TYPE'] == 2){
                $type = 'Mobile';
              }else if($value['TYPE'] == 3){
                $type = 'Telephone';
              }
              ?>
              <li><?php echo $type; ?>: <?php echo $value['DETAIL']; ?></li>
              <?php
            }
           ?>

        </ul>
      </div>
      <hr>
      <!-- Pharmacist -->
      <div class="ps-3">
        <p class="h3">Pharmacist</p>
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th scope="col">#ID</th>
              <th scope="col">First Name</th>
              <th scope="col">Last Name</th>
              <th scope="col">Address</th>
              <th scope="col">Contact Info</th>
              <th scope="col">Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
              foreach ($pharmacist as $key => $value) {
                $id = $value['ID'];
                $fn = $value['FIRST_NAME'];
                $ln = $value['LAST_NAME'];
                $address = $value['ADDRESS'];
                $isActive = $value['IS_ACTIVE'];
                $contactInfo = $value['CONTACT_INFO'];
                ?>
                <tr>
                  <td scope="col"><?php echo "$id"; ?></td>
                  <td scope="col"><?php echo "$fn"; ?></td>
                  <td scope="col"><?php echo "$ln"; ?></td>
                  <td scope="col"><?php echo "$address"; ?></td>
                  <td scope="col">
                    <?php
                    foreach ($contactInfo as $key => $value) {
                      $type = '';
                      if($value['TYPE'] == 1){
                        $type = 'Email';
                      }else if($value['TYPE'] == 2){
                        $type = 'Mobile';
                      }else if($value['TYPE'] == 3){
                        $type = 'Telephone';
                      }
                      ?>
                      <p class="m-0"><?php echo $type; ?>: <?php echo $value['DETAIL']; ?></p>
                      <?php
                    }
                     ?>
                  </td>
                  <td scope="col">
                    <div class="d-flex align-items-center">
                      <?php
                      if ($isActive == 1) {
                        ?>
                        <div class="bg-success rounded-circle me-1" style="width:10px; height:10px;"></div><small>Active</small>
                        <?php
                      }else{
                        ?>
                        <div class="bg-secondary rounded-circle me-1" style="width:10px; height:10px;"></div><small>In Active</small>
                        <?php
                      }
                       ?>
                    </div>
                  </td>
                </tr>
                <?php
              }
             ?>

          </tbody>
        </table>
      </div>
      <hr>
      <!-- doc files -->
      <div class="ps-3">
        <p class="h3">Documents</p>
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th scope="col">#ID</th>
              <th scope="col" class="w-75">FILE</th>
              <th scope="col">Download</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $documentCounter = 1;
            foreach ($documents as $key => $value) {
              $id = $value['ID'];
              $path = $value['INTERNAL_PATH'];
              $splitPath = explode("/",$path);
              $fileName = $splitPath[count($splitPath) - 1];
              ?>
              <tr>
                <td scope="col"><?php echo $documentCounter; ?></td>
                <td scope="col"><?php echo "$fileName"; ?></td>
                <td scope="col">
                  <div class="d-flex align-items-center">
                    <a href="<?php echo "$path"; ?>" target="_blank"><i class="fas fa-download" ></i> <small>Download</small></a>
                  </div>
                </td>
              </tr>
              <?php
              $documentCounter += 1;
            }
             ?>

          </tbody>
        </table>
      </div>
      <!-- verify button -->
      <?php
        if($pharmacy['IS_VERIFIED'] == 0){
       ?>
      <div class="ps-3 mb-5 ">
        <form class="d-flex justify-content-center" action="" method="" id="verifyPharmacy">
          <input type="hidden" name="pharmacyId" value="<?php echo $pharmacy['ID']; ?>">
          <button type="submit" name="button" class="btn btn-primary w-25">Verify</button>
        </form>
      </div>
    <?php
      }
      ?>
    </div>
  </div>
</body>
<script src="<?php echo base_url(); ?>/assets/js/admin.js?v=1" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>/assets/js/adminPharmacy.js?v=3" charset="utf-8"></script>
