<?php
namespace App\Models;

use CodeIgniter\Model;

class GenericName extends Model{
  protected $table = 'generic_names';

  protected $primaryKey = 'id';
  protected $allowedFields = ['NAME'];
}
 ?>
