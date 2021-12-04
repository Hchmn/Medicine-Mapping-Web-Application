<?php
namespace App\Controllers;

class Authentication extends BaseController{

  public function authentication(){
    if(session()->has('authentication_code')){
      echo view('Pharmacy/login/Authentication.php');
    }

    else{
      return redirect()->to('/');
    }
  }
  public function resendAuthentication(){
    if($this->request->getMethod() == 'post'){
      $pharmacist_id  = session()->get('id');
      $pharmacist_fname = session()->get('pharmacist_fname');

      $get_contactID = $this->contactModel->where('PHARMACIST_ID', $pharmacist_id)
              ->first();

      $multiple_conditions = array('CONTACT_ID' => $get_contactID['ID'], 'TYPE' => '1');
      $contactDetails = $this->contactDetailsModel->where($multiple_conditions)
              ->first();
      $email = $contactDetails['DETAIL'];

      $this->resendVerificationCode($pharmacist_fname,$email);
      $session = session();
      $session->set('code_success');
      if(session()->has('authentication_code')){
          return redirect()->to('/authentication');
      }
    }

  }

  private function resendVerificationCode($pharmacist_fname,$email){
    $firstName = $pharmacist_fname;
    $to =  $email;
    $fromEmail = "developers@med-mapping.com";

    $subject = 'Account Authentication';
    $authentication_code = rand(100000,999999);

    $message = "<div style=\"width:100%; height:50px; background-color: rgb(66, 136, 255);text-align:center;font-size:30px;font-weight:bold;color:white;\">";
    $message .= "<span>Medicine Mapping</span>";
    $message .= "</div><p>Hi $firstName! Here is your authentication code:</p>";
		$message .= "<div style=\"width:50%; height:30px; background-color: rgb(197, 200, 188)text-align:center;font-size:30px;font-weight:bold;color:white;\">";
		$message .= "<p style=\"color:#1d9feb; font-size:20px;\">$authentication_code";
    $message .= "<p>Please make sure you never share this code with anyone.</p>";
    $message .= "<p> <strong>Note: </strong> The code will expire in 10 minutes.</p>";
    $message .= "</p><p>For any concern just <a href=\"mailto:$fromEmail\">EMAIL US</a></p>";


    $emailService = \Config\Services::email();
    $emailService->setTo($to);
    $emailService->setFrom('info@gophp.in', 'Medicine Mapping');


    $emailService->setSubject($subject);
    $emailService->setMessage($message);
    $emailService->send();
    $data = [
      'button' => 1,
    ];

    $code_data = [
      'authentication_code' => $authentication_code,
    ];
    session()->set($data);
    session()->setTempData($code_data, 500);

  }
}

 ?>
