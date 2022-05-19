<?php
	
	
	namespace App\Libraries;
	
	use CodeIgniter\Encryption\EncrypterInterface;
	
	class ApiKey
	{
		
		/**
		 * Generate Api Key
		 *
		 * @param string $username username
		 * @param string $password password
		 * @return string
		 */
		public static function generate( string $username , string $password ) : string
		{
			$data = [
				'username' => $username,
				'password' => $password
			];
			
			$data = json_encode( $data );
			
			$encrypter 	= \Config\Services::encrypter();
			$api_key 	= $encrypter->encrypt( $data );
			
			$api_key 	= base64_encode( $api_key);
			
			return $api_key;
		}
		
		
		/**
		 * Translate Api Key
		 *
		 * @param string $api_key api_key
		 * @return object
		 */
		public static function translate( string $api_key ) : array
		{
			$api_key = base64_decode( $api_key );
			
			$api_token =  \Config\Services::encrypter()->decrypt( $api_key );
			
			$api_token = json_decode($api_token, true);
			return $api_token;
		}
		
		
	}