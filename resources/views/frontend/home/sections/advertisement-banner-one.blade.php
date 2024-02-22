<section id="wsus__banner">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="wsus__banner_content">
                    <div class="row banner_slider">
                        @if ($homepage_section_banner_one->banner_one->status == 1)
                            <a href="{{$homepage_section_banner_one->banner_one->banner_url}}">
                                <div class="col-xl-12">
                                    <div class="wsus__single_slider" style="background: url({{asset($homepage_section_banner_one->banner_one->banner_image)}});">
                                    </div>
                                </div>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
