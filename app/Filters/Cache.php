<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Cache implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {    
        
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $uri = current_url(true);
        //$uri->setHost('maformation.com')->getHost();  
        $uri->setPath('find-by');
    }
    
}