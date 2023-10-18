<ul class="sidebar-menu">
    <li class="menu-header">MASTER</li>
    <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-cubes"></i><span>Master Data</span></a>
        <ul class="dropdown-menu">
            @php
                $role = session('privilage');
                $mitem_open = session('mitem_open');
                $muser_open = session('muser_open');
                $mwarna_open = session('mwarna_open');
                $mcounter_open = session('mcounter_open');
                $mhakses_open = session('mhakses_open');
                $tsob_open = session('tsob_open');
                $tpenerimaan_open = session('tpenerimaan_open');
                $tretur_open = session('tretur_open');
                $tbonjual_open = session('tbonjual_open');
                $tadjstock_open = session('tadjstock_open');
                $tsuratjalan_open = session('tsuratjalan_open');
                $tstopname_open = session('tstopname_open');
                $tbelibrg_open = session('tbelibrg_open');
            @endphp
            @if($mcounter_open == 'Y' || $role == 'ADM')      
                <li><a class="nav-link" href="{{ route('mlokasi') }}">Master Counter / Lokasi</a></li>       
            @endif
            @if($muser_open == 'Y' || $role == 'ADM')      
                <li><a class="nav-link" href="{{ route('mspg') }}">Master SPG / User</a></li>      
            @endif
            @if($mwarna_open == 'Y' || $role == 'ADM')      
                <li><a class="nav-link" href="{{ route('mwarna') }}">Master Data Warna</a></li>     
            @endif
            @if($mitem_open == 'Y' || $role == 'ADM')      
                <li><a class="nav-link" href="{{ route('mitem') }}">Master Data Item</a></li>      
            @endif  
            @if($mhakses_open == 'Y' || $role == 'ADM')          
                <li><a class="nav-link" href="{{ route('mhakses') }}">Master Hak Akses</a></li>   
            @endif  
            @if($mhakses_open == 'Y' || $role == 'ADM')          
                <li><a class="nav-link" href="{{ route('mjenispayment') }}">Master Jenis Pembayaran</a></li>   
            @endif  
            @if($mhakses_open == 'Y' || $role == 'ADM')          
                <li><a class="nav-link" href="{{ route('msaldoawal') }}">Master Saldo Awal</a></li>   
            @endif  
        </ul>
    </li>
    <li class="menu-header">Transaction</li>
    <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-exchange-alt"></i>
            <span>Transaction</span></a>
        <ul class="dropdown-menu">
            @if($tbelibrg_open == 'Y' || $role == 'ADM')
                <li><a class="nav-link" href="{{ route('tpembelianbarang') }}">Pembelian Barang</a></li>
                {{-- <li><a class="nav-link" href="{{ route('tpembelianbaranglist') }}">Pembelian Barang List</a></li> --}}
            @endif
            @if($tsob_open == 'Y' || $role == 'ADM')
                <li><a class="nav-link" href="{{ route('tsob') }}">Surat Order Barang</a></li>
                {{-- <li><a class="nav-link" href="{{ route('tsoblist') }}">Surat Order Barang List</a></li> --}}
            @endif
            @if($tsuratjalan_open == 'Y' || $role == 'ADM')
                <li><a class="nav-link" href="{{ route('tsuratjalan') }}">Surat Jalan</a></li>
                {{-- <li><a class="nav-link" href="{{ route('tsuratjalanlist') }}">Surat Jalan List</a></li> --}}
            @endif
            @if($tpenerimaan_open == 'Y' || $role == 'ADM')
                <li><a class="nav-link" href="{{ route('tpenerimaanbrg') }}">Penerimaan Barang</a></li>
                {{-- <li><a class="nav-link" href="{{ route('tpenerimaanbrglist') }}">Penerimaan Barang List</a></li> --}}
            @endif
            @if($tbonjual_open == 'Y' || $role == 'ADM')
                <li><a class="nav-link" href="{{ route('tbonjual') }}">Bon Penjualan</a></li>
                {{-- <li><a class="nav-link" href="{{ route('tbonjuallist') }}">Bon Penjualan List</a></li> --}}
            @endif
            @if($tretur_open == 'Y' || $role == 'ADM')
                <li><a class="nav-link" href="{{ route('treturjual') }}">Retur Penjualan</a></li>
                {{-- <li><a class="nav-link" href="{{ route('treturjuallist') }}">Retur Penjualan List</a></li> --}}
            @endif
            @if($tadjstock_open == 'Y' || $role == 'ADM')
                <li><a class="nav-link" href="{{ route('tadjustmentstock') }}">Adjustment Stock</a></li>
                {{-- <li><a class="nav-link" href="{{ route('tadjlist') }}">Adjustment Stock List</a></li> --}}
            @endif
            @if($tadjstock_open == 'Y' || $role == 'ADM')
                <li><a class="nav-link" href="{{ route('texpense') }}">Biaya Operasional</a></li>
                {{-- <li><a class="nav-link" href="{{ route('tadjlist') }}">Adjustment Stock List</a></li> --}}
            @endif
            {{-- <li><a class="nav-link" href="{{ route('tstockopname') }}">Stock Opname</a></li> --}}
            {{-- <li><a class="nav-link" href="#">Stock Opname</a></li> --}}
        </ul>
    </li>
    <li class="menu-header">Reports</li>
    <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-chart-bar"></i>
            <span>Reports</span></a>
        <ul class="dropdown-menu">
            @if($tadjstock_open == 'Y' || $role == 'ADM')
            <li><a class="nav-link" href="{{ route('romsetitem') }}">Laporan Omset Per Item</a></li>
            @endif
            <li><a class="nav-link" href="{{ route('romsetcounter') }}">Lap. Omset Per-Counter</a></li>
            <li><a class="nav-link" href="{{ route('rlapstockpercounter') }}">Laporan Stock Per-Counter</a></li>
            <li><a class="nav-link" href="{{ route('rmutasistock') }}">Laporan Mutasi Stock</a></li>
            <li><a class="nav-link" href="{{ route('rstockoverview') }}">Laporan Stock Overview</a></li>
            <li><a class="nav-link" href="{{ route('rlaperoutlet') }}">Laporan Per Outlet</a></li>
            {{-- <li><a class="nav-link" href="testreport" target="_blank">Laporan Test</a></li> --}}
        </ul>
    </li>
    <li class="menu-header">Upload Data</li>
    <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-exchange-alt"></i>
            <span>Upload Data</span></a>
        <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('uploadsample') }}">Upload Master Data Item</a></li>
                <li><a class="nav-link" href="{{ route('uploadmitemcounter') }}">Upload M.Item Counter</a></li>
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