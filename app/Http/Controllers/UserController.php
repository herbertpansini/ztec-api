<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use App\Models\User;
use Illuminate\Http\Response;

class UserController extends Controller
{
    use ApiResponser;
    
    public function __construct()
    {
        
    }

    //
    public function index()
    {
        return response()->json(User::all(), Response::HTTP_OK);
    }
}