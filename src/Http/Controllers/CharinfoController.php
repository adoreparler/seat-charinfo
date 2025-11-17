<?php

namespace Adoreparler\Seat\Charinfo\Http\Controllers;

use Seat\Web\Http\Controllers\Controller;
use Seat\Eveapi\Models\Character\CharacterInfo;
use Seat\Eveapi\Models\Character\CharacterLocation;
use Seat\Eveapi\Models\Character\CharacterAffiliation;
use Seat\Eveapi\Models\Assets\CharacterAsset;  // Ship data is here!

class CharinfoController extends Controller
{
    public function list()
    {
        $user = auth()->user();
        $characters = $user->characters()->get();

        $data = $characters->map(function (CharacterInfo $char) {
            // Latest location
            $location = CharacterLocation::where('character_id', $char->character_id)
                ->latest('created_at')
                ->first()?->solar_system?->name ?? 'Unknown';

            // Latest ship (from assets - current ship is the installed item in hangar)
            $ship = CharacterAsset::where('character_id', $char->character_id)
                ->where('location_flag', 'InstalledItem')  // Current ship
                ->where('location_type', 'item')
                ->latest('created_at')
                ->first()?->item?->type?->name ?? 'Unknown';

            // Latest corporation
            $corp = CharacterAffiliation::where('character_id', $char->character_id)
                ->latest('updated_at')
                ->first()?->corporation?->name ?? 'Unknown';

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
