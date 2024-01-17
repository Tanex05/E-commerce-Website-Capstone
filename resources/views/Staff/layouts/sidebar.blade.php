<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="index.html">TechnoBlast</a>
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
        <!-- Starter Dropdown -->
        <li class="dropdown">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Manage Category</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{ route('category.index') }}">Category</a></li>
            <li><a class="nav-link" href="{{ route('sub-category.index') }}">Sub Category</a></li>
            <li><a class="nav-link" href="#">Child Category</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Layout</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{ route('slider.index') }}">Slider</a></li>
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
