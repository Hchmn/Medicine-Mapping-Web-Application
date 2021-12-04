<?php
namespace App\Models;

use CodeIgniter\Model;

class DrugClassification extends Model{
  protected $table = 'drug_classification';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['NAME','GENERAL_CLASSIFICATION_ID'];
}
 ?>
