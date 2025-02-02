<div class="newsletter_section">
    <img width="100%" src="{{ static_asset('assets/img/newsletter.jpg') }}" alt="">

    <div class="news_letter_overlay">
        <div class="news_title">Subscribe Newsletter</div>
        <div class="news_desc">Enjoy early access to sales, new product launches,expert advice and special offers
            delivered steaight to your inbox.</div>
        <div class="subs_news">
            @if (get_setting('newsletter_activation'))
                <div class="mb-3">
                    <form method="POST" action="{{ route('subscribers.store') }}" class="position-relative d-flex">
                        @csrf
                        <div style="max-width: 500px; width: 100%; position: relative;">
                            <input type="email" class="form-control shadow-sm"
                                placeholder="{{ translate('Enter your e-mail') }}" name="email" required
                                style="border-radius: 25px; padding: 12px 15px; padding-right: 100px; border: 1px solid #ccc;">
                            <button type="submit" class="btn btn-success text-white position-absolute"
                                style="right: 10px; top: 50%; transform: translateY(-50%); border-radius: 8px; padding: 5px 15px; font-size: 14px;">
                                {{ translate('Subscribe') }}
                            </button>
                        </div>
                    </form>



                </div>
            @endif
        </div>
    </div>
</div>
