@extends('web::character.layout')

@section('title', 'Character Info')
@section('character-content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Character Summary</h3>
    </div>
    <div class="card-body">
        @if($data->isEmpty())
            <div class="alert alert-info">
                No characters found or no data available.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Character</th>
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
                            <td><strong>{{ $char['name'] }}</strong></td>
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
            </div>
        @endif
    </div>
</div>
@endsection
