<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateSupplierOnUserCreation
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserCreated $event): void
    {
        $user = $event->user;
        $rut = $event->RUT;

        if ($user->user_type == 3) {
            $user->supplier()->create([
                'RUT' => $rut,
                'relative_user' => $user->id,
            ]);
        }
    }
}
