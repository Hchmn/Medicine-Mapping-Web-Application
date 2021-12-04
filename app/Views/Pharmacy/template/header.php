<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo base_url();?>/dashboard_only/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <title>Pharmacy</title>
  </head>
  <body style="overflow:hidden;">
    <div class="w-100" style="width:100%;">
      <nav class="navbar navbar-expand-md navbar-light w-100" style="background: #1d9feb; height:60px; width:100%;" >
            <div class="" style="">
              <a href="/dashboard" class="btn rounded-0 " style="">
                <small style="" class="fw-bold fs-3 text-white">Medicine Mapping</small>
              </a>
            </div>
            <div id="navbarCollapse" class="collapse navbar-collapse">
              <ul class="nav navbar-nav ml-auto">
                  <li class="nav-item dropdown">
                      <a href="#" class="nav-link" data-toggle="dropdown" style="color:White;">
                        <?php
                          $fn = session()->get("pharmacist_fname");
                          $ln = session()->get("pharmacist_lname");
                          $pharma_id = session()->get("pharmacy_id");
                          $db = \Config\Database::connect();
                          $query = $db->query("SELECT * FROM pharmacy WHERE ID LIKE '$pharma_id'");
                          $pharmacy_name = "";
                          foreach ($query->getResult() as $result) {
                            $pharmacy_name = $result->NAME;
                          }
                          echo "$fn $ln";
                        ?>
                        <i class="fa fa-fw fa-user" style="color:White;"></i></a>
                      <div class="dropdown-menu dropdown-menu-right">
                          <a href="#" class="dropdown-item"><?php echo $pharmacy_name; ?></a>
                          <div class="dropdown-divider"></div>
                          <a href="\" action="" onclick="return confirm('Are you sure you want to log out?');" class="dropdown-item">Logout</a>
                      </div>
                  </li>
              </ul>
          </div>
      </nav>
  </div>
    <div class="d-flex flex-row w-100">

      <div class="col-2 h-100 d-flex flex-column pt-3" style="">
          <a href="<?php echo base_url();?>/dashboard" class="btn rounded-0 mb-2 d-flex fs-5 flex-row" style="">
            <i class="fas fa-home fa-lg col-1 p-0"></i>
            <small style="" class="ms-2 col text-start">Home</small>
          </a>

          <a href="<?php echo base_url();?>/inbox" class="btn rounded-0 mb-2 d-flex fs-5 flex-row" style="">
            <i class="far fa-comments fa-lg col-1 p-0"></i>
            <small  class="ms-2 col text-start">Inbox</small>
          </a>

          <a href="<?php echo base_url();?>/addmedicine" class="btn rounded-0 mb-2 d-flex fs-5 flex-row" style="">
            <i class="fas fa-capsules fa-lg col-1 p-0"></i>
            <small  class="ms-2 col text-start">Add Medicine</small>
          </a>

          <a href="<?php echo base_url();?>/logs" class="btn rounded-0 mb-2 d-flex fs-5 flex-row" style="">
            <i class="fas fa-clipboard-list fa-lg col-1 p-0"></i>
            <small  class="ms-2 col text-start">Logs</small>
          </a>

          <a href="<?php echo base_url();?>/pharmacists" class="btn rounded-0 mb-2 d-flex fs-5 flex-row" style="">
            <i class="far fa-user fa-lg col-1 p-0"></i>
            <small  class="ms-2 col text-start">Pharmacists</small>
          </a>

          <a href="<?php echo base_url();?>/settings" class="btn rounded-0 mb-2 d-flex fs-5 flex-row" style="">
            <i class="fas fa-cog fa-lg col-1 p-0"></i>
            <small  class="ms-2 col text-start">Settings</small>
          </a>

      </div>
