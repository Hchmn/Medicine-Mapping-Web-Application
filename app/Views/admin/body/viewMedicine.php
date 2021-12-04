<body class="h-100">
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
        <a href="<?php echo base_url(); ?>/admin/medicine" class="btn btn-outline-secondary w-100 d-flex align-items-center active" style="height:55px;">
          Medicine
        </a>
      </div>
      <div class="border mb-2">
        <a href="<?php echo base_url(); ?>/admin/medicine/form" class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-between" style="height:55px;">
          Medicine Form
        </a>
      </div>
      <div class="border mb-2">
        <a href="<?php echo base_url(); ?>/admin/medicine/drug_classification" class="btn btn-outline-secondary w-100 d-flex align-items-center  justify-content-between" style="height:55px;">
          Drug classification
        </a>
      </div>
      <div class="border mb-2">
        <a href="#" class="btn btn-outline-secondary w-100 d-flex align-items-center  justify-content-between" style="height:55px;">
          General classification <i class="fas fa-exclamation-triangle"></i>
        </a>
      </div>
      <hr>
      <div class="border mb-2">
        <a href="<?php echo base_url(); ?>/admin/pharmacy" class="btn btn-outline-secondary w-100 d-flex align-items-center " style="height:55px;">
          Pharmacy
        </a>
      </div>
      <div class="border">
        <a href="<?php echo base_url(); ?>/admin/log" class="btn btn-outline-secondary w-100 d-flex align-items-center" style="height:55px;">
          Activity log
        </a>
      </div>
    </div>
    <div class="col-3 d-none " id="tempSpace"></div>
    <div class="col p-3">
      <!-- Info -->
      <div class="mb-5">
        <p class="h3 m-0"><?php echo $info['brandName']; ?></p>
        <span class="small p-0">ID#: <?php echo $info['id']; ?></span>
        <p class="m-0">Dosage: <?php echo $info['dosage']; ?></p>
        <p class="m-0">Form: <?php echo $info['form']; ?></p>
        <p class="m-0">Category: <?php echo $info['category']; ?></p>
        <p>Generic Names:</p>
        <ul>
          <?php
            foreach ($info['genericNames'] as $key => $value) {
              ?>
              <li><?php echo $value['name']; ?></li>
              <?php
            }
           ?>
        </ul>
        <p>Classification</p>
        <ul>
          <?php
            foreach ($info['classification'] as $key => $value) {
              ?>
              <li><?php echo $value['drugClassName']; ?> (<?php echo $value['genClassName']; ?>)</li>
              <?php
            }
           ?>

        </ul>
        <p>Usage:</p>
        <div class="ps-3">
          <p><?php echo $info['usage']; ?></p>
        </div>
      </div>
      <hr>
      <!-- Update -->
      <div class="">
        <p class="h4">Update</p>
        <?php if(!empty($updateStatus)){
          ?>
             <div class="text-left">
                <p class="text-success"><i class="fas fa-check-circle"></i> Update Done</p>
             </div>
          <?php
        }
        ?>
        <form class="" action="" method="" id="updateMedicine">
          <input type="hidden" name="id" value="<?php echo $info['id']; ?>">
          <!-- brand name -->
          <div class="mb-3 row">
            <label for="" class="col-sm-2 col-form-label">Brand Name</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="brandName" name="brandName" value="<?php echo $info['brandName']; ?>">
            </div>
          </div>
          <!-- dosage -->
          <div class="mb-3 row">
            <label for="" class="col-sm-2 col-form-label">Dosage</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="dosage" name="dosage" value="<?php echo ($info['dosage'] == "None")? "":$info['dosage']; ?>">
            </div>
          </div>
          <!-- form -->
          <div class="mb-3 row">
            <label for="" class="col-sm-2 col-form-label">Form</label>
            <div class="col-sm-9" id="medicineFormContainer">
              <select class="form-select" name="form">
                <?php
                  foreach ($allForms as $key => $value) {
                    if(strcmp($info['form'], $value['NAME']) === 0){
                      ?>
                      <option value="<?php echo $value['ID']; ?>" selected><?php echo $value['NAME']; ?></option>
                      <?php
                    }else{
                      ?>
                      <option value="<?php echo $value['ID']; ?>"><?php echo $value['NAME']; ?></option>
                      <?php
                    }
                  }
                 ?>
              </select>
            </div>
          </div>
          <!-- generic names -->
          <div class="mb-3 row">
            <label for="" class="col-sm-2 col-form-label">Generic Names</label>
            <select class="form-select d-none" name="genericNames[]" id="defGenericName">
              <option selected>None</option>
              <?php
                foreach ($allGenericNames as $key => $v) {
                    ?>
                    <option value="<?php echo $v['ID']; ?>"><?php echo $v['NAME']; ?></option>
                    <?php
                }
               ?>
            </select>
            <div class="col-sm-9" id="">
              <div id="genericNamesContainer">
                <?php
                $i = 0;
                  foreach ($info['genericNames'] as $key => $value) {
                    ?>
                    <select class="form-select genericName mb-3" name="genericNames[]" id="genericName<?php echo "$i"; ?>">
                      <option value="None">None</option>
                      <?php
                        foreach ($allGenericNames as $key => $v) {
                          if(strcmp($value['name'], $v['NAME']) === 0){
                            ?>
                            <option value="<?php echo $v['ID']; ?>" selected><?php echo $v['NAME']; ?></option>
                            <?php
                          }else{
                            ?>
                            <option value="<?php echo $v['ID']; ?>"><?php echo $v['NAME']; ?></option>
                            <?php
                          }
                        }
                       ?>
                    </select>
                    <?php
                    $i++;
                  }
                 ?>
              </div>
               <button type="button" name="button" class="btn btn-secondary" id="addGenericNames">Add</button>
            </div>
          </div>
          <!-- classification -->
          <div class="mb-3 row">
            <label for="" class="col-sm-2 col-form-label">Classification</label>
            <select class="form-select classification d-none" name="classification[]" id="defClassification">
              <option selected value="None">None</option>
              <?php
                foreach ($allDrugClassification as $key => $v) {
                    ?>
                    <option value="<?php echo $v['ID']; ?>"><?php echo $v['NAME']; ?></option>
                    <?php
                }
               ?>
            </select>
            <div class="col-sm-9" id="">
              <div class="" id="medicineClassificationContainer">
                <?php
                  foreach ($info['classification'] as $key => $value) {
                    ?>
                    <select class="form-select mb-3" name="classification[]" class="classification">
                      <option value="None">None</option>
                      <?php
                        foreach ($allDrugClassification as $key => $v) {
                          if($value['drugClassId']  === $v['ID']){
                            ?>
                            <option value="<?php echo $v['ID']; ?>" selected><?php echo $v['NAME']; ?></option>
                            <?php
                          }else{
                            ?>
                            <option value="<?php echo $v['ID']; ?>"><?php echo $v['NAME']; ?></option>
                            <?php
                          }
                        }
                       ?>
                    </select>
                    <?php
                  }
                 ?>
              </div>
              <button type="button" name="button" class="btn btn-secondary mt-3" id="addClassification">Add</button>
            </div>
          </div>
          <!-- Category -->
          <div class="mb-3 row">
            <label for="" class="col-sm-2 col-form-label">Category</label>
            <div class="col-sm-9 d-flex flex-row">
              <div class="form-check col-2">
                <input class="form-check-input" type="radio" name="category" id="Rx" value="1" <?php echo (strcmp($info['category'],"Rx") === 0)? "checked":""; ?>
                <label class="form-check-label" for="flexRadioDefault1">
                  Rx
                </label>
              </div>
              <div class="form-check col-2">
                <input class="form-check-input" type="radio" name="category" id="Non-Rx" value="0" <?php echo (strcmp($info['category'],"Non-Rx") === 0)? "checked":""; ?>>
                <label class="form-check-label" for="flexRadioDefault1">
                  Non-Rx
                </label>
              </div>

            </div>
          </div>
          <!-- usage -->
          <div class="mb-3 row">
            <label for="" class="col-sm-2 col-form-label">Usage</label>
            <div class="col-sm-9">
              <textarea class="form-control" id="floatingTextarea" name="usage"><?php echo $info['usage']; ?></textarea>
            </div>
          </div>
          <!-- submit button -->
          <div class="mb-3 d-flex flex-row">
            <span class="col-sm-10"></span>
            <button type="submit" name="button" class="btn btn-primary col-sm-1">Update</button>
          </div>

        </form>
      </div>
      <hr>
      <!-- Delete -->
      <div class="mb-5">
        <p class="h4">Delete</p>
        <form class="" action="" method="">
          <input type="hidden" name="id" value="<?php echo $info['id']; ?>">
          <div class="mb-3">
            <label class="">Enter <span class="text-danger fw-bold h5"><?php echo $info['brandName']; ?></span> to remove in the database.</label>
            <input type="text" name="brandName" value="" class="form-control w-25" required>
          </div>
          <div class="mb-3 d-flex flex-row">
            <span class="col-sm-10"></span>
            <button type="submit" name="button" class="btn btn-danger col-sm-1">Delete</button>
          </div>
        </form>
      </div>
      <div class="" style="height:100px;">
      </div>
    </div>
  </div>
</body>
<script src="<?php echo base_url(); ?>/assets/js/admin.js" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>/assets/js/adminMedicine.js" charset="utf-8"></script>
