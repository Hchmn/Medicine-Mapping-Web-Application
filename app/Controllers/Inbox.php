<?php
namespace App\Controllers;

class Inbox extends BaseController{

  public function inbox(){

    if(session()->has('id')){
      // query chats
      $pharmacyId = $this->session->get("pharmacy_id");
      $rawMyMessages = $this->chatModel->where('PHARMACY_ID', $pharmacyId)->findAll();
      $myMessages = [];
      foreach ($rawMyMessages as $key => $value) {
        $chatId = $value['ID'];
        $patientId = $value['PATIENT_ID'];

        $patientData = $this->patientModel->find($patientId);

        $messageData = [
          'CHAT_ID' => $chatId,
          'PATIENT_DATA' => $patientData,
        ];

        array_push($myMessages, $messageData);
      }
      $data = [
        'myMessages' => $myMessages,
        'chatLines' => [],
        'convoId' => NULL,
      ];
      echo view ("Pharmacy/template/header");
      echo view("Pharmacy/pages/Inbox", $data);
      echo view ("Pharmacy/template/footer");
    }
    else{
      return redirect()->to('/');
    }

  }

  public function getConversation($convoId = false){
    header("Content-type:application\json");
    $data = [];
    if(session()->has('id') && $convoId){
      // query chats
      $pharmacyId = $this->session->get("pharmacy_id");
      $rawMyMessages = $this->chatModel->where('PHARMACY_ID', $pharmacyId)->findAll();
      $myMessages = [];
      foreach ($rawMyMessages as $key => $value) {
        $chatId = $value['ID'];
        $patientId = $value['PATIENT_ID'];

        $patientData = $this->patientModel->find($patientId);

        $messageData = [
          'CHAT_ID' => $chatId,
          'PATIENT_DATA' => $patientData,
        ];

        array_push($myMessages, $messageData);
      }

      $data = [
        'myMessages' => $myMessages,
        'convoId' => $convoId,
      ];

      echo view ("Pharmacy/template/header");
      echo view ("Pharmacy/pages/Inbox", $data);
      echo view ("Pharmacy/template/footer");
    }else{
      return redirect()->to('/inbox');
    }
  }

  public function sendMessage(){
    header("Content-type:application\json");
    $pharmacistId = $this->request->getPost("pharmacistId");
    $chatId = $this->request->getPost("chatId");
    $message = $this->request->getPost("message");

    $data = [
      'PHARMACIST_ID' => $pharmacistId,
      'CHATS_ID' => $chatId,
      'MESSAGE' => $message,
      'CREATED_AT' => $this->time->now()->toDateTimeString(),
    ];

    // check if message is not empty
    // else dont add in db
    if(!empty($message)){
      $this->chatLineModel->insert($data);
    }


    $response = [
      'data' => $data,
    ];

    return $this->setResponseFormat('json')->respond($response, 200);
  }

  public function getMessages($chatId = false){
    header("Content-type:application\json");
    $data = [];
    if($chatId){
      $chat = $this->chatModel->find($chatId);
      $patientData = $this->patientModel->find($chat['PATIENT_ID']);
      // query chat lines
      $rawChatLines = $this->chatLineModel->where("CHATS_ID", $chatId)
                                          ->orderBy("ID","ASC")
                                          ->findAll();
      $chatLines = [];
      foreach ($rawChatLines as $key => $value) {
        $id = $value['ID'];
        $message = $value['MESSAGE'];
        $createdAt = $value['CREATED_AT'];
        $isImage = false;
        $pharmacistData = $this->pharmacistModel->find($value['PHARMACIST_ID']);

        if($message == "<image>"){
          $getImage = $this->imageFileModel->where("CHAT_LINES_ID",$id)->first();
          if(!empty($getImage)){
            $imagePath = $getImage['INTERNAL_PATH'];
            $imageName = $getImage['NAME'];
            $message = "<a href='$imagePath' target='_blank'><img class='w-100' src='{$imagePath}' alt='{$imageName}'></a>";
            $isImage = true;
          }
        }

        $chatData = [
          'ID' => $id,
          'MESSAGE' => $message,
          'SENDER' => (empty($value['PHARMACIST_ID']))? $patientData: $pharmacistData,
          'IS_PHARMACIST' => (empty($value['PHARMACIST_ID']))? FALSE:TRUE,
          'IS_IMAGE' => $isImage,
          'CREATED_AT' => $createdAt,
        ];

        array_push($chatLines, $chatData);
      }

      return $this->setResponseFormat('json')->respond($chatLines, 200);
    }
    $response = ['response' => 'bad request'];
    return $this->setResponseFormat('json')->respond($response, 501);
  }

  public function uploadImage(){
    header("Content-type:application/json");

    $pharmacistId = $this->request->getPost("pharmacistId");
    $image = $this->request->getFile('photo');
    $chatId = $this->request->getPost("chatId");


    $createdAt = $this->time->now()->toDateTimeString();

    // create new chat line
    $newChatLine = [
      'CHATS_ID' => $chatId,
      'MESSAGE' => "<image>",
      'CREATED_AT' => $createdAt,
      'PHARMACIST_ID' => $pharmacistId,
    ];

   $this->chatLineModel->insert($newChatLine);

   // get new chat line id
   $newChatLineId = $this->chatLineModel->insertID;

   // save image
   $this->savedImage($image, $newChatLineId);

    $data = [
      "data" => $newChatLine,
    ];
    return $this->setResponseFormat('json')->respond($data, 200);
  }

  private function savedImage($image, $chatLineId){
    // generate random name
    $generatedName = $image->getRandomName();
    $internalPath = FCPATH.'uploads/ChatFiles/';

    // development
    if(ENVIRONMENT == "development"){
      $base_url = "http://192.168.254.103:9093";
      // $base_url = "http://192.168.1.15:9091";
      $externalPath = $base_url."/uploads/ChatFiles/".$generatedName;
    }else{
      $externalPath = base_url()."/uploads/ChatFiles/".$generatedName;
    }
    // compress the image
    $compressImage = \Config\Services::image()->withFile($image)
                                              ->resize(700, 700, true, 'height')
                                              ->save($internalPath.$generatedName);



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
