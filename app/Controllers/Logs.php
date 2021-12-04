<?php
namespace App\Controllers;

class Logs extends BaseController
{
	public function logs()
	{
			if(session()->has('id')){
				$pharamcyId = $this->session->get("pharmacy_id");
				$pharmacist = $this->pharmacistModel->where("PHARMACY_ID", $pharamcyId)->findAll();

				$allPharmacist = [];
				foreach ($pharmacist as $key => $value) {
					array_push($allPharmacist, $value['ID']);
				}

				$logs = $this->pharmacyLogsModel->whereIn('PHARMACIST_ID',$allPharmacist)
																				->orderBy('CREATED_AT','DESC')
																				->findAll();

				$logsData = [];

				foreach ($logs as $key => $value) {
					$id = $value['ID'];
					$pharmacistId = $value['PHARMACIST_ID'];
					$desc = $value['DESCRIPTION'];
					$createdAt = $value['CREATED_AT'];

					$logdata = [
						'ID' => $id,
						'DESC' => $desc,
						'CREATED_AT' => $createdAt,
					];

					$pharmacistData = $this->pharmacistModel->find($pharmacistId);

					$logdata['PHARMACIST_DATA'] = $pharmacistData;

					array_push($logsData, $logdata);
				}

				$data = [
					'logs' => $logsData,
				];
				echo view('Pharmacy/template/header');
		   	    echo view('Pharmacy/pages/Logs',$data);
				echo view('Pharmacy/template/footer');
			}
			else{
				return redirect()->to('/');
			}
	}
}

?>
