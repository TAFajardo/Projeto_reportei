<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

$chart = new LaravelChart($options);
return view('graph', compact('chart'));
