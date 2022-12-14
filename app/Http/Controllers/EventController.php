<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\RepoUser;
use App\Models\Commit;
use App\Models\User;

class EventController extends Controller



{
    public function index(){
        
        $id = Auth::user()->github_id;

        $repousers = RepoUser::where('github_id', $id)->get();
        

        return view('dashboard', ['repousers' => $repousers]);
      


    }

    
    


    public function hooktoken(){
        $dbdatas = User::all();

        return view('graph', ['dbdatas' => $dbdatas]);
    }
}