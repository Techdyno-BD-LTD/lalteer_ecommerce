 <!-- Flash Deal -->
 @php
     $flash_deal = get_featured_flash_deal();
 @endphp
 @if ($flash_deal != null)
     <section class="mb-2 mb-md-3 mt-2 mt-md-3" id="flash_deal">
         <div class="container">
             <!-- Top Section -->
             <div class="d-flex flex-wrap mb-2 mb-md-3 align-items-baseline justify-content-between">
                 <!-- Title -->
                 <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                     <span class="d-inline-block">{{ translate('Flash Deals') }}</span>

                 </h3>
                 <div class="d-none d-md-block timer_flash">
                     <div class="bg-white">
                         <div class="aiz-count-down-circle" end-date="{{ date('Y/m/d H:i:s', $flash_deal->end_date) }}">
                         </div>
                     </div>
                 </div>
                 <!-- Links -->
                 <div>
                     <div class="text-dark d-flex align-items-center mb-0">
                         <a href="{{ route('flash-deals') }}"
                             class="fs-10 fs-md-12 fw-700 text-reset has-transition opacity-60 hov-opacity-100 hov-text-primary animate-underline-primary mr-3">{{ translate('View All Flash Sale') }}</a>
                         <span class=" border-left border-soft-light border-width-2 pl-3">
                             <a href="{{ route('flash-deal-details', $flash_deal->slug) }}"
                                 class="fs-10 fs-md-12 fw-700 text-reset has-transition opacity-60 hov-opacity-100 hov-text-primary animate-underline-primary">{{ translate('View All Products from This Flash Sale') }}</a>
                         </span>
                     </div>
                 </div>
             </div>

             <!-- Countdown for small device -->
             <div class="bg-white mb-3 d-md-none">
                 <div class="aiz-count-down-circle" end-date="{{ date('Y/m/d H:i:s', $flash_deal->end_date) }}"></div>
             </div>

             <div class="row gutters-5 gutters-md-16">
                 <!-- Flash Deals Baner & Countdown -->
                 <div class="flash-deals-baner col-xxl-4 col-lg-5 col-6 h-200px h-md-400px h-lg-475px">
                     <a href="{{ route('flash-deal-details', $flash_deal->slug) }}">
                         <div class="h-100 w-100 w-xl-auto"
                             style="background-image: url('{{ uploaded_asset($flash_deal->banner) }}'); background-size: cover; background-position: center center;">

                         </div>
                     </a>
                 </div>
                 <!-- Flash Deals Products -->
                 <div class="col-xxl-8 col-lg-7 col-6">
                     @php
                         $flash_deal_products = get_flash_deal_products($flash_deal->id);

                     @endphp
                     <div class="aiz-carousel border-top @if (count($flash_deal_products) > 8) border-right @endif arrow-inactive-none arrow-x-0"
                         data-rows="1" data-items="3" data-xxl-items="3" data-xl-items="3" data-lg-items="3"
                         data-md-items="3" data-sm-items="2.5" data-xs-items="1.7" data-arrows="true" data-dots="false">
                         @foreach ($flash_deal_products as $key => $flash_deal_product)
                             <div
                                 class="carousel-box px-3 position-relative has-transition border-right border-top border-bottom @if ($key == 0) border-left @endif hov-animate-outline">
                                 @include(
                                     'frontend.' . get_setting('homepage_select') . '.partials.product_box_1',
                                     ['product' => $flash_deal_product->product]
                                 )
                             </div>
                         @endforeach
                     </div>
                 </div>
             </div>
         </div>
     </section>
 @endif
