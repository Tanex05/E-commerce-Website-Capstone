@extends('frontend.layouts.master')

@section('seo_title', 'TechnoBlast - ' . $product->seo_title)
@section('description', $product->seo_description)

@section('content')
   <!--============================
        BREADCRUMB START
    ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>products details</h4>
                        <ul>
                            <li><a href="#">home</a></li>
                            <li><a href="#">product</a></li>
                            <li><a href="#">product details</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        BREADCRUMB END
    ==============================-->



    <!--============================
        PRODUCT DETAILS START
    ==============================-->
    <section id="wsus__product_details">
        <div class="container">
            <div class="wsus__details_bg">
                <div class="row">
                    <div class="col-xl-4 col-md-5 col-lg-5">
                        <div id="sticky_pro_zoom">
                            <div class="exzoom hidden" id="exzoom">
                                <div class="exzoom_img_box">
                                    @if ($product->video_link)
                                    <a class="venobox wsus__pro_det_video" data-autoplay="true" data-vbtype="video"
                                        href="{{$product->video_link}}">
                                        <i class="fas fa-play"></i>
                                    </a>
                                    @endif
                                    <ul class='exzoom_img_ul'>
                                        <li><img class="zoom ing-fluid w-100" src="{{asset($product->thumbnail_image)}}" alt="product"></li>
                                        @foreach ($product->productImageGalleries as $productImage)
                                            <li><img class="zoom ing-fluid w-100" src="{{asset($productImage->image)}}" alt="product"></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="exzoom_nav"></div>
                                <p class="exzoom_btn">
                                    <a href="javascript:void(0);" class="exzoom_prev_btn"> <i
                                            class="far fa-chevron-left"></i> </a>
                                    <a href="javascript:void(0);" class="exzoom_next_btn"> <i
                                            class="far fa-chevron-right"></i> </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-md-7 col-lg-7">
                        <div class="wsus__pro_details_text">
                            <a class="title" href="javascript:;">{{ $product->name }}</a>
                            @if ($product->qty > 0)
                                <p class="wsus__stock_area"><span class="in_stock">in stock</span> ({{$product->qty}} item)</p>
                            @elseif ($product->qty === 0)
                                <p class="wsus__stock_area"><span class="in_stock">stock out</span> ({{$product->qty}} item)</p>
                            @endif
                            @if (checkDiscount($product))
                                <h4>₱{{ number_format((double) $product->offer_price, 2) }} <del>₱{{ number_format((double) $product->price, 2) }}</del></h4>

                            @else
                                <h4>₱{{ number_format((double) $product->price, 2) }}</h4>

                            @endif

                             <p class="wsus__pro_rating">
                                    @php
                                    $avgRating = $product->reviews()->avg('rating');
                                    $fullRating = round($avgRating);
                                    @endphp

                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $fullRating)
                                        <i class="fas fa-star"></i>
                                        @else
                                        <i class="far fa-star"></i>
                                        @endif
                                    @endfor

                                    <span>({{count($product->reviews)}} review)</span>
                                </p>

                            <p class="description">{!! $product->short_description !!}</p>


                            <form class="shopping-cart-form">
                                <div class="wsus__selectbox">
                                    <div class="row">
                                        <input type="hidden" name="product_id" value="{{$product->id}}">
                                        @foreach ($product->variants as $variant)
                                        @if ($variant->status != 0)
                                            <div class="col-xl-6 col-sm-6">
                                                <h5 class="mb-2">{{$variant->name}}: </h5>
                                                <select class="select_2" name="variants_items[]">
                                                    @foreach ($variant->productVariantItems as $variantItem)
                                                        @if ($variantItem->status != 0)
                                                            <option value="{{$variantItem->id}}" {{$variantItem->is_default == 1 ? 'selected' : ''}}>{{$variantItem->name}} (₱{{ number_format((double) $variantItem->price, 2) }})</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                        @endforeach

                                    </div>
                                </div>
                                <br>
                                <div class="wsus__quentity">
                                    <h5>quantity :</h5>
                                    <div class="select_number">
                                        <input class="number_area" name="qty" type="text" min="1" max="100" value="1" />
                                    </div>
                                </div>


                                <ul class="wsus__button_area">
                                    <li><button type="submit" class="add_cart" href="#">add to cart</button></li>


                                    <li><a style="border: 1px solid gray;
                                        padding: 7px 11px;
                                        border-radius: 100%;" href="javascript:;" class="add_to_wishlist" data-id="{{$product->id}}"><i class="fal fa-heart"></i></a></li>
                                </ul>
                            </form>

                            <br>
                            <p class="brand_model"><span>SKU :</span> {{$product->sku}}</p>
                            <br>
                            <p class="brand_model"><span>brand :</span>    {{ $product->brand !== null ? $product->brand->name : "None" }}</p>

                        </div>
                    </div>
                    {{-- <div class="col-xl-3 col-md-12 mt-md-5 mt-lg-0">
                        <div class="wsus_pro_det_sidebar" id="sticky_sidebar">
                            <ul>
                                <li>
                                    <span><i class="fal fa-truck"></i></span>
                                    <div class="text">
                                        <h4>Return Available</h4>
                                        <!-- <p>Lorem Ipsum is simply dummy text of the printing</p> -->
                                    </div>
                                </li>
                                <li>
                                    <span><i class="far fa-shield-check"></i></span>
                                    <div class="text">
                                        <h4>Secure Payment</h4>
                                        <!-- <p>Lorem Ipsum is simply dummy text of the printing</p> -->
                                    </div>
                                </li>
                                <li>
                                    <span><i class="fal fa-envelope-open-dollar"></i></span>
                                    <div class="text">
                                        <h4>Warranty Available</h4>
                                        <!-- <p>Lorem Ipsum is simply dummy text of the printing</p> -->
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div> --}}
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="wsus__pro_det_description">
                        <div class="wsus__details_bg">
                            <ul class="nav nav-pills mb-3" id="pills-tab3" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-home-tab7" data-bs-toggle="pill"
                                        data-bs-target="#pills-home22" type="button" role="tab" aria-controls="pills-home"
                                        aria-selected="true">Description</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-contact-tab2" data-bs-toggle="pill"
                                        data-bs-target="#pills-contact2" type="button" role="tab"
                                        aria-controls="pills-contact2" aria-selected="false">Reviews</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-contact-tab239" data-bs-toggle="pill"
                                        data-bs-target="#pills-contact239" type="button" role="tab"
                                        aria-controls="pills-contact239" aria-selected="false">FAQs</button>
                                </li>
                            </ul>

                            <div class="tab-content" id="pills-tabContent4">
                                <div class="tab-pane fade show active" id="pills-home22" role="tabpanel"
                                    aria-labelledby="pills-home-tab7">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="wsus__description_area">
                                                {!!$product->long_description!!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="pills-contact2" role="tabpanel"
                                    aria-labelledby="pills-contact-tab2">
                                    <div class="wsus__pro_det_review">
                                        <div class="wsus__pro_det_review_single">
                                            <div class="row">
                                                <div class="col-xl-8 col-lg-7">
                                                    <div class="wsus__comment_area">
                                                        <h4>Reviews <span>{{count($reviews)}}</span></h4>
                                                        @foreach ($reviews as $review)
                                                            <div class="wsus__main_comment">
                                                                <div class="wsus__comment_img">
                                                                    <!-- Make user profile image circular and consistent -->
                                                                    <img src="{{ asset($review->user->image) }}" alt="user" class="img-fluid w-100 rounded-circle" style="max-width: 50px; height: auto;">
                                                                </div>
                                                                <div class="wsus__comment_text reply">
                                                                    <h6>{{ $review->user->name }} <span>{{ $review->rating }} <i class="fas fa-star"></i></span></h6>
                                                                    <span>{{ date('d M Y', strtotime($review->created_at)) }}</span>
                                                                    <p>{{ $review->review }}</p>
                                                                    <ul class="list-unstyled">
                                                                        @if (count($review->productReviewGalleries) > 0)
                                                                        @foreach ($review->productReviewGalleries as $image)
                                                                        <!-- Ensure consistent presentation of product review images -->
                                                                        <li class="d-inline-block mr-2 mb-2">
                                                                            <img src="{{ asset($image->image) }}" alt="product" class="img-fluid rounded" style="max-width: 100px; height: auto;">
                                                                        </li>
                                                                        @endforeach
                                                                        @endif
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                        <div class="mt-5">
                                                            @if ($reviews->hasPages())
                                                                {{$reviews->links()}}
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-5 mt-4 mt-lg-0">
                                                    @auth
                                                    @php
                                                        $isBrought = false;
                                                        $orders = \App\Models\Order::where(['user_id' => auth()->user()->id, 'order_status' => 'delivered'])->get();
                                                        foreach ($orders as $key => $order) {
                                                           $existItem = $order->orderProducts()->where('product_id', $product->id)->first();

                                                           if($existItem){
                                                            $isBrought = true;
                                                           }
                                                        }

                                                    @endphp

                                                    @if ($isBrought === true)
                                                    <div class="wsus__post_comment rev_mar" id="sticky_sidebar3">
                                                        <h4>write a Review</h4>
                                                        <form action="{{route('user.review.create')}}" enctype="multipart/form-data" method="POST">
                                                            @csrf
                                                            <p class="rating">
                                                                <span>select your rating : </span>
                                                            </p>

                                                            <div class="row">

                                                                <div class="col-xl-12 mb-4">
                                                                    <div class="wsus__single_com">
                                                                        <select name="rating" id="" class="form-control">
                                                                            <option value="">Select</option>
                                                                            <option value="1">1</option>
                                                                            <option value="2">2</option>
                                                                            <option value="3">3</option>
                                                                            <option value="4">4</option>
                                                                            <option value="5">5</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-12">
                                                                    <div class="col-xl-12">
                                                                        <div class="wsus__single_com">
                                                                            <textarea cols="3" rows="3" name="review"
                                                                                placeholder="Write your review"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="img_upload">
                                                                <div class="">
                                                                    <input type="file" name="images[]" multiple>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="product_id" id="" value="{{$product->id}}">

                                                            <button class="common_btn" type="submit">submit
                                                                review</button>
                                                        </form>
                                                    </div>
                                                    @endif
                                                    @endauth

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="pills-contact239" role="tabpanel"
                                    aria-labelledby="pills-contact-tab239">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="wsus__contact_question">
                                                <h5>People usually ask these</h5>
                                                <div class="accordion" id="accordionExample">
                                                    @foreach ($faqs as $index => $faq )
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="heading{{ $index }}">
                                                                <button class="accordion-button" type="button"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#collapse{{ $index }}" aria-expanded="false"
                                                                    aria-controls="collapse{{ $index }}">
                                                                    {{ $faq->title }}
                                                                </button>
                                                            </h2>
                                                            <div id="collapse{{ $index }}"
                                                                class="accordion-collapse collapse" aria-labelledby="heading{{ $index }}"
                                                                data-bs-parent="#accordionExample">
                                                                <div class="accordion-body">
                                                                    {{ strip_tags($faq->description) }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>
    <!--============================
        PRODUCT DETAILS END
    ==============================-->

@endsection


