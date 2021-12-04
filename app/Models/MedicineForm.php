<?php
namespace App\Models;

use CodeIgniter\Model;

class MedicineForm extends Model{
  protected $table = 'medicine_form';

  protected $primaryKey = 'id';
  protected $allowedFields = ['NAME'];
}
 ?>
