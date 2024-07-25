<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResourceController extends Controller
{
    public function index() {
        return Resource::all();
    }
    public function playerResources() {
        $user = User::find(Auth::id());

        return $user->resourceWithQuantity();
    }

    public function sell() {}
}
