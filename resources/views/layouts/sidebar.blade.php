<ul class="sidebar-menu">
    <li class="menu-header">MASTER</li>
    <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-cubes"></i><span>Master Data</span></a>
        <ul class="dropdown-menu">
            @php
                // $role = session('privilage');
                // $mitem_open = session('mitem_open');
                // $muser_open = session('muser_open');
                // $msatuan_open = session('msatuan_open');
                // $mdtgrp_open = session('mdtgrp_open');
                // $mcoa_open = session('mcoa_open');
                // $mbank_open = session('mbank_open');
                // $mmtuang_open = session('mmtuang_open');
                // $mcust_open = session('mcust_open');
                // $msupp_open = session('msupp_open');
                // $mlokasi_open = session('mlokasi_open');
                // $mcabang_open = session('mcabang_open');
                // $tpembelianbrg_open = session('tpembelianbrg_open');
                // $tpos_open = session('tpos_open');
                // $tops_open = session('tops_open');
                // $tjvouch_open = session('tjvouch_open');
                // $tpenerimaan_open = session('tpenerimaan_open');
            @endphp
            {{-- @if($muser_open == 'Y' || $role == 'ADM')  
                <li><a class="nav-link" href="{{ route('muser') }}">Master Data User</a></li>          
            @endif --}}
            {{-- @if($mitem_open == 'Y') --}}
                <li><a class="nav-link" href="{{ route('mwarna') }}">Master Data Warna</a></li>     
            {{-- @endif --}}
            {{-- @if($msatuan_open == 'Y') --}}
                <li><a class="nav-link" href="{{ route('mspg') }}">Master SPG / User</a></li>   
                <li><a class="nav-link" href="{{ route('mlokasi') }}">Master Counter / Lokasi</a></li>   
                <li><a class="nav-link" href="{{ route('mitem') }}">Master Data Item</a></li>   
                <li><a class="nav-link" href="{{ route('mhakses') }}">Master Hak Akses</a></li>   
            {{-- @endif --}}
            {{-- @if($mdtgrp_open == 'Y')
                <li><a class="nav-link" href="{{ route('mgrup') }}">Master Data Group</a></li>  
            @endif --}}
            {{-- @if($mcoa_open == 'Y') --}}
                {{-- <li><a class="nav-link" href="">Master Chart Of Account</a></li>  --}}
            {{-- @endif --}}
        </ul>
    </li>
    <li class="menu-header">Transaction</li>
    <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-exchange-alt"></i>
            <span>Transaction</span></a>
        <ul class="dropdown-menu">
            {{-- @if($tpembelianbrg_open == 'Y')
                <li><a class="nav-link" href="{{ route('transbelibrg') }}">Pembelian Barang</a></li>
                <li><a class="nav-link" href="{{ route('tbelibrglist') }}">Pembelian Barang List</a></li>
            @endif --}}
            {{-- @if($tpos_open == 'Y') --}}
                <li><a class="nav-link" href="{{ route('tsob') }}">Surat Order Barang</a></li>
                <li><a class="nav-link" href="{{ route('tsoblist') }}">Surat Order Barang List</a></li>
                <li><a class="nav-link" href="{{ route('tpenerimaanbrg') }}">Penerimaan Barang</a></li>
                <li><a class="nav-link" href="{{ route('tpenerimaanbrglist') }}">Penerimaan Barang List</a></li>
                <li><a class="nav-link" href="{{ route('treturjual') }}">Retur Penjualan</a></li>
                <li><a class="nav-link" href="{{ route('treturjuallist') }}">Retur Penjualan List</a></li>
                <li><a class="nav-link" href="{{ route('tbonjual') }}">Bon Penjualan</a></li>
                <li><a class="nav-link" href="{{ route('tbonjuallist') }}">Bon Penjualan List</a></li>
                <li><a class="nav-link" href="{{ route('tadjustmentstock') }}">Adjustment Stock</a></li>
                <li><a class="nav-link" href="{{ route('tadjlist') }}">Adjustment Stock List</a></li>
                <li><a class="nav-link" href="{{ route('tsuratjalan') }}">Surat Jalan</a></li>
                <li><a class="nav-link" href="{{ route('tsuratjalanlist') }}">Surat Jalan List</a></li>
                <li><a class="nav-link" href="{{ route('tstockopname') }}">Stock Opname</a></li>
                <li><a class="nav-link" href="{{ route('tpembelianbarang') }}">Pembelian Barang</a></li>
                <li><a class="nav-link" href="{{ route('tpembelianbaranglist') }}">Pembelian Barang List</a></li>
            {{-- @endif --}}
        </ul>
    </li>
    <li class="menu-header">Reports</li>
    <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-chart-bar"></i>
            <span>Reports</span></a>
        <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{ route('romsetitem') }}">Laporan Omset Per Item</a></li>
            <li><a class="nav-link" href="{{ route('rstockoverview') }}">Laporan Stock Overview</a></li>
            <li><a class="nav-link" href="{{ route('rmutasistock') }}">Laporan Mutasi Stock</a></li>
        </ul>
    </li>
    {{-- <li><a class="nav-link" href="blank.html"><i class="far fa-square"></i> <span>Blank Page</span></a></li>
    <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-th"></i> <span>Bootstrap</span></a>
        <ul class="dropdown-menu">
            <li><a class="nav-link" href="bootstrap-alert.html">Alert</a></li>
            <li><a class="nav-link" href="bootstrap-badge.html">Badge</a></li>
            <li><a class="nav-link" href="bootstrap-breadcrumb.html">Breadcrumb</a></li>
            <li><a class="nav-link" href="bootstrap-buttons.html">Buttons</a></li>
            <li><a class="nav-link" href="bootstrap-card.html">Card</a></li>
            <li><a class="nav-link" href="bootstrap-carousel.html">Carousel</a></li>
            <li><a class="nav-link" href="bootstrap-collapse.html">Collapse</a></li>
            <li><a class="nav-link" href="bootstrap-dropdown.html">Dropdown</a></li>
            <li><a class="nav-link" href="bootstrap-form.html">Form</a></li>
            <li><a class="nav-link" href="bootstrap-list-group.html">List Group</a></li>
            <li><a class="nav-link" href="bootstrap-media-object.html">Media Object</a></li>
            <li><a class="nav-link" href="bootstrap-modal.html">Modal</a></li>
            <li><a class="nav-link" href="bootstrap-nav.html">Nav</a></li>
            <li><a class="nav-link" href="bootstrap-navbar.html">Navbar</a></li>
            <li><a class="nav-link" href="bootstrap-pagination.html">Pagination</a></li>
            <li><a class="nav-link" href="bootstrap-popover.html">Popover</a></li>
            <li><a class="nav-link" href="bootstrap-progress.html">Progress</a></li>
            <li><a class="nav-link" href="bootstrap-table.html">Table</a></li>
            <li><a class="nav-link" href="bootstrap-tooltip.html">Tooltip</a></li>
            <li><a class="nav-link" href="bootstrap-typography.html">Typography</a></li>
        </ul>
    </li> --}}
    {{-- <li><a class="nav-link" href="credits.html"><i class="fas fa-pencil-ruler"></i> <span>Credits</span></a></li>
</ul> --}}

{{-- <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
    <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
        <i class="fas fa-rocket"></i> Documentation
    </a>
</div> --}}