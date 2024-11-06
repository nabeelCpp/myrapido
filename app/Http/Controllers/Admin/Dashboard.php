<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function index() {
        $data['guard'] = request()->whoIs;
        return view(request()->whoIs.'.dashboard.index', $data);
    }
}
