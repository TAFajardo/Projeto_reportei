<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commit;
    
class ChartJSController extends Controller


{
    public function linechart(Request $request)
    {
    	
    	$laptop_count_20 = Product::where('product_type','Laptop')->where('year','2020')->get()->count();
    	$laptop_count_21 = Product::where('product_type','Laptop')->where('year','2021')->get()->count();
    	$laptop_count_22 = Product::where('product_type','Laptop')->where('year','2022')->get()->count();

    	    	
    	
    	return view('linechart',compact('phone_count_20','phone_count_21','phone_count_22','laptop_count_20','laptop_count_21','laptop_count_22','desktop_count_20','desktop_count_21','desktop_count_22'));
    }
}