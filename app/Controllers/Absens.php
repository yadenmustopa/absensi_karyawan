<?php
    namespace App\Controllers;

    use CodeIgniter\Controller;
    use App\Models\UsersModel;
    use App\Models\AbsensModel;
    use CodeIgniter\I18n\Time;

    class Absens extends ApiController
    {
        public function index()
        {
            $search        = $this->request->getGet('search') ;
            $hasAbsen      = $this->request->getGet('has_absen') ;
            $start_date    = $this->request->getGet('start_date') ?? strtotime( date('m-01-Y 00:00:00' ) );
            $end_date      = $this->request->getGet('end_date') ??  Time::now('Asia/Jakarta','id')->getTimestamp();

            $search = trim( $search );

            $users_model = new UsersModel();
        
            $sql      = $users_model->db->query( $base );
            $response = $sql->getResult('array');
            $data     = [ "data" => $response ];

            return $this->successOutput( $data, 200 ) ;
        }

        public function getSyntax( $search, $start_date, $end_date , $hasAbsen = "Y" )
        {
            $base = "SELECT `users`.`name` AS `name`,`absens`.`created_at` AS `created_at`,`absens`.`status` AS `status`,`absens`.`description` AS `description` FROM `users` CROSS JOIN `absens` ON `absens`.`user_id` = `users`.`id`";
            $base.= " WHERE `absens`.`created_at` BETWEEN $start_date AND $end_date";

            if( $hasAbsen === 'N'){
                $base.= " AND NOT EXISTS ( SELECT `absens`.`user_id` FROM `users` WHERE `users`.`id` = `absens`.`user_id`  )";
            }

            return $base;
        }

        public function add()
        {
            $rules       = $this->getRules();
            $validation  = $this->validation( $rules );

            if( ! $validation["success"] ) return $this->errorOutput( $validation['message'] );

            $user_id      = $this->request->getPost("user_id");
            $status       = $this->request->getPost("status");
            $description  = $this->request->getPost("description");
            $now          = Time::now('Asia/Jakarta','id')->getTimestamp();


            $data = [ 
                "user_id"     => $user_id,
                "status"      => $status,
                "description" => $description,
                "created_at"  => $now,
                "updated_at"  => $now,
            ];

            $AbsenModel = new AbsensModel();
            $AbsenModel->insert( $data );

            return $this->successOutput([]);
        }

        public function update( $absen_id )
        {
            $rules       = $this->getRules();
            $validation  = $this->validation( $rules );

            if( ! $validation["success"] ) return $this->errorOutput( $validation['message'] );

            $status       = $this->request->getPost("status");
            $description  = $this->request->getPost("description");

            $data = [ 
                "status"    => $status,
                "description" => $description,
            ];

            $AbsenModel = new AbsensModel();
            $AbsenModel->update( $absen_id, $data );

            return $this->successOutput([]);
        }


        public function getRules()
        {
            return [
                'user_id' => [
                    'rules' => 'required',
                    'errors' => [
                        "required" => "{field} tidak boleh kosong",
                       
                    ]
                ],
                'status' => [
                    'rules' => 'required',
                    'errors' => [
                        "required" => "{field} tidak boleh kosong",
                    ]
                ],
            ];
        }


        public function validation( $rules ){

            if( $this->validate( $rules )){

                return ['success'=> true ];
                
            }else{

                $validation = \Config\Services::validation();
                $errors  = array_values( $validation->getErrors() );
                $message = $errors[0];

                return ['success'=> false, 'message' => $message ];
            }
        }
    }

?>