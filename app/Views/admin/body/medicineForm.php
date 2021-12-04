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
        <a href="<?php echo base_url(); ?>/admin/medicine" class="btn btn-outline-secondary w-100 d-flex align-items-center" style="height:55px;">
          Medicine
        </a>
      </div>
      <div class="border mb-2">
        <a href="<?php echo base_url(); ?>/admin/medicine/form" class="active btn btn-outline-secondary w-100 d-flex align-items-center justify-content-between" style="height:55px;">
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
      <?php if(!empty($status)){
        ?>
        <div class="pt-2">
          <p class="m-0 text-success"><i class="fas fa-check-circle"></i> <?php echo "$status"; ?></p>
        </div>
        <?php
      } ?>

      <div class="pt-3 pb-3 pe-3 d-flex justify-content-between">
        <button type="button" name="button" class="btn btn-primary" style="width:10%;" data-bs-toggle="modal" data-bs-target="#addForm">Add</button>
        <div class="">
          <input type="text" name="" value="" class="form-control" placeholder="Search" id="searchForm">
        </div>
      </div>

      <!-- table -->
      <table class="table table-striped table-hover" id="medicineFormTable">
        <thead>
          <tr>
            <th scope="col" class="col-sm-1">#ID</th>
            <th scope="col">Name</th>
          </tr>
        </thead>
        <tbody id="tableBody">
          <?php
          foreach ($forms as $key => $value) {
            $id = $value['ID'];
            $name = $value['NAME'];
            ?>
            <tr>
              <td scope="row"><?php echo "$id"; ?></td>
              <td scope=""><?php echo "$name"; ?></td>
            </tr>
            <?php
          }
           ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="addForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel">Medicine Form</h5>
          <button type="button" class="btn-close modalClose" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

          <!-- Modal body -->
          <div class="modal-body">
            <form class="" action="" method="" id="addMedicineForm">
                <!-- brand name -->
                <div class="mb-3 row">
                  <label for="" class="col-sm-3 col-form-label">Name</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="name" name="name" value="" required>
                  </div>
                </div>
          </div>
          <!-- Modal footter -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary modalClose" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
          </form>
      </div>
    </div>
  </div>
</body>
<script src="<?php echo base_url(); ?>/assets/js/admin.js" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>/assets/js/adminMedicineForm.js" charset="utf-8"></script>
