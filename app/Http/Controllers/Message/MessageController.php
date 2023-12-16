<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use App\Services\Message\MessageService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    protected $messageService;

    public function __construct(MessageService $messageService){
        $this->messageService = $messageService;
    }

    public function create(Request $request){
        return $this->messageService->create($request);
    }

    public function get($from,$to){
        return $this->messageService->get($from,$to);
    }

    public function getList($id){
        return $this->messageService->getList($id);
    }

    public function delete(Request $request){
        return $this->messageService->delete($request);
    }
}
