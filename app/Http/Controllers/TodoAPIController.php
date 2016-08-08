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

	public function index(Request $request) {

		$result = [
			'count' => 0,
			'todos' => [],
		];

		// Find user id
		$user = null;
		try {
			$user = User::where('name', $request->user)->first();
		} catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			// not found
		}

		if($user != null) {
			$todos = Todo::where('user_id', $user->id)->orderBy('updated_at', 'desc')->get();
			foreach($todos as $todo) {
				$comment = '';
				if($todo->comment != null) {
					$comment = $todo->comment;
				}

				$item = [
					'id' => $todo->id,
					'content' => $todo->content,
					'comment' => $comment,
					'update' => $todo->updated_at->toDateTimeString(),
				];

				$result['todos'][] = $item;
				$result['count']++;
			}
		}

		return response()->json($result);
	}

	public function show(Request $request, $id) {

		$result = [
			'count' => 0,
			'message' => 'Success',
			'todos' => [],
		];

		// Find user id
		$user = null;
		try {
			$user = User::where('name', $request->user)->first();
		} catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			// not found
		}

		if($user != null) {
			$todos = Todo::where('user_id', $user->id)
							->where('id', $id)
							->orderBy('updated_at', 'desc')
							->get();

			foreach($todos as $todo) {
				$comment = '';
				if($todo->comment != null) {
					$comment = $todo->comment;
				}

				$item = [
					'id' => $todo->id,
					'content' => $todo->content,
					'comment' => $comment,
					'update' => $todo->updated_at->toDateTimeString(),
				];

				$result['todos'][] = $item;
				$result['count']++;
			}
		}

		return response()->json($result);
	}

	public function update(Request $request, $id) {

		$content = $request->content;
		$comment = $request->comment;
		$updated_at = strftime('%Y-%m-%d %H:%m:%S');

		$result = [
			'success' => true,
			'message' => 'Success',
		];

		// Find user id
		$user = null;
		try {
			$user = User::where('name', $request->user)->first();
		} catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			// not found
		}

		if($user != null) {
			$todo = null;
			try {
				$todo = Todo::where('user_id', $user->id)
							->where('id', $id)
							->first();
				$todo->content = $content;
				$todo->comment = $comment;
				$todo->updated_at = $updated_at;
				$todo->save();
			} catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
				$result['success'] = false;
				$result['message'] = 'Failed to find the corresponding todo item.';
			}
		}
		return response()->json($result);
	}

	public function destroy(Request $request, $id) {

		$result = [
			'success' => true,
			'message' => 'Success',
		];

		// Find user id
		$user = null;
		try {
			$user = User::where('name', $request->user)->first();
		} catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			// not found
		}

		if($user != null) {
			$todo = null;
			try {
				$todo = Todo::where('user_id', $user->id)
							->where('id', $id)
							->first();
				$todo->delete();
			} catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			}
		}
		return response()->json($result);
	}
}
