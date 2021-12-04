<?php
namespace App\Models;

use CodeIgniter\Model;

class ChatLine extends Model{
  protected $table = 'chat_lines';

  protected $primaryKey = 'id';
  protected $allowedFields = ['CHATS_ID','MESSAGE', 'PHARMACIST_ID','CREATED_AT'];
}
 ?>
