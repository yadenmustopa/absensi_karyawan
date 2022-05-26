<?php
    namespace App\Controllers;

    use CodeIgniter\Controller;
    use App\Models\KaryawansModel;
    use CodeIgniter\I18n\Time;

    class Karyawans extends ApiController
    {

        public function index()
        {
            $karyawans_model  = new KaryawansModel();
            $sql              = $karyawans_model->findAll();
            $count_all_result = $this->getCountResultArray();
 
            $data = [ 
                "data"      => $sql,
                "count_all" => $count_all_result,
            ];

            return $this->successOutput( $data );
        }

        private function getCountResultArray(){
            
            $karyawans_model = new KaryawansModel();
            $sql             = $karyawans_model->get()->getNumRows();
            return $sql;
        }

        public function add()
        {
            $rules           = $this->getRulesAdd();
            $valid           = $this->validation( $rules );

            if( ! $valid['success'] ) return $this->errorOutput( $valid['message']) ;

            
            $user_id         = $this->request->getPost('user_id');
            $address         = $this->request->getPost('address');
            $position        = $this->request->getPost('position');
            $salary          = $this->request->getPost('salary');
            $no_hp           = $this->request->getPost('no_hp');

            $now      = Time::now('Asia/Jakarta','id')->getTimestamp();
            
            $karyawan = [
                'user_id'  => $user_id,
                'address'  => $address,
                'position' => $position,
                'salary'   => $salary,
                'no_hp'    => $no_hp,
                'updated_at' => $now,
                'created_at' => $now,
            ];

            $karyawans_model = new KaryawansModel();
            $karyawans_model->insert( $karyawan );

            return $this->successOutput([]);
        }


        public function addTemp( $user_id ){
            $now      = Time::now('Asia/Jakarta','id')->getTimestamp();
            $KaryawansModel = new KaryawansModel();

            $data = [ 
                "user_id"    => $user_id ,
                "created_at" => $now,
                "updated_at" => $now
            ];
            $KaryawansModel->insert($data);
        }

        public function update( $id )
        {

            // $validation =  \Config\Services::validation();
            $rules           =  $this->getRulesUpdate();

            $valid           = $this->validation( $rules );

            if( ! $valid ) return $this->errorOutput( $valid["message"] );

          
            $address         = $this->request->getVar('address');
            $position        = $this->request->getVar('position');
            $salary          = $this->request->getVar('salary');
            $no_hp           = $this->request->getVar('no_hp');
            $now             = Time::now('Asia/Jakarta','id')->getTimestamp();
         
            $data = [
                "address"    => $address,
                "position"   => $position,
                "salary"     => $salary,
                "no_hp"      => $no_hp,
                "updated_at" => $now,
            ];

            $karyawans_model = new KaryawansModel();

            $karyawans_model->update( $id, $data );

            return $this->successOutput( [ 'success' => true ] );
        }


        public function upload( $karyawan_id ){

            // $rules = $this->getRulesUpload();
            // $valid = $this->validation( $rules );
           
            // if( ! $valid['success'] ) return $this->errorOutput( $valid['message' ]);
            // $form = json_decode($this->request->getBody());
            // var_dump( $form );
            $img = $this->request->getPost('photo');
            
            $img = str_replace('data:image/webp;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            // var_dump( $data );
            $uniq_id = uniqid();
            
            $file = FCPATH.'/uploads/' . $uniq_id . '.webp';

            $success = file_put_contents($file, $data);
    
            if( !$success ){
                return $this->errorOutput('gagal mengupload');
            }
            // var_dump( $photo );
            // var_dump( $test_request );
            // $img = $this->request->getFile('photo');
            // $name = $img->getRandomName();
            // $img->move('upload',$name);
            // $data = [ "photo" => 'upload/'.$name ];

            $karyawans_model = new KaryawansModel();
            $karyawans_model->update( $karyawan_id, ["photo" => 'uploads/'.$uniq_id.'.webp'] );

            return $this->successOutput(["success" => true]);
        }

        /**
         * @param id int
         */
        public function deleteImg( $user_id = 1  )
        {
            
            $path = $this->getPathPhoto( $user_id );

            if( $path === 'assets/images/avatar.png' || ! $path ) return;

            unlink( $path );
            return;
        }


        private function getPathPhoto( $user_id )
        {
            $db      = \Config\Database::connect();
            $builder = $db->table('karyawans');        // 'mytablename' is the name of your table

            $builder->select('photo');       // names of your columns
            $builder->where('user_id', $user_id );                // where clause
            $query = $builder->get()->getFirstRow();

            if( $query ){
                return $query->photo;
            }else{
                return null;
            }
        }


        private function getRulesUpload()
        {
            return [
                // 'photo' => [
                //     'rules' => 'uploaded[photo]|max_size[photo,2024]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]',
                //     'errors' => [
                //         "uploaded" => "Photo tidak boleh kosong",
                //         "max_size" => "ukuran photo tidak boleh lebih dari 2mb",
                //         "is_image" => "pastikan yang di upload adalah file gambar",
                //         "mime_in"  => "masukan file jpg/jpeg/png"
                //     ]
                // ]
            ];
        }


        private function getRulesAdd()
        {
            return [
                'user_id' => [
                    'rules' => 'required',
                    'errors' => [
                        "required" => "{field} tidak boleh kosong",
                    ]
                ],
                'address' => [
                    'rules' => 'required',
                    'errors' => [
                        "required" => "{field} tidak boleh kosong",
                    ]
                ],
                'position' => [
                    'rules' => 'required',
                    'errors' => [
                        "required" => "{field} tidak boleh kosong",
                    ]
                ],
                'salary' => [
                    'rules' => 'required',
                    'errors' => [
                        "required" => "{field} tidak boleh kosong",
                    ]
                ],
                'no_hp' => [
                    'rules' => 'required',
                    'errors' => [
                        "required" => "{field} tidak boleh kosong",
                    ]
                ],
            ];
        }


        private function getRulesUpdate()
        {
            return [
                'address' => [
                    'rules' => 'required',
                    'errors' => [
                        "required" => "{ field } tidak boleh kosong",
                    ]
                ],
                'position' => [
                    'rules' => 'required',
                    'errors' => [
                        "required" => "{ field } tidak boleh kosong",
                    ]
                ],
                'salary' => [
                    'rules' => 'required',
                    'errors' => [
                        "required" => "{ field } tidak boleh kosong",
                    ]
                ],
                'no_hp' => [
                    'rules' => 'required',
                    'errors' => [
                        "required" => "{field tidak boleh kosong",
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