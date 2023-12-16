<?php

namespace App\Repositories\Message;

use App\Models\Like;
use App\Models\Message;

interface MessageInterface
{
    public function create(array $data): Message;
    public function update(Message $message, array $data): Message;
    public function delete(Message $message): bool;
    public function get($id): ?Message;
    public function getAll();
}
