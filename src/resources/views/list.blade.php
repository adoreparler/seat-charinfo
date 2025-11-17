@extends('web::layouts.app')

@section('page_title', 'Character Info')

@section('page_header')
    <h1>
        <i class="fa fa-info-circle"></i> Character Summary
    </h1>
@endsection

@section('content')
    @if($data->isEmpty())
        <div class="alert alert-info">
            <i class="fa fa-info-circle"></i> No characters found or no data available.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="thead-default">
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
@endsection
