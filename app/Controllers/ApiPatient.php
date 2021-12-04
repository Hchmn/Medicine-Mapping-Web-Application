<?php
namespace App\Controllers;


class ApiPatient extends BaseController{
  public function GetUserCredentials(){
      header("Content-type:application/json");
      $userContactNo = $this->request->getPost("phoneNumber");
      $data = $this->patientModel->where("CONTACT_NO", $userContactNo)->first();


      return $this->setResponseFormat('json')->respond($data, 200);
  }

  public function CreateNewPatient(){
    header("Content-type:application/json");
    $firstName = $this->request->getPost("firstName");
    $lastName = $this->request->getPost("lastName");
    $phoneNumber = $this->request->getPost("phoneNumber");
    // check if user phone number is already registerd.
    $findUser = $this->patientModel->where("CONTACT_NO", $phoneNumber)->first();
    if($findUser){
      $data = [
        "reasonPhrase" => "Phone number already exist.",
        "statusCode" => "400",
      ];
      return $this->setResponseFormat('json')->respond($data, 400);
    }

    $newUserData = [
        'FIRST_NAME' => $firstName,
        'LAST_NAME' => $lastName,
        'CONTACT_NO' => $phoneNumber,
        'CREATED_AT' => $this->time->now()->toDateTimeString(),
    ];

    $this->patientModel->insert($newUserData);

    $data = [
      "reasonPhrase" => "successfully added.",
      "statusCode" => "200",
    ];

    return $this->setResponseFormat('json')->respond($data, 200);
  }

  public function GetConversation(){
    header("Content-type:application/json");

    $phoneNumber = $this->request->getPost("phoneNumber");
    $pharmacyId = $this->request->getPost("pharmacyId");
    log_message("debug","phoneNumber: $phoneNumber pharmaId: $pharmacyId");
    // get user
    $user = $this->patientModel->where("CONTACT_NO", $phoneNumber)->first();

    if(empty($user)){
      log_message("debug", "User empty.");
      $data = [
        'status' => "User does not exist.",
      ];
      return $this->setResponseFormat('json')->respond($data, 200);
    }
    $userId = $user["ID"];
    log_message("debug", "User: $userId");

    // get pharmacy
    $pharmacy = $this->pharmacyModel->find($pharmacyId);

    if(empty($pharmacy)){
      log_message("debug", "Pharmacy Empty");
      $data = [
        'status' => "Pharmacy does not exist.",
      ];
      return $this->setResponseFormat('json')->respond($data, 200);
    }
    log_message("debug", "Pharmacy: $pharmacyId");

    $chat = $this->chatModel->where("PATIENT_ID",$userId)
                            ->where("PHARMACY_ID", $pharmacyId)
                            ->first();
    if(!empty($chat)){
      log_message("debug", "Chat: ".implode(" , ",$chat));
    }

    if(empty($chat)){
      log_message("debug", "Creating conversation");
      $newConvo = [
        'PATIENT_ID' => $userId,
        'PHARMACY_ID' => $pharmacyId,
        'CREATED_AT' => $this->time->now()->toDateTimeString(),
      ];
      $this->chatModel->insert($newConvo);
      $chatId = $this->chatModel->insertID;
      log_message("debug", "[Done] ChatId: $chatId");
    }
    else{
      $chatId = $chat["ID"];
      log_message("debug", "ChatId: $chatId");
    }

    $chatLines = $this->chatLineModel->where("CHATS_ID", $chatId)->findAll();
    log_message("debug", "ChatLines: ".count($chatLines));
    $convo = [];

    foreach ($chatLines as $key => $value) {
      log_message("debug", "ChatLines: ".implode(",",$value));

      if(!empty($value["PHARMACIST_ID"])){
        $pharmacist = $this->pharmacistModel->find($value["PHARMACIST_ID"]);
        log_message("debug", "Pharmacist: ".implode(" , ",$pharmacist));
        $from = $pharmacist["FIRST_NAME"]." ".$pharmacist["LAST_NAME"];
      }else{
        $from = "me";
      }

      if($value["MESSAGE"] == "<image>"){
        // check if their is attach image in files
        $uploadImage = $this->imageFileModel->where("CHAT_LINES_ID", $value["ID"])->first();
        if(!empty($uploadImage)){
          // log_message("critical",implode(" , ", $uploadImage));
          $imgNetworkPath = $uploadImage["INTERNAL_PATH"];
          $message = $imgNetworkPath;
        }else{
          $message = "<image>";
        }
      }else{
        $message =  $value["MESSAGE"];
      }
      $message = [
        "chatLineId" => $value["ID"],
        "chatId" => $value["CHATS_ID"],
        "message" => $message,
        "from" => $from,
        "createdAt" => $value["CREATED_AT"],
      ];
      array_push($convo, $message);
    }

    $data = [
      'chatId' => $chatId,
      'convo' => $convo,
      'status' => "OK",
    ];
    return $this->setResponseFormat('json')->respond($data, 200);
  }
}
 ?>
