<?php

namespace App\Repositories\Message;

use App\Models\Message;
use Illuminate\Support\Facades\DB;

class MessageRepository implements MessageInterface
{
    public function create(array $data): Message
    {
        return Message::create($data);
    }
    public function delete(Message $message): bool
    {
        return $message->delete();
    }
    public function get($request): ?Message
    {
        $result = DB::table('messages')
            ->where('from',$request['from'])
            ->where('to',$request['to'])
            ->get();

        return $result;
    }

    public function getList($to){

        $result = DB::table('messages')
            ->where('to', $to)
            ->select('from')
            ->distinct()
            ->get();

        return $result;
    }

    public function getAll()
    {
        return Message::all();
    }
    public function update(Message $message, array $data): Message
    {
        $message->update($data);
        return $message;
    }
}
