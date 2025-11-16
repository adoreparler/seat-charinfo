@extends('web::layouts.grids.row-1')

@section('title', 'Character Info')

@section('row1')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Character Summary</h3>
        </div>
        <div class="panel-body">
            @if($character_data->isEmpty())
                <p>No characters available or accessible.</p>
            @else
                <table class="table table-condensed table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>Character Name</th>
                            <th>Last Known Location</th>
                            <th>Last Known Ship</th>
                            <th>Token Status</th>
                            <th>First Login</th>
                            <th>Last Login</th>
                            <th>Current Corporation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($character_data as $data)
                            <tr>
                                <td><a href="{{ route('character.view.profile', $data['character']->character_id) }}">{{ $data['name'] }}</a></td>
                                <td>{{ $data['location'] }}</td>
                                <td>{{ $data['ship'] }}</td>
                                <td><span class="label label-{{ $data['token_status'] === 'Valid' ? 'success' : 'danger' }}">{{ $data['token_status'] }}</span></td>
                                <td>{{ $data['first_login'] }}</td>
                                <td>{{ $data['last_login'] }}</td>
                                <td>{{ $data['corporation'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
