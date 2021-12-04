<?php
$db = \Config\Database::connect();
$pharmacy_id = session()->get('pharmacy_id');

 ?>
 <style media="screen">
 .btn-box{
   width: 100%;
   margin-bottom: 30px;
   text-align: center;
 }
 form button{
   width: 110px;
   height: 35px;
   margin 0 10px;
   background: #0bccff;
   border-radius: 25px;
   border: 0;
   outline: none;
   color: #fff;
   cursor: pointer;
 }
 .tab {
   display: none;
 }
 #prevBtn {
   background-color: #bbbbbb;
 }
 button:hover {
 opacity: 0.8;
 }
 input.invalid {
 background-color: #ffdddd;
 }
 select.invalid{
 background-color: #ffdddd;
 }
 .step {
 height: 15px;
 width: 15px;
 margin: 0 2px;
 background-color: #bbbbbb;
 border: none;
 border-radius: 50%;
 display: inline-block;
 opacity: 0.5;
 }

 /* Mark the active step: */
 .step.active {
 opacity: 1;
 }

 /* Mark the steps that are finished and valid: */
 .step.finish {
 background-color: #04AA6D;
 }
 </style>
      <div class="container mh-100 p-3 " style="">
              <small style="font-size: 30px; font-family:Times; color: #1d9feb;">Pharmacists</small>
              <div class="container" style=" border-bottom-width: 2px; border-bottom-style: solid; border-bottom-color:#1d9feb;">
              </div>
              <div class="list_pharmacist d-flex row p-2 mt-3 w-100 container justify-content-center  " style="border-radius: 30px 30px 30px 30px;">
                <?php

                  $pharmacist_fname = "";
                  $pharmacist_lname = "";
                  $pharmacist_address = "";
                  $is_active = "";
                  $created_at = "";
                  $query = $db->query("SELECT * FROM pharmacist WHERE PHARMACY_ID LIKE '$pharmacy_id'");
                  foreach ($query->getResult() as $result) {
                    $pharmacist_fname = $result->FIRST_NAME;
                    $pharmacist_lname = $result->LAST_NAME;
                    $pharmacist_address = $result->ADDRESS;
                    $is_active = ($result->IS_ACTIVE == 1)? 'Active': 'Inactive';
                    $created_at = new DateTime($result->CREATED_AT);

                  ?>
                <div class="container col-3 m-2 p-3  flex-column d-flex border " style=" background-color: #1d9feb;border-radius:30px 30px 30px 30px; height:40%; width:auto;">
                    <i class="fas fa-user mt-3"   style="font-size: 90px; margin-top:2px; margin-right:auto; margin-left:auto; text-align:center; color:white;"></i>
                  <div class="container w-30 h-50 mr-3  " style="position:relative;">
                    <p style="font-size:17px;font-family:Helvetica; margin-top:25px; color:white;">
                      <small style=" text-align:left;" >Name: <?php echo "$pharmacist_fname $pharmacist_lname"; ?></small>
                      <br>
                      <small style=" text-align:left;">Account Status: <?php echo "$is_active"; ?></small>
                      <br>
                      <small style=" text-align:left;">Date Created: <?php echo $created_at->format("M d, Y"); ?></small>
                      <br>
                      <small style=" text-align:left;">Address: <?php echo "$pharmacist_address"; ?></small>
                      <br>
                    </p>
                  </div>
                </div>
              <?php
            } ?>
                <div class="col-3 m-2 p-3  flex-column d-flex border " style=" border-radius:30px 30px 30px 30px; height:40%; width:50%; background:#1d9feb;">
                  <div class="container justify-content-center" style="height:254px; margin-right:auto; margin-left:auto; text-align:center;">
                    <button class="btn mt-5" data-toggle="modal" type="button" data-target=".bd-example-modal-lg" style="font-size:100px; color:black;">
                      <i class="fas fa-user-plus " ></i>
                    </button>
                  </div>

                </div>
                <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header justify-content-center " style="font-size:40px; font-weight:bolder; font-family:times; color:white; background:#1d9feb;">
                        <h2>Pharmacist Registration Form</h2>
                      </div>
                    <form class="" action="pharmacists/add_pharmacist" id = "regForm"method="post">

                      <div class="modal-body h-100">
                        <div class="tab">
                          <div class=" h-auto justify-content-center" style="text-align:center">
                            <h3 style="font-size:35px; font-family:times;">Pharmacists</h3>
                            <p style="color:orange;">Provide one pharmacist information working in the pharmacy.</p>
                          </div>

                            <div class="h-auto mt-4" style="text-align:center;">
                              <label for="" style="margin-top:10px; font-size:22px; font-family:times; "> Name Information</label>
                            </div>
                            <div class="form-group first" style="text-align:center;">
                              <label class="ml-3"for="" style="font-size:20px; font-family:times;">First Name</label>
                              <input type="text" class="form-control" id="f_name" name = "pharmacist_fname" placeholder="Enter First Name" required
                              style="font-size:15px; border-radius: 30px 30px 30px 30px; border-color:#1d9feb; width:50%; margin-right:auto; margin-left:auto;
                              text-align:center;">
                              <input type="hidden" name="pharmacy_id" value="<?php echo "$pharmacy_id"; ?>">
                            </div>

                            <div class="h-auto" style="text-align:center;">
                              <label class="ml-3"for="" style="font-size:20px; font-family:times;">Last Name</label>
                              <input type="text" class="form-control" id="l_name" name = "pharmacist_lname" placeholder="Enter Last Name" required
                              style="font-size:15px; border-radius: 30px 30px 30px 30px; border-color:#1d9feb; width:50%; margin-right:auto; margin-left:auto;
                              text-align:center;">
                            </div>

                            <div class="h-auto mt-4" style="text-align:center;">
                              <label for="" style="margin-top:10px; font-size:22px; font-family:times; "> Contact Information</label>
                            </div>

                            <div class="form-group first justify-content-center" style="text-align:center;">
                              <label class="mt-1"for="" style="font-size:20px; font-family:times;">Email</label>
                              <input type="text" class="form-control" id="email" name = "pharmacist_email" placeholder="Email" required
                              style="font-size:15px; border-radius: 30px 30px 30px 30px; border-color:#1d9feb; width:50%; margin-right:auto; margin-left:auto;
                              text-align:center;">
                            </div>

                            <div class="form-group first justify-content-center" style="text-align:center;">
                              <label class="mt-1"for="" style="font-size:20px; font-family:times;">Contact Number</label>
                              <input type="text" class="form-control" id="contact_number" name = "pharmacist_contact_number" placeholder="Enter Contact Number" required
                              style="font-size:15px; border-radius: 30px 30px 30px 30px; border-color:#1d9feb; width:50%; margin-right:auto; margin-left:auto;
                              text-align:center;">
                            </div>

                            <div class="h-auto mt-4" style="text-align:center;">
                              <label for="" style="margin-top:10px; font-size:22px; font-family:times; ">Address</label>
                            </div>

                            <div class="form-group first justify-content-center" style="text-align:center;">
                                <label class="mt-1"for="" style="font-size:20px; font-family:times;">Province</label>
                                  <select class="form-control justify-content-center" id="pharmacist_province"name="pharmacist_province" style="font-size:15px; border-radius: 30px 30px 30px 30px; border-color:#1d9feb; width:50%;
                                  margin-right:auto; margin-left:auto; text-align:center;font-family:times;">
                                    <option value="Lanao Del Norte" selected>LANAO DEL NORTE</option>
                                  </select>
                            </div>

                            <div class="form-group first justify-content-center" style="text-align:center;">
                              <label class="mt-1"for="" style="font-size:20px; font-family:times;">City</label>
                                <select class="form-control" id = "pharmacist_city" name="pharmacist_city" style="font-size:15px; border-radius: 30px 30px 30px 30px; border-color:#1d9feb; width:50%;
                                margin-right:auto; margin-left:auto; text-align:center; justify-content:center;font-family:times;">
                                  <option value="Iligan City" selected>ILIGAN CITY</option>
                                </select>
                            </div>

                            <div class="form-group first justify-content-center" style="text-align:center;">
                              <label class="mt-1"for="" style="font-size:20px; font-family:times;">Barangays</label>
                                <select class="form-control" id= "pharmacist_barangay" name="pharmacist_barangay" style="font-size:15px; border-radius: 30px 30px 30px 30px; border-color:#1d9feb; width:50%;
                                margin-right:auto; margin-left:auto; text-align:center; justify-content:center;font-family:times; text-transform: uppercase;">
                                </select>
                            </div>
                          </div>

                          <div class="tab">

                              <div class=" h-auto justify-content-center" style="text-align:center">
                                <h3 style="font-size:35px; font-family:times;">Account Details</h3>
                                <p style="color:orange;">Provide the pharmacist account details</p>
                              </div>

                              <div class="form-group first" style="text-align:center;">
                                <label class="ml-3"for="" style="font-size:20px; font-family:times;">Username</label>
                                <input type="text" class="form-control" id="username" name = "username" placeholder="Enter your username" required
                                style="font-size:15px; border-radius: 30px 30px 30px 30px; border-color:#1d9feb; width:50%; margin-right:auto; margin-left:auto;
                                text-align:center;">
                              </div>

                              <div class="h-auto mb-3" style="text-align:center;">
                                <label class="ml-3"for="" style="font-size:20px; font-family:times;">Password</label>
                                <input type="password" class="form-control" id="password" name = "password" placeholder="Enter your password" required
                                style="font-size:15px; border-radius: 30px 30px 30px 30px; border-color:#1d9feb; width:50%; margin-right:auto; margin-left:auto;
                                text-align:center;">
                              </div>
                          </div>

                          <div class="modal-footer">
                            <div class="btn-box" style="margin-bottom:5px; ">
                              <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                              <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                            </div>

                            <div class="" style="text-align:center;margin-top:5px; margin-bottom:5px;">
                              <span class="step"></span>
                              <span class="step"></span>
                            </div>
                          </div>
                         </div>
                    </form>
                    </div>
                  </div>
                </div>
          </div>
      </div>

