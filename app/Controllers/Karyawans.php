<?php
    namespace App\Controllers;

    use CodeIgniter\Controller;
    use App\Models\KaryawansModel;
    use CodeIgniter\I18n\Time;

    class Karyawans extends ApiController
    {

        public function index()
        {
            $karyawans_model = new KaryawansModel();
            $$sql            = $karyawans_model->findAll();

            $data = [ "data" => $sql ];
            return $this->successOutput( $data );
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

        public function update( $id )
        {
            // $validation =  \Config\Services::validation();
            $rules           =  $this->getRulesUpdate();

            $valid           = $this->validation( $rules );

            if( ! $valid ) return $this->errorOutput( $valid["message"] );

            $address         = $this->request->getVar('address');
            $position        = $this->request->getVar('position');
            $salary          = $this->request->getVar('salary');
            $now             = Time::now('Asia/Jakarta','id')->getTimestamp();
         
            $data = [
                "address"    => $address,
                "position"   => $position,
                "salary"     => $salary,
                "updated_at" => $now,
            ];

            $karyawans_model = new KaryawansModel();

            $karyawans_model->update( $id, $data );

            return $this->successOutput( [ 'success' => true ] );
        }


        public function upload( $id ){

            $rules = $this->getRulesUpload();
            $valid = $this->validation( $rules );
           
            if( ! $valid['success'] ) return $this->errorOutput( $valid['message' ]);

            $img = $this->request->getFile('photo');
            $name = $img->getRandomName();
            $img->move('upload',$name);
            $data = [ "photo" => 'upload/'.$name ];

            $karyawans_model = new KaryawansModel();
            $karyawans_model->update( $id, $data );


            return $this->successOutput(["success" => true]);
        }


        private function getRulesUpload()
        {
            return [
                'photo' => [
                    'rules' => 'uploaded[photo]|max_size[photo,2024]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]',
                    'errors' => [
                        "uploaded" => "Photo tidak boleh kosong",
                        "max_size" => "ukuran photo tidak boleh lebih dari 2mb",
                        "is_image" => "pastikan yang di upload adalah file gambar",
                        "mime_in"  => "masukan file jpg/jpeg/png"
                    ]
                ]
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