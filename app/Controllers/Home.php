<?php

namespace App\Controllers;
class Home extends BaseController
{
	public function index(){

		$data = [];
		helper(['form']);

		$data = array('id','username','pharmacist_fname','pharmacist_lname','pharmacist_id','is_LoggedIn');

		if(session()->has('id')){
			session_destroy();
		}

		if($this->request->getMethod() == 'post'){
			$rules = [
				'USERNAME' => 'required|min_length[3]|max_length[255]',
				'PASSWORD' => 'required|min_length[3]|max_length[255]|validateUser[USERNAME,PASSWORD]',
			];

			$errors = ['PASSWORD' => ['validateUser' => 'Username or Password don\'t match']
			];

			if(!$this->validate($rules, $errors)){
				$session = session();
				$session->setFlashdata('invalid', 'Successfully Registered');
			}

			else {
				$user = $this->pharmacistModel->where('USERNAME', $this->request->getVar('USERNAME'))
								->first();

				$this->setUserSession($user);
				if(session()->has('id')){
					return redirect()->to('/dashboard');
				}
			}

		}

		echo view('Pharmacy/login/login.php');
	}

	public function setUserSession($user){
		$data = [
			'id' => $user['ID'],
			'username' => $user['USERNAME'],
			'pharmacist_fname' => $user['FIRST_NAME'],
			'pharmacist_lname' => $user['LAST_NAME'],
			'pharmacy_id' => $user['PHARMACY_ID'],
			'isLoggedIn' => true,
		];
		session()->set($data);
		return true;
	}

	public function unsetUserSession($user){

	}

	public function privacy(){
		echo view("admin\Privacy");
	}
}
?>
