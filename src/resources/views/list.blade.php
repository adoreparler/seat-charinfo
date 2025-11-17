<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Character Info - SeAT</title>

    <!-- SeAT Core CSS -->
    <link href="{{ asset('web/css/seat.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="app header-fixed sidebar-fixed">
    <div class="app-wrapper">
        <!-- Header -->
        @include('web::includes.header')

        <div class="app-body">
            <!-- Sidebar -->
            @include('web::includes.sidebar')

            <!-- Main content -->
            <main class="main">
                <div class="container-fluid">
                    <div class="animated fadeIn">
                        <div class="row">
                            <div class="col-12">
                                <div class="card mt-4">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fas fa-info-circle"></i> Character Summary
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        @if($data->isEmpty())
                                            <div class="alert alert-info">
                                                <strong>No characters found.</strong> Add characters via the Characters menu.
                                            </div>
                                        @else
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead class="table-light">
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
                                                                <span class="badge bg-{{ $char['token_status'] === 'Valid' ? 'success' : 'danger' }}">
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
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Footer -->
        @include('web::includes.footer')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('web/js/app.js') }}"></script>
</body>
</html>
