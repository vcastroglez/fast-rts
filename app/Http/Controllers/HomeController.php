<?php

namespace App\Http\Controllers;

use App\Models\User;

class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$user = User::where('id', auth()->id())->select([
			'id', 'name', 'email',
		])->first();

		return view('home', [
			'user' => $user,
		]);
	}
}