<script type="text/javascript">
  var lanao_del_norte_cities = {};
  // lanao_del_norte_cities['LANAO DEL NORTE'] = ['BACOLOD', 'BALOI', 'BAROY', 'ILIGAN CITY', 'KAPATAGAN', 'KAUSWAGAN', 'KOLAMBUGAN', 'LALA', 'LINAMON', 'MAGSAYSAY','MAIGO',
  //                         'MATUNGAO', 'MUNAI', 'NUNUNGAN', 'PANTAO RAGAT', 'PANTAR', 'POONA PIAGAPO', 'SALVADOR', 'SAPAD', 'SULTAN NAGA DIMAPORO (KAROMATAN)', 'TAGOLOAN'
  //                         ,'TANGCAL', 'TUBOD'];
  barangay_in_cities = {};
  barangay_in_cities['Iligan City'] = ['Abuno', 'Acmac', 'Bagong Silang', 'Bonbonon', 'Bunawan', 'Buru-un', 'Dalipuga', 'Del Carmen', 'Digkilaan', 'Ditucalan', 'Dulag', 'Hinaplanon'
      , 'Hindang', 'Kabacsanan', 'Kalilangan', 'Kiwalan', 'Lanipao', 'Luinab', 'Mahayahay', 'Mainit', 'Mandulog', 'Maria Cristina', 'Palao', 'Panoroganan', 'Poblacio', 'Puga-an'
      , 'Rogongon', 'San Miguel', 'San Roque', 'Santa Elena', 'Santa Filomena', 'Santiago', 'Santo Rosario', 'Saray', 'Suarez', 'Tambacan', 'Tibanga', 'Tipanoy', 'Tomas L. Cabili',
      'Tominobo Upper', 'Tominobo Lower', 'Tubod', 'Ubaldo Laya', 'Upper Hinaplanon', 'Villa Verde'];

  var barangay_list = document.getElementById("pharmacist_barangay");
      while (barangay_list.options.length){
        barangay_list.remove(0);
      }
      var barangays = barangay_in_cities['Iligan City'];

      if(barangays){
        var i;
        for(i = 0; i < barangays.length; i++){

          var barangay = new Option(barangays[i]);
          barangay_list.options.add(barangay);

        }
      }
