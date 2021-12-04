<?php
namespace App\Controllers;

class AddMedicine extends BaseController
{

  public function add_medicine(){
    helper(['form']);
    if($this->request->getMethod() == 'post'){
      $pharmacy_id = $this->request->getVar('pharmacy_id');
      $pharmacist_id = $this->request->getVar('pharmacist_id');
      $medicine_id = $this->request->getVar('medicine_id');
      $medicine_retaiL_price = $this->request->getVar('medicine_price');
    //   $availability = array('0','1  ');
    //   $is_stock =  $availability[mt_rand(0, sizeof($availability) - 1)];
      $now = date("Y-m-d H:i:s");

      $pharmacy_inventory_data = ['PHARMACY_ID' => $pharmacy_id,
                                  'MEDICINE_ID' => $medicine_id,
                                  'IS_STOCK' => 1,
                                  'RETAIL_PRICE' =>  $medicine_retaiL_price,
                                  'CREATED_AT' => $now,
                                ];
     $this->pharmacyInventoryModel->save($pharmacy_inventory_data);
     $session = session();
     $session->setFlashdata('addmed','successfully add medicine');

     $pharma_inventory_id = $this->pharmacyInventoryModel->insertID;

     $medicineData = $this->medicineModel->find($medicine_id);

     $now = date("Y-m-d H:i:s");
     $description = "Added medicine with brand name <span class='fw-bold'>{$medicineData['BRAND_NAME']}(id#$medicine_id)</span>".
     " in the inventory.";
     $inventoryLog_data = [
                  'INVENTORY_ID' => $pharma_inventory_id,
                  'PHARMACIST_ID' => $pharmacist_id,
                  'DESCRIPTION' => $description,
                  'CREATED_AT' => $now,
                ];
     $this->pharmacyLogsModel->save($inventoryLog_data);
     // addLog($pharma_inventory_id, $pharmacist_id, $medicine_id);
     return redirect()->to('addmedicine');
    }
    // echo view("Pharmacy/template/header");
    if(session()->has('id')){

      // check if the medicine are being filtered or not
      if(!empty($this->session->getFlashData("filterMedicines"))){
        // true, get the filtered medicine
        // see filter_medicine() function how it is being done
        $medicine = $this->session->getFlashData("filterMedicines");
      }else{
        // false, get all the stored medicine in the database
        $medicine = $this->medicineModel->findAll();
      }

      $pharmacyId = $this->session->get('pharmacy_id');
      
      $allMedicine = [];

      foreach ($medicine as $key => $value) {
        $medicineId = $value['ID'];
        // map the medicine data
        $medicineDetail = [
          'ID' => $medicineId,
          'BRAND_NAME' => $value['BRAND_NAME'],
          'DOSAGE' => $value['DOSAGE'],
          'USAGE' => $value['USAGE'],
          'CATEGORY' => $value['CATEGORIES'],
          'GENERIC_NAMES' => [],
          'CLASSIFICATION' => [],
        ];
        // check if medicine x is already exist
        // in the pharmacy inventory
        $pharmacyInventory = $this->pharmacyInventoryModel->where("PHARMACY_ID", $pharmacyId)
                                                 ->where("MEDICINE_ID", $medicineId)
                                                 ->first();
        $isExist = (empty($pharmacyInventory))? false : true;

        $medicineDetail['IS_EXIST'] = $isExist;

        // form
        $form = $this->medicineFormModel->find($value['FORM']);
        $medicineDetail['FORM'] = $form;

        // get generic names
        $genericNames = $this->medicineGenericNameModel->where("MEDICINE_ID", $medicineId)->findAll();
        foreach ($genericNames as $key => $value) {
          $genericId = $value['GENERIC_NAMES_ID'];
          $genericData = $this->genericNameModel->find($genericId);

          array_push($medicineDetail['GENERIC_NAMES'], $genericData);
        }

        // get classification names
        $classification = $this->medicineClassificationModel->where("MEDICINE_ID", $medicineId)->findAll();
        foreach ($classification as $key => $value) {
          $classId = $value['DRUG_CLASSIFICATION_ID'];
          $drugClassData = $this->drugClassificationModel->find($classId);

          array_push($medicineDetail['CLASSIFICATION'], $drugClassData);
        }

        array_push($allMedicine, $medicineDetail);
      }

      // get all general classification names
      $generalClassification = $this->generalClassificationModel->findAll();
      $form = $this->medicineFormModel->findAll();

      $data = [
        'allMedicine' => $allMedicine,
        'generalClassifications' => $generalClassification,
        'medicineForms' => $form,
      ];

      echo view ("Pharmacy/template/header");
      echo view("Pharmacy/pages/AddMedicine", $data);
      echo view ("Pharmacy/template/footer");
    }
    else{
      return redirect()->to('/');
    }
    // echo view("Pharmacy/template/footer");
  }

