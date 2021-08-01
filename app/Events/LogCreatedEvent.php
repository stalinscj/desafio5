<?php

namespace App\Events;

use App\Models\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class LogCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The log created
     *
     * @var \App\Models\Log
     */
    public $log;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Log $log)
    {
        $this->log = $log;
    }
}
