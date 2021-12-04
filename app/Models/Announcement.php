<?php
namespace App\Models;

use CodeIgniter\Model;

class Announcement extends Model{
  protected $table = 'app_announcement';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['ADMIN_ID','CONTENT','CREATED_AT','TITLE'];
}
 ?>
