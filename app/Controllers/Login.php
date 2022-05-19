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
            
            $users_model = new UsersModel();
            $username    = $this->request->getPost("username");
            $password    = $this->request->getPost("password");



            $data = [ 
                'username' => $username,
                'password' => sha1( $password ),
            ];
            
            $auth = $users_model->where( $data )->find();

            if( ! $auth ){
                return $this->errorOutput('Kesalahan Credential');
            }


            $api_key = ApiKey::generate( $username, $password );


            $data = [ "api_key" => $api_key ];
            return $this->successOutput( $auth, );
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