<?php
namespace App\Models;

use CodeIgniter\Model;

class Pharmacy extends Model{
  protected $table = 'pharmacy';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['ID','NAME','ADDRESS','LAT','LNG','IS_VERIFIED','CREATED_AT'];
}
 ?>
