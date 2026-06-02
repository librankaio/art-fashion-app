@extends('layouts.main')

@section('topscripts')
    <style>
        /* ====== HOME V2 STYLES ====== */
        .homev2-wrap {
            background: #f4f6fb;
            min-height: 100vh;
            padding-bottom: 40px;
        }

        /* Date picker bar */
        .date-bar {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
            padding: 18px 24px;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .date-bar label {
            font-weight: 600;
            color: #5a5f7d;
            margin: 0;
            font-size: 14px;
        }

        .date-bar input[type="date"] {
            border: 1.5px solid #e0e4f0;
            border-radius: 8px;
            padding: 7px 14px;
            font-size: 14px;
            color: #3c4372;
            outline: none;
            transition: border-color .2s;
        }

        .date-bar input[type="date"]:focus {
            border-color: #6777ef;
        }

        .date-bar .btn-refresh {
            background: linear-gradient(135deg, #6777ef, #9e5fef);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 8px 22px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity .2s, transform .1s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .date-bar .btn-refresh:hover {
            opacity: .9;
        }

        .date-bar .btn-refresh:active {
            transform: scale(.97);
        }

        .date-bar .btn-today {
            background: #f0f2ff;
            color: #6777ef;
            border: 1.5px solid #d6daff;
            border-radius: 8px;
            padding: 7px 16px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s;
        }

        .date-bar .btn-today:hover {
            background: #e4e8ff;
        }

        /* Section label */
        .section-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #a0a8c0;
            margin-bottom: 12px;
            margin-top: 8px;
        }

        /* Summary Cards */
        .summary-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 14px rgba(0, 0, 0, .06);
            padding: 22px 22px 18px;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            transition: box-shadow .25s, transform .2s;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .summary-card:hover {
            box-shadow: 0 6px 28px rgba(0, 0, 0, .11);
            transform: translateY(-2px);
        }

        .summary-card .card-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        .summary-card .card-body-inner {
            flex: 1;
            min-width: 0;
        }

        .summary-card .card-title {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: #a0a8c0;
            margin-bottom: 4px;
        }

        .summary-card .card-count {
            font-size: 28px;
            font-weight: 700;
            color: #2d3159;
            line-height: 1.1;
            margin-bottom: 2px;
        }

        .summary-card .card-sub {
            font-size: 12px;
            color: #7a82a6;
            font-weight: 500;
        }

        .summary-card .card-total {
            font-size: 13px;
            font-weight: 700;
            margin-top: 6px;
        }

        .summary-card .card-stripe {
            position: absolute;
            top: 0;
            right: 0;
            width: 5px;
            height: 100%;
            border-radius: 0 14px 14px 0;
        }

        /* Color themes */
        .theme-purple .card-icon {
            background: #f0eeff;
            color: #6777ef;
        }

        .theme-purple .card-stripe {
            background: linear-gradient(180deg, #6777ef, #9e5fef);
        }

        .theme-purple .card-total {
            color: #6777ef;
        }

        .theme-green .card-icon {
            background: #e6faf3;
            color: #17c97e;
        }

        .theme-green .card-stripe {
            background: linear-gradient(180deg, #17c97e, #0fa963);
        }

        .theme-green .card-total {
            color: #17c97e;
        }

        .theme-blue .card-icon {
            background: #e8f4ff;
            color: #3a9cff;
        }

        .theme-blue .card-stripe {
            background: linear-gradient(180deg, #3a9cff, #1a7ee8);
        }

        .theme-blue .card-total {
            color: #3a9cff;
        }

        .theme-orange .card-icon {
            background: #fff5e8;
            color: #ff9b35;
        }

        .theme-orange .card-stripe {
            background: linear-gradient(180deg, #ff9b35, #e07800);
        }

        .theme-orange .card-total {
            color: #ff9b35;
        }

        .theme-red .card-icon {
            background: #fff0f0;
            color: #f5365c;
        }

        .theme-red .card-stripe {
            background: linear-gradient(180deg, #f5365c, #c0002e);
        }

        .theme-red .card-total {
            color: #f5365c;
        }

        .theme-teal .card-icon {
            background: #e6fafa;
            color: #11cdef;
        }

        .theme-teal .card-stripe {
            background: linear-gradient(180deg, #11cdef, #0099b8);
        }

        .theme-teal .card-total {
            color: #11cdef;
        }

        .theme-indigo .card-icon {
            background: #eceeff;
            color: #5e72e4;
        }

        .theme-indigo .card-stripe {
            background: linear-gradient(180deg, #5e72e4, #3a4ecc);
        }

        .theme-indigo .card-total {
            color: #5e72e4;
        }

        .theme-pink .card-icon {
            background: #fff0f8;
            color: #f72585;
        }

        .theme-pink .card-stripe {
            background: linear-gradient(180deg, #f72585, #c00060);
        }

        .theme-pink .card-total {
            color: #f72585;
        }

        /* Skeleton loader */
        .skeleton {
            background: linear-gradient(90deg, #f0f2f8 25%, #e4e7f2 50%, #f0f2f8 75%);
            background-size: 200% 100%;
            animation: shimmer 1.4s infinite;
            border-radius: 6px;
            display: inline-block;
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        .skeleton-count {
            width: 60px;
            height: 34px;
        }

        .skeleton-sub {
            width: 110px;
            height: 14px;
            margin-top: 6px;
        }

        /* Last updated badge */
        .last-updated {
            font-size: 12px;
            color: #a0a8c0;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .pulse-dot {
            width: 8px;
            height: 8px;
            background: #17c97e;
            border-radius: 50%;
            display: inline-block;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: .4;
                transform: scale(1.4);
            }
        }

        /* Fade-in animation for cards */
        .card-animate {
            animation: fadeUp .4s ease both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-animate:nth-child(1) {
            animation-delay: .05s;
        }

        .card-animate:nth-child(2) {
            animation-delay: .10s;
        }

        .card-animate:nth-child(3) {
            animation-delay: .15s;
        }

        .card-animate:nth-child(4) {
            animation-delay: .20s;
        }

        .card-animate:nth-child(5) {
            animation-delay: .25s;
        }

        .card-animate:nth-child(6) {
            animation-delay: .30s;
        }

        .card-animate:nth-child(7) {
            animation-delay: .35s;
        }

        .card-animate:nth-child(8) {
            animation-delay: .40s;
        }
    </style>
@endsection

@section('content')
    <section class="section homev2-wrap">
        <div class="section-header">
            <h1>Dashboard</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Home</a></div>
                <div class="breadcrumb-item text-muted">Summary Harian</div>
            </div>
        </div>

        <div class="section-body">

            {{-- Date Bar --}}
            <div class="date-bar">
                <i class="fas fa-calendar-alt" style="color:#6777ef;font-size:18px;"></i>
                <label>Tanggal</label>
                <input type="date" id="summary-date" value="{{ date('Y-m-d') }}">
                <button class="btn-today" id="btn-today" type="button">Hari Ini</button>
                <button class="btn-refresh" id="btn-load" type="button">
                    <i class="fas fa-sync-alt" id="refresh-icon"></i> Tampilkan
                </button>
                <span class="last-updated ms-auto" id="last-updated" style="margin-left:auto;"></span>
            </div>

            {{-- Cards Grid --}}
            <div class="p-label section-label">Transaksi Penjualan & Distribusi</div>
            <div class="row" id="cards-row-1">
                {{-- Bon Penjualan --}}
                <div class="col-12 col-md-6 col-lg-3 mb-4 card-animate">
                    <div class="summary-card theme-purple">
                        <div class="card-stripe"></div>
                        <div class="card-icon"><i class="fas fa-shopping-cart"></i></div>
                        <div class="card-body-inner">
                            <div class="card-title">Bon Penjualan</div>
                            <div class="card-count" id="val-penjualan-jml"><span class="skeleton skeleton-count"></span>
                            </div>
                            <div class="card-sub">transaksi hari ini</div>
                            <div class="card-total" id="val-penjualan-tot"><span class="skeleton skeleton-sub"></span></div>
                        </div>
                    </div>
                </div>

                {{-- Surat Jalan --}}
                <div class="col-12 col-md-6 col-lg-3 mb-4 card-animate">
                    <div class="summary-card theme-blue">
                        <div class="card-stripe"></div>
                        <div class="card-icon"><i class="fas fa-truck"></i></div>
                        <div class="card-body-inner">
                            <div class="card-title">Surat Jalan</div>
                            <div class="card-count" id="val-sj-jml"><span class="skeleton skeleton-count"></span></div>
                            <div class="card-sub">transaksi hari ini</div>
                            <div class="card-total" id="val-sj-tot"><span class="skeleton skeleton-sub"></span></div>
                        </div>
                    </div>
                </div>

                {{-- Retur Penjualan --}}
                <div class="col-12 col-md-6 col-lg-3 mb-4 card-animate">
                    <div class="summary-card theme-red">
                        <div class="card-stripe"></div>
                        <div class="card-icon"><i class="fas fa-undo-alt"></i></div>
                        <div class="card-body-inner">
                            <div class="card-title">Retur Penjualan</div>
                            <div class="card-count" id="val-retur-jml"><span class="skeleton skeleton-count"></span></div>
                            <div class="card-sub">transaksi hari ini</div>
                        </div>
                    </div>
                </div>

                {{-- Expense --}}
                <div class="col-12 col-md-6 col-lg-3 mb-4 card-animate">
                    <div class="summary-card theme-pink">
                        <div class="card-stripe"></div>
                        <div class="card-icon"><i class="fas fa-receipt"></i></div>
                        <div class="card-body-inner">
                            <div class="card-title">Expense</div>
                            <div class="card-count" id="val-expense-jml"><span class="skeleton skeleton-count"></span></div>
                            <div class="card-sub">transaksi hari ini</div>
                            <div class="card-total" id="val-expense-tot"><span class="skeleton skeleton-sub"></span></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-label mt-2">Pembelian & Penerimaan</div>
            <div class="row" id="cards-row-2">
                {{-- Pembelian --}}
                <div class="col-12 col-md-6 col-lg-3 mb-4 card-animate">
                    <div class="summary-card theme-orange">
                        <div class="card-stripe"></div>
                        <div class="card-icon"><i class="fas fa-boxes"></i></div>
                        <div class="card-body-inner">
                            <div class="card-title">Pembelian Barang</div>
                            <div class="card-count" id="val-pembelian-jml"><span class="skeleton skeleton-count"></span>
                            </div>
                            <div class="card-sub">transaksi hari ini</div>
                            <div class="card-total" id="val-pembelian-tot"><span class="skeleton skeleton-sub"></span></div>
                        </div>
                    </div>
                </div>

                {{-- Penerimaan --}}
                <div class="col-12 col-md-6 col-lg-3 mb-4 card-animate">
                    <div class="summary-card theme-green">
                        <div class="card-stripe"></div>
                        <div class="card-icon"><i class="fas fa-dolly"></i></div>
                        <div class="card-body-inner">
                            <div class="card-title">Penerimaan Barang</div>
                            <div class="card-count" id="val-penerimaan-jml"><span class="skeleton skeleton-count"></span>
                            </div>
                            <div class="card-sub">transaksi hari ini</div>
                            <div class="card-total" id="val-penerimaan-tot"><span class="skeleton skeleton-sub"></span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Adjustment --}}
                <div class="col-12 col-md-6 col-lg-3 mb-4 card-animate">
                    <div class="summary-card theme-teal">
                        <div class="card-stripe"></div>
                        <div class="card-icon"><i class="fas fa-sliders-h"></i></div>
                        <div class="card-body-inner">
                            <div class="card-title">Adjustment Stock</div>
                            <div class="card-count" id="val-adj-jml"><span class="skeleton skeleton-count"></span></div>
                            <div class="card-sub">transaksi hari ini</div>
                        </div>
                    </div>
                </div>

                {{-- Stock Opname --}}
                <div class="col-12 col-md-6 col-lg-3 mb-4 card-animate">
                    <div class="summary-card theme-indigo">
                        <div class="card-stripe"></div>
                        <div class="card-icon"><i class="fas fa-clipboard-list"></i></div>
                        <div class="card-body-inner">
                            <div class="card-title">Stock Opname</div>
                            <div class="card-count" id="val-so-jml"><span class="skeleton skeleton-count"></span></div>
                            <div class="card-sub">transaksi hari ini</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@stop

@section('botscripts')
    <script>
        var CSRF_TOKEN = '{{ csrf_token() }}';

        function formatRupiah(num) {
            if (num === null || num === undefined) return 'Rp 0';
            return 'Rp ' + Number(num).toLocaleString('id-ID');
        }

        function setSkeleton() {
            var skCount = '<span class="skeleton skeleton-count"></span>';
            var skSub = '<span class="skeleton skeleton-sub"></span>';
            $('#val-penjualan-jml, #val-sj-jml, #val-retur-jml, #val-expense-jml, #val-pembelian-jml, #val-penerimaan-jml, #val-adj-jml, #val-so-jml')
                .html(skCount);
            $('#val-penjualan-tot, #val-sj-tot, #val-pembelian-tot, #val-penerimaan-tot, #val-expense-tot').html(skSub);
            $('#last-updated').html('');
        }

        function loadSummary() {
            var date = $('#summary-date').val();
            if (!date) return;

            setSkeleton();

            var $icon = $('#refresh-icon');
            $icon.addClass('fa-spin');
            $('#btn-load').prop('disabled', true);

            $.ajax({
                url: '{{ route('homev2summary') }}',
                method: 'GET',
                data: {
                    date: date
                },
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                dataType: 'json',
                success: function(r) {
                    // Penjualan
                    $('#val-penjualan-jml').text(r.penjualan.jumlah);
                    $('#val-penjualan-tot').text(formatRupiah(r.penjualan.total));

                    // Surat Jalan
                    $('#val-sj-jml').text(r.suratjalan.jumlah);
                    $('#val-sj-tot').text(formatRupiah(r.suratjalan.total));

                    // Retur
                    $('#val-retur-jml').text(r.retur.jumlah);

                    // Expense
                    $('#val-expense-jml').text(r.expense.jumlah);
                    $('#val-expense-tot').text(formatRupiah(r.expense.total));

                    // Pembelian
                    $('#val-pembelian-jml').text(r.pembelian.jumlah);
                    $('#val-pembelian-tot').text(formatRupiah(r.pembelian.total));

                    // Penerimaan
                    $('#val-penerimaan-jml').text(r.penerimaan.jumlah);
                    $('#val-penerimaan-tot').text(formatRupiah(r.penerimaan.total));

                    // Adjustment
                    $('#val-adj-jml').text(r.adjustment.jumlah);

                    // Stock Opname
                    $('#val-so-jml').text(r.stockopname.jumlah);

                    // Last updated
                    var now = new Date();
                    var time = now.toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit'
                    });
                    $('#last-updated').html('<span class="pulse-dot"></span> Diperbarui ' + time);
                },
                error: function() {
                    $('#val-penjualan-jml, #val-sj-jml, #val-retur-jml, #val-expense-jml, #val-pembelian-jml, #val-penerimaan-jml, #val-adj-jml, #val-so-jml')
                        .text('-');
                    $('#val-penjualan-tot, #val-sj-tot, #val-pembelian-tot, #val-penerimaan-tot, #val-expense-tot')
                        .text('-');
                    $('#last-updated').html(
                        '<span style="color:#f5365c;"><i class="fas fa-exclamation-circle"></i> Gagal memuat data</span>'
                        );
                },
                complete: function() {
                    $icon.removeClass('fa-spin');
                    $('#btn-load').prop('disabled', false);
                }
            });
        }

        $(document).ready(function() {
            // Load otomatis saat halaman dibuka
            loadSummary();

            $('#btn-load').on('click', loadSummary);

            $('#btn-today').on('click', function() {
                var today = new Date().toISOString().split('T')[0];
                $('#summary-date').val(today);
                loadSummary();
            });

            // Load juga kalau tanggal diubah langsung
            $('#summary-date').on('change', loadSummary);
        });
    </script>
@endsection
