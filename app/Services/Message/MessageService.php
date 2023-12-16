<?php

namespace App\Services\Message;

use App\Repositories\Message\MessageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageService
{
    protected $messageRepository;
    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function get($from,$to)
    {
        $result = $this->messageRepository->get(array('from'=>$from,'to'=>$to));

        return ['data' => $result];
    }

    public function getList($id){

        return $this->messageRepository->getList($id);
    }

    public function create(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'from' => 'required',
            'to' => 'required',
            'text'=> 'required|max:255'
        ]);

        if ($validate->fails()) {
            return ['errors' => $validate->errors()];
        }

        $result = $this->messageRepository->create($request->all());

        return ['data' => $result];
    }

    public function delete(Request $request)
    {
        $result = $this->messageRepository->getById($request->like_id);

        return $result;
    }
}
