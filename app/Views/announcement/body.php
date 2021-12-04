<body style="background-color:rgb(226, 226, 226);">
  <div class="">
    <div class="border d-flex flex-row">
      <div class="col-sm-2 border"></div>
      <!-- Content -->
      <div class="col bg-white" style="">
        <!-- header -->
        <div class="p-5" style="background-color:rgb(191, 228, 255);">
          <h1 class="fw-bold"><?php echo "$title"; ?></h1>
          <div class="">
            <p class="m-0">Author: Developer</p>
            <?php
              $postedOn = new DateTime($createdAt);
             ?>
            <p class="m-0 text-muted"><em>Posted on: <?php echo $postedOn->format('F j, Y'); ?></em></p>
          </div>
        </div>
        <div class="d-flex" style="background-color:rgb(59, 173, 255);height:10px;">
          <span></span>
        </div>
        <!-- Content -->
        <div class="ps-5 pe-5 pt-2 pb-3">
          <?php echo $content; ?>
        </div>
      </div>
      <div class="col-sm-2 border"></div>
    </div>
  </div>
</body>
