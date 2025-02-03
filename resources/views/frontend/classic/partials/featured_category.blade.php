@if (count($featured_categories) > 0)
    <section class="mb-2 mb-md-3 mt-2 mt-md-3">
        <div class="">
            <div class="bg-white">
                <!-- Top Section -->
                <div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-between">
                    <!-- Title -->
                    {{-- <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                        <span class="">{{ translate('Featured Categories') }}</span>
                    </h3> --}}
                    <!-- Links -->
                    {{-- <div class="d-flex">
                        <a class="text-blue fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary"
                            href="{{ route('categories.all') }}">{{ translate('View All Categories') }}</a>
                    </div> --}}
                </div>
            </div>
            <!-- Categories -->

            <div class="bg-white position-relative">
                <img width="100%" src="{{ static_asset('assets/img/home_category.jpg') }}" alt="">

                <!-- Blurred background with white text for 'Exclusive' -->
                <div class="feature_title position-absolute top-50 start-50 translate-middle bg-opacity-50 text-white ">
                    Exclusive
                </div>

                <!-- Category images with background overlay -->
                <div style="gap: 10px; margin-top: -170px"
                    class="position-relative bottom-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                    style="background: rgba(0, 0, 0, 0.4);">
                    @foreach ($featured_categories->take(4) as $key => $category)
                        @php
                            $category_name = $category->getTranslation('name');
                        @endphp
                        <a href="{{ route('products.category', $category->slug) }}">
                            <div class="text-center category_" style="position: relative;">
                                <img src="{{ isset($category->bannerImage->file_name) ? my_asset($category->bannerImage->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                                    class="lazyload h-auto mx-auto has-transition"
                                    alt="{{ $category->getTranslation('name') }}"
                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                <div class="home_category_name">
                                    {{ $category->name }}
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>







        </div>
    </section>
@endif
