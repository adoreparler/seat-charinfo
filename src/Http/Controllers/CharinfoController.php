<?php

namespace Adoreparler\Seat\Charinfo\Http\Controllers;

use Seat\Web\Http\Controllers\Controller;
use Seat\Eveapi\Models\Character\CharacterInfo;

class CharinfoController extends Controller
{
    public function list()
    {
        // Build the base query with refresh_token relationship
        $baseQuery = CharacterInfo::with([
            'location.solar_system',
            'ship.type',
            'affiliation.corporation',
            'refresh_token', // This is the key!
        ]);

        // Apply permission filter
        if (auth()->user()->can('charinfo.view_all')) {
            $characters = $baseQuery->get();
        } else {
            $characters = auth()->user()->characters()->with([
                'location.solar_system',
                'ship.type',
                'affiliation.corporation',
                'refresh_token',
            ])->get();
        }

        $data = $characters->map(function ($char) {
            // Now $char->refresh_token is the actual RefreshToken model (or null)
            $hasValidToken = $char->refresh_token &&
                            $char->refresh_token->expires_on?->isFuture();

            return [
                'character_id' => $char->character_id,
                'name'         => $char->name,
                'location'     => $char->location?->solar_system?->name ?? 'Unknown',
                'ship'         => $char->ship?->type?->typeName ?? 'Unknown',
                'token_status' => $hasValidToken ? 'Valid' : 'Expired',
                'first_login'  => $char->created_at?->format('Y-m-d H:i') ?? '—',
                'last_login'   => $char->updated_at?->format('Y-m-d H:i') ?? '—',
                'corporation'  => $char->affiliation?->corporation?->name ?? 'Unknown',
            ];
        });

        return view('charinfo::list', compact('data'));
    }
}
