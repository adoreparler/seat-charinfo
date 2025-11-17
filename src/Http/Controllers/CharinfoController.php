<?php

namespace Adoreparler\Seat\Charinfo\Http\Controllers;

use Seat\Web\Http\Controllers\Controller;
use Seat\Eveapi\Models\Character\CharacterInfo;

class CharinfoController extends Controller
{
    public function list()
    {
        // Correct SeAT permission check
        if (auth()->user()->can('charinfo.view_all')) {
            $characters = CharacterInfo::with([
                'location.solar_system',
                'ship.ship_type',
                'affiliation.corporation'
            ])->get();
        } else {
            $characters = auth()->user()->characters()->with([
                'location.solar_system',
                'ship.ship_type',
                'affiliation.corporation'
            ])->get();
        }

        $data = $characters->map(function ($char) {
            return [
                'character_id' => $char->character_id,
                'name'         => $char->name,
                'location'     => $char->location?->solar_system?->name ?? 'Unknown',
                'ship'         => $char->ship?->ship_type?->name ?? 'Unknown',
                'token_status' => ($char->refresh_token && $char->token_expires_at?->isFuture())
                    ? 'Valid'
                    : 'Expired',
                'first_login'  => $char->created_at?->format('Y-m-d H:i') ?? '—',
                'last_login'   => $char->updated_at?->format('Y-m-d H:i') ?? '—',
                'corporation'  => $char->affiliation?->corporation?->name ?? 'Unknown',
            ];
        });

        return view('charinfo::list', compact('data'));
    }
}
