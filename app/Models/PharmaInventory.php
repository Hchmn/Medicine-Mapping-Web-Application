<?php
namespace App\Models;

use CodeIgniter\Model;

class PharmaInventory extends Model{
  protected $table = 'pharma_inventory';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['PHARMACY_ID','MEDICINE_ID','IS_STOCK','RETAIL_PRICE','CREATED_AT','UPDATE_AT'];
}
 ?>
