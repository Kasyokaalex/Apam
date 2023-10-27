<?php 

namespace App\Filters;

use App\Models\Staff;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = Services::session();
    
        if ($session->has('apam_staff_id'))
        {
            $staffModel = new Staff();
            
            if ($request->uri->getPath() ==  'login' || $request->uri->getPath() == 'login/login_check')
            {
                return redirect()->to( base_url().'/home');
            }
            if ($request->uri->getSegment(1) == 'admin')
            {
                 return redirect()->back();
            }
        } 
        else
        {  
            if ($request->uri->getPath() != 'login/login_check' && $request->uri->getPath() != 'login')
            {
                return redirect()->to(base_url().'/login');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }

}
