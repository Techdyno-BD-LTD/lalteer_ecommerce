@extends('frontend.layouts.app')

@section('content')
    <section class="my-4 gry-bg"
        style="background-image: url('{{ static_asset('assets/img/p_details_bg.jpg') }}'); background-size: cover; background-position: center;">
        <section class="mb-1 pt-3">
            <div class="product-details-bredcrumb" style="position: relative; text-align: center;">
                <img src="{{ static_asset('assets/img/Frame 1171276523.png') }}" alt=""
                    style="width: 100%; height: 200px;">
                <h2
                    style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; font-size: 26px;">
                    Product Details</h2>
            </div>
        </section>
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-lg-12 mx-auto">
                    <form class="form-default" data-toggle="validator" action="{{ route('payment.checkout') }}"
                        role="form" method="POST" id="checkout-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="text_title mt-2">Contact Information</div>
                                <!-- Shipping Info -->
                                <div class="" style="margin-bottom: 2rem;">

                                    <div id="collapseShippingInfo" class="collapse show"
                                        aria-labelledby="headingShippingInfo" data-parent="#accordioncCheckoutInfo">
                                        <div class="card-body" id="shipping_info">
                                            @include('frontend.partials.cart.shipping_info', [
                                                'address_id' => $address_id,
                                            ])
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Cart Summary -->
                            <div class="col-lg-4 mt-4 mt-lg-0" id="cart_summary">
                                @include('frontend.partials.cart.cart_summary_2', [
                                    'proceed' => 0,
                                    'carts' => $carts,
                                ])
                            </div>

                        </div>
                        <div class="" id="">
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
@endsection

