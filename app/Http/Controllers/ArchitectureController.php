<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ArchitectureController extends Controller
{
    public function index(): View
    {
        $folders = [
            [
                'name' => 'app/',
                'function' => 'Tempat kode utama aplikasi seperti Controller, Model, dan Service.'
            ],
            [
                'name' => 'app/Http/Controllers/',
                'function' => 'Mengatur proses request dan menentukan response yang diberikan.'
            ],
            [
                'name' => 'app/Models/',
                'function' => 'Tempat Model untuk berinteraksi dengan data dan database.'
            ],
            [
                'name' => 'routes/',
                'function' => 'Mendefinisikan URL dan menghubungkannya dengan Controller.'
            ],
            [
                'name' => 'resources/views/',
                'function' => 'Tempat tampilan Blade yang dikirim kepada pengguna.'
            ],
            [
                'name' => 'public/',
                'function' => 'Folder publik untuk entry point aplikasi dan file asset.'
            ],
            [
                'name' => 'config/',
                'function' => 'Menyimpan konfigurasi aplikasi Laravel.'
            ],
            [
                'name' => 'database/',
                'function' => 'Berisi migration, seeder, dan factory database.'
            ],
            [
                'name' => 'storage/',
                'function' => 'Menyimpan file hasil proses aplikasi, cache, log, dan lainnya.'
            ],
        ];

        return view('architecture', compact('folders'));
    }

    public function lifecycle(): View
    {
        return view('lifecycle');
    }
}