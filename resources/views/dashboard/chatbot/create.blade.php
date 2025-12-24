@extends('dashboard.layouts.app')

@section('title', 'Create ChatBot')
@section('name_header', 'Create ChatBot')

@section('breadcrumbs')
    <?php
    $breadcrumbs = [['name' => 'ChatBot Manage', 'link' => route('manage.chatbot.index')]];
    ?>
@endsection

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <p class="mb-0">Buat Template ChatBot Baru</p>
            </div>
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('manage.chatbot.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="user_id" class="form-label">User</label>
                        <select name="user_id" id="user_id" class="form-select" required>
                            <option value="">-- Pilih User --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea name="message" id="message" class="form-control" rows="5" required
                            placeholder="Halo {name}, kode qr sudah ready digunakan!"></textarea>
                        <span class="form-text text-muted">Gunakan <code>{name}</code> untuk menampilkan nama client &
                            <code>{url}</code>
                            menampilkan redirect link </span>
                    </div>


                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('manage.chatbot.index') }}" class="btn btn-secondary">Batal</a>
                </form>

            </div>
        </div>
    </section>
@endsection
