<?php
namespace App\Models;

use CodeIgniter\Model;

class GeneralClassification extends Model{
  protected $table = 'general_classification';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['NAME'];
}
 ?>
