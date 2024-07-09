@props(['class' => 'nav-main'])

<ul class="{{ $class }}">
    <li class="nav-main-item">
        <a class="nav-main-link {{ request()->is('admin/beranda') ? ' active' : '' }}" href="{{ route('admin.beranda') }}">
            <i class="nav-main-link-icon fa fa-house-user"></i>
            <span class="nav-main-link-name">Beranda</span>
        </a>
    </li>
    <li class="nav-main-item">
        <a class="nav-main-link {{ request()->is('admin/konsumen') ? ' active' : '' }}" href="{{ route('admin.user.index') }}">
            <i class="nav-main-link-icon fa fa-users"></i>
            <span class="nav-main-link-name">Konsumen</span>
        </a>
    </li>
    <li class="nav-main-item">
        <a class="nav-main-link {{ request()->is('admin/order') ? ' active' : '' }}" href="{{ route('admin.order.index') }}">
            <i class="nav-main-link-icon fa fa-calendar-check"></i>
            <span class="nav-main-link-name">Pemesanan</span>
        </a>
    </li>
    <li class="nav-main-item">
        <a class="nav-main-link {{ request()->is('admin/pembayaran') ? ' active' : '' }}" href="{{ route('admin.payment.index') }}">
            <i class="nav-main-link-icon fa fa-wallet"></i>
            <span class="nav-main-link-name">Pembayaran</span>
        </a>
    </li>
    <li class="nav-main-item">
        <a class="nav-main-link {{ request()->is('admin/kategori') ? ' active' : '' }}" href="{{ route('admin.kategori.index') }}">
            <i class="nav-main-link-icon fa fa-archive"></i>
            <span class="nav-main-link-name">Kategori</span>
        </a>
    </li>
    <li class="nav-main-item">
        <a class="nav-main-link {{ request()->is('admin/produk') ? ' active' : '' }}" href="{{ route('admin.produk.index') }}">
            <i class="nav-main-link-icon fa fa-truck-front"></i>
            <span class="nav-main-link-name">Produk</span>
        </a>
    </li>
</ul>