<?php
namespace App\Models;

use CodeIgniter\Model;

class MedicineGenericName extends Model{
  protected $table = 'medicine_generic_name';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['GENERIC_NAMES_ID','MEDICINE_ID'];
}
 ?>
