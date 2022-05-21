<?php
    namespace App\Models;

    use CodeIgniter\Model;

    class UsersModel extends Model
    {
        protected $table = "users";
        protected $primaryKey = "id";
        // protected $useAutoIncrement = true;
        protected $returnType = 'array';

        protected $allowedFields = ['name','username','password','created_at','updated_at','role'];
        protected $useSoftDeletes = false;
        protected $useTimestamp = true;

        protected $createdField = 'created_at';
        protected $updatedField = 'updated_at';

        protected $validationRules   = [];
        protected $validationMessage = [];
        protected $skipValidation    = false;
    }
?>