<?php
$db = \Config\Database::connect();
$pharmacist_id = session()->get('id');
$pharmacy_id = session()->get('pharmacy_id');
 ?>
      <!-- Trend -->
      <div id="trend" class="col-xl-2 col-3 d-xl-block d-none w-100 mt-4 ms-1"style="">
        <div class="medicine container w-100 mt-3 mb-3" style="" >
          <p class="mt-2" style="color:black; font-size:160%; text-align:center; font-family:Helvetica; font-weight:bold;">
            <small >Top 10 Searched Medicine <?php echo ""; ?></small>
          </p>

          <div class="">
            <ol>
              <?php
              foreach ($medicineTrend as $key => $value) {
                $medicineName = $value['MEDICINE_NAME'];
                ?>
                <li class="text-wrap text-break"><?php echo "$medicineName"; ?></li>
                <?php
              } ?>
            </ol>
          </div>

        </div>

      </div>

      <div id="inventory" class="border col-xl-8 col-10 flex-column d-flex w-100 mt-4" style="">
        <!-- search -->
        <div class="searchbar mb-2 mt-2 d-flex justify-content-between align-items-center">
          <div class="d-xl-none">
            <button id="trendMedbtn" type="button" class="btn btn-primary" name="button">Top Search Medicine</button>
          </div>
          <?php if(session()->get('updatemed')){ ?>
              <p class="m-0 text-success">Update successfully</p>
          <?php }else{
            ?>
            <p class="m-0"></p>
            <?php
          } ?>
          <input class="form-control rounded-pill border border-primary" type="text" id="searchMedicine" placeholder="Search.." style="width:250px;">
        </div>
        <!-- table -->

        <div class="w-100" style="height:80vh; overflow-x: hidden;">
          <table id ="myTable" class="table table-striped" style="width: 100%; font-size:90%;">
             <thead class="header" style="">
               <tr>
                 <th>Generic Name</th>
                 <th>Brand Name</th>
                 <th>Dosage</th>
                 <th>Form</th>
                 <th>Price</th>
                 <th>Availability</th>
                 <th>Action</th>
               </tr>
             </thead>
             <tbody id="tableBody">
                 <?php
                   $medicine_ID = "N/A";
                   $medicine_generic_name = "N/A";
                   $medicine_brand_name = "N/A";
                   $medicine_dosage = "N/A";
                   $medicine_form = "N/A";
                   $medicine_availability = "";

                   $get_medicine = $db->query("SELECT * FROM pharma_inventory WHERE PHARMACY_ID LIKE '$pharmacy_id'");

                   //query data in the pharma_inventory table to get the medicine_id in a certain pharmacy
                   foreach ($get_medicine->getResult() as $medicine) {
                      $pharma_ID = $medicine->ID; // inventory id?
                      $medicine_ID = $medicine->MEDICINE_ID;
                      $medicine_retail_price = $medicine->RETAIL_PRICE;
                      $medicine_availability = $medicine->IS_STOCK;
                      $medicines = $db->query("SELECT * FROM medicine WHERE ID LIKE '$medicine_ID'");

                      foreach ($medicines->getResult() as $medicine_value) {
                        $medicine_brand_name = $medicine_value->BRAND_NAME;
                        $medicine_dosage = (empty($medicine_value->DOSAGE))? "None" : $medicine_value->DOSAGE;
                        $form = $medicine_value->FORM;
                        //query in the medicine form to get the form Name
                        $medicine_forms = $db->query("SELECT * FROM medicine_form WHERE ID LIKE '$form'");
                        foreach ($medicine_forms->getResult() as $value) {
                          $medicine_form = $value->NAME;
                        }
                        $generic_names = $db->query("SELECT * FROM medicine_generic_name WHERE MEDICINE_ID LIKE '$medicine_ID'");
                        $generic_id = "";

                        foreach ($generic_names->getResult() as $generic) {
                          $generic_id = $generic->GENERIC_NAMES_ID;
                        }

                        //query to the Generic Names to get the generic name of the specific medicine
                        $get_generic = $db->query("SELECT * FROM generic_names WHERE ID LIKE '$generic_id'");

                        // $get_generic_result = $get_generic->getResult();
                        // $generic_name = $get_generic_result->NAME;
                        foreach ($get_generic->getResult() as $generic) {
                          $medicine_generic_name = $generic->NAME;
                        }
                      }
                  ?>
                   <tr>
                     <td> <?php echo "$medicine_generic_name"; ?></td>
                     <td> <?php echo "$medicine_brand_name"; ?></td>
                     <td> <?php echo "$medicine_dosage"; ?></td>
                     <td> <?php echo "$medicine_form";?></td>
                     <td> <?php echo "$medicine_retail_price "; ?></td>
                     <td class="">
                        <div class="form-check form-switch p-0 d-flex justify-content-center" style="min-height:35px; max-height: 50px;">
                          <input class="form-check-input m-0 w-100 h-100 medicineAvailability"
                          type="checkbox" id="<?php echo "$pharma_ID"; ?>"
                          <?php echo ($medicine_availability == 1)? "checked":""; ?>
                          >
                        </div>
                     </td>
                     <td><button class="btn btn-primary" data-toggle="modal" type="button" data-target="#update_modals<?php echo "$medicine_ID";?>" <span class="glyphicon glyphicon-edit"></span>Edit Price</button></td>
                   </tr>
                   <!-- Modal -->
                   <div class="modal fade" id="update_modals<?php echo "$medicine_ID";?>" aria-hidden="true">
                     <div class="modal-dialog">
                       <div class="modal-content">
                         <form method="POST" action="AddMedicine/update_price">
                           <div class="modal-header" style="justify-content: center; font-weight:bolder;">
                             <h3 class="modal-title" style="">Medicine Information</h3>
                           </div>
                           <div class="modal-body">
                             <div class="col-md-2"></div>
                             <div class="col-md-8">
                               <div class="form-group "  style="width:140%; height:120%;">
                                 <div class="">
                                   <div class="" style="text-align:justify;">
                                     <label for="">Brand Name: <?php echo "$medicine_brand_name"; ?></label>
                                     <br>
                                     <label for="">Dosage: <?php echo "$medicine_dosage"; ?></label>
                                     <br>
                                     <label for="">Form: <?php echo "$medicine_form"; ?></label>
                                     <br>
                                     <label for="">Generic Name: <?php echo "$medicine_generic_name"; ?></label>
                                     <br>

                                     <label style="">Retail Price: <?php echo "$medicine_retail_price"; ?></label>
                                   </div>
                                 </div>
                                  <div class="mb-3 row">
                                       <input type="hidden" name="medicine_id" value="<?php echo "$medicine_ID"; ?>">
                                       <input type="hidden" name="pharma_inventory_id" value="<?php echo "$pharma_ID"; ?>">
                                       <input type="hidden" name="pharmacy_id" value="<?php echo "$pharmacy_id"; ?>">
                                       <input type="hidden" name="pharmacist_id" value="<?php echo "$pharmacist_id"; ?>">

                                    <div class="col-sm-15 mt-2">
                                      <input type="text " name="new_medicine_price" value="" placeholder="Enter the new retail price of the medicine"class="form-control  border " required="required"  >
                                    </div>
                                  </div>
                              </div>
                           </div>
                           <div style="clear:both;"></div>
                             <div class="modal-footer">
                               <button type="submit"name="update" class="btn rounded border border-primary "><span class="glyphicon glyphicon-edit"></span> Update</button>
                               <button class="btn rounded border border-danger" type="button"  data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
                             </div>
                           </div>
                         </form>
                       </div>
                     </div>
                   </div>
                 <?php
                 }
                 ?>
                 <tr>
                   <td colspan="8" class="text-center">~ END ~</td>
                 </tr>
               </tbody>
          </table>
        </div>
      </div>
  <!-- </div> -->

  <!-- </body>
</html> -->

<script>

$('#trendMedbtn').on('click', function(){
  var trend = $("#trend");
  var inventory = $("#inventory");
  trend.toggleClass("d-none");
  if(inventory.hasClass("col-10")){
    inventory.removeClass("col-10");
    inventory.addClass("col-7");
  }else{
    inventory.removeClass("col-7");
    inventory.addClass("col-10");
  }
});

$('.medicineAvailability').on('change', function(){
  var id = $(this).attr('id');
  var formData = {
    'inventoryId' : id,
  };


  var baseUrl = window.location.origin;
  var apiPath = "/dashboard/medicine/update";
  var url = baseUrl+apiPath;

  $.ajax({
    type: 'post',
    url: url,
    data: formData,
    success: function(data){
      // do something
      window.location.reload();
    },
    error: function(xhr, textStatus, errorMessage){
      // do something
      console.log(xhr.status);
    }
  });

});

$('#searchMedicine').on('keyup', function(){
  var value = $(this).val().toLowerCase();
  $("#tableBody tr").filter(function() {
    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
  });
});
</script>
