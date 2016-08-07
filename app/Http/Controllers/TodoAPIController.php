<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Todo;
use App\User;

class TodoAPIController extends Controller
{
    //
	public function store(Request $request)
	{
		$username = $request->user;
		$content = $request->content;
		$comment = $request->comment;
		$updated_at = strftime('%Y-%m-%d %H:%m:%S');

		// Find user id
		$user = null;
		try {
			$user = User::where('name', $username)->first();
		} catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			// not found
		}

		$result = [
			'success' => true,
			'message' => 'Success',
		];

		if($user != null) {
			$todo = new Todo;
			$todo->user_id = $user->id;
			$todo->content = $content;
			$todo->comment = $comment;
			$todo->updated_at = $updated_at;
			$todo->save();
		} else {
			$result['success'] = false;
			$result['message'] = "No such user";
		}

		return response()->json($result);
	}
}
