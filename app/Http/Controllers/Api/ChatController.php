<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Faker\Provider\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends BaseController
{
    public function chats(Request $request)
    {
        //User chat's id
        $first_user_id = Auth::user()->id;
        $second_user_id = $request->user_id;
        $chatsId = [];
        if (Auth::user()->hasRole('student')) {
            $chatsId = Message::whereIn('sender_id', [$first_user_id, $second_user_id])
                ->whereIn('recipient_id', [$first_user_id, $second_user_id])
                ->pluck('chat_id')->toArray();
        } elseif (Auth::user()->hasRole('advisor')) {
            $chatsId = Message::whereIn('sender_id', [$first_user_id])
                ->orWhereIn('recipient_id', [$first_user_id])
                ->pluck('chat_id')->toArray();
        }

        $chats = Chat::whereIn('id', $chatsId)->get();
        if (isset($chats)) {
            $chats = $chats->toArray();
            return $this->sendResponse($chats);
        }
        return $this->sendError('На данный момент нету чатов!');
    }

    public function getById(Request $request)
    {
        $chat_id = $request->id;
        $chat = Chat::find($chat_id);
        if (isset($chat)) {
            $chat = $chat->load('messages')->toArray();
            return $this->sendResponse($chat);
        }
        return $this->sendError('Пока нету сообщений!');
    }

    public function delete(Request $request)
    {
        $chat_id = $request->id;
        if (Chat::find($chat_id) && Chat::find($chat_id)->delete()) {
            return $this->sendResponse([], 'Вы успешно удалили чат!');
        }
        return $this->sendError('Произошла ошибка при удаление!');
    }

    public function send(Request $request)
    {
        $author_id = Auth::user()->id;
        if (!isset($request->recipient_id)) {
            return $this->sendError('recipient_id is required!');
        }
        $recipient_id = $request->recipient_id;

        $recipient = User::where(['id' => $recipient_id])->first();
        $message = $request->message;

        $authorToRecipient = Message::where(['sender_id' => $author_id])
            ->where(['recipient_id' => $recipient_id])->first();

        $recipientToAuthor = Message::where(['recipient_id' => $author_id])
            ->where(['sender_id' => $recipient_id])->first();

        if (isset($authorToRecipient)) {
            $chat = $authorToRecipient->chat;
        } elseif ($recipientToAuthor) {
            $chat = $recipientToAuthor->chat;
        }

        if (!isset($chat)) {
            try {
                DB::beginTransaction();
                $chat_name = sprintf('chat between %s %s', Auth::user()->name, $recipient->name);
                $chat = Chat::create([
                    'name' => $chat_name,
                    'type' => 'one_to_one_chat', // also we have group_chat
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                Message::create([
                    'sender_id' => $author_id,
                    'recipient_id' => $recipient_id,
                    'message' => $message,
                    'chat_id' => $chat->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                DB::commit();
                return $this->sendResponse($chat->load('messages')->toArray(), 'ok!');
            } catch (\Exception $exception) {
                DB::rollBack();
                var_dump($exception->getMessage());
                return $this->sendError('Произошла ошибка при отправке !!!');
            }
        }

        Message::create([
            'sender_id' => $author_id,
            'recipient_id' => $recipient_id,
            'message' => $message,
            'chat_id' => $chat->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return $this->sendResponse($chat->load('messages')->toArray(), 'ok!');
    }


}
