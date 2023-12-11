<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Models\Supplier;
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
            Supplier::create(
                [
                    'RUT' => $rut,
                    'user_id' => $user->id
                ]
            );
        }
    }
}
