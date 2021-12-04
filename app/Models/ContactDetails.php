<?php
namespace App\Models;

use CodeIgniter\Model;

class ContactDetails extends Model{
  protected $table = 'contact_details';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['CONTACT_ID','TYPE','DETAIL','CREATED_AT','UPDATE_AT'];
}
 ?>
