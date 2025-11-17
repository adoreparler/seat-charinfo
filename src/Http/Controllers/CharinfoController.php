<?php

namespace Adoreparler\Seat\Charinfo\Http\Controllers;

use Seat\Web\Http\Controllers\Controller;
use Seat\Eveapi\Models\Character\CharacterInfo;

class CharinfoController extends Controller
{
    public function list()
    {
        if (auth()->user()->can('charinfo.view_all')) {
            $characters = CharacterInfo::with([
                'location.solar_system',
                'ship.type',
                'affiliation.corporation'
            ])->get();
        } else {
            $characters = auth()->user()->characters()->with([
                'location.solar_system',
                'ship.type',
                'affiliation.corporation'
            ])->get();
        }

        $data = $characters->map(function ($char) {
            // CORRECT token check for SeAT 5.x
            $hasValidToken = !empty($char->scopes) && 
                            $char->token_expires_at?->isFuture();

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
