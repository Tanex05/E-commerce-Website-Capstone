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
                        <h4>cart View</h4>
                        <ul>
                            <li><a href="#">home</a></li>
                            <li><a href="#">product</a></li>
                            <li><a href="#">cart view</a></li>
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
        CART VIEW PAGE START
    ==============================-->
    <section id="wsus__cart_view">
        <div class="container">
            <div class="row">
                <div class="col-xl-9">
                    <div class="wsus__cart_list">
                        <div class="table-responsive">
                            <table>
                                <tbody>
                                    <tr class="d-flex">
                                        <th class="wsus__pro_img">
                                            product item
                                        </th>

                                        <th class="wsus__pro_name">
                                            product details
                                        </th>

                                        <th class="wsus__pro_tk">
                                           unit price
                                        </th>

                                        <th class="wsus__pro_tk">
                                            total
                                        </th>

                                        <th class="wsus__pro_select">
                                            quantity
                                        </th>



                                        <th class="wsus__pro_icon">
                                            <a href="#" class="common_btn clear_cart">clear cart</a>
                                        </th>
                                    </tr>
                                    @foreach ($cartItems as $item)
                                    <tr class="d-flex">
                                        <td class="wsus__pro_img"><img src="{{asset($item->options->image)}}" alt="product"
                                                class="img-fluid w-100">
                                        </td>

                                        <td class="wsus__pro_name">
                                            <p>{!! $item->name !!}</p>
                                            @foreach ($item->options->variants as $key => $variant)
                                            <span>{{ $key }}: {{ $variant['name'] }} (₱{{ number_format((double) $variant['price'], 2) }})</span>
                                            @endforeach

                                        </td>

                                        <td class="wsus__pro_tk">
                                            <h6>{{ '₱' . number_format((double) $item->price, 2) }}</h6>
                                        </td>

                                        <td class="wsus__pro_tk">
                                            <h6 id="{{ $item->rowId }}">{{ '₱' . number_format((double) (($item->price + $item->options->variants_total) * $item->qty), 2) }}</h6>
                                        </td>

                                        <td class="wsus__pro_select">
                                            <div class="product_qty_wrapper">
                                                <button class="btn btn-danger product-decrement">-</button>
                                                <input class="product-qty" data-rowid="{{$item->rowId}}" type="text" min="1" max="100" value="{{$item->qty}}" readonly />
                                                <button class="btn btn-success product-increment">+</button>
                                            </div>
                                        </td>

                                        <td class="wsus__pro_icon">
                                            <a href="{{route('cart.remove-product', $item->rowId)}}"><i class="far fa-times"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach

                                    @if (count($cartItems) === 0)
                                        <tr class="d-flex" >
                                            <td class="wsus__pro_icon" rowspan="2" style="width:100%">
                                                Cart is empty!
                                            </td>
                                        </tr>

                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="wsus__cart_list_footer_button" id="sticky_sidebar">
                        <h6>total cart</h6>
                        <p>subtotal: <span id="sub_total">₱ {{ number_format((double)getCartTotal(), 2) }}</span></p>
                        <p>coupon(-): <span id="discount">₱ {{ number_format((double)getCartDiscount(), 2) }}</span></p>
                        <p class="total"><span>total:</span> <span id="cart_total">₱ {{ number_format((double)getMainCartTotal(), 2) }}</span></p>



                        <form id="coupon_form">
                            <input type="text" placeholder="Coupon Code" name="coupon_code" value="{{ session()->has('coupon') ? session()->get('coupon')['coupon_code'] : '' }}" {{ $disabled ? 'disabled' : '' }}>
                            <button type="submit" class="common_btn" {{ $disabled ? 'disabled' : '' }}>apply</button>
                        </form>
                        @if ($disabled)
                             <p style="color:red">Coupon disabled because the cart contains a flashout item.</p>
                        @endif

                        <a class="common_btn mt-4 w-100 text-center" href="{{route('user.checkout')}}">checkout</a>
                        <a class="common_btn mt-1 w-100 text-center" href="{{route('home')}}"> <i class="fas fa-shopping-basket"></i>Keep Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="wsus__single_banner">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6">
                    <div class="wsus__single_banner_content">
                        @if(isset($cartpage_banner_section->banner_one) && isset($cartpage_banner_section->banner_one->status) && $cartpage_banner_section->banner_one->status == 1)
                            <a href="{{$cartpage_banner_section->banner_one->banner_url}}">
                                <img class="img-fluid" src="{{asset($cartpage_banner_section->banner_one->banner_image)}}" alt="">
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="wsus__single_banner_content single_banner_2">
                        @if(isset($cartpage_banner_section->banner_two) && isset($cartpage_banner_section->banner_two->status) && $cartpage_banner_section->banner_two->status == 1)
                            <a href="{{$cartpage_banner_section->banner_two->banner_url}}">
                                <img class="img-fluid" src="{{asset($cartpage_banner_section->banner_two->banner_image)}}" alt="">
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
          CART VIEW PAGE END
    ==============================-->
