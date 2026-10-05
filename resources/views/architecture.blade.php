@extends('lays.app')

@section('content')

<div class="card">
    <h1>Laravel Architecture Dashboard</h1>

    <p>
        Halaman ini menjelaskan struktur folder penting
        pada aplikasi Laravel 12.
    </p>
</div>

<div class="card">
    <h2>Struktur Folder Penting</h2>

    <table>
        <thead>
            <tr>
                <th>Folder</th>
                <th>Fungsi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($folders as $folder)
                <tr>
                    <td>
                        <strong>{{ $folder['name'] }}</strong>
                    </td>

                    <td>
                        {{ $folder['function'] }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection