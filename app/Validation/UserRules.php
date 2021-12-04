<?php
namespace App\Validation;
use App\Models\Pharmacist;
// use App\Models\UserModel;

class UserRules{

  public function validateUser(string $str, string $fields, array $data){
  //where(first,second) this part is testing 'username entered has found same username in database'
  $model = new Pharmacist();

  $user = $model->where('USERNAME', $data['USERNAME'])
        ->first();

 if(!$user){
   log_message('critical','here DIDNT GET THE USER');
    return false;
    }
 return password_verify($data['PASSWORD'], $user['PASSWORD']);

}

}
