@extends('web::character.layout')

@section('title', 'Character Info')
@section('character-content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Character Summary</h3>
    </div>
    <div class="card-body">
        @if($data->isEmpty())
            <p>No characters available. <a href="{{ route('character.profile', ['character_id' => auth()->user()->characters->first()->character_id ?? '']) }}">Add one here</a>.</p>
        @else
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Ship</th>
                        <th>Token</th>
                        <th>First Login</th>
                        <th>Last Login</th>
                        <th>Corporation</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $char)
                    <tr>
                        <td><a href="{{ route('character.profile', ['character_id' => $char_id ?? '']) }}">{{ $char['name'] }}</a></td> {{-- Note: Pass $char_id from controller if adding --}}
                        <td>{{ $char['location'] }}</td>
                        <td>{{ $char['ship'] }}</td>
                        <td>
                            <span class="label label-{{ $char['token_status'] === 'Valid' ? 'success' : 'danger' }}">
                                {{ $char['token_status'] }}
                            </span>
                        </td>
                        <td>{{ $char['first_login'] }}</td>
                        <td>{{ $char['last_login'] }}</td>
                        <td>{{ $char['corporation'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
