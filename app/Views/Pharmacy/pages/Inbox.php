<style media="screen">
  .customBtnCss:hover{
    background-color: #2699fb;
    color: #ffffff;
  }

  #label-upload-photo{
    cursor: pointer;
  }

</style>
<!-- Inbox -->
<div class="col-2 border p-0" style="height:100vh;">
  <div class="mt-2 border-bottom border-4">
    <p class="fw-bold h4 text-center">Messages</p>
  </div>
  <?php
  foreach ($myMessages as $key => $value) {
    $chat_Id = $value['CHAT_ID'];
    $fn = $value['PATIENT_DATA']['FIRST_NAME'];
    $ln = $value['PATIENT_DATA']['LAST_NAME'];
    ?>
    <a href="<?php echo base_url(); ?>/inbox/<?php echo $chat_Id; ?>" class="customBtnCss btn w-100 d-flex align-items-center rounded-0 messagesBtn border-bottom border-4"
      style="height:80px; <?php echo ($convoId === $chat_Id)? 'background-color: #84c1f6;':''; ?>">
      <div class="">
        <svg id="Group_811" data-name="Group 811" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48">
          <rect id="Rectangle_331" data-name="Rectangle 331" width="48" height="48" fill="#2699fb"/>
          <path id="Union_23" data-name="Union 23" d="M0,16V14c0-2.2,3.6-4,8-4s8,1.8,8,4v2ZM4,4A4,4,0,1,1,8,8,4,4,0,0,1,4,4Z" transform="translate(16 16)" fill="#fff"/>
        </svg>
      </div>
      <span class="ms-3 fs-6 text-wrap text-start"><?php echo "$fn $ln"; ?></span>
    </a>
    <?php
  }
   ?>

</div>
<!-- Chat messages -->
<div class="col-8 p-0 d-flex flex-column">
  <div class="mt-2 border-bottom border-5">
    <p class="text-center h4 fw-bold">Chat</p>
  </div>
  <!-- messages -->
  <div class="overflow-auto" id="chatContainer" style="min-height: 80vh; max-height:80vh; background-color:rgba(227, 227, 227, 0.47);">

  </div>
  <!-- chat box -->
  <div id="chatBox" class="border-top <?php echo (empty($convoId)? "d-none":""); ?>" style="height:150px;">
    <div class="d-flex p-3 align-items-center">
      <form class="col-1" id="uploadImage">
        <input type="hidden" name="pharmacistId" value="<?php echo session()->get('id'); ?>">
        <input id="formChatId" type="hidden" name="chatId" value="<?php echo "$convoId"; ?>">
        <div class="me-3 d-flex justify-content-center align-items-center">
          <label for="upload-photo" id="label-upload-photo" class="fs-3 text-primary m-0">
            <i class="far fa-file-image"></i>
          </label>
          <input name="photo" class="" type="file" id="upload-photo" accept="image/jpeg, image/png" hidden/>
        </div>
      </form>
      <form  class="d-flex col" id="sendMessage">
        <input type="hidden" name="pharmacistId" value="<?php echo session()->get('id'); ?>">
        <input id="formChatId" type="hidden" name="chatId" value="<?php echo "$convoId"; ?>">
        <div class="form-floating col p-0">
          <input name="message" class="form-control form-control-lg" type="text" placeholder=".form-control-lg" aria-label=".form-control-lg example">
          <label for="floatingTextarea">Message</label>
        </div>
        <div class="col-1">
          <button type="submit" name="button" class="btn btn-primary h-100">
            <i class="fas fa-paper-plane"></i>
            Send
          </button>
        </div>
      </form>
    </div>

  </div>
</div>

<!-- Sender -->
<div class="d-none ms-5 mb-3  align-items-start" id="senderContainer">
  <svg id="Group_811" data-name="Group 811" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 48 48">
    <rect id="Rectangle_331" data-name="Rectangle 331" width="48" height="48" fill="#2699fb"/>
    <path id="Union_23" data-name="Union 23" d="M0,16V14c0-2.2,3.6-4,8-4s8,1.8,8,4v2ZM4,4A4,4,0,1,1,8,8,4,4,0,0,1,4,4Z" transform="translate(16 16)" fill="#fff"/>
  </svg>
  <div class="d-flex flex-column ms-2 rounded text-white p-3" style="width:500px; background-color: #2699fb;">
    <p class="fw-bold mb-0">Name</p>
    <small class="mb-3">Time</small>
    <span class=""></span>
  </div>
</div>

<!-- You -->
<div class="d-none mb-3 justify-content-end me-5 " id="youContainer">
  <div class="d-flex flex-column me-2 rounded text-white p-3" style="width:500px; background-color: #2699fb;">
    <p class="fw-bold text-end mb-0">Name</p>
    <small class="text-end mb-3">Time</small>
    <span class=""></span>
  </div>
  <svg id="Group_811" data-name="Group 811" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 48 48">
    <rect id="Rectangle_331" data-name="Rectangle 331" width="48" height="48" fill="#2699fb"/>
    <path id="Union_23" data-name="Union 23" d="M0,16V14c0-2.2,3.6-4,8-4s8,1.8,8,4v2ZM4,4A4,4,0,1,1,8,8,4,4,0,0,1,4,4Z" transform="translate(16 16)" fill="#fff"/>
  </svg>
</div>


<script src="<?php echo base_url(); ?>/assets/js/inbox.js" charset="utf-8"></script>
