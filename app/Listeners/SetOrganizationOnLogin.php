<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class SetOrganizationOnLogin
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
    public function handle(object $event): void
    {
        if (!$event?->user) {
            $message = __('Not authorized.');

            Log::error(
                [
                    $message,
                    __FILE__ . ':' . __LINE__,
                ]
            );

            Auth::logout();

            \abort(401, $message);

            return;
        }

        if ($event?->user?->is_admin) {
            return;
        }

        $orgRef = $event?->user?->orgRef;

        if (!$orgRef) {
            $message = __('Fail on retrieving organization data. If the error persists, please contact support.');

            Log::error(
                [
                    $message,
                    __FILE__ . ':' . __LINE__,
                ]
            );

            Auth::logout();

            \abort(401, $message);

            return;
        }

        \session()->put('org_ref', $orgRef);
    }
}
