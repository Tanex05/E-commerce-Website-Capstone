<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="{{ route('home') }}">TechnoBlast</a>
      </div>
      <div class="sidebar-brand sidebar-brand-sm">
        <a href="index.html">TB</a>
      </div>
      <ul class="sidebar-menu">
        <!-- Dashboard Header -->
        <li class="menu-header">Dashboard</li>
        <!-- Dashboard  -->
        <li class="dropdown active">
          <a href="{{ route('staff.dashboard') }}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
        </li>
        <!-- Starter -->
        <li class="menu-header">Manage Website</li>
        <!-- Category Dropdown -->
        <li class="dropdown {{ setActive(['category.*','sub-category.*','child-category.*']) }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Manage Category</span></a>
            <ul class="dropdown-menu">
                <li class="{{ setActive(['category.*']) }}"><a class="nav-link" href="{{ route('category.index') }}">Category</a></li>
                <li class="{{ setActive(['sub-category.*']) }}"><a class="nav-link" href="{{ route('sub-category.index') }}">Sub Category</a></li>
                <li class="{{ setActive(['child-category.*']) }}"><a class="nav-link" href="{{ route('child-category.index') }}">Child Category</a></li>
            </ul>
        </li>
        <!-- Products Dropdown -->
        <li class="dropdown {{ setActive(['brand.*',]) }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Manage Brand</span></a>
            <ul class="dropdown-menu">
                <li class="{{ setActive(['brand.*']) }}"><a class="nav-link" href="{{ route('brand.index') }}">Brands</a></li>
            </ul>
        </li>
        <!-- Ecommerce Dropdown -->
        <li class="dropdown {{ setActive(['product.*','flash-sale.*','coupons.*','flash-out.*']) }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Manage Product</span></a>
            <ul class="dropdown-menu">
                <li class="{{ setActive(['product.*']) }}"><a class="nav-link" href="{{ route('product.index') }}">Products</a></li>
                <li class="{{ setActive(['coupons.*']) }}"><a class="nav-link" href="{{ route('coupons.index') }}">Coupons</a></li>
                <li class="{{ setActive(['flash-sale.*']) }}"><a class="nav-link" href="{{ route('flash-sale.index') }}">Fash-Sale Products</a></li>
                <li class="{{ setActive(['flash-out.*']) }}"><a class="nav-link" href="{{ route('flash-out.index') }}">Fash-Out Products</a></li>
            </ul>
        </li>

        <!-- Slider Dropdown -->
        <li class="dropdown {{ setActive(['slider.*',]) }}">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Layout</span></a>
          <ul class="dropdown-menu">
            <li class="{{ setActive(['slider.*']) }}"><a class="nav-link" href="{{ route('slider.index') }}">Slider</a></li>
          </ul>
        </li>

        <!-- General Settings Dropdown -->
        <li class="dropdown {{ setActive(['faq.*',]) }}">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>General Setting</span></a>
          <ul class="dropdown-menu">
            <li class="{{ setActive(['faq.*']) }}"><a class="nav-link" href="{{ route('faq.index') }}">FAQ</a></li>
          </ul>
        </li>




        <!-- dropdown copy -->

        {{-- <li class="dropdown">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Layout</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="layout-default.html">Default Layout</a></li>
            <li><a class="nav-link" href="layout-transparent.html">Transparent Sidebar</a></li>
            <li><a class="nav-link" href="layout-top-navigation.html">Top Navigation</a></li>
          </ul>
        </li> --}}

        <!-- Blank -->

        {{-- <li>
            <a class="nav-link" href="blank.html"><i class="far fa-square"></i> <span>Blank Page</span></a>
        </li> --}}
      </ul>

    </aside>
  </div>
