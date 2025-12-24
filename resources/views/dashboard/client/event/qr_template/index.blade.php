@extends('dashboard.layouts.app-event')

@section('title', 'Templates')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10">

                <div class="mb-5">
                    <h1 class="fw-bold text-dark mb-3">Print Your Own A4 Sheets</h1>
                    <p class="text-muted fs-5 lh-base">
                        Our print-yourself cards are the fastest way to get your guests to upload their photos and videos.
                        Download ready-made A4 sheets, print them, and cut them out.
                    </p>
                </div>

                <div class="d-flex flex-wrap gap-2 mb-5">
                    <a href="{{ route('home.templates', $event) }}"
                        class="btn {{ !$activeTemplate ? 'btn-primary' : 'btn-light border' }} rounded-pill px-4 shadow-sm">
                        All Templates
                    </a>
                    @foreach ($templates as $template)
                        <a href="{{ route('home.templates', [$event, 'template' => $template->name_template]) }}"
                            class="btn {{ $activeTemplate === $template->name_template ? 'btn-primary' : 'btn-light border' }} rounded-pill px-4 shadow-sm">
                            {{ $template->name_template }}
                        </a>
                    @endforeach
                </div>

                <div class="row g-4">
                    @forelse($templates as $template)
                        @foreach ($template->files as $file)
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                                    <div class="bg-light p-4 d-flex align-items-center justify-content-center"
                                        style="height: 280px;">
                                        <img src="{{ asset('storage/' . $file->path_template) }}"
                                            alt="{{ $template->name_template }}" class="img-fluid rounded-2 shadow-sm"
                                            style="max-height: 100%; object-fit: contain;">
                                    </div>
                                    <div class="card-body p-4">
                                        <a href="{{ route('home.templates.download', [$event, $file->id]) }}"
                                            class="btn btn-outline-primary w-100 py-2 rounded-3 d-flex align-items-center justify-content-center gap-2 shadow-sm">
                                            <i class="bi bi-download"></i> Download Template
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @empty
                        <div class="col-12">
                            <div class="text-center py-5 bg-light rounded-4 border border-dashed">
                                <p class="text-muted fs-5 mb-0">No templates found in this category.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
@endsection
