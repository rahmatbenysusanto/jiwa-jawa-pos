<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow; // <- NOW
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TransactionEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public array $data) {}

    public function broadcastOn(): array
    {
        return [ new Channel('selvin-pos') ];
    }

    public function broadcastAs(): string
    {
        return 'transaction-data';
    }

    public function broadcastWith(): array
    {
        return [
            'username'  => $this->data['username'] ?? null,
            'type'      => $this->data['type'] ?? null,
            'invoice'   => $this->data['invoice'] ?? null,
            'data'      => $this->data['data'] ?? null,
        ];
    }
}
