<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Welcome extends Controller {

    function index()
    {
        echo view ('welcome');
    }

}

?>