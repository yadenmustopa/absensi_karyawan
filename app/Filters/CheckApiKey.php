<?php
    namespace App\Filters;   

    use CodeIgniter\HTTP\RequestInterface;
    use CodeIgniter\HTTP\ResponseInterface;
    use CodeIgniter\HTTP\Message;
    use CodeIgniter\Filters\FilterInterface;

    class CheckApiKey implements FilterInterface
    {
        public function before( RequestInterface $request, $arguments =  null)
        {
            $path = uri_string(true);   

            if( $path !== 'login' || $path !== 'auth' ){
                $message = new Message();
                $header  = $message->getHeaderLine('api-key');
                var_dump($header);
            }


            var_dump( $path );
        }

        public function after( RequestInterface $request, ResponseInterface $response, $arguments =  null)
        {
            
        }
    }
?>