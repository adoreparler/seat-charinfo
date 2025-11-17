<?php

namespace Adoreparler\Seat\Charinfo\Http\Controllers;

use Seat\Web\Http\Controllers\Controller;
use Seat\Eveapi\Models\Character\CharacterLocation;
use Seat\Eveapi\Models\Character\CharacterShip;
use Seat\Eveapi\Models\Character\CharacterAffiliation;
use Seat\Eveapi\Models\Character\CharacterInfo;

class CharinfoController extends Controller
{
    public function list()
    {
        $user = auth()->user();

        $characters = $user->characters()->get();  // Get base characters

        $data = $characters->map(function ($char) {
            // Latest location
            $latest_location = CharacterLocation::where('character_id', $char->character_id)
                ->latest('recorded_at')
                ->first();
            $location = $latest_location?->solar_system?->name ?? 'Unknown';

            // Latest ship
            $latest_ship = CharacterShip::where('character_id', $char->character_id)
                ->latest('recorded_at')
                ->first();
            $ship = $latest_ship?->ship_type?->name ?? 'Unknown';

            // Latest affiliation
            $latest_affiliation = CharacterAffiliation::where('character_id', $char->character_id)
                ->latest('updated_at')
                ->first();
            $corporation = $latest_affiliation?->corporation?->name ?? 'Unknown';

            // Token check
            $token_status = ($char->refresh_token && $char->token_expires_at?->isFuture()) ? 'Valid' : 'Expired';

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