@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        // Increment product quantity
        $('.product-increment').on('click', function(){
            let input = $(this).siblings('.product-qty');
            let quantity = parseInt(input.val()) + 1;
            let rowId = input.data('rowid');
            input.val(quantity);

            let productId = '#' + rowId;
            $(productId).text(""); // Or any other default value

            // Send Ajax request to update the quantity
            $.ajax({
                url: "{{ route('cart.update-quantity-increment') }}",
                method: 'POST',
                data: {
                    rowId: rowId,
                    quantity: quantity
                },
                success: function(data){
                    if(data.status === 'success'){
                        let productId = '#' + rowId;
                        let totalAmount = "₱" + data.product_total;
                        $(productId).text(totalAmount);

                        // Update cart total
                        $('#cart_total').text("₱" + data.cart_total);

                        // Update other cart details
                        renderCartSubTotal();
                        calculateCouponDiscount();

                        toastr.success(data.message);
                    } else if (data.status === 'error'){
                        // Display error message
                        toastr.error(data.message);

                        // Reset the input value to previous quantity
                        input.val(quantity - 1);
                    }
                },
                // Display error message directly
                error: function(xhr, status, error){
                    toastr.error('Reached maximum quantity of product or not enough stock available');

                    // Reset the input value to previous quantity
                    input.val(quantity - 1);
                }
            });
        });

        // Decrement product quantity
        $('.product-decrement').on('click', function(){
            let input = $(this).siblings('.product-qty');
            let quantity = parseInt(input.val()) - 1;
            let rowId = input.data('rowid');

            // Check if quantity is greater than or equal to 1
            if(quantity >= 1){
                // Update the input value
                input.val(quantity);

                // Send AJAX request to update quantity and cart total
                $.ajax({
                    url: "{{ route('cart.update-quantity-decrement') }}",
                    method: 'POST',
                    data: {
                        rowId: rowId,
                        quantity: quantity
                    },
                    success: function(data){
                        if(data.status === 'success'){
                            let productId = '#' + rowId;
                            let totalAmount = "₱" + data.product_total;
                            $(productId).text(totalAmount);

                            // Update cart total
                            $('#cart_total').text("₱" + data.cart_total);

                            // Update other cart details
                            renderCartSubTotal();
                            calculateCouponDiscount();

                            toastr.success(data.message);
                        } else if (data.status === 'error'){
                            toastr.error(data.message);
                        }
                    },
                    error: function(data){

                    }
                });
            }
        });





        // clear cart
        $('.clear_cart').on('click', function(e){
            e.preventDefault();
            Swal.fire({
                    title: 'Are you sure?',
                    text: "This action will clear your cart!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, clear it!'
                    }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            type: 'get',
                            url: "{{route('clear.cart')}}",
                            success: function(data){
                                if(data.status === 'success'){
                                    window.location.reload();
                                }
                            },
                            error: function(xhr, status, error){
                                console.log(error);
                            }
                        })
                    }
                })
        })

        // get subtotal of cart and put it on dom
        function renderCartSubTotal(){
            $.ajax({
                method: 'GET',
                url: "{{ route('cart.sidebar-product-total') }}",
                success: function(data) {
                    $('#sub_total').text("₱"+data);
                },
                error: function(data) {
                    console.log(data);
                }
            })
        }

        // apply coupon on cart
        $('#coupon_form').on('submit', function(e){
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                method: 'GET',
                url: "{{ route('apply-coupon') }}",
                data: formData,
                success: function(data) {
                   if(data.status === 'error'){
                    toastr.error(data.message)
                   }else if (data.status === 'success'){
                    calculateCouponDiscount()
                    toastr.success(data.message)
                   }
                },
                error: function(data) {
                    console.log(data);
                }
            })

        })

        // calculate discount amount
        function calculateCouponDiscount(){
        $.ajax({
            method: 'GET',
            url: "{{ route('coupon-calculation') }}",
            success: function(data) {
                if(data.status === 'success'){
                    $('#discount').text('₱'+data.discount);
                    $('#cart_total').text('₱'+data.cart_total);
                }
            },
            error: function(data) {
                console.log(data);
            }
        })
    }



    })


</script>
@endpush
