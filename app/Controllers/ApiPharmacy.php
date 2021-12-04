<?php
namespace App\Controllers;


class ApiPharmacy extends BaseController{
  public function GetAll(){
    header("Content-type:application/json");

    $raw = $this->pharmacyModel->findAll();
    $data =[];

    foreach ($raw as $key => $value) {
      // display only verified pharmacies in the mobile
      if($value['IS_VERIFIED'] == 1){
        $pharmaInfo = $this->FormatPharmacy(
          $value['ID'],
          $value['NAME'],
          $value['ADDRESS'],
          $value['LAT'],
          $value['LNG'],
        );

        // add new info to the array list
        array_push($data, $pharmaInfo);
      }

    }

    return $this->setResponseFormat('json')->respond($data, 201);
  }

  private function FormatPharmacy($id, $name, $address, $lat, $lng){
    $format = [];
    $format['id'] = $id;
    $format['name'] = $name;
    $format['lat'] = $lat;
    $format['lng'] = $lng;
    $format['address'] = $address;

    $contact = $this->contactModel->where("PHARMACY_ID", $id)->findAll();
    $contactDetailList = [];
    if(!empty($contact)){
      foreach ($contact as $key => $value) {
        $contactDetail = $this->contactDetailsModel->where("CONTACT_ID", $value["ID"])->first();

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
    }
    $format["contactDetail"] = $contactDetailList;

    return $format;
  }

  public function GetInventory(){
      header("Content-type:application/json");
      $pharmaId = $this->request->getPost("pharmaId");

      $builder = $this->queryBuilder->table("pharma_inventory");
      $builder->select("`pharma_inventory`.`ID` as `invId`,
                        `medicine`.`ID` as `medId`,
                        `pharma_inventory`.`RETAIL_PRICE` as `price`,
                        `pharma_inventory`.`IS_STOCK` as `is_stock`
                        ");
      $builder->join("`medicine`","`medicine`.`ID` = `pharma_inventory`.`MEDICINE_ID`","INNER");
      $builder->where("`pharma_inventory`.`PHARMACY_ID`",$pharmaId);
      $query = $builder->get();

      $inventory = [];
      // return $this->setResponseFormat('json')->respond($query->getResult('array'), 200);

      foreach ($query->getResult('array') as $key => $value) {
        $medId = $value["medId"];
        $invId = $value["invId"];
        $isStock = $value["is_stock"];
        $price = $value["price"];

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

        $drugData = [
          'id' => $medId,
          'brandName' => $medBrandName,
          'dosage' => $medDosage,
          'form' => $medForm['NAME'],
          'usage' => $medUsage,
          'category' => $medCategories,
          'genericNames' => $medGenericNames,
          'medicineClassification' => $medClassification,
        ];

        $result = [
          'id' => $invId,
          'medicine' => $drugData,
          'isStock' => (int)$isStock,
          'price' => (float)$price,
        ];

        array_push($inventory, $result);
      }
      return $this->setResponseFormat('json')->respond($inventory, 200);
  }
}
 ?>
