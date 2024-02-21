@php
    $address = json_decode($order->order_address);
    $shipping = json_decode($order->shipping_method);
    $coupon = json_decode($order->coupon);
    $paymentstatus = $order->payment_status
@endphp

@extends('frontend.dashboard.layouts.master')

@section('content')
    <!--=============================
        DASHBOARD START
      ==============================-->
      <div class="container invoice-print mt-5 mb-5">
        <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="invoice-title">
                                <h4 class="float-end font-size-15">Order No: #{{ $order->id }}
                                    <span class="badge bg-{{ $paymentstatus === 1 ? 'success' : 'warning' }} font-size-12 ms-2">
                                        {{ $paymentstatus === 1 ? 'paid' : 'pending' }}
                                    </span>
                                </h4>
                                <div class="mb-4">
                                   <h2 class="mb-1 text-muted">TechnoBlast Computer Trading</h2>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="text-muted">
                                        <h5 class="font-size-16 mb-3">Billed To:</h5>
                                        <h5 class="font-size-15 mb-2">{{ $address->name }}</h5>
                                        <p class="mb-1">{{ $address->address }},{{ $address->region }},{{ $address->province }},{{ $address->barangay }},{{ $address->city }},{{ $address->postal_code }} </p>
                                        <p class="mb-1">{{ $address->email }}</p>
                                        {{ $address->phone }}
                                    </div>
                                </div>
                                <!-- end col -->
                                <div class="col-sm-6">
                                    <div class="text-muted text-sm-end">
                                        <div>
                                            <h5 class="font-size-15 mb-1">Invoice No:</h5>
                                            <p>{{ $order->invoice_id }}</p>
                                        </div>
                                        <div class="mt-4">
                                            <h5 class="font-size-15 mb-1">Invoice Date:</h5>
                                            <p>{{ $order->created_at->format('F d, Y') }}</p>
                                        </div>
                                        <div class="mt-4">
                                            <h5 class="font-size-15 mb-1">Transaction No:</h5>
                                            <p>{{ $order->transaction->transaction_id }}</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                            <br>
                            <!-- end row -->

                            <div class="py-2">
                                <h5 class="font-size-15">Order Summary</h5>

                                <div class="table-responsive">
                                    <table class="table align-middle table-nowrap table-centered mb-0">
                                        <thead>
                                            <tr>
                                                <th style="width: 70px;">No.</th>
                                                <th>Item</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th class="text-end" style="width: 120px;">Total</th>
                                            </tr>
                                        </thead><!-- end thead -->
                                        <tbody>
                                            @foreach ($order->orderProducts as $index => $product)
                                                <tr>
                                                    <th scope="row">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</th>
                                                    <td>
                                                        <div>
                                                            <h5 class="text-truncate font-size-14 mb-1">{{ $product->product_name }}</h5>
                                                            @php
                                                            $variants = json_decode($product->variants);
                                                            @endphp
                                                            @foreach ($variants as $key => $item)
                                                            <p class="text-muted mb-0">{{ $key }}: {{ $item->name }}  (₱{{ $item->price }})</p>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    <td>₱{{ $product->unit_price }}</td>
                                                    <td>{{ $product->qty }}</td>
                                                    <td class="text-end">₱ {{ ($product->unit_price * $product->qty) + ($product->variant_total * $product->qty) }}</td>
                                                </tr>
                                                @endforeach
                                            <!-- end tr -->
                                            <tr>
                                                <th scope="row" colspan="4" class="text-end">Sub Total</th>
                                                <td class="text-end">₱ {{ @$order->sub_total }}</td>
                                            </tr>
                                            <!-- end tr -->
                                            <tr>
                                                <th scope="row" colspan="4" class="border-0 text-end">
                                                    Coupon :</th>
                                                <td class="border-0 text-end">₱ {{ @$coupon->discount ? $coupon->discount : 0 }}</td>
                                            </tr>
                                            <!-- end tr -->
                                            <tr>
                                                <th scope="row" colspan="4" class="border-0 text-end">
                                                    Shipping Fee :</th>
                                                <td class="border-0 text-end">₱ {{ @$shipping->cost }}</td>
                                            </tr>
                                            <!-- end tr -->
                                            <tr>
                                                <th scope="row" colspan="4" class="border-0 text-end">Total</th>
                                                <td class="border-0 text-end"><h4 class="m-0 fw-semibold">₱ {{ @$order->amount }}</h4></td>
                                            </tr>
                                            <!-- end tr -->
                                        </tbody><!-- end tbody -->
                                    </table><!-- end table -->
                                </div><!-- end table responsive -->
                                <div class="d-print-none mt-4">
                                    <div class="float-end">
                                        <button class="btn btn-warning print_invoice">print</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->
            </div>
        </div>
    <!--=============================
        DASHBOARD START
      ==============================-->
@endsection

@push('scripts')
    <script>
        $('.print_invoice').on('click', function() {
            let printBody = $('.invoice-print');
            let originalContents = $('body').html();

            $('body').html(printBody.html());

            window.print();

            $('body').html(originalContents);

        })
    </script>
@endpush