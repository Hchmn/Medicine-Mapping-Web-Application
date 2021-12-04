<?php
namespace App\Controllers;

/*
   header("Content-type:application/json");
   return $this->setResponseFormat('json')->respond($response, 200);
*/

class AdminController extends BaseController{

  public function index(){
    // delete session if in login
    if($this->session->has("adminId")){
      $this->session->remove("adminId");
      $this->session->remove("adminUsername");
    }

    $data = [
      'pageTitle' => "Admin | Login",
    ];
    echo view("admin/header.php",$data);
    echo view("admin/body/index.php");
    echo view("admin/footer.php");
  }

  public function dashboard(){
    $data = [
      'pageTitle' => "Admin | Dashboard",
    ];

    if($this->session->has("adminId")){
      $data['username'] = $this->session->get("adminUsername");
      echo view("admin/header.php",$data);
      echo view("admin/body/dashboard.php", $data);
      echo view("admin/footer.php");
    }else{
      return redirect()->to("/login");
    }
  }

  // medicine
  public function medicine(){
    // query all medicine
    $medicines = $this->getAllMedicines();
    // get all form data
    $allForms = $this->medicineFormModel->findAll();
    // get all generic names
    $allGenericNames = $this->genericNameModel->findAll();
    // get all drug classification
    $allDrugClassification = $this->drugClassificationModel->findAll();

    $data = [
      'pageTitle' => "Admin | Medicine",
      'medicines' => $medicines,
      'allForms' => $allForms,
      'allGenericNames' => $allGenericNames,
      'allDrugClassification' => $allDrugClassification,
    ];

    if($this->session->has("adminId")){
      $data['username'] = $this->session->get("adminUsername");
      $data['addStatus'] = $this->session->getFlashdata('newMedicineDataStatus');
      echo view("admin/header.php",$data);
      echo view("admin/body/medicine.php", $data);
      echo view("admin/footer.php");
    }else{
      return redirect()->to("/login");
    }
  }

  public function viewMedicine($id = false){

    if($id == false){
      return redirect()->to("/admin/medicine");
    }

    $rawData = $this->medicineModel->find($id);
    $medicineData = [
      'id' => $rawData['ID'],
      'brandName' => $rawData['BRAND_NAME'],
      'dosage' => (empty($rawData['DOSAGE']))? "None":$rawData['DOSAGE'],
      'usage' => $rawData['USAGE'],
    ];

    $rawClassification = $this->medicineClassificationModel->where("MEDICINE_ID", $id)->findAll();
    $classification = [];

    // get all medicine classification w/ general class
    foreach ($rawClassification as $key => $value) {
      $drugClassificationId = $value['DRUG_CLASSIFICATION_ID'];

      $rawDrugClassification = $this->drugClassificationModel->find($drugClassificationId);

      $rawGeneralClassification = $this->generalClassificationModel->find($rawDrugClassification['GENERAL_CLASSIFICATION_ID']);

      $class = [
        'drugClassId' => $drugClassificationId,
        'drugClassName' => $rawDrugClassification['NAME'],
        'genClassId' => $rawGeneralClassification['ID'],
        'genClassName' => $rawGeneralClassification['NAME'],
      ];

      array_push($classification, $class);
    }
    // add classification
    $medicineData['classification'] = $classification;

    // get generic name
    $rawGenericNames = $this->medicineGenericNameModel->where("MEDICINE_ID", $id)->findAll();
    $genericNames = [];

    foreach ($rawGenericNames as $key => $value) {
      $genericName = $this->genericNameModel->find($value['GENERIC_NAMES_ID']);
      $genericData = [
        'id' => $genericName['ID'],
        'name' => $genericName['NAME'],
      ];
      array_push($genericNames, $genericData);
    }

    $medicineData['genericNames'] = $genericNames;

    $form = $this->medicineFormModel->find($rawData['FORM']);

    $medicineData['form'] = $form['NAME'];

    $medicineData['category'] = ($rawData['CATEGORIES'] == 1)? "Rx":"Non-Rx";

    // get all form data
    $allForms = $this->medicineFormModel->findAll();
    // get all generic names
    $allGenericNames = $this->genericNameModel->findAll();
    // get all drug classification
    $allDrugClassification = $this->drugClassificationModel->findAll();


    $data = [
      'pageTitle' => "Admin | Medicine",
      'info' => $medicineData,
      'allForms' => $allForms,
      'allGenericNames' => $allGenericNames,
      'allDrugClassification' => $allDrugClassification,
    ];

    if($this->session->has("adminId")){
      $data['username'] = $this->session->get("adminUsername");
      $data['updateStatus'] = $this->session->getFlashdata('updateStatus');
      echo view("admin/header.php",$data);
      echo view("admin/body/viewMedicine.php", $data);
      echo view("admin/footer.php");
    }else{
      return redirect()->to("/login");
    }
  }

