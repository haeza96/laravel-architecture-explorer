@extends('lays.app')

@section('content')

<div class="card">
    <h1>Request Lifecycle</h1>

    <p>
        Request lifecycle adalah proses yang terjadi ketika
        pengguna membuka URL pada aplikasi Laravel sampai
        Laravel mengirimkan response kembali ke browser.
    </p>
</div>

<div class="card">

    <div class="flow">

        <div class="step">
            <strong>1. Browser</strong>
            <br>
            Pengguna membuka URL
        </div>

        <div class="arrow">↓</div>

        <div class="step">
            <strong>2. Web Server</strong>
            <br>
            Request diteruskan ke aplikasi Laravel
        </div>

        <div class="arrow">↓</div>

        <div class="step">
            <strong>3. public/index.php</strong>
            <br>
            Entry point aplikasi Laravel
        </div>

        <div class="arrow">↓</div>

        <div class="step">
            <strong>4. Application Bootstrap</strong>
            <br>
            Laravel menyiapkan aplikasi
        </div>

        <div class="arrow">↓</div>

        <div class="step">
            <strong>5. Middleware</strong>
            <br>
            Request dapat diperiksa sebelum diproses
        </div>

        <div class="arrow">↓</div>

        <div class="step">
            <strong>6. Router</strong>
            <br>
            URL dicocokkan dengan named route
        </div>

        <div class="arrow">↓</div>

        <div class="step">
            <strong>7. Controller</strong>
            <br>
            Logic aplikasi dijalankan
        </div>

        <div class="arrow">↓</div>

        <div class="step">
            <strong>8. Blade View</strong>
            <br>
            Data controller ditampilkan menjadi HTML
        </div>

        <div class="arrow">↓</div>

        <div class="step">
            <strong>9. Response</strong>
            <br>
            HTML dikirim kembali ke browser
        </div>

    </div>

</div>

@endsection