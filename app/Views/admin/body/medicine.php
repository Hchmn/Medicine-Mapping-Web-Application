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
    <!-- Content -->
    <div class="col">
      <?php if(!empty($addStatus)){
        ?>
        <div class="pt-2">
          <p class="m-0 text-success"><i class="fas fa-check-circle"></i> <?php echo "$addStatus"; ?></p>
        </div>
        <?php
      } ?>

      <div class="pt-3 pb-3 pe-3 d-flex justify-content-between">
        <button type="button" name="button" class="btn btn-primary" style="width:10%;" data-bs-toggle="modal" data-bs-target="#addMedicine">Add</button>
        <div class="">
          <input type="text" name="" value="" class="form-control" placeholder="Search" id="searchMedicine">
        </div>
      </div>

      <!-- table -->
      <table class="table table-striped table-hover" id="medicineTable">
        <thead>
          <tr>
            <th scope="col">#ID</th>
            <th scope="col">Generic Names</th>
            <th scope="col">Brand Name</th>
            <th scope="col">Classifications</th>
            <th scope="col">Dosage</th>
            <th scope="col">Form</th>
            <th scope="col">Category</th>
            <th scope="col">Options</th>
          </tr>
        </thead>
        <tbody id="tableBody">
          <?php
            // print_r($medicines);
            foreach ($medicines as $key => $medicine) {
              $id = $medicine['id'];
              $brandName = $medicine['brandName'];
              $dosage = $medicine['dosage'];
              $form = $medicine['form'];
              $category = $medicine['category'];
              $genericNames =  $medicine['genericNames'];
              $classification = $medicine['medicineClassification'];
              $medGenericNames = "";
              $medClassification = "";
              if(!empty($genericNames)){
                foreach ($genericNames as $key => $genericName) {
                  $medGenericNames = $medGenericNames.$genericName['name'];
                }
              }
              if(!empty($classification)){
                foreach ($classification as $key => $value) {
                  $medClassification = $medClassification.$value["drugClassificationName"].", ";
                }
              }
              ?>
              <tr>
                <th scope="row"><?php echo $id; ?></th>
                <td class="genericNames" id="<?php echo "$medGenericNames";?>"><?php echo "$medGenericNames";?></td >
                <td class="brandNames"><?php echo "$brandName"; ?></td >
                <td class="classifications"><?php echo "$medClassification";?></td >
                <td class="dosages"><?php echo "$dosage"; ?></td >
                <td class="forms"><?php echo "$form"; ?></td >
                <td class="categories"><?php echo "$category"; ?></td >
                <td ><a href="<?php echo base_url(); ?>/admin/medicine/<?php echo "$id"; ?>" class="btn btn-primary text-center w-100">
                  <i class="far fa-edit"></i> Edit</a>
                </td >
              </tr>
              <?php
            }
           ?>

        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="addMedicine" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel">Add Medicine</h5>
          <button type="button" class="btn-close modalClose" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

          <!-- Modal body -->
          <div class="modal-body">
            <form class="" action="" method="" id="addMedicineForm">
                <!-- brand name -->
                <div class="mb-3 row">
                  <label for="" class="col-sm-3 col-form-label">Brand Name</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="brandName" name="brandName" value="" required>
                  </div>
                </div>
                <!-- dosage -->
                <div class="mb-3 row">
                  <label for="" class="col-sm-3 col-form-label">Dosage</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="dosage" name="dosage" value="" >
                  </div>
                </div>
                <!-- form -->
                <div class="mb-3 row">
                  <label for="" class="col-sm-3 col-form-label">Form</label>
                  <div class="col-sm-9" id="medicineFormContainer">
                    <select class="form-select" name="form" required>
                      <option value="">None</option>
                      <?php
                      foreach ($allForms as $key => $value) {
                        $id = $value['ID'];
                        $name = $value['NAME'];
                        ?>
                        <option value="<?php echo "$id"; ?>"><?php echo "$name"; ?></option>
                        <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <!-- generic names -->
                <div class="mb-3 row">
                  <label for="" class="col-sm-3 col-form-label">Generic Names</label>
                  <select class="form-select d-none" name="genericNames[]" id="defGenericName">
                    <option value="">None</option>
                    <?php
                    foreach ($allGenericNames as $key => $value) {
                      $id = $value['ID'];
                      $name = $value['NAME'];
                      ?>
                      <option value="<?php echo $id; ?>"><?php echo "$name"; ?></option>
                      <?php
                    }
                     ?>
                  </select>
                  <div class="col-sm-9" id="">
                    <div id="genericNamesContainer">

                          <select class="form-select genericName mb-3" name="genericNames[]" required>
                            <option value="">None</option>
                            <?php
                            foreach ($allGenericNames as $key => $value) {
                              $id = $value['ID'];
                              $name = $value['NAME'];
                              ?>
                              <option value="<?php echo $id; ?>"><?php echo "$name"; ?></option>
                              <?php
                            }
                             ?>
                          </select>

                    </div>
                     <button type="button" name="button" class="btn btn-outline-secondary w-100" id="addGenericNames">
                       <i class="fas fa-plus"></i>
                     </button>
                  </div>
                </div>
                <!-- classification -->
                <div class="mb-3 row">
                  <label for="" class="col-sm-3 col-form-label">Classification</label>
                  <select class="form-select classification d-none" name="classification[]" id="defClassification">
                    <option value="">None</option>
                    <?php
                      foreach ($allDrugClassification as $key => $value) {
                        $id = $value['ID'];
                        $name = $value['NAME'];
                        ?>
                        <option value="<?php echo $id; ?>"><?php echo "$name"; ?></option>
                        <?php
                      }
                     ?>
                  </select>
                  <div class="col-sm-9" id="">
                    <div class="" id="medicineClassificationContainer">
                          <select class="form-select mb-3" name="classification[]" class="classification" required>
                            <option value="">None</option>
                            <?php
                              foreach ($allDrugClassification as $key => $value) {
                                $id = $value['ID'];
                                $name = $value['NAME'];
                                ?>
                                <option value="<?php echo $id; ?>"><?php echo "$name"; ?></option>
                                <?php
                              }
                             ?>
                          </select>
                    </div>
                    <button type="button" name="button" class="btn btn-outline-secondary w-100" id="addClassification">
                      <i class="fas fa-plus"></i>
                    </button>
                  </div>
                </div>
                <!-- Category -->
                <div class="mb-3 row">
                  <label for="" class="col-sm-3 col-form-label">Category</label>
                  <div class="col-sm-9 d-flex flex-row align-items-center">
                    <div class="form-check col-sm-3">
                      <input class="form-check-input" type="radio" name="category" id="Rx" value="1" required>
                      <label class="form-check-label" for="flexRadioDefault1">
                        Rx
                      </label>
                    </div>
                    <div class="form-check col-sm-3">
                      <input class="form-check-input" type="radio" name="category" id="Non-Rx" value="0" required>
                      <label class="form-check-label" for="flexRadioDefault1">
                        Non-Rx
                      </label>
                    </div>

                  </div>
                </div>
                <!-- usage -->
                <div class="mb-3 row">
                  <label for="" class="col-sm-3 col-form-label">Usage</label>
                  <div class="col-sm-9">
                    <textarea class="form-control" id="floatingTextarea" name="usage"></textarea>
                  </div>
                </div>
          </div>
          <!-- Modal footter -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary modalClose" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
          </form>
      </div>
    </div>
  </div>
</body>
<script src="<?php echo base_url(); ?>/assets/js/admin.js" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>/assets/js/adminMedicineExt.js?v=1" charset="utf-8"></script>
