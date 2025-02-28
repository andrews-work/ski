<?php

namespace App\Events;

use App\Models\ForumPost; // Import the ForumPost model
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast; // Implement ShouldBroadcast
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class PostCreated implements ShouldBroadcast // Implement ShouldBroadcast
{


    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $post; // Add a public property to hold the post data


    public function log()
    {
            Log::info('post event called');
    }


    /**
     * Create a new event instance.
     */
    public function __construct(ForumPost $post) // Accept the ForumPost model
    {
        $this->post = $post; // Assign the post to the property
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // Broadcast on a public or private channel
        return [
            new Channel('posts'), // Use a public channel named 'posts'
        ];
    }

    /**
     * Optional: Customize the data to be broadcasted.
     */
    public function broadcastWith(): array
    {
        return [
            'post' => [
                'id' => $this->post->id,
                'title' => $this->post->title,
                'content' => $this->post->content,
                'user_id' => $this->post->user_id,
                'category_id' => $this->post->category_id,
                'created_at' => $this->post->created_at,
            ],
        ];
    }
}
