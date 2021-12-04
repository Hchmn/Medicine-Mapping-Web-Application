<?php
namespace App\Models;

use CodeIgniter\Model;

class Contact extends Model{
  protected $table = 'contact';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['PHARMACY_ID','PHARMACIST_ID'];
}
 ?>
