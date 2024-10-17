@extends('layout.home')

@section('content')
<link rel="stylesheet" href="/vendors/mdi/css/materialdesignicons.min.css">



<div class="row justify-content-center">
    <div class="col-md-12 grid-margin">
        <div class="row justify-content-center">
            <div class="col-12 mb-4">
                <h3 class="font-weight-bold">Welcome, {{ auth()->user()->username }}</h3>
                <h6 class="font-weight-normal mb-4">
                    All systems are running smoothly! You have
                    <span class="text-primary">3 unread alerts!</span>
                </h6>
            </div>
            {{-- api bmkg cuaca --}}
            <div class="col-lg-8">
                <div class="card mt-4 shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title">Weather Forecast Data</h4>
                        <div id="weatherCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
                            <div class="carousel-inner" id="dataContainer">
                                {{-- Weather data will be dynamically inserted here --}}
                            </div>
                            <a class="carousel-control-prev" href="#weatherCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#weatherCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>


            {{-- Postings Section --}}
            <div class="col-lg-10">
                <div class="container p-4">
                    @if ($postings->isEmpty())
                        <div class="text-center text-muted">
                            <p>No postings available.</p>
                        </div>
                    @else
                        @foreach($postings as $posting)
                            <div class="card mb-4 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="https://placehold.co/400x400" alt="" style="max-width: 50px; border-radius: 50%;">
                                        <div class="divider" style="height: 40px; width: 1px; background-color: #ccc; margin: 0 15px;"></div>
                                        <h2 class="card-title mb-0">{{ $posting->create_by }}</h2>

                                        <div class="dropdown ml-auto">
                                            <a class="text-muted" href="#" id="dropdownMenuButton{{ $posting->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical" style="font-size: 1.5rem;"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton{{ $posting->id }}">
                                                @if ($posting->user_id === auth()->id())
                                                    <a class="dropdown-item" href="{{ route('edit.postings', $posting->id) }}">
                                                        <i class="mdi mdi-pencil"></i> Edit
                                                    </a>
                                                    <form action="{{ route('delete.postings', $posting->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="dropdown-item" type="submit" onclick="return confirm('Are you sure you want to delete this post?');">
                                                            <i class="mdi mdi-delete"></i> Delete
                                                        </button>
                                                    </form>
                                                @else
                                                    <a class="dropdown-item" href="">
                                                        <i class="mdi mdi-flag"></i> Report
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @if($posting->message_gambar)
                                        <div class="my-3 text-center">
                                            <img src="{{ asset($posting->message_gambar) }}" alt="Image" class="img-fluid rounded" style="object-fit: contain; width: 100%; height: auto;">
                                        </div>
                                    @endif
                                    <p class="text-muted mb-2">{{ $posting->created_at->diffForHumans() }}</p>
                                    <p class="card-text">{{ $posting->message }}</p>
                                    {{-- like section --}}
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div class="d-flex align-items-center">
                                            @php
                                                $liked = $posting->likes->contains('user_id', auth()->id());
                                            @endphp
                                            <form action="{{ $liked ? route('postings.unlike', $posting->id) : route('postings.like', $posting->id) }}" method="POST" class="mr-2">
                                                @csrf
                                                <button type="submit" style="border: none; background: none; padding: 0; cursor: pointer;">
                                                    <i class="mdi {{ $liked ? 'mdi-heart' : 'mdi-heart-outline' }}" style="color: #ff0000; font-size: 1rem;"></i>
                                                </button>
                                            </form>
                                            <b class="ml-2">{{ $posting->likes->count() }} likes</b>
                                            <button style="border: none; background : none" href="#" class="ml-3 text-muted" data-toggle="modal" data-target="#likesModal-{{ $posting->id }}">Show all Likes</button>
                                        </div>
                                    </div>
                                    {{-- comment section --}}
                                    <div class="mt-3">
                                        <h6 class="text-muted mb-2">Comments :</h6>
                                        <div class="comments-container" id="comments-{{ $posting->id }}">
                                            @foreach($posting->comments->sortByDesc('created_at') as $index => $comment)
                                                <div class="comment mb-2 {{ $index >= 3 ? 'd-none extra-comment' : '' }}">
                                                    <hr>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex flex-grow-1">
                                                            <div>
                                                                <strong>{{ $comment->create_by }} :</strong>
                                                                <span>{{ $comment->comment }}</span>
                                                            </div>
                                                            <p class="text-muted mb-2 ml-auto">{{ $comment->created_at->diffForHumans() }}</p>
                                                        </div>

                                                        @if($comment->user_id == auth()->id())
                                                            <div class="dropdown ml-auto">
                                                                <a class="text-muted" href="#" id="dropdownMenuButton{{ $comment->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="mdi mdi-dots-vertical" style="font-size: 1.5rem;"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton{{ $comment->id }}">
                                                                    <form action="{{ route('postings.discomment', [$posting->id, $comment->id]) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="dropdown-item text-danger">
                                                                            <i class="mdi mdi-delete"></i> Delete
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        {{-- Show More / Show Less Button --}}
                                        @if($posting->comments->count() > 3)
                                            <button class="btn text-muted mt-2" data-toggle="modal" data-target="#commentsModal-{{ $posting->id }}">Show all comments</button>
                                        @endif

                                        {{-- Form to Add a New Comment --}}
                                        <form action="{{ route('postings.comment', $posting->id) }}" method="POST" class="mt-3">
                                            @csrf
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="comment" placeholder="Add a comment..." required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="submit">Comment</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>

                             {{-- Modal for Likes --}}
                             <div class="modal fade " id="likesModal-{{ $posting->id }}" tabindex="-1" role="dialog" aria-labelledby="likesModalLabel{{ $posting->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="likesModalLabel{{ $posting->id }}">Users who liked this post</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            @if($posting->likes->isEmpty())
                                                <p>No one has liked this post yet.</p>
                                            @else
                                            <ul class="list-group list-group-flush">
                                                @foreach($posting->likes as $like)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <strong>{{ $like->user->username }}</strong>
                                                        <p class="text-muted mb-0">{{ $like->created_at->diffForHumans() }}</p>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Modal for Comments --}}
                            <div class="modal fade" id="commentsModal-{{ $posting->id }}" tabindex="-1" role="dialog" aria-labelledby="commentsModalLabel{{ $posting->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="commentsModalLabel{{ $posting->id }}">Comments for this post</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            @if($posting->comments->isEmpty())
                                                <p>No comments yet.</p>
                                            @else
                                                <ul class="list-group list-group-flush">
                                                    @foreach($posting->comments->sortByDesc('created_at') as $index => $comment)
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <strong>{{ $comment->create_by }} :</strong>
                                                                <span>{{ $comment->comment }}</span>
                                                                <p class="text-muted mb-0">{{ $comment->created_at->diffForHumans() }}</p>
                                                            </div>

                                                            @if($comment->user_id == auth()->id())
                                                                <div class="dropdown ml-auto">
                                                                    <a class="text-muted" href="#" id="dropdownMenuButton{{ $comment->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <i class="mdi mdi-dots-vertical" style="font-size: 1.5rem;"></i>
                                                                    </a>
                                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton{{ $comment->id }}">
                                                                        <form action="{{ route('postings.discomment', [$posting->id, $comment->id]) }}" method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="dropdown-item text-danger">
                                                                                <i class="mdi mdi-delete"></i> Delete
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>


