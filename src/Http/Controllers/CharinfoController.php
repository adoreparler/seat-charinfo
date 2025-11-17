<?php

namespace Adoreparler\Seat\Charinfo\Http\Controllers;

use Seat\Web\Http\Controllers\Controller;

class CharinfoController extends Controller
{
    public function list()
    {
        $user = auth()->user();
        $characters = $user->characters()->get();

        $data = $characters->map(function ($char) {
            // Latest location (dynamic relationship)
            $latest_location = $char->location()->latest('created_at')->first();
            $location = $latest_location?->solar_system?->name ?? 'Unknown';

            // Latest ship (dynamic relationship)
            $latest_ship = $char->ship()->latest('created_at')->first();
            $ship = $latest_ship?->ship_type?->name ?? 'Unknown';

            // Latest affiliation (dynamic relationship)
            $latest_affiliation = $char->affiliation()->latest('updated_at')->first();
            $corporation = $latest_affiliation?->corporation?->name ?? 'Unknown';

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
                'corporation'  => $corporation,
            ];
        });

        return view('charinfo::list', compact('data'));
    }
}
