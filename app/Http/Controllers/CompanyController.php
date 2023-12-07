<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use App\Models\Company;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        return response()->json(Company::all(), Response::HTTP_OK);
    }
}