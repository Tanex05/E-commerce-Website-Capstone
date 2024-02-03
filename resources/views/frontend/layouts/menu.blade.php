@php
    $categories = \App\Models\Category::where('status', 1)
        ->with(['subCategories' => function ($query) {
            // Eager load subCategories with a condition
            $query->where('status', 1)
                ->with(['childCategories' => function ($query) {
                    // Eager load childCategories with a condition
                    $query->where('status', 1);
                }]);
        }])
    ->get();

@endphp
<nav class="wsus__main_menu d-none d-lg-block">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="relative_contect d-flex">
                    <div class="wsus_menu_category_bar">
                        <i class="far fa-bars"></i>
                    </div>
                    <ul class="wsus_menu_cat_item show_home toggle_menu">
                        {{-- <li><a href="#"><i class="fas fa-star"></i> hot promotions</a></li> --}}
                        @foreach ($categories as $category)
                            <li><a class="{{ count($category->subCategories) > 0 ? 'wsus__droap_arrow' : '' }}" href="{{route('product.index', ['category' => $category->slug])}}"><i class="{{ $category->icon }}"></i> {{ $category->name }} </a>
                                @if (count($category->subCategories) > 0)
                                    <ul class="wsus_menu_cat_droapdown">
                                        @foreach ( $category->subCategories as $subCategory )
                                            <li><a href="{{route('product.index', ['subcategory' => $subCategory->slug])}}">{{ $subCategory->name }} <i class="{{ count($subCategory->childCategories)> 0 ? 'fas fa-angle-right' : '' }}"></i></a>
                                                @if (count($subCategory->childCategories) > 0)
                                                    @foreach ($subCategory->childCategories as $childCategory )
                                                            <ul class="wsus__sub_category">
                                                                <li><a href="{{route('product.index', ['childcategory' => $childCategory->slug])}}">{{ $childCategory->name }}</a></li>
                                                            </ul>
                                                    @endforeach
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach


                        {{-- <li><a href="#"><i class="fal fa-gem"></i> View All Categories</a></li> --}}
                    </ul>

                    <ul class="wsus__menu_item">
                        <li><a class="active" href="{{ route('home') }}">home</a></li>

                        <li><a class="{{setActive(['flash-sale'])}}" href="{{route('flash-sale')}}">Promo Sale</a></li>
                        <li><a class="{{setActive(['flash-out'])}}" href="{{route('flashout')}}">Flash Out</a></li>

                        <li><a class="{{setActive(['about'])}}" href="#">about</a></li>

                        <li><a class="{{setActive(['contact'])}}" href="#">contact</a></li>

                    </ul>

                    <ul class="wsus__menu_item wsus__menu_item_right">
                        <li><a href="#">track order</a></li>

                        @if (auth()->check())
                            @if (auth()->user()->role === 'user')
                                <li><a href="{{route('user.dashboard')}}">my account</a></li>
                            @elseif (auth()->user()->role === 'employee')
                                <li><a href="{{route('staff.profile')}}">Employee Dashboard</a></li>
                            @elseif (auth()->user()->role === 'admin')
                                <li><a href="{{route('staff.profile')}}">Admin Dashboard</a></li>
                            @endif
                        @else
                            <li><a href="{{route('login')}}">login</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>




<!-- Mobile Menu -->

