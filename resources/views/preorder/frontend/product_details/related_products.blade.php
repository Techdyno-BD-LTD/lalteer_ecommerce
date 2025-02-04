<div class="border rounded-2">
    <div class="p-3 p-sm-4">
        <h3 class="fs-16 fw-700 mb-0">
            <span class="mr-4 text-uppercase">{{ translate('Related Products') }}</span>
        </h3>
    </div>
    <div class="px-4">
        <div class="aiz-carousel gutters-4 half-outside-arrow gap-3" data-items="4" data-xl-items="3" data-lg-items="4"
            data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true' data-infinite='true'>
            @foreach (\App\Models\Product::inRandomOrder()->take(10)->get() as $key => $related_product)
                <div
                    class="carousel-box px-3 position-relative has-transition border-right border-top border-bottom @if ($key == 0) border-left @endif hov-animate-outline">
                    @include('frontend.' . get_setting('homepage_select') . '.partials.product_box_1', [
                        'product' => $related_product,
                    ])
                </div>
            @endforeach
        </div>
    </div>
</div>
