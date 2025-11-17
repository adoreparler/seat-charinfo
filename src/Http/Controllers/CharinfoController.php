<?php

namespace Adoreparler\Seat\Charinfo\Http\Controllers;

use Seat\Web\Http\Controllers\Controller;

// Correct SeAT 5.x model paths
use Seat\Characters\Models\Character\Location;
use Seat\Characters\Models\Character\Ship;
use Seat\Characters\Models\Character\Affiliation;

class CharinfoController extends Controller
{
    public function list()
    {
        $user = auth()->user();

        $characters = $user->characters()->get();

        $data = $characters->map(function ($char) {
            // Latest location
            $location = Location::where('character_id', $char->character_id)
                ->latest('recorded_at')
                ->first()
                ?->solar_system
                ?->name ?? 'Unknown';

            // Latest ship
            $ship = Ship::where('character_id', $char->character_id)
                ->latest('recorded_at')
                ->first()
                ?->ship_type
                ?->name ?? 'Unknown';

            // Latest corporation
            $corp = Affiliation::where('character_id', $char->character_id)
                ->latest('updated_at')
                ->first()
                ?->corporation
                ?->name ?? 'Unknown';

            // Token status
            $token_status = ($char->refresh_token && $char->token_expires_at?->isFuture())
                ? 'Valid'
                : 'Expired';

            return [
                'character_id' => $char->character_id,
                'name'         => $char->name,
                'location'     => $location,
                'ship'         => $ship,
                'token_status' => $token_status,
                'first_login'  => $char->created_at->format('Y-m-d H:i'),
                'last_login'   => $char->updated_at->format('Y-m-d H:i'),
                'corporation'  => $corp,
            ];
        });

        return view('charinfo::list', compact('data'));
    }
}
