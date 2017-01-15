<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

// use App\Http\Requests;
use DB;


class StockController extends Controller
{
    public function receiving(){
    	$unit_type = DB::table('unit_type')->lists('name','id');
		$curr_type = DB::table('curr_type')->lists('name','id');
		
    	return view('stock.receiving')->with('unit_type',$unit_type)->with('curr_type',$curr_type);
    }

    public function outgoing(){
    	$unit_type = DB::table('unit_type')->lists('name','id');
		$stock_to = DB::table('stock_to')->lists('name','id');

    	return view('stock.outgoing')->with('unit_type',$unit_type)->with('stock_to',$stock_to);
    }
}
