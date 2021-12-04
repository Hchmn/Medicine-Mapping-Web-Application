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
  <!-- Content -->
  <div class="h-100 d-flex flex-row">
    <!-- Side menu -->
    <div class="col-3 p-4 sidemenu">
      <div class="border mb-2">
        <a href="<?php echo base_url(); ?>/admin/announcement" class="btn btn-outline-secondary w-100 d-flex align-items-center" style="height:55px;">
          New
        </a>
      </div>
      <div class="border mb-2">
        <a href="<?php echo base_url(); ?>/admin/announcement/archives" class="btn btn-outline-secondary active w-100 d-flex align-items-center justify-content-between" style="height:55px;">
          Archives
        </a>
      </div>
    </div>
    <div class="col-3 d-none " id="tempSpace"></div>
    <!-- content -->
    <div class="col">
      <table class="table table-striped border">
        <thead>
          <tr>
            <th scope="col" class="col-1">Created at</th>
            <th scope="col" class="col-3">Title</th>
            <th scope="col" class="col-2">Created By</th>
            <th scope="col" class="col-2">Link</th>
          </tr>
        </thead>
        <tbody>
          <?php
            foreach ($announcements as $key => $i) {
              $id = $i["ID"];
              $title = $i["TITLE"];
              $created_at = new DateTime($i["CREATED_AT"]);
              $admin = $i["USERNAME"];
              ?>
              <tr>
                <th scope="row"><?php echo $created_at->format('m/j/Y h:i A'); ?></th>
                <td><?php echo "$title"; ?></td>
                <td><?php echo "$admin"; ?></td>
                <td><a href="<?php echo base_url(); ?>/announcement/<?php echo "$id"; ?>" target="_blank">Link</a></td>
              </tr>
              <?php
            }
           ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
<script src="<?php echo base_url(); ?>/assets/js/admin.js" charset="utf-8"></script>
