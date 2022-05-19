<?php
	
	
	namespace CodeIgniter\Filters;
	
	
	class DocFilter
	{
		private static function processOutput( $output ){
			if( gettype( $output ) === 'object' ){
				//jadiin loop dulu
				$output = ( array ) $output;
				$result = [];
				foreach( $output as $key => $o ){
					$result[$key] = self::processOutput( $o );
				}
				
				return (object)$result;
			}
			else if( gettype( $output ) === 'array' ){
				$result = [];
				foreach( $output as $index => $o ){
					//process index pertama aja
					if( $index > 0 ) break;
					
					$result[$index] = self::processOutput( $o );
				}
				
				return $result;
			}
		}
		
		public static function output( $outputs ){
			$outputs = ( array ) $outputs;
			$result  = [];
			foreach( $outputs as $key => $output ){
				$result[$key] = self::processOutput( $output);
			}
			
			return $result;
		}
	}