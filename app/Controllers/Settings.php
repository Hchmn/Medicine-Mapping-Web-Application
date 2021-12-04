<?php
namespace App\Controllers;

class Settings extends BaseController
{
	public function settings(){
			if(session()->has('id')){
				echo view("Pharmacy/template/header");
		     	echo view('Pharmacy/pages/Settings');
				echo view("Pharmacy/template/footer");
			}
			else{
				return redirect()->to('/');
			}
	}

	public function change_password(){
		helper(['form']);
		if($this->request->getMethod() == 'post'){
			$pharmacist_id = $this->request->getVar('pharmacist_id');
			$current_password = $this->request->getVar('old_password');
			$new_password = $this->request->getVar('new_password');

			$query = $this->queryBuilder->query("SELECT * FROM pharmacist WHERE ID LIKE '$pharmacist_id'");
			$crypted = "";

			//query password
			foreach ($query->getResult() as $result) {
				$crypted = $result->PASSWORD;
			}

			$result = password_verify($current_password, $crypted) ? '1' : '0';

			if($result == '1'){
				$update_at = date("Y-m-d H:i:s");
				$password_hash = password_hash($new_password,PASSWORD_DEFAULT);

				$change_password_data = ['PASSWORD' => $password_hash,
																 'UPDATE_AT' => $update_at,
															 	];
				//creating a method for saving the new Password
				$this->saveNewPassword($pharmacist_id, $change_password_data);

				//creating a method for saving the logs
				$this->savePasswordLogs($pharmacist_id,$update_at);

			 return redirect()->to('settings');
			}

			else {
				// $session = session();
				$this->session->setFlashdata('changepassfail','Password has not changed');
				 return redirect()->to('/settings');
			}

		}

	}

	private function savePasswordLogs($pharmacist_id,$update_at){

		$pharmacistData = $this->pharmacistModel->find($pharmacist_id);
		$description = "{$pharmacistData['FIRST_NAME']} {$pharmacistData['LAST_NAME']} changed password";
		$inventoryLog_data = ['PHARMACIST_ID' => $pharmacist_id,
								 'DESCRIPTION' => $description,
								 'CREATED_AT' => $update_at,
							 ];
		$this->pharmacyLogsModel->save($inventoryLog_data);

	}
	private function saveNewPassword($pharmacist_id, $change_password_data){
		$pharma_id = $pharmacist_id;
		$newPass_data = $change_password_data;

		$this->pharmacistModel->update($pharma_id,$newPass_data);
		// $session = session();
		$this->session->setFlashdata('changepass','Successfully changed password');
	}

	public function change_username(){
		helper(['form']);

		if($this->request->getMethod() == 'post'){
			$pharmacist_id = $this->request->getVar('pharmacist_id');
			$new_username = $this->request->getVar('new_username');
			$update_at = date("Y-m-d H:i:s");
			$change_username_data = ['USERNAME' => $new_username,
															 'UPDATE_AT' => $update_at,];

			//create a method to Save the New Username
			$this->saveNewUsername($pharmacist_id,$change_username_data);

			//create a method to Save the New Username Logs
			$this->saveUsernameLogs($pharmacist_id, $update_at);

		 return redirect()->to('/settings');
		}
	}

	private function saveNewUsername($pharmacist_id, $change_username_data){
		$pharmacistID = $pharmacist_id;
		$usernameData = $change_username_data;
		$this->pharmacistModel->update($pharmacistID, $usernameData);
		$session = session();
		$session->setFlashdata('changeusername','Successfully changed username');
	}

	private function saveUsernameLogs($pharmacist_id,$update_at){
		$pharmacistData = $this->pharmacistModel->find($pharmacist_id);
		$description = "{$pharmacistData['FIRST_NAME']} {$pharmacistData['LAST_NAME']} changed username";

		$inventoryLog_data = ['PHARMACIST_ID' => $pharmacist_id,
								 'DESCRIPTION' => $description,
								 'CREATED_AT' => $update_at,
							 ];
	 $this->pharmacyLogsModel->save($inventoryLog_data);
	}
}

?>
