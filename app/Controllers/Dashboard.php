<?php
namespace App\Controllers;

class Dashboard extends BaseController
{
	public function dashboard()
	{
			$medicineTrend = $this->medicineTrendModel->select('COUNT(`MEDICINE_ID`) as `OCCURANCE`, `MEDICINE_ID`')
																								->groupBy('`MEDICINE_ID`')
																								->orderBy('`OCCURANCE`','DESC')
																								->findAll();
			$trend = [];
			$counter = 0;
			foreach ($medicineTrend as $key => $value) {
				$medId = $value['MEDICINE_ID'];
				$medicineData = $this->medicineModel->find($medId);
				$trendData = [
					'OCCURANCE' => $value['OCCURANCE'],
					'MEDICINE_NAME' => $medicineData['BRAND_NAME'],
				];
				array_push($trend, $trendData);
				$counter += 1;
				if($counter == 10){
					break;
				}
			}
			// count each medicine
			$data = [
				'medicineTrend' => $trend,
			];
			if(session()->has('id')){
				echo view ("Pharmacy/template/header");
		    echo view('Pharmacy/pages/Dashboard', $data);
				echo view ("Pharmacy/template/footer");
			}
			else{
				return redirect()->to('/');
			}
	}

	public function changeMedicineAvailability(){
		header("Content-type: application/json");
		$inventoryId = $this->request->getPost("inventoryId");

		$inventoryData = $this->pharmacyInventoryModel->find($inventoryId);

		$data = [
			'ID' => $inventoryId,
			'IS_STOCK' => ($inventoryData['IS_STOCK'] == 1)? 0 : 1,
		];

		$this->pharmacyInventoryModel->update($inventoryId, $data);

		$medicineData = $this->medicineModel->find($inventoryData['MEDICINE_ID']);
		$now = date("Y-m-d H:i:s");
		if($inventoryData['IS_STOCK'] == 1){
			$description = "Update medicine availability with brand name {$medicineData['BRAND_NAME']}(id#{$medicineData['ID']}) ".
										 "from <span class='fw-bold'>AVAILABLE</span> ".
			 							 "to <span class='fw-bold'>NOT AVAILABLE</span>";
		}else{
			$description = "Update medicine availability with brand name {$medicineData['BRAND_NAME']}(id#{$medicineData['ID']}) ".
										 "from <span class='fw-bold'>NOT AVAILABLE</span> ".
			 							 "to <span class='fw-bold'>AVAILABLE</span>";
		}

		$inventoryLog_data = [
								 'INVENTORY_ID' => $inventoryId,
								 'PHARMACIST_ID' => $this->session->get('id'),
								 'DESCRIPTION' => $description,
								 'CREATED_AT' => $now,
							 ];
		$this->pharmacyLogsModel->insert($inventoryLog_data);

		$response = [
			'data' => $data,
		];
		return $this->setResponseFormat('json')->respond($response, 200);
	}
}

?>