</script>

<script type="text/javascript">
      var currentTab = 0; // Current tab is set to be the first tab (0)
      var x = document.getElementsByClassName("tab");
      var xLen = x.length;
      showTab(currentTab); // Display the current tab

      function showTab(n) {
        // This function will display the specified tab of the form ...

        x[n].style.display = "block";
        // ... and fix the Previous/Next buttons:
        if (n == 0) {
          document.getElementById("prevBtn").style.display = "none";
        } else {
          document.getElementById("prevBtn").style.display = "inline";
        }
        if (n == (xLen - 1)) {
          document.getElementById("nextBtn").innerHTML = "Submit";
        } else {
          document.getElementById("nextBtn").innerHTML = "Next";
        }
        // ... and run a function that displays the correct step indicator:
        fixStepIndicator(n)
      }

      function nextPrev(n) {
        // This function will figure out which tab to display

        // Exit the function if any field in the current tab is invalid:
        if (n == 1 && !validateForm()) return false;
        // Hide the current tab:
        x[currentTab].style.display = "none";
        // Increase or decrease the current tab by 1:
        currentTab = currentTab + n;
        // if you have reached the end of the form... :
        if (currentTab >= xLen) {
          //...the form gets submitted:
          document.getElementById("regForm").submit();
          return false;
        }
        // Otherwise, display the correct tab:
        showTab(currentTab);
      }

      function validateForm() {
        // This function deals with validation of the form fields
        var y, i, valid = true;

        y = x[currentTab].getElementsByTagName("input");
        // A loop that checks every input field in the current tab:
        for (i = 0; i < y.length; i++) {
          // If a field is empty...
          if (y[i].value == "") {
            // add an "invalid" class to the field:
            y[i].className += " invalid";
            // and set the current valid status to false:
            valid = false;
          }
        }
        // If the valid status is true, mark the step as finished and valid:
        if (valid) {
          document.getElementsByClassName("step")[currentTab].className += " finish";
        }
        return valid; // return the valid status
      }

      function fixStepIndicator(n) {
        // This function removes the "active" class of all steps...
        var i, x = document.getElementsByClassName("step");
        for (i = 0; i < xLen; i++) {
          x[i].className = x[i].className.replace(" active", "");
        }
        //... and adds the "active" class to the current step:
        x[n].className += " active";
      }
</script>
