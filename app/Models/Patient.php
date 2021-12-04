<?php
namespace App\Models;

use CodeIgniter\Model;

class Patient extends Model{
  protected $table = 'patient';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['FIRST_NAME','LAST_NAME','CONTACT_NO','CREATED_AT','UPDATED_AT'];
}
 ?>
