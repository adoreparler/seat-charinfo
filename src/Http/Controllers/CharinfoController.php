<?php

namespace Adoreparler\Seat\Charinfo\Http\Controllers;

use Seat\Web\Http\Controllers\Controller;
use Seat\Eveapi\Models\Character\CharacterInfo;

class CharinfoController extends Controller
{
    public function list()
    {
        // Permission gate: users with 'charinfo.view_all' see all characters
        $query = auth()->user()->has('charinfo.view_all')
            ? CharacterInfo::query()
            : auth()->user()->characters();

        $characters = $query->with('location.solar_system', 'ship.ship_type', 'affiliation.corporation')->get();

        $data = $characters->map(function ($char) {
            // Current ship from assets (correct for SeAT 5.x)
            $current_ship = $char->assets()
                ->where('location_flag', 'Hangar')
                ->where('is_singleton', true)
                ->where('type_id', '>', 0)
                ->whereHas('item.type')
                ->latest('created_at')
                ->first();

            return [
                'character_id' => $char->character_id,
                'name'         => $char->name,
                'location'     => $char->location?->solar_system?->name ?? 'Unknown',
                'ship'         => $current_ship?->item?->type?->typeName ?? 'Unknown',
                'token_status' => ($char->refresh_token && $char->token_expires_at?->isFuture()) ? 'Valid' : 'Expired',
                'first_login'  => $char->created_at?->format('Y-m-d H:i'),
                'last_login'   => $char->updated_at?->format('Y-m-d H:i'),
                'corporation'  => $char->affiliation?->corporation?->name ?? 'Unknown',
            ];
        });

        return view('charinfo::list', compact('data'));
    }
}
