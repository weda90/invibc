<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Http\Requests;
use DB;

class MasterController extends Controller
{
    public function material(){
    	// DB::table('role_user')->where('user_id',$id)->delete();
    	$material_type = DB::table('material_type')->lists('name','id');
		$company_type = DB::table('company_type')->lists('name','id');
		$company_status = DB::table('company_status')->lists('name','id');
		$company_location = DB::table('company_location')->lists('name','id');

    	return view('master.material')->with('material_type',$material_type)->with('company_type',$company_type)->with('company_status',$company_status)->with('company_location',$company_location);
    }

    public function company(){
    	return view('master.company');
    }
}
