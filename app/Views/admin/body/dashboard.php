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
  <div class="row row-cols-2 gy-5 p-5">
    <!-- Medicine -->
    <div class="col">
      <div class="d-flex flex-column border rounded p-4">
        <span class="h2 fw-bold"><i class="fas fa-pills"></i> Medicine</span>
        <p class="mt-4 mb-4 lh-base fs-5 flex-fill">Manage medicines in the database</p>
        <div class="d-flex justify-content-center">
          <a href="<?php echo base_url(); ?>/admin/medicine" class="btn btn-primary fs-5 w-50">Go</a>
        </div>
      </div>
    </div>

    <!-- Pharmacy -->
    <div class="col">
      <div class="d-flex flex-column border rounded p-4">
        <span class="h2 fw-bold"><i class="fas fa-mortar-pestle"></i> Pharmacy</span>
        <p class="mt-4 mb-4 lh-base fs-5 flex-fill">Manage pharmacies</p>
        <div class="d-flex justify-content-center">
          <a href="<?php echo base_url(); ?>/admin/pharmacy" class="btn btn-primary fs-5 w-50">Go</a>
        </div>
      </div>
    </div>

    <!-- Activity log -->
    <div class="col">
      <div class="d-flex flex-column border rounded p-4">
        <span class="h2 fw-bold"><i class="fas fa-clipboard-list"></i> Activity Log</span>
        <p class="mt-4 mb-4 lh-base fs-5 flex-fill">View other admins activities</p>
        <div class="d-flex justify-content-center">
          <a href="<?php echo base_url(); ?>/admin/log" class="btn btn-primary fs-5 w-50">Go</a>
        </div>
      </div>
    </div>

    <!-- Make announcement -->
    <div class="col">
      <div class=" d-flex flex-column border rounded p-4">
        <span class="h2 fw-bold"><i class="fas fa-scroll"></i> Announcement</span>
        <p class="mt-4 mb-4 lh-base fs-5 flex-fill">Make announcement</p>
        <div class="d-flex justify-content-center">
          <a href="<?php echo base_url(); ?>/admin/announcement" class="btn btn-primary fs-5 w-50">Go</a>
        </div>
      </div>
    </div>

  </div>
</body>