  public function updateMedicine(){
    header("Content-type:application/json");
    $id = $this->request->getPost("id");
    $brandName = $this->request->getPost("brandName");
    $dosage = $this->request->getPost("dosage");
    $form = $this->request->getPost("form");
    $genericNames = $this->request->getPost("genericNames[]");
    $classification = $this->request->getPost("classification[]");
    $category = $this->request->getPost("category");
    $usage = $this->request->getPost("usage");

    // update medicine
    $updateMedicineInfo = [
      'BRAND_NAME' => $brandName,
      'DOSAGE' => $dosage,
      'FORM' => $form,
      'CATEGORIES' => $category,
      'USAGE' => $usage,
    ];

    $this->medicineModel->update($id, $updateMedicineInfo);
    // logs

    // update generic names
    $newGenericNamesList = [];

    foreach ($genericNames as $key => $value) {
      if($value != "None"){
        array_push($newGenericNamesList, $value);
      }
    }

    // delete existing data of the medicine in generic names
    $this->medicineGenericNameModel->where("MEDICINE_ID", $id)->delete();

    // add new generic names for the medicine
    foreach ($newGenericNamesList as $key => $value) {
      $data = [
        'GENERIC_NAMES_ID' => $value,
        'MEDICINE_ID' => $id,
      ];

      $this->medicineGenericNameModel->insert($data);
    }

    // update classification
    $newClassification = [];

    foreach ($classification as $key => $value) {
      if($value != "None"){
        array_push($newClassification, $value);
      }
    }
    // delete existing data of the drug classification
    $this->medicineClassificationModel->where("MEDICINE_ID",$id)->delete();

    // add new classifications
    foreach ($newClassification as $key => $value) {
      $data = [
        'DRUG_CLASSIFICATION_ID' => $value,
        'MEDICINE_ID' => $id,
      ];

      $this->medicineClassificationModel->insert($data);
    }
    $this->session->setFlashdata('updateStatus', true);

    $description = "Update medicine ID#$id.";
    $time = $this->time->now()->toDateTimeString();
    $this->addLog($description, $time);

    $response = [
      'response' => $newClassification,
    ];

    return $this->setResponseFormat('json')->respond($response, 200);
  }

  public function addMedicine(){
    header("Content-type:application/json");
    $brandName = $this->request->getPost("brandName");
    $dosage = $this->request->getPost("dosage");
    $form = $this->request->getPost("form");
    $genericNames = $this->request->getPost("genericNames[]");
    $classification = $this->request->getPost("classification[]");
    $category = $this->request->getPost("category");
    $usage = $this->request->getPost("usage");

    // add new medicine
    $newMedicine = [
      'BRAND_NAME' => $brandName,
      'DOSAGE' => $dosage,
      'FORM' => $form,
      'USAGE' => $usage,
      'CATEGORIES' => $category,
    ];

    $this->medicineModel->insert($newMedicine);
    // retrieve newly inserted data ID.
    $newMedicineId = $this->medicineModel->insertID;

    // insert generic names
    foreach ($genericNames as $key => $value) {
      if(!empty($value)){
        $genericNamesData = [
          'GENERIC_NAMES_ID' => $value,
          'MEDICINE_ID' => $newMedicineId,
        ];
        $this->medicineGenericNameModel->insert($genericNamesData);
      }
    }

    // insert classification
    foreach ($classification as $key => $value) {
      if(!empty($value)){
        $classification = [
          'DRUG_CLASSIFICATION_ID' => $value,
          'MEDICINE_ID' => $newMedicineId,
        ];
        $this->medicineClassificationModel->insert($classification);
      }
    }

    // logs
    $description = "Added new medicine {ID#$newMedicineId, BRAND_NAME: $brandName}.";
    $time = $this->time->now()->toDateTimeString();
    $this->addLog($description, $time);

    $this->session->setFlashdata('newMedicineDataStatus', $description);

    $data = [
      'BRAND_NAME'=> $brandName,
      'DOSAGE' => $dosage,
      'FORM' => $form,
      'USAGE' => $usage,
      'CATEGORIES' => $category,
      'GENERIC_NAME' => $genericNames,
      'CLASSIFICATION' => $classification,
    ];

    $response = [
      'response' => "OK",
      'data' => $data,
    ];
    return $this->setResponseFormat('json')->respond($response, 200);
  }

