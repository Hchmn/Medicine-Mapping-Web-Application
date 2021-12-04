var origHeight;
$(document).ready(function(){
  // get new data per 500 ms
   loadMessage();
   setTimeout(function(){
     var chatContainer = document.getElementById('chatContainer');
     origHeight = chatContainer.scrollHeight;
     var scrollOption = {
       top: chatContainer.scrollHeight,
       left: 0,
       behavior: 'smooth',
     };
     chatContainer.scrollTo(scrollOption);
  }, 600);

  setInterval(loadMessage,500);
});

$("#upload-photo").on('change', function(){
  var e = document.getElementById('uploadImage');
  // console.log(e);
  var img = new FormData(e);

  var baseUrl = window.location.origin;
  var apiPath = "/inbox/send/message/img";
  var url = baseUrl+apiPath;

  $.ajax({
    type: 'post',
    url: url,
    data: img,
    cache: false,
    contentType: false,
    processData: false,
    success: function(data){
      // console.log(data);
      // scroll down when new message
      setTimeout(function(){
        var chatContainer = document.getElementById('chatContainer');
        var scrollHeight = chatContainer.scrollHeight + 200;
        var scrollOption = {
          top: scrollHeight,
          left: 0,
          behavior: 'smooth',
        };
        chatContainer.scrollTo(scrollOption);
      }, 590);

      var form = document.getElementById("uploadImage");
      form.reset();
    },
    error: function(xhr, textStatus, errorMessage){
      // do something
      console.log(xhr.status);
    }
  });
});

$("#sendMessage").submit(function(e){
  e.preventDefault();

  var formData = $(this).serialize();

  // make a request
  var baseUrl = window.location.origin;
  var apiPath = "/inbox/send/message";
  var url = baseUrl+apiPath;

  $.ajax({
    type: 'post',
    url: url,
    data: formData,
    success: function(data){
      // window.location.reload();
      // scroll down when new message
      setTimeout(function(){
        var chatContainer = document.getElementById('chatContainer');
        var scrollHeight = chatContainer.scrollHeight + 200;
        var scrollOption = {
          top: scrollHeight,
          left: 0,
          behavior: 'smooth',
        };
        chatContainer.scrollTo(scrollOption);
      }, 590);

      var form = document.getElementById("sendMessage");
      form.reset();
    },
    error: function(xhr, textStatus, errorMessage){
      // do something
      console.log(xhr.status);
    }
  });

});


function htmlEntities(str) {
  return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

function loadMessage(){
  var chatContainer = document.getElementById('chatContainer');
  // console.log("Orig = " + origHeight);
  // console.log("Client = " + chatContainer.scrollHeight);
  if(origHeight < chatContainer.scrollHeight){
      // new message
      var scrollOption = {
        top: chatContainer.scrollHeight,
        left: 0,
        behavior: 'smooth',
      };
      chatContainer.scrollTo(scrollOption);
      origHeight = chatContainer.scrollHeight;
  }
  var id = window.location.pathname;
  id = id[id.length - 1];
  var chatContainer = document.getElementById('chatContainer');

  // make a request
  var baseUrl = window.location.origin;
  var apiPath = "/inbox/get/messages/" + id;
  var url = baseUrl+apiPath;

  $.ajax({
    type: 'get',
    url: url,
    error: function(xhr, textStatus, errorMessage){
      // do something
      console.log(xhr.status);
    }
  }).done(function(data){


    var chatLines = data;
    $("#chatContainer").empty(); // remove existing elements
    var chatBoxContainer = document.getElementById('chatContainer');

    for (var variable in chatLines) {
      if (chatLines.hasOwnProperty(variable)) {
        var data = chatLines[variable];
        if(data.IS_PHARMACIST){
          let youContainer = document.getElementById('youContainer').cloneNode(true);
          youContainer.classList.add("d-flex");
          youContainer.classList.remove("d-none");
          let messageDetail = youContainer.children[0];
          // get nodes
          let senderName = messageDetail.children[0];
          let time = messageDetail.children[1];
          let message = messageDetail.children[2];

          senderName.innerHTML = data.SENDER.FIRST_NAME + " " + data.SENDER.LAST_NAME;

          let datetime = new Date(data.CREATED_AT);
          let options = {dateStyle: "short", timeStyle:'short'};
          time.innerHTML = datetime.toLocaleString('en-US',options);
          // check if message is an image
          if(data.IS_IMAGE){
            var cleanMessage = data.MESSAGE;
          }else{
            cleanMessage = htmlEntities(data.MESSAGE); // disregard html tags messages
          }
          message.innerHTML = cleanMessage;
          chatBoxContainer.appendChild(youContainer);
        }else{
          let senderContainer = document.getElementById('senderContainer').cloneNode(true);
          senderContainer.classList.add("d-flex");
          senderContainer.classList.remove("d-none");
          let messageDetail = senderContainer.children[1];

          let senderName = messageDetail.children[0];
          let time = messageDetail.children[1];
          let message = messageDetail.children[2];

          senderName.innerHTML = data.SENDER.FIRST_NAME + " " + data.SENDER.LAST_NAME;

          let datetime = new Date(data.CREATED_AT);
          let options = {dateStyle: "short", timeStyle:'short'};
          time.innerHTML = datetime.toLocaleString('en-US',options);
          // check if message is an image
          if(data.IS_IMAGE){
            cleanMessage = data.MESSAGE;
          }else{
            cleanMessage = htmlEntities(data.MESSAGE); // disregard html tags messages
          }

          message.innerHTML = cleanMessage;

          chatBoxContainer.appendChild(senderContainer);
        }

      }
    }

  });
}