@section('modal')
    <!-- Address Modal -->
    @if (Auth::check())
        @include('frontend.partials.address.address_modal')
    @endif
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $(".online_payment").click(function() {
                $('#manual_payment_description').parent().addClass('d-none');
            });
            toggleManualPaymentData($('input[name=payment_option]:checked').data('id'));
        });

        var minimum_order_amount_check = {{ get_setting('minimum_order_amount_check') == 1 ? 1 : 0 }};
        var minimum_order_amount =
            {{ get_setting('minimum_order_amount_check') == 1 ? get_setting('minimum_order_amount') : 0 }};

        function use_wallet() {
            $('input[name=payment_option]').val('wallet');
            if ($('#agree_checkbox').is(":checked")) {
                ;
                if (minimum_order_amount_check && $('#sub_total').val() < minimum_order_amount) {
                    AIZ.plugins.notify('danger',
                        '{{ translate('You order amount is less then the minimum order amount') }}');
                } else {
                    var allIsOk = false;
                    var isOkShipping = stepCompletionShippingInfo();
                    var isOkDelivery = stepCompletionDeliveryInfo();
                    var isOkPayment = stepCompletionWalletPaymentInfo();
                    if (isOkShipping && isOkDelivery && isOkPayment) {
                        allIsOk = true;
                    } else {
                        AIZ.plugins.notify('danger', '{{ translate('Please fill in all mandatory fields!') }}');
                        $('#checkout-form [required]').each(function(i, el) {
                            if ($(el).val() == '' || $(el).val() == undefined) {
                                var is_trx_id = $('.d-none #trx_id').length;
                                if (($(el).attr('name') != 'trx_id') || is_trx_id == 0) {
                                    $(el).focus();
                                    $(el).scrollIntoView({
                                        behavior: "smooth",
                                        block: "center"
                                    });
                                    return false;
                                }
                            }
                        });
                    }

                    if (allIsOk) {
                        $('#checkout-form').submit();
                    }
                }
            } else {
                AIZ.plugins.notify('danger', '{{ translate('You need to agree with our policies') }}');
            }
        }

        function submitOrder(el) {
            $(el).prop('disabled', true);
            if ($('#agree_checkbox').is(":checked")) {
                if (minimum_order_amount_check && $('#sub_total').val() < minimum_order_amount) {
                    AIZ.plugins.notify('danger',
                        '{{ translate('You order amount is less then the minimum order amount') }}');
                } else {
                    var offline_payment_active = '{{ addon_is_activated('offline_payment') }}';
                    if (offline_payment_active == '1' && $('.offline_payment_option').is(":checked") && $('#trx_id')
                        .val() == '') {
                        AIZ.plugins.notify('danger', '{{ translate('You need to put Transaction id') }}');
                        $(el).prop('disabled', false);
                    } else {
                        var allIsOk = false;
                        var isOkShipping = stepCompletionShippingInfo();
                        var isOkDelivery = stepCompletionDeliveryInfo();
                        var isOkPayment = stepCompletionPaymentInfo();
                        if (isOkShipping && isOkDelivery && isOkPayment) {
                            allIsOk = true;
                        } else {
                            AIZ.plugins.notify('danger', '{{ translate('Please fill in all mandatory fields!') }}');
                            $('#checkout-form [required]').each(function(i, el) {
                                if ($(el).val() == '' || $(el).val() == undefined) {
                                    var is_trx_id = $('.d-none #trx_id').length;
                                    if (($(el).attr('name') != 'trx_id') || is_trx_id == 0) {
                                        $(el).focus();
                                        $(el).scrollIntoView({
                                            behavior: "smooth",
                                            block: "center"
                                        });
                                        return false;
                                    }
                                }
                            });
                        }

                        if (allIsOk) {
                            $('#checkout-form').submit();
                        }
                    }
                }
            } else {
                AIZ.plugins.notify('danger', '{{ translate('You need to agree with our policies') }}');
                $(el).prop('disabled', false);
            }
        }

        function toggleManualPaymentData(id) {
            if (typeof id != 'undefined') {
                $('#manual_payment_description').parent().removeClass('d-none');
                $('#manual_payment_description').html($('#manual_payment_info_' + id).html());
            }
        }
        // coupon apply
        $(document).on("click", "#coupon-apply", function() {
            @if (Auth::check())
                @if (Auth::user()->user_type != 'customer')
                    AIZ.plugins.notify('warning',
                        "{{ translate('Please Login as a customer to apply coupon code.') }}");
                    return false;
                @endif

                var data = new FormData($('#apply-coupon-form')[0]);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "POST",
                    url: "{{ route('checkout.apply_coupon_code') }}",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data, textStatus, jqXHR) {
                        AIZ.plugins.notify(data.response_message.response, data.response_message
                            .message);
                        $("#cart_summary").html(data.html);
                    }
                });
            @else
                $('#login_modal').modal('show');
            @endif
        });

        // coupon remove
        $(document).on("click", "#coupon-remove", function() {
            @if (Auth::check() && Auth::user()->user_type == 'customer')
                var data = new FormData($('#remove-coupon-form')[0]);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "POST",
                    url: "{{ route('checkout.remove_coupon_code') }}",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data, textStatus, jqXHR) {
                        $("#cart_summary").html(data);
                    }
                });
            @endif
        });

        function updateDeliveryAddress(id, city_id = 0) {
            $('.aiz-refresh').addClass('active');
            $.post('{{ route('checkout.updateDeliveryAddress') }}', {
                _token: AIZ.data.csrf,
                address_id: id,
                city_id: city_id
            }, function(data) {
                $('#delivery_info').html(data.delivery_info);
                $('#cart_summary').html(data.cart_summary);
                $('.aiz-refresh').removeClass('active');
            });
            AIZ.plugins.bootstrapSelect("refresh");
        }

        function stepCompletionShippingInfo() {
            var headColor = '#9d9da6';
            var btnDisable = true;
            var allOk = false;
            @if (Auth::check())
                var length = $('input[name="address_id"]:checked').length;
                if (length > 0) {
                    headColor = '#15a405';
                    btnDisable = false;
                    allOk = true;
                }
            @else
                var count = 0;
                var length = $('#shipping_info [required]').length;
                $('#shipping_info [required]').each(function(i, el) {
                    if ($(el).val() != '' && $(el).val() != undefined && $(el).val() != null) {
                        count += 1;
                    }
                });
                if (count == length) {
                    headColor = '#15a405';
                    btnDisable = false;
                    allOk = true;
                }
            @endif

            $('#headingShippingInfo svg *').css('fill', headColor);
            $("#submitOrderBtn").prop('disabled', btnDisable);
            return allOk;
        }

        $('#shipping_info [required]').each(function(i, el) {
            $(el).change(function() {
                if ($(el).attr('name') == 'address_id') {
                    updateDeliveryAddress($(el).val());
                }
                @if (get_setting('shipping_type') == 'area_wise_shipping')
                    if ($(el).attr('name') == 'city_id') {
                        let country_id = $('select[name="country_id"]').val();
                        let city_id = $(this).val();
                        updateDeliveryAddress(country_id, city_id);
                    }
                @endif
                stepCompletionShippingInfo();
            });
        });

        function stepCompletionDeliveryInfo() {
            var headColor = '#9d9da6';
            var btnDisable = true;
            var allOk = false;
            var content = $('#delivery_info [required]');
            if (content.length > 0) {
                var content_checked = $('#delivery_info [required]:checked');
                if (content_checked.length > 0) {
                    content_checked.each(function(i, el) {
                        allOk = false;
                        if ($(el).val() == 'carrier') {
                            var owner = $(el).attr('data-owner');
                            if ($('input[name=carrier_id_' + owner + ']:checked').length > 0) {
                                allOk = true;
                            }
                        } else if ($(el).val() == 'pickup_point') {
                            var owner = $(el).attr('data-owner');
                            if ($('select[name="pickup_point_id_' + owner + '"]').val() != '') {
                                allOk = true;
                            }
                        } else {
                            allOk = true;
                        }

                        if (allOk == false) {
                            return false;
                        }
                    });

                    if (allOk) {
                        headColor = '#15a405';
                        btnDisable = false;
                    }
                }
            } else {
                allOk = true
                headColor = '#15a405';
                btnDisable = false;
            }

            $('#headingDeliveryInfo svg *').css('fill', headColor);
            $("#submitOrderBtn").prop('disabled', btnDisable);
            return allOk;
        }

        function updateDeliveryInfo(shipping_type, type_id, user_id, country_id = 0, city_id = 0) {
            @if (get_setting('shipping_type') == 'area_wise_shipping' || get_setting('shipping_type') == 'carrier_wise_shipping')
                country_id = $('select[name="country_id"]').val() != null ? $('select[name="country_id"]').val() : 0;
                city_id = $('select[name="city_id"]').val() != null ? $('select[name="city_id"]').val() : 0;
            @endif
            $('.aiz-refresh').addClass('active');
            $.post('{{ route('checkout.updateDeliveryInfo') }}', {
                _token: AIZ.data.csrf,
                shipping_type: shipping_type,
                type_id: type_id,
                user_id: user_id,
                country_id: country_id,
                city_id: city_id
            }, function(data) {
                $('#cart_summary').html(data);
                stepCompletionDeliveryInfo();
                $('.aiz-refresh').removeClass('active');
            });
            AIZ.plugins.bootstrapSelect("refresh");
        }

        function show_pickup_point(el, user_id) {
            var type = $(el).val();
            var target = $(el).data('target');
            var type_id = null;

            if (type == 'home_delivery' || type == 'carrier') {
                if (!$(target).hasClass('d-none')) {
                    $(target).addClass('d-none');
                }
                $('.carrier_id_' + user_id).removeClass('d-none');
            } else {
                $(target).removeClass('d-none');
                $('.carrier_id_' + user_id).addClass('d-none');
            }

            if (type == 'carrier') {
                type_id = $('input[name=carrier_id_' + user_id + ']:checked').val();
            } else if (type == 'pickup_point') {
                type_id = $('select[name=pickup_point_id_' + user_id + ']').val();
            }
            updateDeliveryInfo(type, type_id, user_id);
        }

        function stepCompletionPaymentInfo() {
            var headColor = '#9d9da6';
            var btnDisable = true;
            var payment = false;
            var agree = false;
            var allOk = false;
            var length = $('input[name="payment_option"]:checked').length;
            if (length > 0) {
                if ($('input[name="payment_option"]:checked').hasClass('offline_payment_option')) {
                    if ($('#trx_id').val() != '' && $('#trx_id').val() != undefined && $('#trx_id').val() != null) {
                        payment = true;
                    }
                } else {
                    payment = true;
                }

                if ($('#agree_checkbox').is(":checked")) {
                    agree = true;
                }

                if (payment && agree) {
                    headColor = '#15a405';
                    btnDisable = false;
                    allOk = true;
                }
            }

            $('#headingPaymentInfo svg *').css('fill', headColor);
            $("#submitOrderBtn").prop('disabled', btnDisable);
            return allOk;
        }

        function stepCompletionWalletPaymentInfo() {
            var headColor = '#9d9da6';
            var btnDisable = true;
            var allOk = false;
            if ($('#agree_checkbox').is(":checked")) {
                headColor = '#15a405';
                btnDisable = false;
                allOk = true;
            }

            $('#headingPaymentInfo svg *').css('fill', headColor);
            $("#submitOrderBtn").prop('disabled', btnDisable);
            return allOk;
        }

        $('input[name="payment_option"]').change(function() {
            stepCompletionPaymentInfo();
        });

        $(document).ready(function() {
            stepCompletionShippingInfo();
            stepCompletionDeliveryInfo();
            stepCompletionPaymentInfo();
        });
    </script>

    @include('frontend.partials.address.address_js')


    @if (get_setting('google_map') == 1)
        @include('frontend.partials.google_map')
    @endif
@endsection
