<?php

namespace App\Http\Controllers;

use App\Events\GotMessage;
use App\Jobs\SendMessage;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
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

	public function messages(): JsonResponse
	{
		$messages = Message::with('user')->get()->append('time');

		return response()->json($messages);
	}

	public function message(Request $request): JsonResponse
	{
		$user_id = auth()->id();
		$message = Message::create([
			'user_id' => $user_id,
			'text'    => $request->get('text'),
		]);

//		SendMessage::dispatch($message);

		GotMessage::dispatch([
			'id'      => $message->id,
			'user_id' => $user_id,
			'text'    => $message->text,
			'time'    => $message->time,
		]);

		return response()->json([
			'success' => true,
			'message' => "Message created and job dispatched.",
		]);
	}
}
