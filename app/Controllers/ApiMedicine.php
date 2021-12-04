<?php
namespace App\Controllers;


class ApiMedicine extends BaseController{
  public function GetAll(){
    header("Content-type:application/json");

    $raw = $this->medicineModel->findAll();
    $medList = [];
    // traverse each medicine
    foreach ($raw as $key => $medicine) {

      // medicine info
      $medId = $medicine['ID'];
      $medBrandName = $medicine['BRAND_NAME'];
      $medDosage = $medicine['DOSAGE'];
      $medUsage = $medicine['USAGE'];
      $medCategories = ($medicine['CATEGORIES'] == 0)? "Rx" : "Non-Rx";

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


      array_push($medList, $medicineData);
    }

    return $this->setResponseFormat('json')->respond($medList, 201);
  }

  public function FilterMedicine(){
    header("Content-type:application/json");

    $filterGeneralClassification = $this->request->getGet("GeneralClassification[]");
    $filterMedicineForm = $this->request->getGet("MedicineForm[]");

    $filterGeneralClassificationIds = [];
    // get each classification id in the list
    if(!empty($filterGeneralClassification)){
      foreach ($filterGeneralClassification as $key => $value) {
        $generalClassificationData = $this->generalClassificationModel->where("NAME", $value)->first();
        array_push($filterGeneralClassificationIds, $generalClassificationData["ID"]);
      }
    }


    $filterMedicineFormIds = [];
    if(!empty($filterMedicineForm)){
      foreach ($filterMedicineForm as $key => $value) {
        $medicineFormData = $this->medicineFormModel->where("NAME", $value)->first();
        array_push($filterMedicineFormIds, $medicineFormData["ID"]);
      }
    }


    // query builder
    $builder = $this->queryBuilder->table("drug_classification");
    $builder->select("`medicine`.`ID` as `medicineId`");
    $builder->join("`classification`","`classification`.`DRUG_CLASSIFICATION_ID` = `drug_classification`.`ID`","inner");
    $builder->join("`medicine`","`medicine`.`ID` = `classification`.`MEDICINE_ID`","inner");
    $builder->join("`medicine_form`","`medicine`.`FORM` = `medicine_form`.`ID`","inner");

    if(!empty($filterGeneralClassificationIds)){
      $builder->whereIn("`drug_classification`.`GENERAL_CLASSIFICATION_ID`", $filterGeneralClassificationIds);
    }
    if(!empty($filterMedicineFormIds)){
      $builder->whereIn("`medicine_form`.`ID`", $filterMedicineFormIds);
    }

    $builder->distinct();
    $query = $builder->get();

    $filterResult = [];

    foreach ($query->getResult('array') as $key => $value) {
      $medId = $value["medicineId"];
      $medicineData = $this->medicineModel->find($medId);

      $medBrandName = $medicineData['BRAND_NAME'];
      $medDosage = $medicineData['DOSAGE'];
      $medUsage = $medicineData['USAGE'];
      $medCategories = ($medicineData['CATEGORIES'] == 0)? "Rx" : "Non-Rx";

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
      $medForm = $this->medicineFormModel->find($medicineData['FORM']);

      $result = [
        'id' => $medId,
        'brandName' => $medBrandName,
        'dosage' => $medDosage,
        'form' => $medForm['NAME'],
        'usage' => $medUsage,
        'category' => $medCategories,
        'genericNames' => $medGenericNames,
        'medicineClassification' => $medClassification,
      ];

      array_push($filterResult, $result);
    }

    // $data = [
    //   'res' => $filterMedicineForm
    // ];
    return $this->setResponseFormat('json')->respond($filterResult, 200);
  }

  public function GetGeneralClassification(){
    header("Content-type:application/json");

    $generalClassification = $this->generalClassificationModel->findAll();

    // $data = [];

    return $this->setResponseFormat('json')->respond($generalClassification, 200);
  }

  public function GetMedicineForm(){
    header("Content-type:application/json");

    $data = $this->medicineFormModel->findAll();

    return $this->setResponseFormat('json')->respond($data, 200);
  }

  public function GetAveragePrice(){
    header("Content-type:application/json");
    $medId = $this->request->getPost("medicineId");

    $builder = $this->queryBuilder->table("pharma_inventory");
    $builder->selectAvg('`RETAIL_PRICE`');
    $builder->where("MEDICINE_ID", $medId);
    $query = $builder->get();

    $result = $query->getResult("array");
    $data = [
      'AvgPrice' => (float)$result[0]["RETAIL_PRICE"],
    ];

    return $this->setResponseFormat('json')->respond($data, 200);
  }

  public function GetPharmacies(){
    header("Content-type:application/json");
    $medId = $this->request->getPost("medicineId");

    $builder = $this->queryBuilder->table("pharma_inventory");
    $builder->select("`pharma_inventory`.`ID` as `invID`,
                      `pharma_inventory`.`PHARMACY_ID` as `pharmaId`,
                      `pharma_inventory`.`IS_STOCK` as `isStock`,
                      `pharma_inventory`.`RETAIL_PRICE` as `price`
                    ");
    $builder->where("MEDICINE_ID", $medId);
    $query = $builder->get();

    $result = [];
    // get pharmacies detail
    foreach ($query->getResult("array") as $key => $value) {
      $pharmacyData = [];
      $pharmacyRawData = $this->pharmacyModel->find($value["pharmaId"]);
      $pharmacyData["id"] = $pharmacyRawData["ID"];
      $pharmacyData["name"] = $pharmacyRawData["NAME"];
      $pharmacyData["lat"] = $pharmacyRawData["LAT"];
      $pharmacyData["lng"] = $pharmacyRawData["LNG"];
      $pharmacyData["address"] = $pharmacyRawData["ADDRESS"];

      // get contact details
      $contact = $this->contactModel->where("PHARMACY_ID", $pharmacyData["id"])->findAll();
      $contactDetailList = [];


        foreach ($contact as $key => $contactValue) {
          $contactDetail = $this->contactDetailsModel->where("CONTACT_ID", $contactValue["ID"])->first();

          if($contactDetail['TYPE'] == 1){
            $type = "EMAIL";
          }else if($contactDetail['TYPE'] == 2){
            $type = "MOBILE";
          }else if($contactDetail['TYPE'] == 3){
            $type = "TELEPHONE";
          }

          $contactDetailData = [
            'ID' => $contactDetail['ID'],
            'CONTACT_ID' => $contactDetail['CONTACT_ID'],
            'TYPE' => $type,
            'DETAIL' => $contactDetail['DETAIL'],
            'CREATED_AT' => $contactDetail['CREATED_AT'],
            'UPDATE_AT' => $contactDetail['UPDATE_AT'],
          ];

          array_push($contactDetailList, $contactDetailData);
        }

      $pharmacyData["contactDetail"] = $contactDetailList;

      $info = [
        'pharmacy' => $pharmacyData,
        'isStock' => ($value["isStock"] == 1)? true:false,
        'price' => (float)$value["price"],
      ];

      // add pharmacy to the result
      array_push($result, $info);
    }

    return $this->setResponseFormat('json')->respond($result, 200);
  }

  public function AddTrendMedicine(){
    header("Content-type:application/json");
    $medicineId = $this->request->getPost("medicineId");

    $time = $this->time->now()->toDateTimeString();

    $newData = [
      'DATE' => $time,
      'MEDICINE_ID' => $medicineId,
    ];

    $this->medicineTrendModel->insert($newData);

    $data = [
      "response" => "OK",
    ];
    return $this->setResponseFormat('json')->respond($data, 200);
  }
}
 ?>
