<?php
namespace App\Models;

use CodeIgniter\Model;

class PharmaLog extends Model{
  protected $table = 'pharma_inv_log';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['INVENTORY_ID','PHARMACIST_ID','DESCRIPTION','CREATED_AT'];
}
 ?>
