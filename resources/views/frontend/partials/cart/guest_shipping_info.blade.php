<div class="p-3">
    <!-- Name -->
    <label>{{ translate('User Name') }} <span class="text-danger">*</span></label>
    <div class="row">

        <div class="col-md-12">

            <input class="form-control mb-3 checkout_custom_input" placeholder="{{ translate('Name') }}" rows="2"
                name="name" required></input>
        </div>

    </div>
    <!-- Address -->
    <label>{{ translate('Address') }} <span class="text-danger">*</span></label>
    <div class="row">
        <div class="col-md-12">
            <textarea class="form-control mb-3 checkout_custom_input" placeholder="{{ translate('Your Address') }}" rows="2"
                name="address" required></textarea>
        </div>
    </div>
    <!-- Country -->
    <div class="row">
        <div class="col-md-6">
            <label>{{ translate('Country') }} <span class="text-danger">*</span></label>
            <div class="mb-3">
                <select class="form-control aiz-selectpicker checkout_custom_input"
                    @if (get_setting('shipping_type') == 'carrier_wise_shipping') onchange="updateDeliveryAddress(this.value)" @endif
                    data-live-search="true" data-placeholder="{{ translate('Select your country') }}" name="country_id"
                    required>
                    <option value="">{{ translate('Select your country') }}</option>
                    @foreach (get_active_countries() as $key => $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <label>Religion/{{ translate('State') }} <span class="text-danger ">*</span></label>
            <select class="form-control mb-3 aiz-selectpicker checkout_custom_input " data-live-search="true"
                name="state_id" required>

            </select>
        </div>
    </div>

    <!-- City -->
    <div class="row">
        <div class="col-md-6">
            <label>{{ translate('City') }} <span class="text-danger">*</span></label>
            <select class="form-control mb-3 aiz-selectpicker checkout_custom_input" data-live-search="true"
                name="city_id" required>

            </select>
        </div>
        <div class="col-md-6">
            <label>{{ translate('Zip code') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control mb-3 checkout_custom_input"
                placeholder="{{ translate('Your Postal Code') }}" name="postal_code" value="" required>
        </div>
    </div>
    <!-- Email -->
    <div class="row">
        <div class="col-md-12">
            <label>{{ translate('Email') }} <span class="text-danger">*</span></label>
            <input type="email" class="form-control mb-3 checkout_custom_input"
                placeholder="{{ translate('Your Email') }}" name="email" value="" required>
        </div>
    </div>



    @if (get_setting('google_map') == 1)
        <!-- Google Map -->
        <div class="row mt-3 mb-3">
            <input id="searchInput" class="controls" type="text" placeholder="{{ translate('Enter a location') }}">
            <div id="map"></div>
            <ul id="geoData">
                <li style="display: none;">Full Address: <span id="location"></span></li>
                <li style="display: none;">Postal Code: <span id="postal_code"></span></li>
                <li style="display: none;">Country: <span id="country"></span></li>
                <li style="display: none;">Latitude: <span id="lat"></span></li>
                <li style="display: none;">Longitude: <span id="lon"></span></li>
            </ul>
        </div>
        <!-- Longitude -->
        <div class="row">
            <div class="col-md-2" id="">
                <label for="exampleInputuname">{{ translate('Longitude') }}</label>
            </div>
            <div class="col-md-10" id="">
                <input type="text" class="form-control mb-3 rounded-0" id="longitude" name="longitude"
                    readonly="">
            </div>
        </div>
        <!-- Latitude -->
        <div class="row">
            <div class="col-md-2" id="">
                <label for="exampleInputuname">{{ translate('Latitude') }}</label>
            </div>
            <div class="col-md-10" id="">
                <input type="text" class="form-control mb-3 rounded-0" id="latitude" name="latitude" readonly="">
            </div>
        </div>
    @endif

    <!-- Phone -->
    <div class="row">
        <div class="col-md-12">
            <label>{{ translate('Phone') }} <span class="text-danger">*</span></label>
            <input type="tel" id="phone-code" class="form-control checkout_custom_input" placeholder=""
                name="phone" autocomplete="off" required>
            <input type="hidden" name="country_code" value="">
        </div>
    </div>
    <!-- Agree Box -->
    <div class="pt-2rem fs-14">
        <label class="aiz-checkbox">
            <input type="checkbox" required id="agree_checkbox" onchange="stepCompletionPaymentInfo()">
            <span class="aiz-square-check"></span>
            <span>{{ translate('I agree to the') }}</span>
        </label>
        <a href="{{ route('terms') }}" class="fw-700">{{ translate('terms and conditions') }}</a>,
        <a href="{{ route('returnpolicy') }}" class="fw-700">{{ translate('return policy') }}</a> &
        <a href="{{ route('privacypolicy') }}" class="fw-700">{{ translate('privacy policy') }}</a>
    </div>
</div>

<div class="px-3 pt-3 pb-4 row">
    <div class="col-md-2 mt-md-2"></div>
    <div class="col-md-10">
        <div class="bg-soft-info p-2">
            {{ translate('If you have already used the same mail address or phone number before, please ') }}
            <a href="javascript:void(0);" data-toggle="modal" data-target="#login_modal"
                class="fw-700 animate-underline-primary">{{ translate('Login') }}</a>
            {{ translate(' first to continue') }}
        </div>
    </div>
</div>
