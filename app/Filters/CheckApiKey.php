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
            header('Access-Control-Allow-Origin: NULL');
            header('Access-Control-Allow-Origin: *');
            header("Access-Control-Allow-Headers: HTTP_KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, DELETE");

            $method = $_SERVER['REQUEST_METHOD'];
      
            if ($method == "OPTIONS") {
            die();
            }

            $path = uri_string(true);   
            
            if( $path === 'login' OR $path === 'auth' OR $path === '' ){
                
            }else{
                $ApiController   = new ApiController();
                
                try{
                    $api_key  = $_SERVER['HTTP_KEY'];
                    if( !$api_key || ! $_SERVER['HTTP_KEY'] ) return $ApiController->errorOutput("tidak di ijinkan mengakses", 401 );
                    
                    
                    $check = $this->checkApiKey( $api_key );
                    if( ! $check ) return $ApiController->errorOutput('key tidak berlaku' );
                    
                }catch( Exception $err ){
                    $ApiController->errorOutput('Anda Tidak Di ijinkan mengakses tanpa token', 401 );
                }
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