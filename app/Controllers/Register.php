<?php
namespace App\Controllers;
use \App\Models\Pharmacy;
use \App\Models\Pharmacist;
class Register extends BaseController
{
	public function register(){
	   	echo view('Pharmacy/registration/register.php');
	}

	public function submitForm(){
		// validate
		header("Content-type:application\json");
		// pharmacy
		$pharmacyName = $this->request->getPost("pharmacyName");
		// address
		$pharmacyProvince = $this->request->getPost("pharmacyProvince");
		$pharmacyCity = $this->request->getPost("pharmacyCity");
		$pharmacyBarangay = $this->request->getPost("pharmacyBarangay");
		$pharmacyStreet = $this->request->getPost("pharmacyStreet");
		$pharmacyAddress = $pharmacyStreet.", ".$pharmacyBarangay.", ".$pharmacyCity.", ".$pharmacyProvince;
		// location
		$pharmacyLat = $this->request->getPost("pharmacyLatitude");
		$pharmacyLng = $this->request->getPost("pharmacyLongitude");
		// contact
		$pharmacyEmail = $this->request->getPost("pharmacyEmail");
		$pharmacyMobileNumber = $this->request->getPost("pharmacyMobileNumber");
		$pharmacyTelephone = $this->request->getPost("pharmacyTelephone");
		// documents
		$pharmacyFDA = $this->request->getFileMultiple("FDAcert");
		$pharmacyBIR = $this->request->getFileMultiple("BIRcert");

		// map pharmacy data
		$pharmacyData = [
			'NAME' => $pharmacyName,
			'ADDRESS' => $pharmacyAddress,
			'LAT' => $pharmacyLat,
			'LNG' => $pharmacyLng,
			'EMAIL' => $pharmacyEmail,
			'MOBILE_NUMBER' => $pharmacyMobileNumber,
			'TELEPHONE' => $pharmacyTelephone,
			'FDA' => $pharmacyFDA,
			'BIR' => $pharmacyBIR,
		];

		// pharmacist
		$pharmacistFirstName = $this->request->getPost("pharmacistFirstName");
		$pharmacistLastName = $this->request->getPost("pharmacistLastName");

		// location
		$pharmacistProvince = $this->request->getPost("pharmacistProvince");
		$pharmacistCity = $this->request->getPost("pharmacistCity");
		$pharmacistBarangay = $this->request->getPost("pharmacistBarangay");
		$pharmacistStreet = $this->request->getPost("pharmacistStreet");
		$pharmacistAddress = $pharmacistStreet.", ".$pharmacistBarangay.", ".$pharmacistCity.", ".$pharmacistProvince;

		// contact
		$pharmacistEmail = $this->request->getPost("pharmacistEmail");
		$pharmacistMobileNumber = $this->request->getPost("pharmacistMobileNumber");
		$pharmacistTelephone = $this->request->getPost("pharmacistTelephone");

		// map pharamcist data
		$pharmacistData = [
			'FIRST_NAME' => $pharmacistFirstName,
			'LAST_NAME' => $pharmacistLastName,
			'ADDRESS' => $pharmacistAddress,
			'EMAIL' => $pharmacistEmail,
			'MOBILE_NUMBER' => $pharmacistMobileNumber,
			'TELEPHONE' => $pharmacistTelephone,
		];

		// insertion
		$datetime = $this->time->now()->toDateTimeString();
		// pharmacy
		$newPharamcyData = [
			'NAME' => $pharmacyData['NAME'],
			'ADDRESS' => $pharmacyData['ADDRESS'],
			'LAT' => $pharmacyData['LAT'],
			'LNG' => $pharmacyData['LNG'],
			'IS_VERIFIED' => 0,
			'CREATED_AT' => $datetime,
		];
		$this->pharmacyModel->insert($newPharamcyData);
		$newPharmacyId = $this->pharmacyModel->insertID;
		// upload documents
		// FDA
		foreach ($pharmacyData['FDA'] as $image) {
			if($image->isValid() && !$image->hasMoved()){
					// generate random name
					$generatedName = $image->getRandomName();
					$generatedName = "FDA_".$generatedName;
					$this->uploadImage($newPharmacyId, $image, $datetime,$generatedName);
			}
		}
		// BIR
		foreach ($pharmacyData['BIR'] as $image) {
			if($image->isValid() && ! $image->hasMoved()){
				// generate random name
				$generatedName = $image->getRandomName();
				$generatedName = "BIR_".$generatedName;
				$this->uploadImage($newPharmacyId, $image, $datetime,$generatedName);
			}
		}
		// contact Information
		$newPharmacyContact = [
			'PHARMACY_ID' => $newPharmacyId,
		];
		$this->contactModel->insert($newPharmacyContact);
		$pharmacyContactId = $this->contactModel->insertID;
		// email
		if(!empty($pharmacyEmail)){
			$pharmacyContactDetailData = [
				'CONTACT_ID' => $pharmacyContactId,
				'TYPE' => 1,
				'DETAIL' => $pharmacyEmail,
				'CREATED_AT' => $datetime,
			];
			$this->contactDetailsModel->insert($pharmacyContactDetailData);
		}
		// mobile
		if(!empty($pharmacyMobileNumber)){
			$pharmacyContactDetailData = [
				'CONTACT_ID' => $pharmacyContactId,
				'TYPE' => 2,
				'DETAIL' => $pharmacyMobileNumber,
				'CREATED_AT' => $datetime,
			];
			$this->contactDetailsModel->insert($pharmacyContactDetailData);
		}
		// tel
		if(!empty($pharmacyTelephone)){
			$pharmacyContactDetailData = [
				'CONTACT_ID' => $pharmacyContactId,
				'TYPE' => 3,
				'DETAIL' => $pharmacyTelephone,
				'CREATED_AT' => $datetime,
			];
			$this->contactDetailsModel->insert($pharmacyContactDetailData);
		}

		// pharmacist
		$newPharmacistData = [
			'FIRST_NAME' => $pharmacistFirstName,
			'LAST_NAME' => $pharmacistLastName,
			'ADDRESS' => $pharmacistAddress,
			'PHARMACY_ID' => $newPharmacyId,
			'CREATED_AT' => $datetime,
		];

		$this->pharmacistModel->insert($newPharmacistData);
		$newPharmacistId = $this->pharmacistModel->insertID;

		// contact Information
		$newPharmacistContact = [
			'PHARMACIST_ID' => $newPharmacistId,
		];
		$this->contactModel->insert($newPharmacistContact);
		$pharmacistContactId = $this->contactModel->insertID;

		// email
		if(!empty($pharmacistEmail)){
			$pharmacistContactDetailData = [
				'CONTACT_ID' => $pharmacistContactId,
				'TYPE' => 1,
				'DETAIL' => $pharmacistEmail,
				'CREATED_AT' => $datetime,
			];
			$this->contactDetailsModel->insert($pharmacistContactDetailData);
		}
		// mobile

		if(!empty($pharmacistMobileNumber)){
			$pharmacistContactDetailData = [
				'CONTACT_ID' => $pharmacistContactId,
				'TYPE' => 2,
				'DETAIL' => $pharmacistMobileNumber,
				'CREATED_AT' => $datetime,
			];
			$this->contactDetailsModel->insert($pharmacistContactDetailData);
		}
		// tell
		if(!empty($pharmacistTelephone)){
			$pharmacistContactDetailData = [
				'CONTACT_ID' => $pharmacistContactId,
				'TYPE' => 3,
				'DETAIL' => $pharmacistTelephone,
				'CREATED_AT' => $datetime,
			];
			$this->contactDetailsModel->insert($pharmacistContactDetailData);
		}


		$data = [
			'PHARMACY' => $pharmacyData,
			'PHARMACIST' => $pharmacistData,
		];
		$response = [
			'data' => $data,
		];
		return $this->setResponseformat('json')->respond($response, 200);
	}

	private function uploadImage($pharmacyId, $image, $dateTime, $generatedName){
    $internalPath = FCPATH.'uploads/pharmacy_documents/';
    $externalPath = base_url()."/uploads/pharmacy_documents/".$generatedName;
    // compress the image
    $compressImage = \Config\Services::image()->withFile($image)
                                              ->save($internalPath.$generatedName,10);


		// map image
    $newImage = [
      "PHARMACY_ID" => $pharmacyId,
      "INTERNAL_PATH" => $externalPath,
      "MIME_TYPE" => $image->getClientMimeType(),
      "CREATED_AT" => $dateTime,
    ];

    // insert the image
		$this->pharmacyDocumentsModel->insert($newImage);
	}
}

?>
