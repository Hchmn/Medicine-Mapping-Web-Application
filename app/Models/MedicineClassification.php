<?php
namespace App\Models;

use CodeIgniter\Model;

class MedicineClassification extends Model{
  protected $table = 'classification';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['DRUG_CLASSIFICATION_ID','MEDICINE_ID'];
}
 ?>
