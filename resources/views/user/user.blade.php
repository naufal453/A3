<body>
    @auth
        <!-- Sorting Form -->
        <form method="GET" action="{{ route('home.index') }}">
            <label for="sort">Sort by:</label>
            <select name="sort" id="sort" onchange="this.form.submit()">
                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
            </select>
        </form>
        <br>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            @foreach ($posts as $item)
                <div class="col">
                    <!-- Card for larger devices -->
                    <div class="card d-none d-md-flex mb-3" style="width: 540px;margin-left:20px;"
                        onclick="window.location='{{ route('home.post.detail', ['id' => $item->id]) }}'">
                        <div class="row g-0">
                            <div class="col-md-4">
                                @if ($item->image_path)
                                    <img src="{{ asset('storage/' . $item->image_path) }}" class="img-fluid rounded-start"
                                        alt="Post Image" style="height: 250px; object-fit: cover;">
                                @else
                                    <img src="..." class="img-fluid rounded-start" alt="Default Image"
                                        style="height: 100%; object-fit: cover;">
                                @endif
                            </div>
                            <div class="col-md-8">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $item->title ?? 'Unknown Title' }}</h5>
                                    <p class="card-text">
                                        {{ Str::limit($item->description ?? 'No description available', 100) }}
                                    </p>
                                    <p class="card-text mt-auto">
                                        <small class="text-body-secondary">
                                            Created by
                                            @if ($item->user)
                                                <a href="{{ route('user.show', ['id' => $item->user->id]) }}"
                                                    class="user-link">{{ $item->user->username }}</a>
                                            @else
                                                <span>Unknown User</span>
                                            @endif
                                            on {{ $item->created_at->format('M d, Y') }}
                                        </small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card for smaller devices -->
                    <div class="card d-md-none mb-3"
                        onclick="window.location='{{ route('home.post.detail', ['id' => $item->id]) }}'">
                        @if ($item->image_path)
                            <img src="{{ asset('storage/' . $item->image_path) }}" class="card-img-top" alt="Post Image">
                        @else
                            <img src="..." class="card-img-top" alt="Default Image">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->title ?? 'Unknown Title' }}</h5>
                            <p class="card-text">
                                {{ Str::limit($item->description ?? 'No description available', 100) }}
                            </p>
                            <p class="card-text">
                                <small class="text-body-secondary">
                                    Created by
                                    @if ($item->user)
                                        <a href="{{ route('user.show', ['id' => $item->user->id]) }}"
                                            class="user-link">{{ $item->user->username }}</a>
                                    @else
                                        <span>Unknown User</span>
                                    @endif
                                    on {{ $item->created_at->format('M d, Y') }}
                                </small>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endauth
</body>