  // form
  public function medicineForm(){
    // get all form
    // get all form data
    $allForms = $this->medicineFormModel->findAll();

    $data = [
      'pageTitle' => "Admin | Form",
      'forms' => $allForms,
    ];

    if($this->session->has("adminId")){
      $data['username'] = $this->session->get("adminUsername");
      $data['status'] = $this->session->getFlashData("status");
      echo view("admin/header.php",$data);
      echo view("admin/body/medicineForm.php", $data);
      echo view("admin/footer.php");
    }else{
      return redirect()->to("/login");
    }
  }

  public function addMedicineForm(){
    header("Content-type:application/json");
    $name = $this->request->getPost("name");

    $data = [
      'NAME' => $name,
    ];

    $this->medicineFormModel->insert($data);
    $newId = $this->medicineFormModel->insertID;

    // logs
    $description = "Added new medicine form {ID#$newId, NAME: $name}.";
    $time = $this->time->now()->toDateTimeString();
    $this->addLog($description, $time);

    $this->session->setFlashdata('status', $description);

    $response = [
      'response' => "OK",
      'data' => $name,
    ];

    return $this->setResponseFormat('json')->respond($response, 200);
  }

  // drug classification
  public function drugClassification(){
    // get all classification data
    $builder = $this->queryBuilder->table("drug_classification");
    $builder->select("`drug_classification`.`ID` as `DRUG_CLASSIFICATION_ID`,
                      `drug_classification`.`NAME` as `DRUG_CLASSIFICATION_NAME`,
                      `general_classification`.`ID` as `GENERAL_CLASSIFICATION_ID`,
                      `general_classification`.`NAME` as `GENERAL_CLASSIFICATION_NAME`");
    $builder->join("`general_classification`","`drug_classification`.`GENERAL_CLASSIFICATION_ID` = `general_classification`.`ID`","LEFT");
    $query = $builder->get();

    $allClass = $query->getResult("array");

    $data = [
      'pageTitle' => "Admin | Form",
      'classifications' => $allClass,
    ];

    if($this->session->has("adminId")){
      $data['username'] = $this->session->get("adminUsername");
      $data['status'] = $this->session->getFlashData("status");
      echo view("admin/header.php",$data);
      echo view("admin/body/drugClassification.php", $data);
      echo view("admin/footer.php");
    }else{
      return redirect()->to("/login");
    }
  }

  public function addDrugClassification(){
    header("Content-type:application/json");
    $name = $this->request->getPost("name");
    $genClass = $this->request->getPost("generalClassification");

    $data = [
      'NAME' => $name,
      'GENERAL_CLASSIFICATION_ID' => $genClass,
    ];

    // insert
    $this->drugClassificationModel->insert($data);
    $newId = $this->drugClassificationModel->insertID;

    // logs
    $description = "Added new drug classification {ID#$newId, NAME: $name}.";
    $time = $this->time->now()->toDateTimeString();
    $this->addLog($description, $time);
    $this->session->setFlashdata('status', $description);

    $response = [
      'response' => "OK",
      'data' => $data,
    ];

    return $this->setResponseFormat('json')->respond($response, 200);
  }


  // pharmacy
  public function pharmacy(){
    $verifiedPharmacy = $this->getAllVerifiedPharmacy();
    $data = [
      'pageTitle' => "Admin | Pharmacy",
      'verifiedPharmacy' => $verifiedPharmacy,
    ];

    if($this->session->has("adminId")){
      $data['username'] = $this->session->get("adminUsername");
      echo view("admin/header.php",$data);
      echo view("admin/body/pharmacy.php", $data);
      echo view("admin/footer.php");
    }else{
      return redirect()->to("/login");
    }
  }

  public function viewPharmacy($id = false){
    if($id == false){
      return redirect()->to("/admin/pharmacy");
    }
    // query pharmacy informations
    $pharmacy = $this->pharmacyModel->find($id);

    // get pharacy contact details
    $contact = $this->contactModel->where("PHARMACY_ID", $id)->findAll();

    $pharmacyContactInfo = [];
    foreach ($contact as $key => $value) {
      $contactDetail = $this->contactDetailsModel->where("CONTACT_ID", $value['ID'])->first();
      array_push($pharmacyContactInfo, $contactDetail);
    }

    // get pharamcist
    $rawPharmacist = $this->pharmacistModel->where("PHARMACY_ID", $id)->findAll();
    $pharmacist = [];
    foreach ($rawPharmacist as $key => $value) {
      // get pharmacist contact details
      $pharmacistContact = $this->contactModel->where("PHARMACIST_ID", $value['ID'])->findAll();
      $pharmacistContactInfo = [];

      foreach ($pharmacistContact as $key => $v) {
        $pharmacistContactDetail = $this->contactDetailsModel->where("CONTACT_ID", $v['ID'])->first();
        array_push($pharmacistContactInfo, $pharmacistContactDetail);
      }
      // map pharmacist data
      $pharmacistData = [
        'ID' => $value['ID'],
        'FIRST_NAME' => $value['FIRST_NAME'],
        'LAST_NAME' => $value['LAST_NAME'],
        'ADDRESS' => $value['ADDRESS'],
        'USERNAME' => $value['USERNAME'],
        'PASSWORD' => $value['PASSWORD'],
        'CONTACT_INFO' => $pharmacistContactInfo,
        'IS_ACTIVE' => $value['IS_ACTIVE'],
      ];

      array_push($pharmacist, $pharmacistData);
    }

    // get submitted files
    $files = $this->pharmacyDocumentsModel->where("PHARMACY_ID", $id)->findAll();

    // map data
    $data = [
      'pageTitle' => "Admin | Pharmacy",
      'pharmacy' => $pharmacy,
      'contactInfo' => $pharmacyContactInfo,
      'pharmacist' => $pharmacist,
      'documents' => $files,
    ];

    if($this->session->has("adminId")){
      $data['username'] = $this->session->get("adminUsername");
      echo view("admin/header.php",$data);
      echo view("admin/body/viewPharmacy.php", $data);
      echo view("admin/footer.php");
    }else{
      return redirect()->to("/login");
    }
  }

  public function toVerifyPharmacy(){
    $notVerifiedPharmacy = $this->pharmacyModel->where("IS_VERIFIED", 0)->findAll();
    $data = [
      'pageTitle' => "Admin | Pharmacy",
      'notVerifiedPharmacy' => $notVerifiedPharmacy,
    ];

    if($this->session->has("adminId")){
      $data['username'] = $this->session->get("adminUsername");
      echo view("admin/header.php",$data);
      echo view("admin/body/toVerify.php", $data);
      echo view("admin/footer.php");
    }else{
      return redirect()->to("/login");
    }
  }

  public function verifyPharmacy(){
    header("Content-type:application/json");
    $pharmacyId = $this->request->getPost("pharmacyId");
    $adminUsername = $this->session->get("adminUsername");

    $pharmacy = $this->pharmacyModel->find($pharmacyId);

    $pharmacyName = $pharmacy['NAME'];
    // update pharmacy
    $this->pharmacyModel->where("ID", $pharmacyId)->set('IS_VERIFIED', 1)->update();
    // logs
    $description = "$adminUsername verified $pharmacyName";
    $time = $this->time->now()->toDateTimeString();
    $this->addLog($description, $time);
    // update pharmacist
    $pharmacist = $this->pharmacistModel->where("PHARMACY_ID", $pharmacyId)->first();

    // generate username and password
    $randomNumber = rand(100,9999);
    $username = $pharmacist['FIRST_NAME'].".".$pharmacist['LAST_NAME'].$randomNumber;
    $password = $this->randomPassword();
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);
    // update pharmacist
    $newData = [
      'USERNAME' => $username,
      'PASSWORD' => $hashPassword,
    ];

    $this->pharmacistModel->update($pharmacist['ID'],$newData);

    $pharmacistContact = $this->contactModel->where("PHARMACIST_ID", $pharmacist['ID'])->first();



    $pharmacistContactDetail = $this->contactDetailsModel->where("CONTACT_ID", $pharmacistContact['ID'])->where("TYPE", 1)->first();

    // send email
    $fromEmail = "developers@med-mapping.com";
    $fromName = "Med-mapping developers";
    $toEmail = $pharmacistContactDetail["DETAIL"];
    $toName = $pharmacist['FIRST_NAME']." ".$pharmacist['LAST_NAME'];
    $subject = "Login credentials";

    $message = "<div style=\"width:100%; height:50px; background-color: rgb(66, 136, 255);text-align:center;font-size:30px;font-weight:bold;color:white;\">";
    $message .= "<span>Medicine Mapping</span>";
    $message .= "</div><p>Hi! Here is your login credentials</p><br>";
    $message .= "<div style=\"padding-left:20px;\"><p>Username: <span style=\"font-weight:bold;\">$username</span></p>";
    $message .= "<p>Password: <span style=\"font-weight:bold;\">$password</span></p></div><br>";
    $message .= "<p>This is a system generated credentials we highly recommend to change it in your own preference in settings.</p>";
    $message .= "<p>For any concern just <a href=\"mailto:$fromEmail\">EMAIL US</a></p>";

    $this->sendEmail(
        $fromEmail,
        $fromName,
        $toEmail,
        $toName,
        $subject,
        $message
        );

    // logs
    $description = "System generate username and password for ".
                    $pharmacist['LAST_NAME'].", ".$pharmacist['FIRST_NAME'];
    $time = $this->time->now()->toDateTimeString();
    $this->addLog($description, $time);

    $data = [
      'response' => 'OK',
    ];
    return $this->setResponseFormat('json')->respond($data, 200);
  }
  // activity log
  public function activityLog(){
    $builder = $this->queryBuilder->table("`admin_activity_log`");
    $builder->select("
    `admin_activity_log`.`ID` AS `LOG_ID`,
    `admin_activity_log`.`DESCRIPTION` AS `LOG_DESC`,
    `admin_activity_log`.`CREATED_AT` AS `CREATED_AT`,
    `admin`.`USERNAME` AS `ADMIN`
    ");
    $builder->join("`admin`","`admin_activity_log`.`ADMIN_ID` = `admin`.`ID`","LEFT");
    $builder->orderby("`LOG_ID`","DESC");
    $query = $builder->get();
    $activityLog = $query->getResult("array");
    $data = [
      'pageTitle' => "Admin | Logs",
      'logs' => $activityLog,
    ];
    if($this->session->has("adminId")){
      $data['username'] = $this->session->get("adminUsername");
      echo view("admin/header.php",$data);
      echo view("admin/body/activitylog.php", $data);
      echo view("admin/footer.php");
    }else{
      return redirect()->to("/login");
    }
  }

  private function randomPassword() {
    $passCharacters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890@#$%^&*()!_-';
    $pass = array(); //remember to declare $pass as an array
    $length = strlen($passCharacters) - 1; //put the length -1 in cache
    for ($i = 0; $i < 12; $i++) {
        $n = rand(0, $length);
        $pass[] = $passCharacters[$n];
    }
    return implode($pass); //turn the array into a string
  }

  // announcement
  public function announcement(){
    $data = [
      'pageTitle' => "Admin | Annoucement",
    ];
    if($this->session->has("adminId")){
      $data['username'] = $this->session->get("adminUsername");
      echo view("admin/header.php",$data);
      echo view("admin/body/announcement.php", $data);
      echo view("admin/footer.php");
    }else{
      return redirect()->to("/login");
    }
  }

  public function announcementArchive(){
    $announcements = $this->announcementModel->select("`app_announcement`.`ID` AS `ID`,
                                                       `app_announcement`.`CONTENT` AS `CONTENT`,
                                                       `app_announcement`.`TITLE` AS `TITLE`,
                                                       `app_announcement`.`CREATED_AT` AS `CREATED_AT`,
                                                       `app_announcement`.`ADMIN_ID` AS `ADMIN_ID`,
                                                       `admin`.`USERNAME` AS `USERNAME`")
                                             ->join("`admin`","`app_announcement`.`ADMIN_ID` = `admin`.`ID`")
                                             ->orderBy("`app_announcement`.`CREATED_AT` DESC")
                                             ->findAll();

    $data = [
      'pageTitle' => "Admin | Annoucement",
      'announcements' => $announcements,
    ];
    if($this->session->has("adminId")){
      $data['username'] = $this->session->get("adminUsername");
      echo view("admin/header.php",$data);
      echo view("admin/body/announcement_archive.php", $data);
      echo view("admin/footer.php");
    }else{
      return redirect()->to("/login");
    }
  }

  public function newAnnouncement(){
    header("Content-type:application/json");
    $title = $this->request->getPost("title");
    $content = $this->request->getPost("content");


    $time = $this->time->now()->toDateTimeString();
    $adminId = $this->session->get("adminId");

    $data = [
      'TITLE' => $title,
      'CONTENT' => $content,
      'CREATED_AT' => $time,
      'ADMIN_ID' => $adminId,
    ];

    $this->announcementModel->insert($data);

    // logs
    $description = "Make an announcement.";
    $this->addLog($description, $time);

    $response = [
      'data' => $data,
    ];
    return $this->setResponseFormat('json')->respond($response, 200);
  }

  // login
  public function verifyCredentials(){
    header("Content-type:application/json");
    $username = $this->request->getPost('username');
    $password = $this->request->getPost('password');

    // verify credentials
    $admin = $this->adminModel->where("username", $username)->first();

    $isValid = false;

    if(!empty($admin)){
      $hashPassword = $admin["PASSWORD"];
      $passwordVerify = password_verify($password,$hashPassword);
      $isValid = $passwordVerify;
    }

    if($isValid){
      $sessionKeys = [
        "adminId" => $admin['ID'],
        "adminUsername" => $admin['USERNAME'],
      ];

      // logs
      $description = "Admin {$username} has login";
      $time = $this->time->now()->toDateTimeString();
      $this->addLog($description, $time);

      $this->session->set($sessionKeys);
    }else{
      // logs
      $description = "Username:{$username} attempt to login";
      $time = $this->time->now()->toDateTimeString();
      $this->addLog($description, $time);
    }
    return $this->setResponseFormat('json')->respond($isValid, 200);
  }

  // queries
  private function getAllVerifiedPharmacy(){
    // get all verified pharmacy
    $verifiedPharmacy = $this->pharmacyModel->where("IS_VERIFIED", 1)->findAll();
    return $verifiedPharmacy;
  }

  private function getAllMedicines(){
    $rawData = $this->medicineModel->findAll();
    $medicines = [];
    // traverse each medicine
    foreach ($rawData as $key => $medicine) {

      // medicine info
      $medId = $medicine['ID'];
      $medBrandName = $medicine['BRAND_NAME'];
      $medDosage = $medicine['DOSAGE'];
      $medUsage = $medicine['USAGE'];
      $medCategories = ($medicine['CATEGORIES'] == 1)? "Rx" : "Non-Rx";

      // get medicine classification
      $rawClassification = $this->medicineClassificationModel->where("MEDICINE_ID", $medId)->findAll();

      $medClassification = [];

      foreach ($rawClassification as $key => $value) {
        // get classification name
        $classificationId = $value['DRUG_CLASSIFICATION_ID'];
        $classInfo = $this->drugClassificationModel->find($classificationId);

        $genClassInfo = $this->generalClassificationModel->find($classInfo['GENERAL_CLASSIFICATION_ID']);

        $classData = [
          'drugClassificationName' =>  $classInfo['NAME'],
          'generalClassificationName' => $genClassInfo['NAME'],
        ];

        array_push($medClassification, $classData);
      }

      // get medicine generic names
      $rawMedGenericNames = $this->medicineGenericNameModel->where("MEDICINE_ID", $medId)->findAll();
      $medGenericNames = [];
      foreach ($rawMedGenericNames as $key => $value) {

        $genericName = $this->genericNameModel->find($value['GENERIC_NAMES_ID']);

        $genericData = [
          'id' => $genericName['ID'],
          'name' => $genericName['NAME'],
        ];

        array_push($medGenericNames, $genericData);
      }

      // get form
      $medForm = $this->medicineFormModel->find($medicine['FORM']);

      $medicineData = [
        'id' => $medId,
        'brandName' => $medBrandName,
        'dosage' => $medDosage,
        'form' => $medForm['NAME'],
        'usage' => $medUsage,
        'category' => $medCategories,
        'genericNames' => $medGenericNames,
        'medicineClassification' => $medClassification,
      ];


      array_push($medicines, $medicineData);
    }
    return $medicines;
  }

  private function addLog($description, $time){
    if($this->session->has("adminId")){
        $adminId = $this->session->get("adminId");
    }else{
        $adminId = NULL;
    }

    $data = [
      'ADMIN_ID' => $adminId,
      'DESCRIPTION' => $description,
      'CREATED_AT' => $time,
    ];
    $this->adminActivityLogModel->insert($data);
  }
}
 ?>
