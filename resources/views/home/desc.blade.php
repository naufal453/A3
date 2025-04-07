                <!-- View Post Modal -->
                <div class="modal fade" id="viewPostModal{{ $post->id }}" tabindex="-1"
                    aria-labelledby="viewPostModalLabel{{ $post->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="viewPostModalLabel{{ $post->id }}">
                                    {{ $post->title }}</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>{{ $post->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
