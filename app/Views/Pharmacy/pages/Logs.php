<?php
$db = \Config\Database::connect();
$pharmacist_id = session()->get('id');
 ?>
      <div class="col-lg-10 p-0" style="height:90vh; overflow-x:hidden;">
        <div class="border w-100" style="">
          <p class="m-0 mt-2 mb-3 fw-bold fs-3 ps-3" style="">
            Pharmacy Activity Logs
          </p>
          <div class="" style=" border-bottom-width: 2px; border-bottom-style: solid; border-bottom-color:#1d9feb;">
          </div>

          <div class="p-3">
            <?php foreach ($logs as $key => $value) {
              $id = $value['ID'];
              $desc = $value['DESC'];
              $createdAt = new DateTime($value['CREATED_AT']);
              $pharmacist = $value['PHARMACIST_DATA'];
              ?>
              <div class="border border-secondary p-3 mb-3 rounded">
                <p><span class="fw-bold"><?php echo $createdAt->format("M d, Y h:i A"); ?></span></p>
                <p><?php echo "{$pharmacist['FIRST_NAME']} {$pharmacist['LAST_NAME']}"; ?></p>
                <p>Description:</p>
                <p class="p-3"><?php echo "$desc"; ?></p>
              </div>
              <?php
            } ?>

          </div>
        </div>
      </div>
