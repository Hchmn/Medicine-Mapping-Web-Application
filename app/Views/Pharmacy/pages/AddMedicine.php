<?php
$db = \Config\Database::connect();
$pharmacist_id = session()->get('id');
$pharmacy_id = session()->get('pharmacy_id');
 ?>
 <style media="screen">
 #filterContainer {
    opacity: 1;
    transition: opacity 1s;
    display:  flex;
  }
  #filterContainer.hide {
    opacity: 0;
    display: none;
  }
 </style>
      <div id="filterContainer" class="col-lg-2 flex-column h-100 p-0 pt-4 hide" style="">
        <!-- Filter -->
        <div class="medicine container h-100 w-100 mt-0 mb-2" style="">
          <p class="fw-bold fs-4" style="">
            Filter Medicine
          </p>
          <form class="" id="filterForm" style="">
            <div class="" style="height: 75vh;overflow-x:hidden;">
              <!-- General Classification -->
              <div class="mb-3">
                <p class="fw-bold">General Categories</p>
                <?php
                foreach ($generalClassifications as $key => $value) {
                  $id = $value['ID'];
                  $name = $value['NAME'];
                  ?>
                  <div class="form-check ms-2">
                    <input class="form-check-input" name="generalClassification[]" type="checkbox" value="<?php echo "$id"; ?>" id="generalClassification<?php echo "$id"; ?>">
                    <label class="form-check-label" for="generalClassification<?php echo "$id"; ?>">
                      <?php echo "$name"; ?>
                    </label>
                  </div>
                  <?php
                }
                 ?>
              </div>
              <!-- Form -->
              <div class="mb-3">
                <p class="fw-bold">Form</p>
                <?php foreach ($medicineForms as $key => $value) {
                  $id = $value['ID'];
                  $name = $value['NAME'];
                  ?>
                  <div class="form-check ms-2">
                    <input class="form-check-input" name="medicineForm[]" type="checkbox" value="<?php echo "$id"; ?>" id="medicineForm<?php echo "$id"; ?>">
                    <label class="form-check-label" for="medicineForm<?php echo "$id"; ?>">
                      <?php echo "$name"; ?>
                    </label>
                  </div>
                  <?php
                } ?>
              </div>
              <!-- Category -->
              <div class="mb-3">
                <p class="fw-bold">Category</p>
                <div class="form-check ms-2">
                  <input class="form-check-input" type="radio" name="filterCategory" value="1" id="Rx">
                  <label class="form-check-label" for="Rx">
                    Rx
                  </label>
                </div>
                <div class="form-check ms-2">
                  <input class="form-check-input" type="radio" name="filterCategory" value="0" id="Non-Rx">
                  <label class="form-check-label" for="Non-Rx">
                    Non-Rx
                  </label>
                </div>
              </div>
              <!-- Sort -->
              <div class="mb-3">
                <p class="fw-bold">Sort Brand Name</p>
                <div class="form-check ms-2">
                  <input class="form-check-input" type="radio" name="filterSort" id="ASC" value="ASC" checked>
                  <label class="form-check-label" for="ASC">
                    A-Z
                  </label>
                </div>
                <div class="form-check ms-2">
                  <input class="form-check-input" type="radio" name="filterSort" id="DESC" value="DESC">
                  <label class="form-check-label" for="DESC">
                    Z-A
                  </label>
                </div>
              </div>
            </div>
            <div class="p-3">
              <button type="submit" name="button" class="btn btn-primary w-100">Submit</button>
            </div>
          </form>
        </div>
      </div>
      <div id="medicineContainer" class="col-lg-10 flex-column d-flex w-100 mt-4" style="">
          <!-- search -->
          <div class="searchbar mb-2 mt-2 d-flex justify-content-between align-items-center">
            <button type="button" name="button" class="btn btn-primary" id="filterBtn">
              <i class="far fa-eye " id="showIcon"></i>
              Filter
            </button>
            <?php if(session()->get('addmed')){ ?>
                <p class="m-0 text-success">Add successfully</p>
            <?php }else{
              ?>
              <p class="m-0"></p>
              <?php
            } ?>
            <input class="form-control rounded-pill border border-primary" type="text" id="searchMedicine" placeholder="Search.." style="width:250px;">
          </div>
          <div class="w-100" style="height:75vh; overflow-x: hidden;">
            <table id ="" class="table table-striped w-100" style="">
               <thead class="" style="" >
                 <tr id="tHead">
                   <th scope="col" class="col-1">#</th>
                   <th scope="col" class="">Generic Name</th>
                   <th scope="col">Classification</th>
                   <th scope="col" class="">Brand Name</th>
                   <th scope="col" class="d-xl-table-cell d-none">Dosage</th>
                   <th scope="col" class="d-xl-table-cell d-none">Form</th>
                   <th scope="col" class="d-xl-table-cell d-none">Category</th>
                   <th scope="col" class=""></th>
                 </tr>
               </thead>
               <tbody id="tableBody">
                 <?php
                  foreach ($allMedicine as $key => $value) {
                    // code...
                    $medicine_id = $value['ID'];
                    $brand_name = $value['BRAND_NAME'];
                    $dosage = (empty($value['DOSAGE']))? "NONE":$value['DOSAGE'];
                    $category = ($value['CATEGORY'] == 1)? "Rx":"Non-Rx";
                    $generic_name = "";
                    $form_name = $value['FORM']['NAME'];
                    $medicine_usage = $value['USAGE'];
                    $classification = "";
                    // append all generic names
                    foreach ($value['GENERIC_NAMES'] as $key => $g) {
                      $name = $g['NAME'];
                      $generic_name .= $name . " ";
                    }
                    // append all classification
                    foreach ($value['CLASSIFICATION'] as $key => $c) {
                      $name = $c['NAME'];
                      $classification .= $name." ";
                    }
                  ?>

                 <tr>
                     <td scope="row"> <?php echo "$medicine_id"; ?></td>
                     <td> <?php echo "$generic_name"; ?></td>
                     <td> <?php echo "$classification"; ?></td>
                     <td> <?php echo "$brand_name"; ?></td>
                     <td class="d-xl-table-cell d-none"> <?php echo "$dosage"; ?></td>
                     <td class="d-xl-table-cell d-none"> <?php echo "$form_name";?></td>
                     <td class="d-xl-table-cell d-none"><?php echo "$category"; ?></td>
                     <td><button class="btn <?php echo ($value['IS_EXIST'])? "btn-secondary":"btn-primary"; ?>" data-toggle="modal"
                       type="button"
                       data-target="#update_modals<?php echo $medicine_id;?>"
                       style="width:70px;"
                       <?php echo ($value['IS_EXIST'])? "disabled":""; ?>
                       >
                       <span class="glyphicon glyphicon-edit"></span>Add</button>
                     </td>

                 </tr>

                 <div class="modal fade" id="update_modals<?php echo $medicine_id; ?>" aria-hidden="true">
                     <div class="modal-dialog">
                       <div class="modal-content">
                         <form method="POST" action="AddMedicine/add_medicine">
                           <div class="modal-header" style="justify-content: center; font-weight:bolder;">
                             <h3 class="modal-title" style="">Medicine Information</h3>
                           </div>
                           <div class="modal-body">
                             <div class="col-md-2"></div>
                             <div class="col-md-12 ">
                               <div class="form-group" >

                                 <div class="">
                                   <p style="margin-top:0px;">Generic Name: <?php echo "$generic_name"; ?></p>
                                   <p>Brand Name: <?php echo "$brand_name"; ?></p>
                                   <p>Dosage: <?php echo "$dosage"; ?></p>
                                   <p>Form: <?php echo "$form_name"; ?></p>
                                   <p style="text-align:justify;"> Usage: <?php echo "$medicine_usage"; ?></p>
                                 </div>

                                 <div class="mt-4 " style="float:right;">
                                   <input type="hidden" name="medicine_id" value="<?php echo "$medicine_id"; ?>">
                                   <input type="hidden" name="pharmacy_id" value="<?php echo "$pharmacy_id"; ?>">
                                   <input type="hidden" name="pharmacist_id" value="<?php echo "$pharmacist_id";?>">
                                   <input type="text " name="medicine_price" placeholder="Enter the medicine price" class="form-control mt-1 mb-2 rounded" required="required" />
                                 </div>
                               </div>
                             </div>
                           </div>
                           <div style="clear:both;"></div>
                             <div class="modal-footer">
                               <button name="update" class="btn rounded border border-primary "><span class="glyphicon glyphicon-edit"></span>Add</button>
                               <button class="btn rounded border border-danger" type="button"  data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
                             </div>
                           </div>
                         </form>
                       </div>
                   </div>
                 <?php
                  }
                 ?>
               </tbody>
            </table>

          </div>
      </div>
