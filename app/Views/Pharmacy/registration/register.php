<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.js"></script>

  </head>

  <body>
    <!-- header -->
    <div class="navbar" style="background: #1d9feb; height:65px;">
      <div class="" style="">
          <p style="" class="fw-bold fs-3 text-white text-uppercase">Register</p>
      </div>
    </div>
    <!-- content -->
    <div class="">
        <!-- Pharma Info -->
        <form id="pharmaInfo" class="d-lg-flex flex-row p-4">
          <div class="col ps-5 pe-5">
            <div class="mb-1">
              <p class="fw-bold fs-3 text-uppercase">Pharmacy Information</p>
            </div>
            <!-- Name -->
            <div class="mb-3 row">
              <label for="pharmacyName" class="col-sm-2 col-form-label">Name</label>
              <div class="col-sm-10">
                <input required name="pharmacyName" id="pharmacyName" type="text" class="form-control" value="">
              </div>
            </div>
            <!-- Location -->
            <p class="mt-2 fw-bold fs-5 text-uppercase">Location</p>
            <!-- Province -->
            <div class="mb-3 row">
              <label for="pharmacyProvince" class="col-sm-2 col-form-label">Province</label>
              <div class="col-sm-10">
                <select class="province form-select" name="pharmacyProvince" id="pharmacyProvince" required>
                  <option value="Lanao Del Norte" selected>Lanao Del Norte</option>
                </select>
              </div>
            </div>
            <!-- City -->
            <div class="mb-3 row">
              <label for="pharmacyCity" class="col-sm-2 col-form-label">City</label>
              <div class="col-sm-10">
                <select class="city form-select" name="pharmacyCity" id="pharmacyCity" required>
                  <option value="Iligan City" selected>Iligan City</option>
                </select>
              </div>
            </div>
            <!-- Barangay -->
            <div class="mb-3 row">
              <label for="pharmacyBarangay" class="col-sm-2 col-form-label">Barangay</label>
              <div class="col-sm-10">
                <select class="barangay form-select" name="pharmacyBarangay" id="pharmacyBarangay" required>
                  <option value="Iligan City" selected>Iligan City</option>
                </select>
              </div>
            </div>
            <!-- Street (Opt.) -->
            <div class="mb-3">
              <label for="pharmacyStreet" class="form-label">Street/Purok/Bldg. No</label>
              <div class="">
                <input type="text" name="pharmacyStreet" class="form-control" id="pharmacyStreet" value="">
              </div>
            </div>
            <!-- Gmap -->
            <div class="">
              <input type="text" id="pharmacyLatitude" class="" name="pharmacyLatitude" hidden value="">
              <input type="text" id="pharmacyLongitude" class="" name="pharmacyLongitude" hidden value="">
              <label for="map" class="fw-bold fs-5 text-uppercase">Google Map</label>
              <p id="gmapInfo" class="text-info text-uppercase fs-6 text-center m-0">
                PLEASE PIN THE EXACT LOCATION OF THE PHARMACY IN THE MAP
              </p>
              <div id="map" style="height: 400px;" class="rounded"></div>
              <div class="d-flex ">
                <p>(
                  <p id="pharmacyLatitudeText">Latitude</p>
                  <p>,&nbsp;</p>
                  <p id="pharmacyLongitudeText">Longitude</p>
                )</p>
              </div>
            </div>
          </div>
          <!-- Contact Detail -->
          <div class="col  ps-5 pe-5">
            <div class="mb-2"></div>
            <p class="fw-bold fs-5 text-uppercase m-0">Contact Detail</p>
            <p id="contactInfo" class="text-info text-uppercase fs-6">
              Provide at least one contact information
            </p>
            <!-- Email -->
            <div class="mb-3 row">
              <label for="pharmacyEmail" class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
                <input name="pharmacyEmail" id="pharmacyEmail" type="text" class="form-control" value="">
              </div>
            </div>
            <!-- Mobile Number -->
            <div class="mb-3 row">
              <label for="pharmacyMobileNumber" class="col-sm-2 col-form-label">Mobile Number</label>
              <div class="col-sm-10">
                <input name="pharmacyMobileNumber" id="pharmacyMobileNumber" type="text" class="form-control" value="">
              </div>
            </div>
            <!-- Telephone -->
            <div class="mb-3 row">
              <label for="pharmacyTelephone" class="col-sm-2 col-form-label">Telephone</label>
              <div class="col-sm-10">
                <input name="pharmacyTelephone" id="pharmacyTelephone" type="text" class="form-control" value="">
              </div>
            </div>
            <!-- Document -->
            <p class="fw-bold fs-5 text-uppercase m-0">Documents</p>
            <p><small class="text-info text-uppercase">for verification purposes only please upload a clear image of the follow documents</small></p>
            <!-- FDA -->
            <div class="mb-3">
              <label for="FDAcert" class="form-label">FDA certification documents</label>
              <input class="form-control" type="file" name="FDAcert[]" id="FDAcert" multiple accept="image/jpeg, image/x-png, image/png" required>
            </div>
            <!-- BIR -->
            <div class="mb-3">
              <label for="BIRcert" class="form-label">BIR certification documents</label>
              <input class="form-control" type="file" name="BIRcert[]" id="BIRcert" multiple  accept="image/jpeg, image/x-png, image/png" required>
            </div>
            <!-- btn -->
            <div class="d-flex justify-content-end mt-5">
              <button type="submit" class="btn btn-primary w-25" id="nxtBtn">Next</button>
            </div>
          </div>
        </form>

        <!-- Your Info -->
        <form id="yourInfo" class="d-none flex-row p-4">
          <!-- Demographic -->
          <div class="col ps-5 pe-5">
            <p class="fw-bold fs-3 text-uppercase">Your Information</p>
            <!-- FirstName -->
            <div class="mb-3 row">
              <label for="pharmacistFirstName" class="col-sm-2 col-form-label">First name</label>
              <div class="col-sm-10">
                <input required name="pharmacistFirstName" id="pharmacistFirstName" type="text" class="form-control" value="">
              </div>
            </div>
            <!-- LastName -->
            <div class="mb-3 row">
              <label for="pharmacistLastName" class="col-sm-2 col-form-label">Last name</label>
              <div class="col-sm-10">
                <input required name="pharmacistLastName" id="pharmacistLastName" type="text" class="form-control" value="">
              </div>
            </div>
            <!-- Location -->
            <p class="mt-2 fw-bold fs-5 text-uppercase">Location</p>
            <!-- Province -->
            <div class="mb-3 row">
              <label for="pharmacistProvince" class="col-sm-2 col-form-label">Province</label>
              <div class="col-sm-10">
                <select class="province form-select" name="pharmacistProvince" id="pharmacistProvince" required>
                  <option value="Lanao Del Norte" selected>Lanao Del Norte</option>
                </select>
              </div>
            </div>
            <!-- City -->
            <div class="mb-3 row">
              <label for="pharmacistCity" class="col-sm-2 col-form-label">City</label>
              <div class="col-sm-10">
                <select class="city form-select" name="pharmacistCity" id="pharmacistCity" required>
                  <option value="Iligan City" selected>Iligan City</option>
                </select>
              </div>
            </div>
            <!-- Barangay -->
            <div class="mb-3 row">
              <label for="pharmacistBarangay" class="col-sm-2 col-form-label">Barangay</label>
              <div class="col-sm-10">
                <select class="barangay form-select" name="pharmacistBarangay" id="pharmacistBarangay" required>
                  <option value="Iligan City" selected>Iligan City</option>
                </select>
              </div>
            </div>
            <!-- Street (Opt.) -->
            <div class="mb-3">
              <label for="pharmacistStreet" class="form-label">Street/Purok/Bldg. No</label>
              <div class="">
                <input type="text" name="pharmacistStreet" class="form-control" id="pharmacistStreet" value="">
              </div>
            </div>
          </div>
          <!-- Contact Detail -->
          <div class="col ps-5 pe-5">
            <div class="mb-2"></div>
            <p class="fw-bold fs-5 text-uppercase m-0">Contact Detail</p>
            <p id="pharmacistContactInfo" class="text-info text-uppercase fs-6">
              Provide at least one contact information
            </p>
            <!-- Email -->
            <div class="mb-3 row">
              <label for="pharmacistEmail" class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
                <input required name="pharmacistEmail" id="pharmacistEmail" type="text" class="form-control" value="">
              </div>
            </div>
            <!-- Mobile Number -->
            <div class="mb-3 row">
              <label for="pharmacistMobileNumber" class="col-sm-2 col-form-label">Mobile Number</label>
              <div class="col-sm-10">
                <input name="pharmacistMobileNumber" id="pharmacistMobileNumber" type="text" class="form-control" value="">
              </div>
            </div>
            <!-- Telephone -->
            <div class="mb-3 row">
              <label for="pharmacistTelephone" class="col-sm-2 col-form-label">Telephone</label>
              <div class="col-sm-10">
                <input name="pharmacistTelephone" id="pharmacistTelephone" type="text" class="form-control" value="">
              </div>
            </div>
            <!-- btn -->
            <div class="d-flex justify-content-end mt-5">
              <button type="button" class="btn btn-primary me-3 w-25" id="backBtn">Back</button>
              <button type="submit" class="btn btn-primary w-25">Submit</button>
            </div>
          </div>
        </form>

    </div>

    <script src="<?php echo base_url(); ?>/assets/js/registration.js" charset="utf-8"></script>
    <insert_api_key>
      

  </body>
</html>
