<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $session;

    protected $sessionHash;

    public function __construct(Request $request)
    {
        $this->session = $request->session();

        $this->sessionHash = $this->getSessionHash();
    }

    private function getSessionHash()
    {
        return $this->session->has('uuid') ? $this->session->get('uuid') : $this->setSessionHash();
    }

    private function setSessionHash()
    {
        $this->session->put('uuid', uniqid());
    }
}
