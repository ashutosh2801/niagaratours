@extends('layouts.app')

@section('title', $page->title ?? 'Page')

@if(!empty($page->meta_description))
    @section('meta_description', $page->meta_description)
@endif

@section('content')
    <!-- Page Header -->
    <section class="bg-gray-50 border-b border-gray-200">
        <x-breadcrumbs :items="[
            ['label' => $page->title ?? 'Page'],
        ]" />
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900">{{ $page->title ?? 'Page' }}</h1>
        </div>
    </section>

    <!-- Page Content -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="prose prose-gray prose-lg max-w-none">
                    {!! $page->content ?? '' !!}
                </div>

                @if(($page->images ?? null) && count($page->images) > 0)
                    <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($page->images as $image)
                            <img src="{{ $image }}" alt="" class="rounded-xl shadow-sm w-full h-64 object-cover">
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>

    @if($page->show_cta ?? false)
        <!-- Call to Action -->
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ $page->cta_title ?? 'Ready to Start Your Adventure?' }}</h2>
                <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">{{ $page->cta_description ?? 'Book your Niagara Falls tour today and create memories that will last a lifetime.' }}</p>
                <a href="{{ $page->cta_url ?? route('tours') }}" wire:navigate class="inline-flex items-center gap-2 px-8 py-3.5 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors shadow-lg">
                    {{ $page->cta_text ?? 'Browse Tours' }}
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </section>
    @endif
@endsection
