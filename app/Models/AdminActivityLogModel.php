<?php
namespace App\Models;

use CodeIgniter\Model;

class AdminActivityLogModel extends Model{
  protected $table = 'admin_activity_log';

  protected $primaryKey = 'id';
  protected $allowedFields = ['ADMIN_ID','DESCRIPTION','CREATED_AT'];
}
 ?>
