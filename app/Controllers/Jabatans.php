<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JabatansModel;
use CodeIgniter\I18n\Time;

class Jabatans extends ApiController
{


    public function index()
    {
        $JabatansModel = new JabatansModel();   
        $search        = $this->request->getGet('search');
        $page          = ( int )$this->request->getGet('page') ?? 1 ;
        $per_page      = ( int )$this->request->getGet('per_page') ?? 10 ;
        $sort_by       = $this->request->getGet('sort_by')?? "id:DESC";
        $filter        = $this->request->getGet('filter');

        if( $search ){
            $JabatansModel->like("name", $search);
            $JabatansModel->orlike("description", $search);
        }

        
        if( $filter ){
            $i_f    = 0;
            $filter = explode(';', $filter);
            
            foreach ($filter as $d_f) {
                $f = explode(':', $d_f);
        
                $key   = $f[0];
                $value = $f[1];
     
                if ($i_f === 0 ){
                    $JabatansModel->where( $key , $value);
                }else{
                    $JabatansModel->orWhere( $key, $value);
                }

                $i_f++;
            }
        }

        if( $sort_by ){
            $sort = explode(":", $sort_by );

            var_dump( $sort );
            // $JabatansModel->orderBy( $sort[0], $sort[1]);
            $JabatansModel->orderBy( "name", "DESC");
        }

        $count_all = $JabatansModel->get()->getNumRows();
        
        $offset    = ( $page - 1 ) * $per_page;
        
        if( $page || $per_page  ){
            $JabatansModel->offset( $offset );
            $JabatansModel->limit( $per_page );
        }

        $data = $JabatansModel->get()->getResultArray();
     
        $pagination = [
            "per_page" => (int)$per_page,
            "page"     => (int)$page,
            "offset"   => (int)$offset,
            "count_all" => (int)$count_all,
        ];

        $output = [
           "pagination" => $pagination,
           "data"       => $data,
        ];

        return $this->successOutput( $output );
    }

    public function add()
    {
        $rules = $this->rulesAdd();
        $validation = $this->validation( $rules );

        if( ! $validation['success'] ) return $this->errorOutput( $validation['message'] );

        $name        = strtoupper($this->request->getPost('name'));
        $description = $this->request->getPost('description');
        $now         = $this->nowTimestamp();
        
        $data = [
            "name" => $name,
            "description" => $description,
            "created_at" => $now,
            "updated_at" => $now,
        ];

        $JabatansModel = new JabatansModel();
        $JabatansModel->insert( $data );

        $id = $JabatansModel->getInsertID();

        return $this->successOutput([ "id" => $id ]);
    }

   

    public function update( $id )
    {
        $JabatansModel   = new JabatansModel();
        $before_name     = $JabatansModel->find( $id )['name'];
        $name            = strtoupper( $this->request->getJsonVar('name') );
        $description     =  $this->request->getJsonVar('description');
        $rule            = [];

        if( $before_name === $name ){
            $rule = $this->rulesUpdateNotUnique();
        }else{
            $rule = $this->rulesUpdateUnique();
        }

        $validation = $this->validation( $rule );

        if( ! $validation['success'] ) return $this->errorOutput( $validation['message'] );

        $data = [
            "name" => $name,
            "description" => $description,
            "updated_at"  => $this->nowTimestamp()
        ];

        $JabatansModel = new JabatansModel();
        $JabatansModel->update( $id, $data );

        return $this->successOutput([]);
    }

    public function delete( $id )
    {
        $JabatansModel = new JabatansModel();
        $JabatansModel->delete( $id );

        return $this->successOutput([]);
    }


    private function rulesAdd(){
        return [ 
            'name' => [
                'rules' => 'required|is_unique[jabatans.name]',
                'errors' => [
                    'required' => 'Nama jabatan Harus Di isi',
                    'is_unique' => 'Nama Jabatan Sudah Ada',
                ]
            ]
        ];
    }

    private function rulesUpdateUnique(){
        return [ 
            'name' => [
                'rules' => 'required|is_unique[jabatans.name]',
                'errors' => [
                    'required' => 'Nama jabatan Harus Di isi',
                    'is_unique' => 'Nama Jabatan Sudah Ada',
                ]
            ]
        ];
    }

    private function rulesUpdateNotUnique(){
        return [ 
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama jabatan Harus Di isi',
                ]
            ]
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

    private function nowTimestamp(){
        return Time::now('Asia/Jakarta','id')->getTimestamp();
    }

}
