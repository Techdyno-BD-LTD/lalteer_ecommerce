@if (count(get_featured_products()) > 0)
    <section class="mb-2 mb-md-3 mt-2 mt-md-3">
        <div class="container">
            <!-- Top Section -->
            <div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-between">
                <!-- Title -->
                <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                    <span class="">{{ translate('Featured Products') }}</span>
                </h3>
                <!-- Links -->
                {{-- <div class="d-flex">
                    <a type="button" class="arrow-prev slide-arrow link-disable text-secondary mr-2"
                        onclick="clickToSlide('slick-prev','section_featured')"><i
                            class="las la-angle-left fs-20 fw-600"></i></a>
                    <a type="button" class="arrow-next slide-arrow text-secondary ml-2"
                        onclick="clickToSlide('slick-next','section_featured')"><i
                            class="las la-angle-right fs-20 fw-600"></i></a>
                </div> --}}
            </div>
            <!-- Products Section -->

            <div class="px-sm-3">
                <div class="row">
                    @foreach (get_featured_products() as $key => $product)
                        <div class="col-md-3 {{ $loop->last ? '' : 'mb-2' }}">
                            <div
                                class="position-relative has-transition hov-animate-outline border-right border-top border-bottom @if ($key == 0) border-left @endif">
                                @include(
                                    'frontend.' . get_setting('homepage_select') . '.partials.product_box_1',
                                    ['product' => $product]
                                )
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </section>
@endif
