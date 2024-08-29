<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use \Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;

class ApiController extends Controller
{
    use ApiResponser,ValidatesRequests;

    public function __construct()
    {
      
    }
}
