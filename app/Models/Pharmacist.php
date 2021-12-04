<?php
namespace App\Models;

use CodeIgniter\Model;

class Pharmacist extends Model{
  protected $table = 'pharmacist';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['FIRST_NAME','LAST_NAME','ADDRESS','PHARMACY_ID','USERNAME','PASSWORD','IS_ACTIVE','CREATED_AT','UPDATE_AT'];
}
 ?>
