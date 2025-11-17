@extends('web::layouts.app')

@section('page_header')
    <h1><i class="fa fa-info-circle"></i> Character Summary</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Registered Characters</h3>
    </div>
    <div class="card-body">
        @if($data->isEmpty())
            <div class="alert alert-info">No characters found.</div>
        @else
            <table id="charinfo-table" class="table table-striped table-hover" style="width:100%">
                <thead>
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
        @endif
    </div>
</div>

@push('javascript')
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

<script>
$(document).ready(function() {
    $('#charinfo-table').DataTable({
        pageLength: 25,
        order: [[0, 'asc']],
        columnDefs: [
            { searchable: false, targets: [4, 5] }, // Disable search on date columns
            { orderable: true, targets: '_all' }
        ],
        language: {
            search: "Filter:",
            lengthMenu: "Show _MENU_ characters"
        }
    });
});
</script>
@endpush
@endsection
