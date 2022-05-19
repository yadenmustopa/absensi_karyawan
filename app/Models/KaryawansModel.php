<?php
    namespace App\Models;

    use CodeIgniter\Model;

    class KaryawansModel extends Model
    {
        protected $table        = 'karyawans';
        protected $primaryKey   = 'id';
        protected $useTimeStamp = true;
        protected $createdField = "created_at";
        protected $updatedField = "updated_at";
        protected $returnType   = "array";

        protected $allowedFields = ['user_id','address','position','no_hp','salary','photo','updated_at','created_at'];

        protected $validationRules   = [];
        protected $validationMessage = [];
        protected $skipValidation    = false;
    }

?>