<section id="wsus__mobile_menu">
    <span class="wsus__mobile_menu_close"><i class="fal fa-times"></i></span>
    <ul class="wsus__mobile_menu_header_icon d-inline-flex">

        <li><a href="wishlist.html"><i class="far fa-heart"></i> <span>2</span></a></li>

        <li><a href="compare.html"><i class="far fa-random"></i> </i><span>3</span></a></li>
    </ul>
    <form>
        <input type="text" placeholder="Search">
        <button type="submit"><i class="far fa-search"></i></button>
    </form>

    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"
                role="tab" aria-controls="pills-home" aria-selected="true">Categories</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile"
                role="tab" aria-controls="pills-profile" aria-selected="false">main menu</button>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="wsus__mobile_menu_main_menu">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <ul class="wsus_mobile_menu_category">
                        <li><a href="#"><i class="fas fa-star"></i> hot promotions</a></li>
                        <li><a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseThreew" aria-expanded="false"
                                aria-controls="flush-collapseThreew"><i class="fal fa-tshirt"></i> fashion</a>
                            <div id="flush-collapseThreew" class="accordion-collapse collapse"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <ul>
                                        <li><a href="#">men's</a></li>
                                        <li><a href="#">wemen's</a></li>
                                        <li><a href="#">kid's</a></li>
                                        <li><a href="#">others</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li><a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseThreer" aria-expanded="false"
                                aria-controls="flush-collapseThreer"><i class="fas fa-tv"></i> electronics</a>
                            <div id="flush-collapseThreer" class="accordion-collapse collapse"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <ul>
                                        <li><a href="#">Consumer Electronic</a></li>
                                        <li><a href="#">Accessories & Parts</a></li>
                                        <li><a href="#">other brands</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li><a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseThreerrp" aria-expanded="false"
                                aria-controls="flush-collapseThreerrp"><i class="fas fa-chair-office"></i>
                                furnicture</a>
                            <div id="flush-collapseThreerrp" class="accordion-collapse collapse"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <ul>
                                        <li><a href="#">home</a></li>
                                        <li><a href="#">office</a></li>
                                        <li><a href="#">restaurent</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li><a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseThreerrw" aria-expanded="false"
                                aria-controls="flush-collapseThreerrw"><i class="fal fa-mobile"></i> Smart
                                Phones</a>
                            <div id="flush-collapseThreerrw" class="accordion-collapse collapse"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <ul>
                                        <li><a href="#">apple</a></li>
                                        <li><a href="#">xiaomi</a></li>
                                        <li><a href="#">oppo</a></li>
                                        <li><a href="#">samsung</a></li>
                                        <li><a href="#">vivo</a></li>
                                        <li><a href="#">others</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li><a href="#"><i class="fas fa-home-lg-alt"></i> Home & Garden</a></li>
                        <li><a href="#"><i class="far fa-camera"></i> Accessories</a></li>
                        <li><a href="#"><i class="fas fa-heartbeat"></i> healthy & Beauty</a></li>
                        <li><a href="#"><i class="fal fa-gift-card"></i> Gift Ideas</a></li>
                        <li><a href="#"><i class="fal fa-gamepad-alt"></i> Toy & Games</a></li>
                        <li><a href="#"><i class="fal fa-gem"></i> View All Categories</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
            <div class="wsus__mobile_menu_main_menu">
                <div class="accordion accordion-flush" id="accordionFlushExample2">
                    <ul>
                        <li><a href="index.html">home</a></li>
                        <li><a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseThree" aria-expanded="false"
                                aria-controls="flush-collapseThree">shop</a>
                            <div id="flush-collapseThree" class="accordion-collapse collapse"
                                data-bs-parent="#accordionFlushExample2">
                                <div class="accordion-body">
                                    <ul>
                                        <li><a href="#">men's</a></li>
                                        <li><a href="#">wemen's</a></li>
                                        <li><a href="#">kid's</a></li>
                                        <li><a href="#">others</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li><a href="vendor.html">vendor</a></li>
                        <li><a href="blog.html">blog</a></li>
                        <li><a href="daily_deals.html">campain</a></li>
                        <li><a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseThree101" aria-expanded="false"
                                aria-controls="flush-collapseThree101">pages</a>
                            <div id="flush-collapseThree101" class="accordion-collapse collapse"
                                data-bs-parent="#accordionFlushExample2">
                                <div class="accordion-body">
                                    <ul>
                                        <li><a href="404.html">404</a></li>
                                        <li><a href="faqs.html">faq</a></li>
                                        <li><a href="invoice.html">invoice</a></li>
                                        <li><a href="about_us.html">about</a></li>
                                        <li><a href="team.html">team</a></li>
                                        <li><a href="product_grid_view.html">product grid view</a></li>
                                        <li><a href="product_grid_view.html">product list view</a></li>
                                        <li><a href="team_details.html">team details</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li><a href="track_order.html">track order</a></li>
                        <li><a href="daily_deals.html">daily deals</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
