@extends('layouts.app')

@section('content')
    <h1 class="ui header">Films</h1>

    <div class="ui divided items">
        @foreach ($films as $film)
            <div class="item">
                <div class="content">
                    <div class="header is-flex">
                        <span class="flex">{{ $film->title }}</span>

                        <div class="ui star rating" data-film-id="{{ $film->id }}" data-rating="{{ $film->stars }}" data-max-rating="5"></div>
                    </div>

                    <div class="meta is-flex">
                        <span class="flex">{{ $film->language->name }} {{ $film->release_year }}</span>

                        @if (auth()->user()->rated($film->id))
                            <span class="italic">Your rating: {{ auth()->user()->ratingFor($film->id) }}</span>
                        @endif
                    </div>

                    <div class="description">
                        <p>{{ $film->description }}</p>
                    </div>
                </div>
            </div>
        @endforeach

        <a href="/films?page={{ $page - 1 }}" class="ui left labeled icon button" rel="prev">
            <i class="left chevron icon"></i>
            @lang('pagination.previous')
        </a>

        <a href="/films?page={{ $page + 1 }}" class="ui right labeled icon button" rel="next">
            <i class="right chevron icon"></i>
            @lang('pagination.next')
        </a>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/films.js') }}"></script>
@endpush
