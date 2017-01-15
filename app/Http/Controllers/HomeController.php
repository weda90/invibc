<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stock = array();

        // $tableStock = DB::table('stock_master')->select('qty');

        $stock['receiving']= DB::table('stock_master')->select('qty')->where('type','=','1')->sum('qty');
        $stock['outgoing']= DB::table('stock_master')->select('qty')->where('type','=','2')->sum('qty');
        $stock['balancing']= DB::table('stock_master')->select('qty')->where('type','=','3')->sum('qty');

        // dump($stock);
        return view('home')->with('stock_stat',$stock);
    }
}
