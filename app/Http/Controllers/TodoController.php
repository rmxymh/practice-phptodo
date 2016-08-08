<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use App\Todo;

class TodoController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

	function index() {
		$user = Auth::user();
		$todos = Todo::where('user_id', $user->id)->get();

		$data = [
			'title' => 'Todo List',
			'todos' => $todos,
			'username' => $user->name,
		];

		return view('todo', $data);
	}
}
