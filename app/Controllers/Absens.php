<?php
    namespace App\Controllers;

    use CodeIgniter\Controller;
    use App\Models\KaryawansModel;
    use CodeIgniter\I18n\Time;

    class Absens extends BaseController
    {
        public function index()
        {
            $name        = $this->request->getGet('name');
            $start_date  = $this->request->getGet('start_date');
            $end_date    = $this->request->getGet('end_date');

            
        }
    }

?>