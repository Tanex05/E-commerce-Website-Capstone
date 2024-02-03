<section id="wsus__flash_sell" class="wsus__flash_sell_2">
    <div class=" container">
        @php
            // Fetch Flash Out items with related data
            $FlashOut = \App\Models\FlashOutItem::with(['product.variants', 'product.category', 'product.productImageGalleries'])
                ->where('status', 1)
                ->get();
        @endphp

    @if($FlashOut->isNotEmpty() && $FlashOut->contains('status', 1))
        <!-- Show this section if there are items with status equal to 1 -->
        <div class="row">
            <div class="col-xl-12">
                <div class="offer_time" style="background: url({{ asset('Frontend/images/flash_sell_bg.jpg') }})">
                    <div class="wsus__flash_coundown" style="padding-top: 4%; padding-bottom: 4%;">
                        <span class="end_text">Flash Out</span>
                        <a class="common_btn" href="{{ route('flashout') }}">see more <i class="fas fa-caret-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row flash_sell_slider">
        @php
            $flashOutItems = \App\Models\FlashOutItem::with(['product.variants', 'product.category', 'product.productImageGalleries'])
                ->where('show_at_home', 1)
                ->where('status', 1)
                ->get();
        @endphp
        @foreach ($flashOutItems as $flashOutItem)
            <!-- Show product card only if show_at_home is 1 -->
            @if ($flashOutItem->show_at_home == 1)
                <x-product-card :product="$flashOutItem->product" />
            @endif
        @endforeach
    </div>

</section>
