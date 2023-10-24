<?php

namespace App\Http\Controllers;

use App\Models\Mcounter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerReportStockOverview extends Controller
{
    public function index()
    {
        $counters = Mcounter::select('id','code','name')->get();
        return view('pages.Report.rstockoverview',[
            'counters' => $counters
        ]);
    }

    public function post(Request $request)
    {
        // dd($request->all());
        $dtfr = $request->input('dtfr');
        $dtto = $request->input('dtto');
        // $datefrForm = Carbon::createFromFormat('d/m/Y', $dtfr)->format('Y-m-d');
        // $datetoForm = Carbon::createFromFormat('d/m/Y', $dtto)->format('Y-m-d');
        $counter = $request->input('counter');

        // $results = DB::table('vomsetpercounter')->whereBetween('tgl', [$dtfr, $dtto])->paginate(100);
        $results = DB::select('CALL prStockOverview (?,?,?)', [$dtfr, $dtto,$counter]);
        // $results = DB::select( DB::raw("SELECT A.*, (A.stock_awal+A.stock_in)-A.stock_out 'stock_akhir' FROM (
		
        //     SELECT 
        //             TA.code
        //             , TA.name
        //             , TA.satuan
        //             , 	(IFNULL((SELECT SUM(qty) FROM vpembelian WHERE code = TA.`code` AND tgl < idatefrom and counter = 'HO'),0) + IFNULL((SELECT SUM(qty) FROM vpenerimaan WHERE code = TA.`code` AND tgl < idatefrom and counter = icounter),0)) -
        //                 (IFNULL((SELECT SUM(qty) FROM vpenjualan WHERE code = TA.`code` AND tgl < idatefrom and counter = icounter),0)+IFNULL((SELECT SUM(qty) FROM vsj WHERE code = TA.`code` AND tgl < idatefrom and counter = icounter),0))	
        //                 AS 'stock_awal'
                        
        //             , IFNULL((SELECT SUM(qty) FROM vpembelian WHERE code = TA.`code` AND tgl BETWEEN idatefrom AND idateto and counter = 'HO'),0) + IFNULL((SELECT SUM(qty) FROM vpenerimaan WHERE code = TA.`code` AND tgl BETWEEN idatefrom AND idateto and counter = icounter),0) AS 'stock_in'
                    
        //             , IFNULL((SELECT SUM(qty) FROM vpenjualan WHERE code = TA.`code` AND tgl BETWEEN idatefrom AND idateto and counter = icounter),0)+IFNULL((SELECT SUM(qty) FROM vsj WHERE code = TA.`code` AND tgl BETWEEN idatefrom AND idateto and counter = icounter),0) AS 'stock_out'
                    
        //             , TA.hrgjual
        //         FROM
        //             mitems TA
        //         WHERE 1=1
                    
        
        //             ) A
        //             ORDER BY A.code"));
        // $totqty = DB::select('SELECT sum(qty) as totalqty FROM vomsetpercounter');
        // $grandtot = DB::select('SELECT sum(subtotal) as grandtotal FROM vomsetpercounter');
        $counters = Mcounter::select('id','code','name')->get();
        // dd($results);

        return view('pages.Report.rstockoverview', [
            'results' => $results,
            'counters' => $counters,
            // 'totqty' => $totqty,
            // 'grandtot' => $grandtot,
        ]);
    }

    public function exportExcel(Request $request)
    {
        $dtfr = $request->input('dtfr');
        $dtto = $request->input('dtto');
        $counter = $request->input('counter');

        $results = DB::select('CALL prStockOverview (?,?,?)', [$dtfr, $dtto,$counter]);

        // dd($results);
        return view('pages.Print.Excel.rstockoverviewexcl', compact('results','counter','dtfr','dtto'));
    }
}
