<?php
    namespace App\Filters;   

    use CodeIgniter\HTTP\RequestInterface;
    use CodeIgniter\HTTP\ResponseInterface;
    use CodeIgniter\HTTP\Message;
    use CodeIgniter\Filters\FilterInterface;
    use App\Controllers\Login;
    use App\Controllers\ApiController;
    use App\Libraries\ApiKey;
use Exception;

    class CheckApiKey implements FilterInterface
    {
        public function before( RequestInterface $request, $arguments =  null)
        {
            $path = uri_string(true);   
            
            if( $path === 'login' OR $path === 'auth' OR $path === '' ){
                
            }else{
                $ApiController   = new ApiController();
                $api_key  = $_SERVER['HTTP_KEY'];
                if( !$api_key || ! $_SERVER['HTTP_KEY'] ) return $ApiController->errorOutput("tidak di ijinkan mengakses", 401 );
                
                
                $check = $this->checkApiKey( $api_key );
                if( ! $check ) return $ApiController->errorOutput('key tidak berlaku', 401 );
                
            }

        }

        /**
         * @param string api key
         * 
         */
        private function checkApiKey( $api_key ){
  
            $Login           = new Login();

            try{

                $data            = ApiKey::translate( $api_key );
                $username        = $data["username"];
                $password        = $data["password"];
                $check = $Login->checkInDb( $username, $password );

            }catch( Exception $e ){
                return false;
            }
            

            return $check["success"];
        }

        public function after( RequestInterface $request, ResponseInterface $response, $arguments =  null)
        {
            
        }
    }
?>