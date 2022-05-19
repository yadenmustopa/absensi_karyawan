<?php
    namespace App\Models;

    use CodeIgniter\Model;
  
class AbsensModel extends Model
{
    protected $table        = 'absens';
    protected $primaryKey   = 'id';
    protected $useTimeStamp = true;
    protected $createdField = "created_at";
    protected $updatedField = "updated_at";
    protected $returnType   = "array";

    protected $allowedFields = ['created_at','status','description'];

    protected $validationRules   = [];
    protected $validationMessage = [];
    protected $skipValidation    = false;
}
?>