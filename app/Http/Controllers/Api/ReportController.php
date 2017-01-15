<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use DateTime;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    protected $table = 'stock_master';

    public function index(Request $request, $id){
    	// return 'ok';
    	switch ($id) {
    		case '1':
    			return $this->bc23($request);
    			break;
    		case '2':
    			return $this->bc40($request);
    			break;
    		case '3':
    			return $this->bc27o($request);
    			break;
    		case '4':
                return $this->bc27i($request);
                break;
            case '5':
                return $this->bc261($request);
                break;
            case '6':
                return $this->bc262($request);
                break;
            case '7':
                return $this->bc41($request);
                break;
    		default:
    			return $this->bc23($request);
    			break;
    	}
    }


    public function json($request, $list_columns, $arr_select, $results){

        $data = (count($request->input()) != 0)?$request->input():'';

        $object = (object) $data;
        
        $order = $data['order'][0];
                    
        // results for filtering
        $results = (isset($data['filter_no_transc']) AND $data['filter_no_transc'] != '') ? $results->where('stock_master.no','=',$data['filter_no_transc']) : $results ;

        $iTotalRecords = $results->count();

        // results for ordering
        $results = (isset($order['column']) AND $order['column'] <= count($list_columns)) ? $results->orderBy($list_columns[$order['column']],$order['dir']) : $results ;

        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
        $iDisplayStart = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);

        $records = array();
        $records["data"] = array(); 
        foreach ($results->skip($iDisplayStart)->take($iDisplayLength)->get() as $result) {
            

                $records["data"][] =  array(
                    '<a href="javascript:;" class="detail-datatable"> 
                        '.$result->no.'
                    </a>',
                    date('d M Y', strtotime($result->date)),
                    $result->no_bc,
                    date('d M Y', strtotime($result->date_bc)),
                    $result->code_mat,
                    $result->code_company,
                    $result->qty,
                    $result->name_unit,
                    $result->price,
                    $result->name_curr,
                    $result->no_inv,
                    $result->no_po,
                    $result->no_so,
                    );            
            
        }


        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;

        if (isset($_REQUEST["customActionType"])) {
            $records["customActionStatus"] = (isset($customActionStatus)) ? $customActionStatus : 'OK' ;
            $records["customActionMessage"] = (isset($customActionMessage)) ? $customActionMessage : 'Message' ;
        }

        return response()->json($records);
    }

    function bc23($request){
    	// $results = DB::table('stock_master')->select('stock_master.no')->leftJoin('company_master','company_master.code','=','stock_master.code_company')->where('stock_master.type','=',1)->where('company_master.location','=',2)->where('company_master.type','=',1);
    	
        $list_columns = array('stock_master.no','stock_master.date','stock_master.no_bc','stock_master.date_bc','stock_master.type_bc','stock_master.code_mat','stock_master.code_company','stock_master.qty','stock_master.unit','stock_master.price','stock_master.curr','stock_master.no_inv','stock_master.no_po','stock_master.no_so');

        $arr_select = array('stock_master.id','stock_master.date','stock_master.no','stock_master.date_bc','stock_master.no_bc','stock_master.code_mat','stock_master.code_company','stock_master.qty','stock_master.price','stock_master.no_inv','stock_master.no_po','stock_master.no_so','bc_type.name as name_bc','unit_type.name as name_unit','curr_type.name as name_curr','stock_type.name as name_stock','stock_to.name as stock_to');

        $results = DB::table($this->table)
                    ->select($arr_select)
                    ->leftJoin('bc_type','stock_master.type_bc','=','bc_type.id')
                    ->leftJoin('unit_type','stock_master.unit','=','unit_type.id')
                    ->leftJoin('curr_type','stock_master.curr','=','curr_type.id')
                    ->leftJoin('stock_type','stock_master.type','=','stock_type.id')
                    ->leftJoin('stock_to','stock_master.to','=','stock_to.id')
                    ->leftJoin('company_master','company_master.code','=','stock_master.code_company')
                    ->where('stock_master.type','=',1)->where('company_master.location','=',2)->where('company_master.type','=',1);
                    
       
        return $this->json($request, $list_columns, $arr_select, $results);
    }

    function bc40($request){
    	// $results = DB::table('stock_master')->select('stock_master.no')->leftJoin('company_master','company_master.code','=','stock_master.code_company')->where('stock_master.type','=',1)->where('company_master.location','=',1)->where('company_master.type','=',1);

    	$list_columns = array('stock_master.no','stock_master.date','stock_master.no_bc','stock_master.date_bc','stock_master.type_bc','stock_master.code_mat','stock_master.code_company','stock_master.qty','stock_master.unit','stock_master.price','stock_master.curr','stock_master.no_inv','stock_master.no_po','stock_master.no_so');

        $arr_select = array('stock_master.id','stock_master.date','stock_master.no','stock_master.date_bc','stock_master.no_bc','stock_master.code_mat','stock_master.code_company','stock_master.qty','stock_master.price','stock_master.no_inv','stock_master.no_po','stock_master.no_so','bc_type.name as name_bc','unit_type.name as name_unit','curr_type.name as name_curr','stock_type.name as name_stock','stock_to.name as stock_to');

        $results = DB::table($this->table)
                    ->select($arr_select)
                    ->leftJoin('bc_type','stock_master.type_bc','=','bc_type.id')
                    ->leftJoin('unit_type','stock_master.unit','=','unit_type.id')
                    ->leftJoin('curr_type','stock_master.curr','=','curr_type.id')
                    ->leftJoin('stock_type','stock_master.type','=','stock_type.id')
                    ->leftJoin('stock_to','stock_master.to','=','stock_to.id')
                    ->leftJoin('company_master','company_master.code','=','stock_master.code_company')
                    ->where('stock_master.type','=',1)->where('company_master.location','=',1)->where('company_master.type','=',1);
                    
       
        return $this->json($request, $list_columns, $arr_select, $results);
    	
    }

    function bc27o($request){
    	// $results = DB::table('stock_master')->select('stock_master.no')->leftJoin('company_master','company_master.code','=','stock_master.code_company')->where('stock_master.type','=',2)->where('stock_master.to','=',2)->where('company_master.status','=',1);

        $list_columns = array('stock_master.no','stock_master.date','stock_master.no_bc','stock_master.date_bc','stock_master.type_bc','stock_master.code_mat','stock_master.code_company','stock_master.qty','stock_master.unit','stock_master.price','stock_master.curr','stock_master.no_inv','stock_master.no_po','stock_master.no_so');

        $arr_select = array('stock_master.id','stock_master.date','stock_master.no','stock_master.date_bc','stock_master.no_bc','stock_master.code_mat','stock_master.code_company','stock_master.qty','stock_master.price','stock_master.no_inv','stock_master.no_po','stock_master.no_so','bc_type.name as name_bc','unit_type.name as name_unit','curr_type.name as name_curr','stock_type.name as name_stock','stock_to.name as stock_to');

        $results = DB::table($this->table)
                    ->select($arr_select)
                    ->leftJoin('bc_type','stock_master.type_bc','=','bc_type.id')
                    ->leftJoin('unit_type','stock_master.unit','=','unit_type.id')
                    ->leftJoin('curr_type','stock_master.curr','=','curr_type.id')
                    ->leftJoin('stock_type','stock_master.type','=','stock_type.id')
                    ->leftJoin('stock_to','stock_master.to','=','stock_to.id')
                    ->leftJoin('company_master','company_master.code','=','stock_master.code_company')
                    ->where('stock_master.type','=',2)->where('stock_master.to','=',2)->where('company_master.status','=',1);                    
       
        return $this->json($request, $list_columns, $arr_select, $results);
    }

    function bc27i($request){
    	// $results = DB::table('stock_master')->select('stock_master.no')->leftJoin('company_master','company_master.code','=','stock_master.code_company')->where('stock_master.type','=',1)->where('stock_master.to','=',2)->where('company_master.status','=',1);

    	$list_columns = array('stock_master.no','stock_master.date','stock_master.no_bc','stock_master.date_bc','stock_master.type_bc','stock_master.code_mat','stock_master.code_company','stock_master.qty','stock_master.unit','stock_master.price','stock_master.curr','stock_master.no_inv','stock_master.no_po','stock_master.no_so');

        $arr_select = array('stock_master.id','stock_master.date','stock_master.no','stock_master.date_bc','stock_master.no_bc','stock_master.code_mat','stock_master.code_company','stock_master.qty','stock_master.price','stock_master.no_inv','stock_master.no_po','stock_master.no_so','bc_type.name as name_bc','unit_type.name as name_unit','curr_type.name as name_curr','stock_type.name as name_stock','stock_to.name as stock_to');

        $results = DB::table($this->table)
                    ->select($arr_select)
                    ->leftJoin('bc_type','stock_master.type_bc','=','bc_type.id')
                    ->leftJoin('unit_type','stock_master.unit','=','unit_type.id')
                    ->leftJoin('curr_type','stock_master.curr','=','curr_type.id')
                    ->leftJoin('stock_type','stock_master.type','=','stock_type.id')
                    ->leftJoin('stock_to','stock_master.to','=','stock_to.id')
                    ->leftJoin('company_master','company_master.code','=','stock_master.code_company')       
                    ->where('stock_master.type','=',1)->where('stock_master.to','=',2)->where('company_master.status','=',1);

        return $this->json($request, $list_columns, $arr_select, $results);
    }

    function bc261($request){
        // $results = DB::table('stock_master')->select('stock_master.no')->leftJoin('company_master','company_master.code','=','stock_master.code_company')->where('stock_master.type','=',2)->where('stock_master.to','=',2)->where('company_master.status','=',2);

        $list_columns = array('stock_master.no','stock_master.date','stock_master.no_bc','stock_master.date_bc','stock_master.type_bc','stock_master.code_mat','stock_master.code_company','stock_master.qty','stock_master.unit','stock_master.price','stock_master.curr','stock_master.no_inv','stock_master.no_po','stock_master.no_so');

        $arr_select = array('stock_master.id','stock_master.date','stock_master.no','stock_master.date_bc','stock_master.no_bc','stock_master.code_mat','stock_master.code_company','stock_master.qty','stock_master.price','stock_master.no_inv','stock_master.no_po','stock_master.no_so','bc_type.name as name_bc','unit_type.name as name_unit','curr_type.name as name_curr','stock_type.name as name_stock','stock_to.name as stock_to');

        $results = DB::table($this->table)
                    ->select($arr_select)
                    ->leftJoin('bc_type','stock_master.type_bc','=','bc_type.id')
                    ->leftJoin('unit_type','stock_master.unit','=','unit_type.id')
                    ->leftJoin('curr_type','stock_master.curr','=','curr_type.id')
                    ->leftJoin('stock_type','stock_master.type','=','stock_type.id')
                    ->leftJoin('stock_to','stock_master.to','=','stock_to.id')
                    ->leftJoin('company_master','company_master.code','=','stock_master.code_company')       
                    ->where('stock_master.type','=',2)->where('stock_master.to','=',2)->where('company_master.status','=',2);

        return $this->json($request, $list_columns, $arr_select, $results);
    }

    function bc262($request){
        // $results = DB::table('stock_master')->select('stock_master.no')->leftJoin('company_master','company_master.code','=','stock_master.code_company')->where('stock_master.type','=',1)->where('stock_master.to','=',2)->where('company_master.status','=',2);

        $list_columns = array('stock_master.no','stock_master.date','stock_master.no_bc','stock_master.date_bc','stock_master.type_bc','stock_master.code_mat','stock_master.code_company','stock_master.qty','stock_master.unit','stock_master.price','stock_master.curr','stock_master.no_inv','stock_master.no_po','stock_master.no_so');

        $arr_select = array('stock_master.id','stock_master.date','stock_master.no','stock_master.date_bc','stock_master.no_bc','stock_master.code_mat','stock_master.code_company','stock_master.qty','stock_master.price','stock_master.no_inv','stock_master.no_po','stock_master.no_so','bc_type.name as name_bc','unit_type.name as name_unit','curr_type.name as name_curr','stock_type.name as name_stock','stock_to.name as stock_to');

        $results = DB::table($this->table)
                    ->select($arr_select)
                    ->leftJoin('bc_type','stock_master.type_bc','=','bc_type.id')
                    ->leftJoin('unit_type','stock_master.unit','=','unit_type.id')
                    ->leftJoin('curr_type','stock_master.curr','=','curr_type.id')
                    ->leftJoin('stock_type','stock_master.type','=','stock_type.id')
                    ->leftJoin('stock_to','stock_master.to','=','stock_to.id')
                    ->leftJoin('company_master','company_master.code','=','stock_master.code_company')       
                    ->where('stock_master.type','=',1)->where('stock_master.to','=',2)->where('company_master.status','=',2);

        return $this->json($request, $list_columns, $arr_select, $results);
    }

    function bc41($request){
        // $results = DB::table('stock_master')->select('stock_master.no')->leftJoin('company_master','company_master.code','=','stock_master.code_company')->where('stock_master.type','=',1)->where('company_master.location','=',2);

        $list_columns = array('stock_master.no','stock_master.date','stock_master.no_bc','stock_master.date_bc','stock_master.type_bc','stock_master.code_mat','stock_master.code_company','stock_master.qty','stock_master.unit','stock_master.price','stock_master.curr','stock_master.no_inv','stock_master.no_po','stock_master.no_so');

        $arr_select = array('stock_master.id','stock_master.date','stock_master.no','stock_master.date_bc','stock_master.no_bc','stock_master.code_mat','stock_master.code_company','stock_master.qty','stock_master.price','stock_master.no_inv','stock_master.no_po','stock_master.no_so','bc_type.name as name_bc','unit_type.name as name_unit','curr_type.name as name_curr','stock_type.name as name_stock','stock_to.name as stock_to');

        $results = DB::table($this->table)
                    ->select($arr_select)
                    ->leftJoin('bc_type','stock_master.type_bc','=','bc_type.id')
                    ->leftJoin('unit_type','stock_master.unit','=','unit_type.id')
                    ->leftJoin('curr_type','stock_master.curr','=','curr_type.id')
                    ->leftJoin('stock_type','stock_master.type','=','stock_type.id')
                    ->leftJoin('stock_to','stock_master.to','=','stock_to.id')
                    ->leftJoin('company_master','company_master.code','=','stock_master.code_company')       
                    ->where('stock_master.type','=',1)->where('company_master.location','=',2);

        return $this->json($request, $list_columns, $arr_select, $results);
    }
}
