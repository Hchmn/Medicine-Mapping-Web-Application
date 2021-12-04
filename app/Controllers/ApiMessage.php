<?php
namespace App\Controllers;


class ApiMessage extends BaseController{
  public function NewMessage(){
      header("Content-type:application/json");

      $phoneNumber = $this->request->getPost("phoneNumber");
      $pharmacistId = $this->request->getPost("pharmacistId");
      $chatId = $this->request->getPost("chatId");
      $message = $this->request->getPost("message");

      if(!empty($phoneNumber)){
        // user
        // log_message("critical","$chatId");
        // $user = $this->patientModel->where("CONTACT_NO", $phoneNumber)->first();
        $newMessage = [
          'CHATS_ID' => $chatId,
          'MESSAGE' => $message,
          'CREATED_AT' => $this->time->now()->toDateTimeString(),
        ];
        $this->chatLineModel->insert($newMessage);
        $id = $this->chatLineModel->insertID;
        log_message("critical","CHAT_ID: {CHATS_ID} MSG: {MESSAGE} TIME: {CREATED_AT}", $newMessage);
      }elseif(!empty($pharmacistId)){

      }

      $data = [
        "status" => "sent",
      ];

      return $this->setResponseFormat('json')->respond($data, 200);
  }

  public function uploadImage(){
    header("Content-type:application/json");
    $phoneNumber = $this->request->getPost("phoneNumber");
    $pharmacistId = $this->request->getPost("pharmacistId");
    $image = $this->request->getFile('file');
    $chatId = $this->request->getPost("chatId");


    $createdAt = $this->time->now()->toDateTimeString();

    // create new chat line
    $newChatLine = [
      'CHATS_ID' => $chatId,
      'MESSAGE' => "<image>",
      'CREATED_AT' => $createdAt,
    ];

   $this->chatLineModel->insert($newChatLine);

   // get new chat line id
   $newChatLineId = $this->chatLineModel->insertID;

   // save image
   $this->savedImage($image, $newChatLineId);

    $data = [
      "status" => "OK",
    ];
    return $this->setResponseFormat('json')->respond($data, 200);
  }

  private function savedImage($image, $chatLineId){
    // generate random name
    $generatedName = $image->getRandomName();
    $internalPath = FCPATH.'uploads/ChatFiles/';
    $externalPath = base_url()."/uploads/ChatFiles/".$generatedName;
    // compress the image
    $compressImage = \Config\Services::image()->withFile($image)
                                              ->save($internalPath.$generatedName,10);



    $newImage = [
      "NAME" => $generatedName,
      "INTERNAL_PATH" => $externalPath,
      "MIME_TYPE" => $image->getClientMimeType(),
      "CHAT_LINES_ID" => $chatLineId,
    ];

    // insert the image
    $this->imageFileModel->insert($newImage);
  }
}
 ?>
