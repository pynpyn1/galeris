@extends('dashboard.layouts.app')

@section('title', 'Edit ChatBot')
@section('name_header', 'Edit ChatBot')

@section('breadcrumbs')
    <?php
    $breadcrumbs = [['name' => 'ChatBot Manage', 'link' => route('manage.chatbot.index')]];
    ?>
@endsection

@section('content')


    <section class="section">
        <div class="card">
            <div class="card-header">
                <p class="mb-0">Edit Message ChatBot</p>
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

                <form action="{{ route('chatbot.update', $chatbot->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea name="message" id="message" class="form-control" rows="5" required>{{ $chatbot->message }}</textarea>
                        <span class="form-text text-muted">Gunakan <code>{name}</code> untuk menampilkan nama client &
                            <code>{url}</code>
                            menampilkan redirect link </span>
                    </div>

                    <button type="submit" class="btn {{ $chatbot->trashed() ? 'btn-success' : 'btn-primary' }}">
                        {{ $chatbot->trashed() ? 'Restore & Update' : 'Update' }}
                    </button>
                    <a href="{{ route('chatbot.index') }}" class="btn btn-secondary">Batal</a>
                </form>


            </div>
        </div>
    </section>
@endsection
