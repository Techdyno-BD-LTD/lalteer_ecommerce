<div class="">
    <div class="mt-3">
        <!-- Sliders -->
        <div class="home-slider position-relative">
            @if (get_setting('home_slider_images', null, $lang) != null)
                <div class="aiz-carousel dots-inside-bottom" data-autoplay="true" data-infinite="true">
                    @php
                        $decoded_slider_images = json_decode(get_setting('home_slider_images', null, $lang), true);
                        $sliders = get_slider_images($decoded_slider_images);
                        $home_slider_links = get_setting('home_slider_links', null, $lang);
                    @endphp
                    @foreach ($sliders as $key => $slider)
                        <div class="carousel-box position-relative">
                            <a
                                href="{{ isset(json_decode($home_slider_links, true)[$key]) ? json_decode($home_slider_links, true)[$key] : '' }}">
                                <img class="d-block mw-100 img-fit overflow-hidden h-180px h-md-320px h-lg-460px"
                                    src="{{ $slider ? my_asset($slider->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                                    alt="{{ env('APP_NAME') }} promo"
                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                            </a>

                            <!-- Overlay Content -->
                            <div class="slider-overlay">
                                <h2 class="slider-heading">Welcome to Our Store</h2>
                                <p class="slider-description">
                                    Discover amazing deals and exclusive offers. Browse our top categories and find what
                                    you love!
                                </p>
                                <div class="slider-buttons">
                                    <a href="{{ url('/shop') }}" class="btn btn-primary">Shop Now</a>
                                    <a href="{{ url('/contact') }}" class="btn btn-outline-light ml-2">Contact Us</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
<div style="background-image: url('{{ asset('public/assets/img/steptodown.com135440 2.jpg') }}');"
    class="below_slider_wrapper">

    <div class="container below_slider">
        <div class="item_1">
            <img src="{{ asset('public/assets/img/Group (2).png') }}" alt="">
            <div class="ex_shipping">Exclusive Shipping</div>
            <div class="ex_description">Free shipping over 500 BDT.</div>
        </div>
        <div class="item_1">
            <img src="{{ asset('public/assets/img/Group (2).png') }}" alt="">
            <div class="ex_shipping">Exclusive Shipping</div>
            <div class="ex_description">Free shipping over 500 BDT.</div>
        </div>
        <div class="item_1">
            <img src="{{ asset('public/assets/img/Group (2).png') }}" alt="">
            <div class="ex_shipping">Exclusive Shipping</div>
            <div class="ex_description">Free shipping over 500 BDT.</div>
        </div>
        <div class="item_1">
            <img src="{{ asset('public/assets/img/Group (2).png') }}" alt="">
            <div class="ex_shipping">Exclusive Shipping</div>
            <div class="ex_description">Free shipping over 500 BDT.</div>
        </div>
    </div>
</div>
