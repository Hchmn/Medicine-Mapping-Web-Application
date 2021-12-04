<?php
namespace App\Controllers;

class Pharmacists extends BaseController{

  public function pharmacists(){
    echo view("Pharmacy/template/header");
    echo view("Pharmacy/pages/Pharmacists");
    echo view("Pharmacy/template/footer");
  }

  public function add_pharmacist(){
    helper(['form']);

    if($this->request->getMethod() == 'post'){
      $pharmacist_fname = $this->request->getVar('pharmacist_fname');
      $pharmacist_lname = $this->request->getVar('pharmacist_lname');
      $pharmacist_email = $this->request->getVar('pharmacist_email');
      $pharmacist_contact_number = $this->request->getVar('pharmacist_contact_number');
      $pharmacist_province = $this->request->getVar('pharmacist_province');
      $pharmacist_city = $this->request->getVar('pharmacist_city');
      $pharmacist_barangay = $this->request->getVar('pharmacist_barangay');
      $pharmacist_address = "Barangay ".$pharmacist_barangay.", ".$pharmacist_city." - ".$pharmacist_province;
      $created_at = date("Y-m-d H:i:s");
      $pharmacy_id = $this->request->getVar('pharmacy_id');
      $pharmacist_username = $this->request->getVar('username');
      $pharmacist_password = $this->request->getVar('password');

      $hash_password = password_hash($pharmacist_password, PASSWORD_DEFAULT);

      $pharmacist_data = ['FIRST_NAME' => $pharmacist_fname,
                          'LAST_NAME' => $pharmacist_lname,
                          'ADDRESS' => $pharmacist_address,
                          'PHARMACY_ID' => $pharmacy_id,
                          'USERNAME' => $pharmacist_username,
                          'PASSWORD' => $hash_password,
                          'IS_ACTIVE' => 1,
                          'CREATED_AT' => $created_at,
                         ];

     $this->pharmacistModel->save($pharmacist_data);
     $session = session();
     $session->setFlashdata('add_pharmacist', 'Successfully Add Pharmacist');
     $pharmacist_id = $this->pharmacistModel->insertID;

     $pharmacist_contact_data = ['PHARMACIST_ID' => $pharmacist_id,];
     $this->contactModel->save($pharmacist_contact_data);

     $pharmacist_contact_id = $this->contactModel->insertID;
     $pharmacist_fullname = $pharmacist_fname." ".$pharmacist_lname;

     //Email
     $pharmacist_contact_details_data = ['CONTACT_ID' => $pharmacist_contact_id,
                             'TYPE' => 1,
                             'DETAIL' => $pharmacist_email,
                             'CREATED_AT' => $created_at,
                             ];
     $this->contactDetailsModel->save($pharmacist_contact_details_data);
     $pharmacist_contact_details_data = ['CONTACT_ID' => $pharmacist_contact_id,
                             'TYPE' => 2,
                             'DETAIL' => $pharmacist_contact_number,
                             'CREATED_AT' => $created_at,
                             ];

     $this->contactDetailsModel->save($pharmacist_contact_details_data);
     return redirect()->to('/pharmacists');
    }

  }


}
 ?>