  public function update_price(){
    helper(['form']);
    if($this->request->getMethod() == 'post'){
      // $pharmacy_id = $this->request->getVar('pharmacy_id');
      $medicine_id = $this->request->getVar('medicine_id');
      $pharmacist_id = $this->request->getVar('pharmacist_id');
      $retail_price = $this->request->getVAr('new_medicine_price');
      $pharma_inventory_id = $this->request->getVar('pharma_inventory_id');
      $update_at = date("Y-m-d H:i:s");

      $pharma_inventory_data = ['RETAIL_PRICE' => $retail_price,
                                'UPDATE_AT' => $update_at,];

      $this->pharmacyInventoryModel->update($pharma_inventory_id,$pharma_inventory_data);

      $description = "Pharmacist ID: ".$pharmacist_id." updated the retail price of medicine id: ".$medicine_id." in the pharmacy.";
      $inventoryLog_data = ['INVENTORY_ID' => $pharma_inventory_id,
                   'PHARMACIST_ID' => $pharmacist_id,
                   'DESCRIPTION' => $description,
                   'CREATED_AT' => $update_at,
                 ];

     $this->pharmacyLogsModel->save($inventoryLog_data);


      $session = session();
      $session->setFlashdata('updatemed','successfully update medicine');
      return redirect()->to('dashboard');
    }
  }

  /*
    this function will filter the medicine
  */
  public function filter_medicine(){
      header("Content-type:application\json"); // set webpage header

      // get the pass values from ajax
      $generalClassifications = $this->request->getPost("generalClassification[]");
      $medicineForms = $this->request->getPost("medicineForm[]");
      $category = $this->request->getPost("filterCategory");
      $sort = $this->request->getPost("filterSort");

      /* if $generalClassifications is not empty get all data where in $generalClassifications
       otherwise just find where GENERAL_CLASSIFICATION_ID is not null*/
      if(!empty($generalClassifications)){
        $medClassString = implode(",",$generalClassifications);
        $sqlGenClassForm = "GENERAL_CLASSIFICATION_ID IN ($medClassString)";
      }else{
        $sqlGenClassForm = "GENERAL_CLASSIFICATION_ID IS NOT NULL";
      }

      /* if $medicineForms is not empty get all the data where in $medicineForms
        otherwise find where FORM is not null*/
      if(!empty($medicineForms)){
        $medFormString = implode(",",$medicineForms);
        $sqlMedForm = "FORM IN ($medFormString)";
      }else{
        $sqlMedForm = "FORM IS NOT NULL";
      }

      // medicine category
      $categorySqlStatement = ($category === NULL)? "CATEGORIES IS NOT NULL":"CATEGORIES = $category";

      // get all drug classification where in $generalClassification
      $drugClassification = $this->drugClassificationModel->where($sqlGenClassForm)
                                                          ->findAll();
      $drugClassificationIds = []; // container for drug classifications

      foreach ($drugClassification as $key => $value) {
        // push drug_classification_id in the container
        array_push($drugClassificationIds, $value['ID']);
      }

      // get all medicine fit in the given criteria
      // tables: medicine_classification(left) x medicine
      $filteredMedicineData = $this->medicineClassificationModel
                                   ->join('`medicine`','`medicine`.`ID` = `classification`.`MEDICINE_ID`','LEFT')
                                   ->whereIn('DRUG_CLASSIFICATION_ID', $drugClassificationIds) // IN ($drugClassificationIds)
                                   ->where($sqlMedForm) // medicine_form
                                   ->where($categorySqlStatement) // rx or non-rx
                                   ->orderBy('BRAND_NAME',$sort) // asc or desc
                                   ->findAll(); // get all

      // map the inputted data
      // P.S. the purpose of this associative array is to
      // know how data being process in the function

      $data = [
        'generalClassification' => $generalClassifications,
        'form' => $medicineForms,
        'category' => $category,
        'sort' => $sort,
        'drugClass' => $drugClassification,
        'med' => $filteredMedicineData,
      ];

      $medicineData = []; // medicine container

      // properly map the $filteredMedicineData
      foreach ($filteredMedicineData as $key => $value) {
        $id = $value['MEDICINE_ID'];
        $medData = [
          'ID' => $value['MEDICINE_ID'],
          'DOSAGE' => $value['DOSAGE'],
          'FORM' => $value['FORM'],
          'USAGE' => $value['USAGE'],
          'BRAND_NAME' => $value['BRAND_NAME'],
          'CATEGORIES' => $value['CATEGORIES'],
        ];
        array_push($medicineData, $medData);
      }

      // instantiate ang flash data for the filtered medicine
      $this->session->setFlashData("filterMedicines", $medicineData);

      // return $data
      $response = [
        'data' => $data,
      ];

      return $this->setResponseformat('json')->respond($response,200);
  }
}

?>
