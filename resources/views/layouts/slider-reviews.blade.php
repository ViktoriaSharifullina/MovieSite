<div class="swiper-container">
    <div class="slide-container swiper">
        <div class="slide-content">
            <div class="card-wrapper swiper-wrapper">
                @foreach ($reviews as $review)
                <div class="swiper-slide">
                    <div class="image-content">
                        <div class="rate {{ $review->rating_value < 5 ? 'low' : ($review->rating_value < 7 ? 'medium' : 'high') }}">
                        </div>
                        <!-- <div class="rate {{ $review->rateClass }}"></div> -->
                        <div class="card-image"></div>
                        <div class="name">{{ $review->user->name }}</div>
                    </div>

                    <div class="card-content">
                        <p class="description">
                            {{ $review->comment }}
                        </p>
                        <button class="button">View More</button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>