@extends('frontend.layouts.master')

@section('content')
    <!--============================
        BREADCRUMB START
    ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>payment</h4>
                        <ul>
                            <li><a href="{{ route('home') }}">home</a></li>
                            <li><a href="javascript:;">payment</a></li>
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
        PAYMENT PAGE START
    ==============================-->
    <section id="wsus__cart_view">
        <div class="container">
            <div class="wsus__pay_info_area">
                <div class="row">
                    <div class="col-xl-3 col-lg-3">
                        <div class="wsus__payment_menu" id="sticky_sidebar">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">

                                <button class="nav-link common_btn active" id="v-pills-home-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-banks-e-wallet" type="button" role="tab"
                                    aria-controls="v-pills-banks-e-wallet" aria-selected="true">Bank / E-Wallet</button>

                                <button class="nav-link common_btn" id="v-pills-profile-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-cod" type="button" role="tab"
                                    aria-controls="v-pills-stripe" aria-selected="false">Cash On Delivery</button>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-5">
                        <div class="tab-content" id="v-pills-tabContent">


                            <div class="tab-pane fade show active" id="v-pills-banks-e-wallet" role="tabpanel"
                                aria-labelledby="v-pills-home-tab">
                                <div class="row">
                                    <div class="col-xl-12 m-auto">
                                        <div class="wsus__payment_area">
                                            <form action="{{ route('user.paymongo.payment') }}" method="POST"
                                                id="paymongo_payment_form">
                                                @csrf
                                                <button type="submit" class="nav-link common_btn text-center">Pay With
                                                    Paymongo</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="tab-pane fade" id="v-pills-cod" role="tabpanel"
                                aria-labelledby="v-pills-profile-tab">
                                <div class="row">
                                    <div class="col-xl-12 m-auto">
                                        <div class="wsus__payment_area">
                                            <form action="{{ route('user.cod.payment') }}" method="GET" id="cod_payment_form">
                                                @csrf
                                                <button type="submit" class="nav-link common_btn text-center">Pay With
                                                    Cash On Delivery</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4">
                        <div class="wsus__pay_booking_summary" id="sticky_sidebar2">
                            <h5>Order Summary</h5>
                            <p>subtotal : <span>₱{{ getCartTotal() }}</span></p>
                            <p>shipping fee(+) : <span>₱{{ getShppingFee() }}</span></p>
                            <p>coupon(-) : <span>₱{{ getCartDiscount() }}</span></p>
                            <h6>total <span>₱{{ getFinalPayableAmount() }}</span></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        PAYMENT PAGE END
    ==============================-->
@endsection
