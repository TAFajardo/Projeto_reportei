<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\RepoUser;
use App\Models\Commit;
use App\Models\User;

class TesteController extends Controller

{
    public function detail(){
        $commitdetails = Commit::all();

        return view('graph', ['commitdetails' => $commitdetails]);}
    }
//   Esta função visa puxar do BD as informações       // 
//   preenchidas sobre os Commits (nome,data,etc)      //
//   e enviar para a view /graph para serem carregadas //
//   em um gráfico.     //

