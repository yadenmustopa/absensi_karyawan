<?php
	
	namespace App\Controllers;
	
	
	use App\Filters\DocFilter;
	use App\Libraries\Xml;
	use CodeIgniter\API\ResponseTrait;
	use CodeIgniter\Controller;
	use CodeIgniter\Database\MySQLi\Connection;
	use CodeIgniter\HTTP\RequestInterface;
	use CodeIgniter\HTTP\ResponseInterface;
	use Config\Database;
	use Psr\Log\LoggerInterface;
	
	/**
	 * Class ApiController.
	 *
	 * Perform basic task of API / RESTFUL request
	 *
	 * @author yaden mustopa https://github.com/yaden
	 */
	class ApiController extends Controller
	{
		use ResponseTrait;
		
		public  $supportedResponseFormats = [
			'application/json',
			'application/xml',
		];
		
		public  $formatters = [
			'application/json' => \CodeIgniter\Format\JSONFormatter::class,
			'application/xml' => \CodeIgniter\Format\XMLFormatter::class,
		];
		
		/**
		 * An array of helpers to be loaded automatically upon
		 * class instantiation. These helpers will be available
		 * to all other controllers that extend BaseController.
		 *
		 * @var array
		 */
		protected $helpers = ['common'];
		
		/**
		 * Constructor.
		 * @param RequestInterface $request
		 * @param ResponseInterface $response
		 * @param LoggerInterface $logger
		 */
		public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
		{
			// Do Not Edit This Line
			parent::initController($request, $response, $logger);
			
			/*
			 * Karena pada dasarnya MySQLi selalu menganggap angka (int/float) sebagai string
			 * solusinya harus pakai MYSQLI_OPT_INT_AND_FLOAT_NATIVE di mysqli_options nya
			 * nah, problemnya di codeigniter4 gak ada / belum disediain fungsi
			 * buat set langsung via interface nya
			 * dan gue gamau tangan gue ngoprek source asli si codeigniter
			 * jadi dengan itu terpaksa harus bikin base nya dulu disini
			 *
			 * dah, pokonya kalo ga ngerti apa2 gausah ngoprek2 codingan ini
			 */
			
			$DB = Database::connect(); // ambil koneksi
			$DB->reconnect(); // reconnect biar konek dulu, karna inisialisasi nya begitu
			if(!empty($DB->mysqli)) {
				$DB->mysqli->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE, true);
			}
			
			if(env('api.status') === 'maintenance') {
				header('Retry-After:3600');
				$this->exitOutput('api.maintenance', 503); // exit
			}
//			header("Access-Control-Allow-Origin: null");
//			header("Access-Control-Allow-Origin: *");
////			header("Access-Control-Allow-Headers: origin, x-requested-with, content-type");
//			header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
//			header("Content-Type:application/json");
			
			$this->response->setHeader('Access-Control-Allow-Origin', '*')
			->setHeader('Access-Control-Allow-Header', '*')
			->setHeader('Access-Control-Allow-Methods', 'PUT, GET, POST, DELETE, OPTIONS')
			->setHeader("Content-Type","application/json");
			
			
//			$method = $_SERVER['REQUEST_METHOD'];
//			if($method == "OPTIONS") {
//				die();
//			}
			
		}
		
		public function options()
		{
			header("Access-Control-Allow-Methods: *");
			return $this->respondNoContent();
		}
		
		/**
		 * Send Output to user auto detect success or error
		 *
		 * @param array $output [success, message, ..data]
		 * @param null $code
		 * @return mixed
		 */
		public function sendOutput(array $output, $code=null)
		{
//			$this->response->setHeader('Access-Control-Allow-Origin', 'null')
//				->setHeader('Access-Control-Allow-Origin', '*')
//				->setHeader('Access-Control-Allow-Header', '*')
//				->setHeader('Access-Control-Allow-Methods', 'POST,GET,PUT,PATCH,DELETE');
//				->setHeader("Content-Type","application/json");
			
			
			$method = $_SERVER['REQUEST_METHOD'];
			if($method == "OPTIONS") {
//				die();
			}
			
			$output['elapsed_time'] = '{elapsed_time} (s)';
			$output['memory_usage'] = memory_get_usage(true);
			if (empty($output['success'])) {
				$output['success'] = false;
				$output['message'] = $output['message'] ?? 'No error message returned';

//            return $this->respond($output, $code ?? 400);
			}
			
			// For documentation purposes
			if($this->request->getGet('docs') === 'Y') {
				unset($output['elapsed_time'], $output['memory_usage']);
				$output = DocFilter::output($output);
			}
			
			return $this->respond($output, $code ?? 200);
		}
		
		/**
		 * Send Success output directly to user
		 *
		 * @param array $data
		 * @param int $code
		 * @return mixed
		 */
		public function successOutput(array $data, int $code=200)
		{
			
			$output['success'] = true;
			$output = array_merge($output, $data);
			return $this->sendOutput($output,$code);
		}
		
		/**
		 * Send error output which is bad request 400
		 *
		 * @param string $message
		 * @param int $code
		 * @param array $args
		 * @return mixed
		 */
		public function errorOutput(string $message, int $code=400, array $args = [])
		{
			$output = [];
			$output['success'] = false;
			if(!empty(lang($message))) {
				$output['error_code'] = $message;
				$message = lang($message, $args);
			}
			$output['message'] = $message;
			return $this->sendOutput($output, $code);
		}
		
		
		/**
		 * If need to exit immediately
		 * @param string $lang
		 * @param int $code
		 */
		protected function exitOutput(string $lang = "", int $code = 500): void
		{
			\http_response_code($code);
			
			$accept = $this->request->getHeaderLine('accept') ?? 'application/json';
			
			$output = [
				'success' => false,
			];
			
			if(!empty(lang($lang))) {
				$output['error_code'] = $lang;
				$lang = lang($lang);
			}
			$output['message'] = $lang;
			
			if ($accept === 'application/xml') {
				header("Content-Type:application/xml");
				echo Xml::array2xml($output);
			} else {
				header("Content-Type:application/json");
				echo json_encode($output);
			}
			exit();
		}
		
	
		protected function cekValidation( array $options )
		{
			$validation = $this->validate(  $options  );
			
			if( $validation ){
				return ["is_valid" => true ];
			}
			
			$validation = \Config\Services::validation();
			$errors = $validation->getErrors();
			$error  = "";
			$i      = 0;
			//diloop heula ambil loop pertama
			foreach ( $errors as $key => $value){
				$error = $value;
				if( $i === 0 ) break;
			}
			
			return [ "is_valid" => false, "error" => $error ];
		}
		
		
		protected function errorValidation( $error ){
			$this->errorOutput( $error );
		}
	}
