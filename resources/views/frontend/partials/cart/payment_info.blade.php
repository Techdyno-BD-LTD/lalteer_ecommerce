{{-- <div class="mb-4">
    <h3 class="fs-16 fw-700 text-dark">
        {{ translate('Any additional info?') }}
    </h3>
    <textarea name="additional_info" rows="5" class="form-control rounded-0"
        placeholder="{{ translate('Type your text...') }}"></textarea>
</div> --}}
<div>
    <h3 class="fs-16 fw-700 text-dark">
        <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 27 27" fill="none">
            <path
                d="M2.20605 8.42188C2.20605 7.45218 2.59127 6.5222 3.27695 5.83652C3.96263 5.15084 4.89261 4.76563 5.8623 4.76562H21.2998C22.2695 4.76563 23.1995 5.15084 23.8852 5.83652C24.5708 6.5222 24.9561 7.45218 24.9561 8.42188V18.9844C24.9561 19.9541 24.5708 20.8841 23.8852 21.5697C23.1995 22.2554 22.2695 22.6406 21.2998 22.6406H5.8623C4.89261 22.6406 3.96263 22.2554 3.27695 21.5697C2.59127 20.8841 2.20605 19.9541 2.20605 18.9844V8.42188ZM5.8623 6.39062C5.32358 6.39062 4.80693 6.60463 4.42599 6.98556C4.04506 7.3665 3.83105 7.88315 3.83105 8.42188V9.64062H23.3311V8.42188C23.3311 7.88315 23.117 7.3665 22.7361 6.98556C22.3552 6.60463 21.8385 6.39062 21.2998 6.39062H5.8623ZM3.83105 18.9844C3.83105 19.5231 4.04506 20.0398 4.42599 20.4207C4.80693 20.8016 5.32358 21.0156 5.8623 21.0156H21.2998C21.8385 21.0156 22.3552 20.8016 22.7361 20.4207C23.117 20.0398 23.3311 19.5231 23.3311 18.9844V11.2656H3.83105V18.9844ZM17.6436 16.1406H20.0811C20.2965 16.1406 20.5032 16.2262 20.6556 16.3786C20.808 16.531 20.8936 16.7376 20.8936 16.9531C20.8936 17.1686 20.808 17.3753 20.6556 17.5276C20.5032 17.68 20.2965 17.7656 20.0811 17.7656H17.6436C17.4281 17.7656 17.2214 17.68 17.069 17.5276C16.9167 17.3753 16.8311 17.1686 16.8311 16.9531C16.8311 16.7376 16.9167 16.531 17.069 16.3786C17.2214 16.2262 17.4281 16.1406 17.6436 16.1406Z"
                fill="black" />
        </svg> {{ translate('Payment Method') }}
    </h3>
    <div class="row gutters-10">
        @foreach (get_activate_payment_methods() as $payment_method)
            <div class="col-xl-4 col-md-6">
                <label class="aiz-megabox d-block mb-3">
                    <input value="{{ $payment_method->name }}" class="online_payment" type="radio"
                        name="payment_option" checked>
                    <span class="d-flex align-items-center justify-content-between aiz-megabox-elem rounded-0 p-3">
                        <span class="d-block fw-400 fs-14">{{ ucfirst(translate($payment_method->name)) }}</span>
                        <span class="rounded-1 h-40px overflow-hidden">
                            <img src="{{ static_asset('assets/img/cards/' . $payment_method->name . '.png') }}"
                                class="img-fit h-100">
                        </span>
                    </span>
                </label>
            </div>
        @endforeach

        <!-- Cash Payment -->
        @if (get_setting('cash_payment') == 1)
            @php
                $digital = 0;
                $cod_on = 1;
                foreach ($carts as $cartItem) {
                    $product = get_single_product($cartItem['product_id']);
                    if ($product['digital'] == 1) {
                        $digital = 1;
                    }
                    if ($product['cash_on_delivery'] == 0) {
                        $cod_on = 0;
                    }
                }
            @endphp
            @if ($digital != 1 && $cod_on == 1)
                <div class="col-xl-4 col-md-6">
                    <label class="aiz-megabox d-block mb-3">
                        <input value="cash_on_delivery" class="online_payment" type="radio" name="payment_option"
                            checked>
                        <span class="d-flex align-items-center justify-content-between aiz-megabox-elem rounded-0 p-3">
                            <span class="d-block fw-400 fs-14">{{ translate('Cash on Delivery') }}</span>
                            <span class="rounded-1 h-40px w-70px overflow-hidden">
                                <img src="{{ static_asset('assets/img/cards/cod.png') }}" class="img-fit h-100">
                            </span>
                        </span>
                    </label>
                </div>
            @endif
        @endif

        @if (Auth::check())
            <!-- Offline Payment -->
            @if (addon_is_activated('offline_payment'))
                @foreach (get_all_manual_payment_methods() as $method)
                    <div class="col-xl-4 col-md-6">
                        <label class="aiz-megabox d-block mb-3">
                            <input value="{{ $method->heading }}" type="radio" name="payment_option"
                                class="offline_payment_option" onchange="toggleManualPaymentData({{ $method->id }})"
                                data-id="{{ $method->id }}" checked>
                            <span
                                class="d-flex align-items-center justify-content-between aiz-megabox-elem rounded-0 p-3">
                                <span class="d-block fw-400 fs-14">{{ $method->heading }}</span>
                                <span class="rounded-1 h-40px w-70px overflow-hidden">
                                    <img src="{{ uploaded_asset($method->photo) }}" class="img-fit h-100">
                                </span>
                            </span>
                        </label>
                    </div>
                @endforeach

                @foreach (get_all_manual_payment_methods() as $method)
                    <div id="manual_payment_info_{{ $method->id }}" class="d-none">
                        @php echo $method->description @endphp
                        @if ($method->bank_info != null)
                            <ul>
                                @foreach (json_decode($method->bank_info) as $key => $info)
                                    <li>{{ translate('Bank Name') }} -
                                        {{ $info->bank_name }},
                                        {{ translate('Account Name') }} -
                                        {{ $info->account_name }},
                                        {{ translate('Account Number') }} -
                                        {{ $info->account_number }},
                                        {{ translate('Routing Number') }} -
                                        {{ $info->routing_number }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach
            @endif
        @endif
    </div>

    <!-- Offline Payment Fields -->
    @if (addon_is_activated('offline_payment') && count(get_all_manual_payment_methods()) > 0)
        <div class="d-none mb-3 rounded border bg-white p-3 text-left">
            <div id="manual_payment_description">

            </div>
            <br>
            <div class="row">
                <div class="col-md-3">
                    <label>{{ translate('Transaction ID') }} <span class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control mb-3" name="trx_id"
                        onchange="stepCompletionPaymentInfo()" id="trx_id"
                        placeholder="{{ translate('Transaction ID') }}" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-form-label">{{ translate('Photo') }}</label>
                <div class="col-md-9">
                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-soft-secondary font-weight-medium">
                                {{ translate('Browse') }}</div>
                        </div>
                        <div class="form-control file-amount">{{ translate('Choose image') }}
                        </div>
                        <input type="hidden" name="photo" class="selected-files">
                    </div>
                    <div class="file-preview box sm">
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Wallet Payment -->
    @if (Auth::check() && get_setting('wallet_system') == 1)
        <div class="py-4 px-4 text-center bg-soft-secondary-base mt-4">
            <div class="fs-14 mb-3">
                <span class="opacity-80">{{ translate('Or, Your wallet balance :') }}</span>
                <span class="fw-700">{{ single_price(Auth::user()->balance) }}</span>
            </div>
            @if (Auth::user()->balance < $total)
                <button type="button" class="btn btn-secondary" disabled>
                    {{ translate('Insufficient balance') }}
                </button>
            @else
                <button type="button" onclick="use_wallet()" class="btn btn-primary fs-14 fw-700 px-5 rounded-0">
                    {{ translate('Pay with wallet') }}
                </button>
            @endif
        </div>
    @endif
</div>
