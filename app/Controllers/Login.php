<?php
    namespace App\Controllers;
    
    use App\Controllers\BaseController;
    use App\Models\UsersModel;

    class Login extends BaseController
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
                echo 'username/password jangan ada yang kosong ';
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
                return;
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