<?php
    namespace App\Controllers;

    use CodeIgniter\Controller;
    use App\Models\UsersModel;
    use App\Models\KaryawansModel;
    use App\Controllers\Karyawans;
    use CodeIgniter\I18n\Time;

    class Users extends ApiController
    {
        public function index()
        {
            $search        = trim( $this->request->getGet('search') );
            $page          = ( $this->request->getGet('page') ) ? ( int )$this->request->getGet('page') : 1;
            $per_page      = ( $this->request->getGet('per_page') ) ? ( int ) $this->request->getGet('per_page') :  10 ;

            $sort_by       = $this->request->getGet('sort_by') ?? '';
            $filter        = $this->request->getGet('filter') ?? '';

            $identity      = $this->request->getGet('with_identity');
            $output        = [];

            if( $identity === "Y"){
                $output = $this->withIdentity( $search, $sort_by, $filter, $page, $per_page );
            }else{
                $output = $this->noIdentity( $search, $sort_by, $filter, $page, $per_page );
            }
            
            return $this->successOutput( $output, 200 ) ;
        }

        private function withIdentity( $search = "", $sort_by = "`users`.`id`:DESC", $filter = "", $page, $per_page ){
            $UsersModel = new UsersModel();
            $base        = "SELECT `users`.`name` AS `name`,`users`.`created_at` AS `created_at`,`users`.`username` AS `username`,`users`.`role`AS`status`,`karyawans`.`address` AS `address`,`karyawans`.`position` AS `position`,`karyawans`.`no_hp` AS `no_hp`, `karyawans`.`photo` AS `photo`, `karyawans`.`salary` AS `salary`, `karyawans`.`id` AS `karyawan_id`, `users`.`id` AS `user_id` FROM `users` RIGHT JOIN `karyawans` ON `karyawans`.`user_id` = `users`.`id`";
            
            if( $search ){
                $base .= " WHERE `users`.`name` LIKE '%$search%' OR  `users`.`username` LIKE '% $search%' OR `karyawans`.`address` LIKE '%$search%'  ";
            }
            

            if( $filter ){
                $i_f    = 0;
				$filter = explode(';', $filter);
				
				foreach ($filter as $d_f) {
					$f = explode(':', $d_f);
			
					$key   = $f[0];
					$value = $f[1];
				
				
					$base.=" AND $key = '$value'";
	
					$i_f++;
				}
            }

            if( $sort_by ){
                $sort = explode(":", $sort_by );

                $base.=" ORDER BY $sort[0] $sort[1]";
            }else{
                $base.=" ORDER BY `users`.`id` DESC";
            }

            $count_all = $UsersModel->db->query( $base )->getNumRows();
            
            $offset    = ( $page - 1 ) * $per_page;
            
            if( $page || $per_page  ){
                $base.=" LIMIT $per_page OFFSET $offset";
            }

            $data = $UsersModel->db->query( $base )->getResultArray();
         
            $pagination = [
                "per_page" => (int)$per_page,
                "page"     => (int)$page,
                "offset"   => (int)$offset,
                "count_all" => (int)$count_all,
            ];

            $output = [
               "pagination" => $pagination,
               "data" => $data,
            ];


            return $output;
        }

        /**
         * 
         */
        private function noIdentity(  $search = "", $sort_by , $filter = "", $page, $per_page ){
            $UserModel = new UsersModel();
            $sql = "SELECT * FROM `users`";

            if( $search ){
                $sql.=" WHERE `name` LIKE '%$search%' ";
            }

            if( $filter ){
                $i_f    = 0;
				$filter = explode(';', $filter);
				
				foreach ($filter as $d_f) {
					$f = explode(':', $d_f);
			
					$key   = $f[0];
					$value = $f[1];

                    if( !$search && $i_f === 0 ){
                        $sql.=" WHERE ";
                    }else if( $search && $i_f === 0){
                        $sql.=" AND ";
                    }else{
                        $sql.=" OR ";
                    }
                    
                    $sql.="$key='$value' ";
					$i_f++;
				}
            }

            if( $sort_by ){
                $sort = explode(":", $sort_by );

                $sql.= " ORDER BY $sort[0] $sort[1]";
            }else{
                $sql.=' ORDER BY `id` DESC '; 
            }

            $count_all = $UserModel->db->query( $sql )->getNumRows();

            
            $offset    = ( $page - 1 ) * $per_page;
            
            if( $page || $per_page  ){
                $sql.=" LIMIT $per_page OFFSET $offset ";
            }

            $data = $UserModel->db->query( $sql )->getResultArray();
         
            $pagination = [
                "per_page" => (int)$per_page,
                "page"     => (int)$page,
                "offset"   => (int)$offset,
                "count_all" => (int)$count_all,
            ];

            $output = [
               "pagination" => $pagination,
               "data" => $data,
            ];

            return $output;

        }


        public function add()
        {
           
            $rules       = $this->getRulesAdd();
            $validation  = $this->validation( $rules );

            if( ! $validation["success"] ) return $this->errorOutput( $validation['message'] );

            $name     = $this->request->getPost("name");
            $username = $this->request->getPost("username");
            $password = $this->request->getPost("password");
            $role     = $this->request->getPost("role");
            $now      = Time::now('Asia/Jakarta','id')->getTimestamp();

            $data = [
                "name"       => $name,
                "username"   => $username,
                "password"   => sha1( $password ),
                "role"       => $role,
                "created_at" => $now,
                "updated_at" => $now,
            ];

            $UsersModel = new UsersModel();
            $Karyawans  = new Karyawans();

            $UsersModel->db->transBegin();
            
                $UsersModel->insert( $data );
                
                $user_id = $UsersModel->getInsertID();
                $Karyawans->addTemp( $user_id );
            
            $UsersModel->db->transComplete();

            if( $UsersModel->db->transStatus() === false ){
                return $this->errorOutput('gagal menyimpan');
            }
        
            return $this->successOutput(["successs" => true ]);
        }


        public function update( $id )
        {
            $rules       = $this->getRulesUpdate();
            $validation  = $this->validation( $rules );

            if( ! $validation["success"] ) return $this->errorOutput( $validation['message'] );

            $name = $this->request->getJsonVar('name');
            $role = $this->request->getJsonVar('role');

            $now  = Time::now('Asia/Jakarta','id')->getTimestamp();

            $UsersModel = new UsersModel();
            $UsersModel->update( $id , [ "name" => $name, "role" => $role, "updated_at" => $now ]);

            return $this->successOutput( [ "success" => true ] );
        }


        public function updatePwd(){
            $id              = $this->request->getVar('user_id');
            $role_access     = $this->request->getVar('role_access');
            $password        = $this->request->getVar('password');
            $old_password    = $this->request->getVar('old_password');

            if( $role_access === "KARYAWAN"){
                $cek = $this->checkPwd( $id, $old_password );
    
                if( ! $cek ) return $this->errorOutput('password Sebelumnya Salah');
            }

            $UsersModel = new UsersModel();
            $UsersModel->update( $id , [ "password" => sha1( $password ) ]);

            return $this->successOutput( [ "success" => true ] );
        }

        // function username_check_blank($str) {
        //     $validation =  \Config\Services::validation();
        //     $pattern = '/ /';
        //     $result = preg_match($pattern, $str);

        //     if ($result) {
        //         // $validation->form_validation->set_message('username_check', 'The %s field can not have a " "');
        //         return FALSE;
        //     } else {
        //         return TRUE;
        //     }
        // }

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
                    'rules' => 'required|is_unique[users.username]|alpha',
                    'errors' => [
                        "required" => "{field} tidak boleh kosong",
                        "is_unique" => "Username Tidak Boleh Sama",
                        "alpha" => "Username tidak boleh berisi spasi atau simbol"
                    ]
                ],
                'password' => [
                    'rules' => 'required',
                    'errors' => [
                        "required" => "{field} tidak boleh kosong",
                    ]
                ],
                'role' => [
                    'rules' => 'required',
                    'errors' => [
                        "required" => "{field} tidak boleh kosong",
                    ]
                ],
                'confirmation_password' => [
                    'rules' => 'required|matches[password]',
                    'errors' => [
                        "required" => "{field} tidak boleh kosong",
                        "matches" => "password dan Konfirmasi password harus sama",
                    ]
                ],
            ];
        }

        function alpha_numeric_spaces($fullname){
            if (! preg_match('/^[a-zA-Z\s]+$/', $fullname)) {
                $this->form_validation->set_message('alpha_dash_space', 'The %s field may only contain alpha characters & White spaces');
                return FALSE;
            } else {
                return TRUE;
            }
        }


        public function getRulesUpdate()
        {
            return [
                'name' => [
                    'rules' => 'required',
                    'errors' => [
                        "required" => "{field} tidak boleh kosong",
                    ]
                ],
                'role' => [
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


        public function delete( $id ){

            $UsersModel = new UsersModel();
            $UsersModel->db->transBegin();

            $UsersModel->delete( $id );
         
            $Karyawans = new Karyawans();
            $Karyawans->deleteImg( $id );
        
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