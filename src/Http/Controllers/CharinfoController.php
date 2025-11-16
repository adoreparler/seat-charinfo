<?php

namespace Seat\Charinfo\Http\Controllers;

use Illuminate\Http\Request;
use Seat\Services\Http\Controller;
use Seat\Web\Models\User;
use Seat\Characters\Models\Character\CharacterAffiliation;
use Seat\Characters\Models\Character\CharacterInfo;
use Seat\Characters\Models\Character\CharacterLocation;
use Seat\Characters\Models\Character\CharacterShip;

class CharinfoController extends Controller
{
    public function list(Request $request)
    {
        // Get characters the user can access (via affiliations)
        $characters = User::find(auth()->id())
            ->getAffiliatedCharacters()
            ->with(['affiliation', 'location.solarSystem', 'ship.shipType'])
            ->get();

        $character_data = $characters->map(function ($character) {
            $latest_location = $character->location()->latest()->first();
            $latest_ship = $character->ship()->latest()->first();
            $latest_affiliation = CharacterAffiliation::where('character_id', $character->character_id)
                ->latest('updated_at')
                ->first();

            return [
                'name' => $character->name,
                'location' => $latest_location ? $latest_location->solarSystem->name : 'Unknown',
                'ship' => $latest_ship ? $latest_ship->shipType->name : 'Unknown',
                'token_status' => (
                    $character->refresh_token &&
                    $character->token_expires_at &&
                    $character->token_expires_at->gt(now())
                ) ? 'Valid' : 'Expired/Invalid',
                'first_login' => $character->created_at->format('Y-m-d H:i'),
                'last_login' => $character->updated_at->format('Y-m-d H:i'),
                'corporation' => $latest_affiliation ? $latest_affiliation->corporation->name : 'Unknown',
                'character' => $character, // For linking to full character sheet
            ];
        });

        return view('charinfo::list', compact('character_data'));
    }
}
