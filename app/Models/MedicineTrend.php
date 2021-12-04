<?php
namespace App\Models;

use CodeIgniter\Model;

class MedicineTrend extends Model{
  protected $table = 'medicine_trend';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['DATE','MEDICINE_ID'];
}
 ?>
