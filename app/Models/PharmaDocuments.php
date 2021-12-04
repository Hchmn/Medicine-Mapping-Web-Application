<?php
namespace App\Models;

use CodeIgniter\Model;

class PharmaDocuments extends Model{
  protected $table = 'pharma_documents_path';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['PHARMACY_ID','INTERNAL_PATH','MIME_TYPE','CREATED_AT'];
}
 ?>
