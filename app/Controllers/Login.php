<?php
    namespace App\Controllers;
    
    use App\Controllers\BaseController;
    use App\Models\UsersModel;
    use App\Libraries\ApiKey;

    class Login extends ApiController
    {
        public function index()
        {
            view('login');
        }


        public function auth()
        {
            $rules = [
                "username" => 'required',
                "password" => 'required'
            ];

            $valid = $this->validation( $rules );

            if( !$valid ) {
                return $this->errorOutput(  'username/password jangan ada yang kosong' );
            }
            
            $username    = $this->request->getPost("username");
            $password    = $this->request->getPost("password");
            $check       = $this->checkInDb( $username, $password );
          
            if( ! $check["success"] ){
                return $this->errorOutput('Kesalahan Credential');
            }


            $api_key = ApiKey::generate( $username, $password );


            $data = [ "api_key" => $api_key, "data" => $check["data"] ];
            return $this->successOutput( $data );
        }

        /**
         * 
         * @return []
         */
        public function checkInDb( $username, $password ){
            $data = [ 
                'username' => $username,
                'password' => sha1( $password ),
            ];

            $users_model = new UsersModel();
            $auth = $users_model->where( $data )->find();

            if( !$auth ){
                return ['success' => false ];
            }else{
                return ["success" => true , "data" => $auth ];
            }
        }


        protected function validation( $rules )
        {
            if( !$this->validate( $rules )){
                return false;
            }

            return true;
        }
    }
?>