<script>

// event listener for filter form
$('#filterForm').submit(function(e){
  e.preventDefault(); // prevent window to reload when submit
  var formData = $(this).serialize(); // get data in form

  var baseUrl = window.location.origin;
  var apiPath = "/addmedicine/filter";
  var url = baseUrl+apiPath;

  $.ajax({
    type: 'post', // request method
    url: url,
    data: formData,
    success: function(data){
      // un-comment the line below to see the returned data from the request
      // console.log(data);
      window.location.reload(); // reload the page when success
    },
    error: function(xhr, textStatus, errorMessage){
      // display error status code
      console.log(xhr.status);
    }
  });
});

// event listener when filter btn being click
$('#filterBtn').on('click', function(){
  /**
    this function will hide() and show() filter section
    and adjust dimension of the medicine section
  */
  if($("#filterContainer").hasClass('hide')){
    $("#medicineContainer").removeClass('col-lg-10');
    $("#medicineContainer").addClass('col-lg-8');

    $("#showIcon").removeClass("fa-eye");
    $("#showIcon").addClass("fa-eye-slash");

    $("#filterContainer").removeClass('hide');
  }else{
    $("#medicineContainer").addClass('col-lg-10');
    $("#medicineContainer").removeClass('col-lg-8');

    $("#showIcon").addClass("fa-eye");
    $("#showIcon").removeClass("fa-eye-slash");

    $("#filterContainer").addClass('hide');
  }

});

// search
$('#searchMedicine').on('keyup', function(){
  var value = $(this).val().toLowerCase();
  $("#tableBody tr").filter(function() {
    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
  });
});

</script>
