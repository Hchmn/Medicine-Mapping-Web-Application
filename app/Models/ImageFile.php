<?php
namespace App\Models;

use CodeIgniter\Model;

class ImageFile extends Model{
  protected $table = 'files';

  protected $primaryKey = 'id';
  protected $allowedFields = ['NAME','INTERNAL_PATH', 'MIME_TYPE','CHAT_LINES_ID'];
}
 ?>
