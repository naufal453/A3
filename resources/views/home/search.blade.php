@extends('layouts.app-master')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">

@section('content')
    <div class="content-area p-5 rounded">
        <h1 class="my-4 text-center">Search Results</h1>
        <form action="{{ route('search.results') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="query" class="form-control" placeholder="Search..."
                    value="{{ request('query') }}" required>
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>

        @if (isset($results) && $results->isNotEmpty())
            <div class="row row-cols-1 row-cols-md-2 g-4">
                @foreach ($results as $result)
                    <div class="col">
                        <!-- Card for larger devices -->
                        <div class="card d-none d-md-flex mb-3" style="width: 540px; margin-left: 20px;"
                            onclick="window.location='{{ route('posts.show', $result->id) }}'">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    @if ($result->image_path)
                                        <img src="{{ asset('storage/' . $result->image_path) }}"
                                            class="img-fluid rounded-start" alt="Post Image"
                                            style="height: 250px; object-fit: cover;">
                                    @else
                                        <img src="..." class="img-fluid rounded-start" alt="Default Image"
                                            style="height: 100%; object-fit: cover;">
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ $result->title ?? 'Unknown Title' }}</h5>
                                        <p class="card-text">
                                            {!! Str::limit(strip_tags(html_entity_decode($result->description)), 100) !!}
                                        </p>
                                        <p class="card-text mt-auto">
                                            <small class="text-body-secondary">
                                                Created by
                                                @if ($result->user)
                                                    <a href="{{ route('user.show', ['username' => $result->user->username]) }}"
                                                        class="user-link">{{ $result->user->username }}</a>
                                                @else
                                                    <span>Unknown User</span>
                                                @endif
                                                on {{ $result->created_at->format('M d, Y') }}
                                            </small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card for smaller devices -->
                        <div class="card d-md-none mb-3" onclick="window.location='{{ route('posts.show', $result->id) }}'">
                            @if ($result->image_path)
                                <img src="{{ asset('storage/' . $result->image_path) }}" class="card-img-top"
                                    alt="Post Image">
                            @else
                                <img src="..." class="card-img-top" alt="Default Image">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $result->title ?? 'Unknown Title' }}</h5>
                                <p class="card-text">
                                    {!! Str::limit($result->description ?? 'No description available', 100) !!}
                                </p>
                                <p class="card-text">
                                    <small class="text-body-secondary">
                                        Created by
                                        @if ($result->user)
                                            <a href="{{ route('user.show', ['username' => $result->user->username]) }}"
                                                class="user-link">{{ $result->user->username }}</a>
                                        @else
                                            <span>Unknown User</span>
                                        @endif
                                        on {{ $result->created_at->format('M d, Y') }}
                                    </small>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @elseif(isset($results))
            <p class="text-muted text-center">No results found for "{{ request('query') }}".</p>
        @endif
    </div>
@endsection