<script>
// for carousell
$(document).ready(function() {
    $.ajax({
        url: 'https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4=35.78.23.1001',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log(response);

            let weatherData = response.data[0].cuaca[1];
            let dataContainer = $('#dataContainer');
            let location = response.data[0].lokasi;

            // Display location details
            let locationHeader = `
                <h5>${location.provinsi}, ${location.kotkab}, ${location.kecamatan}, ${location.desa}</h5>
            `;
            dataContainer.append(locationHeader);

            // Check if weatherData is available
            if (weatherData.length === 0) {
                dataContainer.append('<p>No weather data available.</p>');
                return;
            }

            // Loop through the weather data array and display each item
            weatherData.forEach(function(item, index) {
                let localDatetime = item.local_datetime;
                let temperature = `${item.t}°C`;
                let description = item.weather_desc;
                let windSpeed = `${item.ws} km/h`;
                let humidity = `${item.hu}%`;
                let iconUrl = item.image;

                // Determine if this is the first item to set active class
                let isActiveClass = (index === 0) ? 'active' : '';

                let carouselItem = `
                    <div class="carousel-item ${isActiveClass}">
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="${iconUrl}" class="d-block" alt="Weather Icon" style="width: 100px;">
                        </div>
                        <div class="text-center mt-3">
                            <h5>${localDatetime}</h5>
                            <p><strong>Temperature:</strong> ${temperature}</p>
                            <p><strong>Weather:</strong> ${description}</p>
                            <p><strong>Wind Speed:</strong> ${windSpeed}</p>
                            <p><strong>Humidity:</strong> ${humidity}</p>
                        </div>
                    </div>
                `;

                // Append the carousel item to the data container
                dataContainer.append(carouselItem);
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching weather data:', error);
            $('#dataContainer').append('<p>Error fetching weather data. Please try again later.</p>');
        }
    });
});



</script>
@endsection
