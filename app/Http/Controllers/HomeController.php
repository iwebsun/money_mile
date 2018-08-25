<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
		Call Search listing
    */

	public function searchListing() {
		return view('frontend.search');	
	}

	public function searchBCApi() {
		return 'vipin';
	}
}
