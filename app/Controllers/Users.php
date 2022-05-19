<?php
    namespace App\Controllers;

    use CodeIgniter\Controller;
    use App\Models\UsersModel;
    use App\Models\KaryawansModel;
    use CodeIgniter\I18n\Time;

    class Users extends ApiController
    {
        public function index()
        {
            $search        = $this->request->getGet('search');

            $$search = trim( $search );

            $users_model = new UsersModel();
            $base = "SELECT `users`.`name` AS `name`,`users`.`created_at` AS `created_at`,`users`.`username` AS `username`,`users`.`status`AS`status`,`karyawans`.`address` AS `address`,`karyawans`.`position` AS `position`,`karyawans`.`no_hp` AS `no_hp`, `karyawans`.`photo` AS `photos` FROM `users` JOIN `karyawans` ON `karyawans`.`user_id` = `users`.`id`";

            
            if( $search ){
                $base .= " WHERE `users`.`name` LIKE '%$search%' OR  `users`.`username` LIKE '% $search%' OR `karyawans`.`address` LIKE '%$search%'  ";
            }
            
            $sql = $users_model->db->query( $base );

            $response = $sql->getResult('array');

            $data = ["data" => $response ];
            return $this->successOutput( $data, 200 ) ;
        }


        public function add()
        {
            $rules       = $this->getRulesAdd();
            $validation  = $this->validation( $rules );

            if( ! $validation["success"] ) return $this->errorOutput( $validation['message'] );

            $name     = $this->request->getPost("name");
            $username = $this->request->getPost("username");
            $password = $this->request->getPost("password");
            $status   = $this->request->getPost("status");
            $now      = Time::now('Asia/Jakarta','id')->getTimestamp();

            $data = [
                "name"       => $name,
                "username"   => $username,
                "password"   => sha1( $password ),
                "status"     => $status,
                "created_at" => $now,
                "updated_at" => $now,
            ];

            var_dump( $data );
            $UsersModel = new UsersModel();
            $UsersModel->insert( $data );
            

            return $this->successOutput(["successs" => true ]);
        }


        public function update()
        {
            $rules       = $this->getRulesUpdate();
            $validation  = $this->validation( $rules );

            if( ! $validation["success"] ) return $this->errorOutput( $validation['message'] );

            $name = $this->request->getVar('name');
            $id   = $this->request->getVar('user_id');
            $now  = Time::now('Asia/Jakarta','id')->getTimestamp();

            $UsersModel = new UsersModel();
            $UsersModel->update( $id , [ "name" => $name, "updated_at" => $now ]);

            return $this->successOutput( [ "success" => true ] );
        }


        public function updatePwd(){
            $id              = $this->request->getVar('user_id');
            $password        = $this->request->getVar('password');
            $old_password    = $this->request->getVar('old_password');

            $cek = $this->checkPwd( $id, $old_password );

            if( ! $cek ) return $this->errorOutput('password Sebelumnya Salah');

            $UsersModel = new UsersModel();
            $UsersModel->update( $id , [ "password" => $password ]);

            return $this->successOutput( [ "success" => true ] );
        }

        public function getRulesAdd()
        {
            return [
                'name' => [
                    'rules' => 'required',
                    'errors' => [
                        "required" => "{field} tidak boleh kosong",
                       
                    ]
                ],
                'username' => [
                    'rules' => 'required|is_unique[users.username]',
                    'errors' => [
                        "required" => "{field} tidak boleh kosong",
                        "is_unique" => "Username Tidak Boleh Sama"
                    ]
                ],
                'password' => [
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
                'confirmation_password' => [
                    'rules' => 'required|matches[password]',
                    'errors' => [
                        "required" => "{field} tidak boleh kosong",
                        "matches" => "{field} tidak cocok dengan konfirmasi password",
                    ]
                ],
            ];
        }


        public function getRulesUpdate()
        {
            return [
                'name' => [
                    'rules' => 'required|is_unique[users.username]',
                    'errors' => [
                        "required" => "{field} tidak boleh kosong",
                        "is_unique" => "Username Tidak Boleh Sama"
                    ]
                ],
                'user_id' => [
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

        /**
         * @param { String } Password
         */
        public function checkPwd( $id, $password )
        {
            $UsersModel = new UsersModel();
            $check      = $UsersModel->where(['password' => sha1( $password ),'id' => $id ])->findAll();

            if( ! $check ) return false;

            return true;
        }


        public function delete(){

            $id = $this->request->getVar( "user_id");

            $UsersModel = new UsersModel();
            $UsersModel->db->transBegin();

            $UsersModel->delete( $id );
            $KaryawanModel = new KaryawansModel();
            $KaryawanModel->where('user_id', $id )->delete();

            
            $UsersModel->db->transComplete();

            if( $UsersModel->db->transStatus() === false ){
                return $this->errorOutput('gagal menghapus');
            }

            return $this->successOutput([ "success" => true ], 200);

        }

    }
?>