<?php
    namespace App\Controllers;

    use CodeIgniter\Controller;
    use App\Models\UsersModel;
    use App\Models\AbsensModel;
    use CodeIgniter\I18n\Time;
    use stdClass;

    class Absens extends ApiController
    {

        
        public function index()
        {
            $search        = $this->request->getGet('search') ;
            $page          = (int)$this->request->getGet('page') ?? 1;
            $per_page      = (int)$this->request->getGet('per_page') ?? 10;
            
            $sort_by       = $this->request->getGet('sort_by');
            $filter        = $this->request->getGet('filter');
            
            $has_absen     = $this->request->getGet('has_absen') ;
            $start_date    = $this->request->getGet('start_date') ?? strtotime( date('m-01-Y 00:00:00' ) );
            $end_date      = $this->request->getGet('end_date') ??  Time::now('Asia/Jakarta','id')->getTimestamp();

            $search = trim( $search );

            $output = $this->getSyntax( $search, $start_date, $end_date, $has_absen, $sort_by, $filter, $page, $per_page);

            return $this->successOutput( $output, 200 ) ;
        }


        private function getSyntax( $search, $start_date, $end_date , $has_absen = "Y", $sort_by, $filter = "", $page = 1, $per_page = 10 )
        {
            $AbsenModel = new AbsensModel();

            $base = "";

            if( $has_absen === 'N'){
                $base = $this->getNoAbsen( $search, $start_date, $end_date, $sort_by , $filter, $page, $per_page );
            }else{
                $base = $this->getHasAbsen( $search, $start_date, $end_date, $sort_by, $filter, $page, $per_page );
            }

            $data = $AbsenModel->db->query( $base["sql"] )->getResultArray();

            $pagination = [
                "per_page" => (int)$per_page,
                "page"     => (int)$page,
                "offset"   => (int)$base["offset"],
                "count_all" => (int)$base["count_all"],
            ];

            $output = [
               "pagination" => $pagination,
               "data" => $data,
            ];

            return $output;
        }

        private function getNoAbsen( $search, $start_date, $end_date, $sort_by = "`users`.`id`:DESC", $filter, $page, $per_page ){
            $AbsenModel = new AbsensModel();

            $base = "";

            if( $search ){
                $base = "SELECT * FROM `users` CROSS JOIN `karyawans` ON `users`.`id` = `karyawans`.`user_id`  WHERE `users`.`id` NOT IN ( SELECT `user_id` FROM `absens` WHERE `absens`.`created_at` BETWEEN $start_date AND $end_date ) AND `users`.`name` LIKE '%$search%' OR `karyawans`.`address` LIKE '%$search%'";
            }else{
                $base = "SELECT * FROM `users` CROSS JOIN `karyawans` ON `users`.`id` = `karyawans`.`user_id`  WHERE `users`.`id` NOT IN ( SELECT `user_id` FROM `absens` WHERE `absens`.`created_at` BETWEEN $start_date AND $end_date )";
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
            }

            $count_all = $AbsenModel->db->query( $base )->getNumRows();
            
            $offset    = ( $page - 1 ) * $per_page;
            
            if( $page || $per_page  ){
                $base.=" LIMIT $per_page OFFSET $offset";
            }
            
            

            return [ "sql" => $base, "count_all" => $count_all, "offset" => $offset ];
        }


        private function getHasAbsen( $search, $start_date, $end_date, $sort_by = "`absens`.`id`:DESC", $filter, $page, $per_page ){
            $base = "SELECT `absens`.`id` AS `absen_id`, `users`.`name` AS `name`,`karyawans`.`position` AS `position`,`absens`.`created_at` AS `created_at`,`absens`.`status` AS `status`,`absens`.`description` AS `description` FROM `users` CROSS JOIN `absens` ON `absens`.`user_id` = `users`.`id` CROSS JOIN `karyawans` ON `users`.`id`=`karyawans`.`user_id` WHERE `absens`.`created_at` BETWEEN $start_date AND $end_date";
            
            if( $search ){
                $base .=" AND `users`.`name` LIKE '%$search%' ";
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
            }

            

            $AbsenModel= new AbsensModel();
            $count_all = $AbsenModel->db->query( $base )->getNumRows();
            

            $offset = ( $page - 1 ) * $per_page;

           
            if( $page || $per_page  ){
                $base.=" LIMIT $per_page OFFSET $offset";
            }

            return [ "sql" => $base, "count_all" => $count_all, "offset" => $offset ];
        }




        public function getById( $user_id ){
            $search        = $this->request->getGet('search') ;
            // $has_absen     = $this->request->getGet('has_absen') ;
            $start_date    = $this->request->getGet('start_date') ?? strtotime( date('m-01-Y 00:00:00' ) );
            $end_date      = $this->request->getGet('end_date') ??  Time::now('Asia/Jakarta','id')->getTimestamp();

            $AbsenModel    = new AbsensModel();
            $sql = $AbsenModel -> where('user_id', $user_id )
                               -> where('created_at>=', $start_date )
                               -> where('created_at<=', $end_date )
                               -> get()->getResultArray();

            $data = [ "data" => $sql ];

            return $this->successOutput( $data );
            
        }

        public function add()
        {
            $rules       = $this->getRules();
            $validation  = $this->validation( $rules );

            if( ! $validation["success"] ) return $this->errorOutput( $validation['message'] );

            $user_id      = $this->request->getPost("user_id");
            $status       = $this->request->getPost("status");
            $description  = $this->request->getPost("description");
            $now          = Time::now('Asia/Jakarta','id')->getTimestamp();


            $data = [ 
                "user_id"     => $user_id,
                "status"      => $status,
                "description" => $description,
                "created_at"  => $now,
                "updated_at"  => $now,
            ];

            $AbsenModel = new AbsensModel();
            $AbsenModel->insert( $data );

            return $this->successOutput([]);
        }

        public function multiAdd(){
            $data = $this->request->getPost('absens');

            if( ! $data )return $this->errorOutput("Data Tidak Boleh Kosong");
    
            
            $datas = json_decode( $data );

            if( ! $datas ) return $this->errorOutput("Data Tidak Boleh Kosong");

            foreach ( $datas as $key => $value ) {
                $datas[ $key ] = new stdClass();
                $datas[ $key ]->created_at = $this->now();
                $datas[ $key ]->updated_at = $this->now();
                $datas[ $key ]->user_id = $value->user_id;
                $datas[ $key ]->status = $value->status;
                $datas[ $key ]->description = $value->description ?? '';
            }

            $AbsenModel = new AbsensModel();
            $AbsenModel->insertBatch( $datas );

        }

        private function now(){
            return Time::now('Asia/Jakarta','id')->getTimestamp();
        }

        public function update( $absen_id )
        {
            $rules       = $this->getRules();
            $validation  = $this->validation( $rules );

            if( ! $validation["success"] ) return $this->errorOutput( $validation['message'] );

            $status       = $this->request->getPost("status");
            $description  = $this->request->getPost("description");

            $data = [ 
                "status"    => $status,
                "description" => $description,
            ];

            $AbsenModel = new AbsensModel();
            $AbsenModel->update( $absen_id, $data );

            return $this->successOutput([]);
        }


        public function getRules()
        {
            return [
                'user_id' => [
                    'rules' => 'required',
                    'errors' => [
                        "required" => "{field} tidak boleh kosong",
                       
                    ]
                ],
                'status' => [
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
    }

?>