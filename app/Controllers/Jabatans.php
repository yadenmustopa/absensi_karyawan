<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JabatansModel;
use CodeIgniter\I18n\Time;

class Jabatans extends ApiController
{


    public function index()
    {
        $search = $this->request->getGet('search');
        $sql = "";
        
        $JabatansModel = new JabatansModel();
        if( $search ){
            $sql = $JabatansModel->like('name',$search)->orLike('description', $search)->get()->getResultArray();
        }else{
            $sql = $JabatansModel->get()->getResultArray();
        }

        $data = ["data" => $sql ];
        
        return $this->successOutput( $data );
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
