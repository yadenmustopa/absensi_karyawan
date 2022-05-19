<?php
    namespace App\Models;

    use CodeIgniter\Model;

    class UsersModel extends Model
    {
        protected $table = "users";
        protected $primaryKey = "id";
        // protected $useAutoIncrement = true;
        protected $returnType = 'array';

        protected $allowedFields = ['nama','username','password','crated_at','updated_at'];
        protected $useSoftDeletes = false;
        protected $useTimestamp = true;

        protected $createdField = 'created_at';
        protected $updatedField = 'updated_at';

        protected $validationRules   = [];
        protected $validationMessage = [];
        protected $skipValidation    = false;
    }
?>