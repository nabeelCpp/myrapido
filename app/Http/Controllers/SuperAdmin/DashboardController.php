<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data['guard'] = request()->whoIs;
        return view(request()->whoIs.'.dashboard.index', $data);
    }
}
