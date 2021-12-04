<?php
namespace App\Models;

use CodeIgniter\Model;

class Chat extends Model{
  protected $table = 'chats';

  protected $primaryKey = 'id';
  protected $allowedFields = ['PATIENT_ID','PHARMACY_ID', 'CREATED_AT','UPDATE_AT'];
}
 ?>
