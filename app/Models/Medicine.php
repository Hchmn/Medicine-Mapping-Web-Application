<?php
namespace App\Models;

use CodeIgniter\Model;

class Medicine extends Model{
  protected $table = 'medicine';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['BRAND_NAME','DOSAGE','FORM','USAGE','CATEGORIES'];

}
 ?>
