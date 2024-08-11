<?php

namespace App\Http\Controllers;

use App\Models\Home;
use App\Services\WithService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function show(Home $home) {
        // Load relationship
        $home->house->load("houseType");
        return $home;
    }
}
