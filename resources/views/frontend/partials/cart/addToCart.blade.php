<div class="modal-body px-4 py-5 c-scrollbar-light">
    <div class="row">
        <!-- Product Image gallery -->
        <div class="col-md-12">
            <div class="row">
                <div class="col-lg-4">
                    <img style="padding: 20px;background-color: #edeaea;" height="300px" width="100%"
                        class="lazyload mx-auto  has-transition" src="{{ get_image($product->thumbnail) }}"
                        alt="{{ $product->getTranslation('name') }}" title="{{ $product->getTranslation('name') }}"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">

                </div>
                <div class="col-lg-8">
                    <h2 class="mb-2 fs-28 fw-700 text-dark">
                        {{ $product->getTranslation('name') }}
                    </h2>
                    <div class="category_nam text-dark opacity-80">
                        {{ getCategoryName($product->category_id) }}</div>
                    <div class="cat_des opacity-70">
                        {!! \Illuminate\Support\Str::words($product->description, 100) !!}
                    </div>

                </div>
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-lg-12 pt-3">
            <div class="text-left">
                <!-- Product name -->
                <strong>Choose a size</strong>
                <form id="option-choice-form">
                    @csrf
                    <input type="hidden" name="id" value="{{ $product->id }}">
                    @php
                        $qty = 0;
                        foreach ($product->stocks as $key => $stock) {
                            $qty += $stock->qty;
                        }
                    @endphp

                    @if ($product->digital != 1)
                        <!-- Product Choice options -->
                        @if ($product->choice_options != null)
                            @foreach (json_decode($product->choice_options) as $choice)
                                <div class="row no-gutters mt-3">
                                    <div class="col-12">
                                        <div class="aiz-radio-inline">
                                            @foreach ($choice->values as $key => $value)
                                                <div class="my_cart mb-4">
                                                    <div class="product-name">
                                                        <!-- Display the product name here -->
                                                        <h5 class="text-dark">{{ $product->name }} (
                                                            <span class="text-primary">{{ $value }}</span>)
                                                        </h5>
                                                        <div class="">
                                                            <strong class="fs-16 fw-700 text-dark">
                                                                {{ home_discounted_price_cart($product, $value) }}
                                                                <!-- Pass the variant value here -->
                                                            </strong>
                                                            <del class="fs-14 opacity-60 ml-2">
                                                                {{ home_price_cart($product, true, $value) }}
                                                            </del>

                                                            @if ($product->unit != null)
                                                                <span
                                                                    class="opacity-70 ml-1">/{{ $product->getTranslation('unit') }}</span>
                                                            @endif
                                                            @if (discount_in_percentage($product) > 0)
                                                                <span
                                                                    class="bg-danger ml-2 fs-11 fw-700 text-white w-35px text-center px-2"
                                                                    style="padding-top:2px;padding-bottom:2px;">
                                                                    -{{ discount_in_percentage($product) }}%</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <label class="aiz-megabox pl-0 mr-2 mb-0">
                                                        <input type="radio"
                                                            name="attribute_id_{{ $choice->attribute_id }}"
                                                            value="{{ $value }}"
                                                            @if ($key == 0) checked @endif>
                                                        <div
                                                            class="aiz-megabox-elem rounded-1 d-flex btn btn-primary align-items-center justify-content-center py-1 px-3">
                                                            Add To Cart
                                                        </div>

                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        @endif

                        <!-- Color -->
                        @if ($product->colors && count(json_decode($product->colors)) > 0)
                            <div class="row no-gutters mt-3">
                                <div class="col-3">
                                    <div class="text-secondary fs-14 fw-400 mt-2">{{ translate('Color') }}</div>
                                </div>
                                <div class="col-9">
                                    <div class="aiz-radio-inline">
                                        @foreach (json_decode($product->colors) as $key => $color)
                                            <label class="aiz-megabox pl-0 mr-2 mb-0" data-toggle="tooltip"
                                                data-title="{{ get_single_color_name($color) }}">
                                                <input type="radio" name="color"
                                                    value="{{ get_single_color_name($color) }}"
                                                    @if ($key == 0) checked @endif>
                                                <span
                                                    class="aiz-megabox-elem rounded-0 d-flex align-items-center justify-content-center p-1">
                                                    <span class="size-25px d-inline-block rounded"
                                                        style="background: {{ $color }};"></span>
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="row no-gutters d-none mt-3">
                            <div class="col-3">
                                <div class="text-secondary fs-14 fw-400 mt-2">{{ translate('Quantity') }}</div>
                            </div>
                            <div class="col-9">
                                <div class="product-quantity d-flex align-items-center">
                                    <div class="row no-gutters align-items-center aiz-plus-minus mr-3"
                                        style="width: 130px;">
                                        <button class="btn col-auto btn-icon btn-sm btn-light rounded-0" type="button"
                                            data-type="minus" data-field="quantity" disabled="">
                                            <i class="las la-minus"></i>
                                        </button>
                                        <input type="number" name="quantity"
                                            class="col border-0 text-center flex-grow-1 fs-16 input-number"
                                            placeholder="1" value="{{ $product->min_qty }}"
                                            min="{{ $product->min_qty }}" max="10" lang="en">
                                        <button class="btn col-auto btn-icon btn-sm btn-light rounded-0" type="button"
                                            data-type="plus" data-field="quantity">
                                            <i class="las la-plus"></i>
                                        </button>
                                    </div>
                                    <div class="avialable-amount opacity-60">
                                        @if ($product->stock_visibility_state == 'quantity')
                                            (<span id="available-quantity">{{ $qty }}</span>
                                            {{ translate('available') }})
                                        @elseif($product->stock_visibility_state == 'text' && $qty >= 1)
                                            (<span id="available-quantity">{{ translate('In Stock') }}</span>)
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Show Add to Cart Button if no variants -->
                        @if ($product->choice_options == null || count(json_decode($product->choice_options)) == 0)
                            <div class="row no-gutters mt-3">
                                <button type="submit" class="btn btn-primary w-100">
                                    Add To Cart
                                </button>
                            </div>
                        @endif
                    @else
                        <!-- Quantity -->
                        <input type="hidden" name="quantity" value="1">

                    @endif
                </form>




            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#option-choice-form input').on('change', function() {
        checked = true;
        getVariantPrice();
    });
</script>
