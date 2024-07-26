<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CityController extends Controller
{
    public function companies() {
        $user = User::find(Auth::id());

        return Company::where("city_id", $user->city_id)->where("activated", 1)->with("user")
            ->orderByDesc("id")->get();
    }
}
