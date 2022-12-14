<?php

namespace Carbon;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\RepoUser;
use App\Models\Commit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/auth/redirect', function () {
    return Socialite::driver('github')
    ->scopes(['repo'])
    ->redirect();

});


 
Route::get('/auth/callback', function () {
    $githubUser = Socialite::driver('github')->stateless()->user();
    
    
    $user = User::updateOrCreate([
        'github_id' => $githubUser->id,
    ],
        
    [
        'name' => $githubUser->name,
        'email' => $githubUser->email,
        'github_token' => $githubUser->token,
        'github_refresh_token' => $githubUser->refreshToken,
    ]);
 
    Auth::login($user);
 
    $response = Http::withToken($githubUser->token)->get('https://api.github.com/user/repos');
    $responsejson=$response->json();
    


    foreach ($responsejson as &$valor) {


        $repouser = RepoUser::updateOrCreate([
            'repo_id' => $valor['id'],
        ],

        [
            'github_id' => $githubUser->id,
            'owner_name'=> $valor['owner']['login'],
            'repo_name'=> $valor['name'],
            'repo_url'=> $valor['url'],
            'repo_full_name'=> $valor['url'],
        ]);


    }
      /*
    foreach ($valor as &$valorsecundario)
        $commit = Commit::updateOrCreate([
            'commit_id' => $valorsecundario['id'],
        ]
        
        [
            'commit_name'=> $valorsecundario['name'],
            'commit_date'=> $valorsecundario['date'],
        ]
        )
    */ 


    /*$categories = Category::all();
    $categories->each(function (Category $category){
        dd($category->name); */
        /*dd($category);  Para verificar os dados recebidos */  
    
    


    return redirect('/dashboard');

});



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard',[EventController::class,'index'])
->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/graph/{username}/{reponame}', function($username, $reponame){   
    $githubToken = Auth::user()->github_token;
    $url="https://api.github.com/repos/" . $username . "/" . $reponame . "/commits";

    $commitresponse = Http::withToken($githubToken)->get($url);
    $commitresponsejson=$commitresponse->json();
       

    foreach ($commitresponsejson as &$commitvalor) {
        

        $commits = Commit::updateOrCreate([
            'github_commit_id' => $commitvalor['sha']
        ],
        [
            'github_repo_name'=>$reponame,
            'github_user_name'=>$username,
            'commit_date'=> Carbon::parse($commitvalor['commit']['author']['date']),
            //->format('d.m.Y')//
        ]);
    }
        $date = Carbon::now()->subDays(90);
        $commitscount = Commit::where('commit_date', '>=', $date)->where('github_repo_name', '=', $reponame)->get()->count();


    $chart_options= [
        'chart_title' => 'Commits nos últimos 90 dias',
        'where_raw' => 'github_repo_name = "' .  $reponame . '"',
        'report_type' => 'group_by_date',
        'model' => 'App\Models\Commit',
        'conditions'=>[
            ['github_repo_name' =>'','condition'=>'','color'=>'blue' ,'fill' =>true],
        ],
        'group_by_field' => 'commit_date',
        'group_by_period' => 'day',

        'chart_type' => 'line',
        'filter_field' => 'commit_date',  
        'date_format' => 'd-m-Y',
        'filter_days' => '90', // show only transactions for last 90 days
        'continuous_time'=> true,
        'show_blank_data'=>true,
        
            
            
        ];
        $chart1 = new LaravelChart($chart_options);


        //dd($commitscount);
    	

        return view('graph', compact('chart1', 'commitscount'));
    
    
    }
    )->name('graph');




    //Route::get('graph', [ChartController::class, 'showChart']);
    //return view('graph',['commits' => $commits]);
    //return view('graph');

    //return view('/graph');//


/*
Route::get('/graph/{user_id}/{repo_id}', [EventController::class,'hooktoken']);
$commitresponse = Http::withToken($githubUser->token)->get('https://api.github.com/repos/{name}/{repo_name}/commits');
$commitresponsejson=$commitresponse->json();




    foreach($commitresponsejson as &$commitvalor){
        
        $commit = Commit::updateOrCreate([
            'commit_id' => $commitvalor['id'],
        ],
        
        [
            'commit_name' => $commitvalor['name'],
            'commit_date' => $commitvalor['date'],
        ]);
    }
*/


;





require __DIR__.'/auth.php';
