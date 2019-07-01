<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;

class testController extends Controller
{
    public function handle(){
    	$date = date('d');
	    $test = Report::missingReport('month');
	    // $test = new Report;
	    echo '<pre>';
	    var_dump($test);
	    echo '</pre>';
	    // echo $test;
	}
}
