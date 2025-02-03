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
@php
    $bannerImage = \App\Models\BusinessSetting::where('type', 'home_banner3_images')->first();
    $value = json_decode($bannerImage['value'], true);
    $firstValue = $value[0];
@endphp
<div style="background-image: url('{{ uploaded_asset($firstValue) }}');" class="below_slider_wrapper">

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
    <div class="exclusive_btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="51" height="51" viewBox="0 0 51 51" fill="none">
            <path
                d="M25.5 33L35.5 23H15.5L25.5 33ZM25.5 50.5C22.0417 50.5 18.7917 49.8433 15.75 48.53C12.7083 47.2166 10.0625 45.4358 7.8125 43.1875C5.5625 40.9391 3.78167 38.2933 2.47 35.25C1.15834 32.2066 0.50167 28.9566 0.500003 25.5C0.498336 22.0433 1.155 18.7933 2.47 15.75C3.785 12.7067 5.56583 10.0608 7.8125 7.8125C10.0592 5.56416 12.705 3.78333 15.75 2.47C18.795 1.15667 22.045 0.5 25.5 0.5C28.955 0.5 32.205 1.15667 35.25 2.47C38.295 3.78333 40.9408 5.56416 43.1875 7.8125C45.4341 10.0608 47.2158 12.7067 48.5325 15.75C49.8491 18.7933 50.505 22.0433 50.5 25.5C50.495 28.9566 49.8383 32.2066 48.53 35.25C47.2216 38.2933 45.4408 40.9391 43.1875 43.1875C40.9341 45.4358 38.2883 47.2175 35.25 48.5325C32.2116 49.8475 28.9617 50.5033 25.5 50.5Z"
                fill="white" />
        </svg> Download Catalouge
        <button class="btn btn-primary">Download</button>
        <button class="btn btn-secondary">Preview</button>
    </div>
</div>
