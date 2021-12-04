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
  <!-- content -->
  <div class="h-100 d-flex flex-row">
    <!-- Side menu -->
    <div class="col-3 p-4 sidemenu">
      <div class="border mb-2">
        <a href="<?php echo base_url(); ?>/admin/announcement" class="btn btn-outline-secondary w-100 d-flex align-items-center active" style="height:55px;">
          New
        </a>
      </div>
      <div class="border mb-2">
        <a href="<?php echo base_url(); ?>/admin/announcement/archives" class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-between" style="height:55px;">
          Archives
        </a>
      </div>
    </div>
    <div class="col-3 d-none " id="tempSpace"></div>
    <!-- content -->
    <div class="col">
      <div class="border">
        <form id="announcement" class="d-flex flex-column p-5">
          <div class="input-group mb-3">
            <span class="fs-4 fw-bold me-5">Title</span>
            <input required name="title" type="text" class="form-control" placeholder="Title" aria-label="Title" aria-describedby="announcement-title">
          </div>
          <div class="mb-3">
            <p class="fs-5 fw-bold">Content</p>
            <textarea id="content" name="content" style=""></textarea>
          </div>
          <div id="errMessage" class="d-none text-center rounded-pill mb-3 p-1" style="background-color:rgb(255, 177, 177);">
            <p class="m-0">System: Content is empty. If not, retry to submit the form.</p>
          </div>
          <div id="succMessage" class="d-none text-center rounded-pill mb-3 p-1" style="background-color:rgb(177, 255, 185);">
            <p class="m-0">System: successful!</p>
          </div>
          <div class="d-flex justify-content-center">
            <button type="submit" name="submit" class="btn btn-primary" >Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
<script src="<?php echo base_url(); ?>/assets/js/admin.js" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>/assets/tinymce/tinymce.min.js" charset="utf-8"></script>
<script type="text/javascript">
  tinymce.init({
    selector: '#content',
    plugins: 'print preview paste importcss searchreplace autolink autosave save code '+
    'visualblocks visualchars fullscreen link codesample table charmap hr pagebreak '+
    'nonbreaking anchor toc insertdatetime advlist lists wordcount textpattern noneditable '+
    'charmap emoticons',

    toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect |'+
    'alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist |' +
    ' charmap emoticons | fullscreen  preview save print |' +
    'link anchor codesample | ltr rtl',
    height:400,
  });
</script>
<script src="<?php echo base_url(); ?>/assets/js/announcement.js" charset="utf-8"></script>
