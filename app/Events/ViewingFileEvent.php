<?php

namespace App\Events;

use App\Models\File;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ViewingFileEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public User $user, public File $file)
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel("public-updates"),
        ];
    }

    public function broadcastWith(): array
    {
        return array(
            'file_view' => [
                'file' => $this->file->name,
                'user' => $this->user->email,
            ]
        );
    }

    public function broadcastAs(): string
    {
        return 'public.notification';
    }
}
