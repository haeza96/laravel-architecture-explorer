@extends('lays.app')

@section('content')

<div class="card">

    <h1>Environment Information</h1>

    <p>
        Informasi berikut aman untuk ditampilkan karena
        tidak berisi password, API key, APP_KEY, atau secret lainnya.
    </p>

</div>

<div class="card">

    <table>

        <tr>
            <th>Application Name</th>
            <td>{{ $environment['app_name'] }}</td>
        </tr>

        <tr>
            <th>Environment</th>
            <td>
                <span class="badge">
                    {{ $environment['app_env'] }}
                </span>
            </td>
        </tr>

        <tr>
            <th>Debug</th>
            <td>{{ $environment['app_debug'] }}</td>
        </tr>

        <tr>
            <th>PHP Version</th>
            <td>{{ $environment['php_version'] }}</td>
        </tr>

        <tr>
            <th>Laravel Version</th>
            <td>{{ $environment['laravel_version'] }}</td>
        </tr>

        <tr>
            <th>Timezone</th>
            <td>{{ $environment['timezone'] }}</td>
        </tr>

    </table>

</div>

@endsection