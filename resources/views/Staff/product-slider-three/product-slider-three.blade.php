@extends('Staff.layouts.master')

@php
    $sliderSectionThree = isset($sliderSectionThree) ? json_decode($sliderSectionThree->value) : null;
@endphp

@section('content')

<section class="section">
    <div class="section-header">
        <h1>Product Slider 3</h1>
    </div>

    <div class="section-body">
        <div class="card border">
            <div class="card-body">
                <h5>Product Slider 3</h5>
                <br>
                <div class="row">
                    <div class="col-md-4">
                        @if (!empty($sliderSectionThree->category))
                            @php
                                $categoryId = $sliderSectionThree->category;
                                $category = \App\Models\Category::find($categoryId);
                            @endphp
                            <div class="d-flex align-items-center">
                                <h4 class="text-primary">{{ $category->name }}</h4>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-4">
                        @if (!empty($sliderSectionThree->sub_category))
                            @php
                                $subCategoryId = $sliderSectionThree->sub_category;
                                $subCategory = \App\Models\SubCategory::find($subCategoryId);
                            @endphp
                            <div class="d-flex align-items-center">
                                <h4 class="text-warning">{{ $subCategory->name }}</h4>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-4">
                        @if (!empty($sliderSectionThree->child_category))
                            @php
                                $childCategoryId = $sliderSectionThree->child_category;
                                $childCategory = \App\Models\ChildCategory::find($childCategoryId);
                            @endphp
                            <div class="d-flex align-items-center">
                                <h4 class="text-dark">{{ $childCategory->name }}</h4>
                            </div>
                        @endif
                    </div>
                </div>
                <form action="{{ route('product-slider-section-three') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inputState">Category</label>
                                <select id="inputState" class="form-control main-category" name="category_three">
                                    <option value="">Select</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inputState">Sub Category</label>
                                <select id="inputState" class="form-control sub-category" name="sub_category_three">
                                    <option value="">Select</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inputState">Child Category</label>
                                <select id="inputState" class="form-control child-category" name="child_category_three">
                                    <option value="">Select</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            /** get sub categories **/
            $('body').on('change', '.main-category', function(e) {
                let id = $(this).val();
                $.ajax({
                    method: 'GET',
                    url: "{{ route('product-get-subcategories') }}",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $('.sub-category').html('<option value="">Select</option>');

                        $.each(data, function(i, item) {
                            $('.sub-category').append(`<option value="${item.id}">${item.name}</option>`);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });

            /** get child categories **/
            $('body').on('change', '.sub-category', function(e) {
                let id = $(this).val();
                let row = $(this).closest('.row');
                $.ajax({
                    method: 'GET',
                    url: "{{ route('product-get-childcategories') }}",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        let selector = row.find('.child-category');
                        selector.html('<option value="">Select</option>');

                        $.each(data, function(i, item) {
                            selector.append(`<option value="${item.id}">${item.name}</option>`);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
@endpush
