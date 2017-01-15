<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use DateTime;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
	protected $table = 'stock_master';

	public function index(Request $request, $type){

		$data = (count($request->input()) != 0)?$request->input():'';

		$object = (object) $data;

		if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
			foreach ($data['id'] as $id) {
				if ($data['customActionName'] == 'delete') {
					$this->destroy($id);
				}
			}
			$customActionStatus = "OK";
			$customActionMessage = "Deleted successfully has been completed. Well done!";
		}

		
		$order = $data['order'][0];

		if ($type == 1) {
			$list_columns = array('stock_master.no','stock_master.date','stock_master.no_bc','stock_master.date_bc','stock_master.type_bc','stock_master.code_mat','stock_master.code_company','stock_master.qty','stock_master.unit','stock_master.price','stock_master.curr','stock_master.no_inv','stock_master.no_po','stock_master.no_so');

			$arr_select = array('stock_master.id','stock_master.date','stock_master.no','stock_master.date_bc','stock_master.no_bc','stock_master.code_mat','stock_master.code_company','stock_master.qty','stock_master.price','stock_master.no_inv','stock_master.no_po','stock_master.no_so','bc_type.name as name_bc','unit_type.name as name_unit','curr_type.name as name_curr','stock_type.name as name_stock','stock_to.name as stock_to');
		} elseif ($type == 2) {
			$list_columns = array('stock_master.no','stock_master.date','stock_master.no_bc','stock_master.date_bc','stock_master.code_mat','stock_master.code_company','stock_master.qty','stock_master.unit','stock_to.name');

			$arr_select = array('stock_master.id','stock_master.date','stock_master.no','stock_master.date_bc','stock_master.no_bc','stock_master.code_mat','stock_master.code_company','stock_master.qty','unit_type.name as name_unit','stock_to.name as name_to','stock_to.name as stock_to');
		}
		

		

		$results = DB::table($this->table)
					->select($arr_select)
					->leftJoin('bc_type','stock_master.type_bc','=','bc_type.id')
					->leftJoin('unit_type','stock_master.unit','=','unit_type.id')
					->leftJoin('curr_type','stock_master.curr','=','curr_type.id')
					->leftJoin('stock_type','stock_master.type','=','stock_type.id')
					->leftJoin('stock_to','stock_master.to','=','stock_to.id')
					->where('stock_type.id','=',$type);
					
		// results for filtering
		$results = (isset($data['filter_no_transc']) AND $data['filter_no_transc'] != '') ? $results->where('stock_master.no','=',$data['filter_no_transc']) : $results ;

		$iTotalRecords = $results->count();

		// results for ordering
		$results = (isset($order['column']) AND $order['column'] <= count($list_columns)) ? $results->orderBy($list_columns[$order['column']-1],$order['dir']) : $results ;

		// var_dump($list_columns[$order['column']-1]);


		$iDisplayLength = intval($_REQUEST['length']);
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
		$iDisplayStart = intval($_REQUEST['start']);
		$sEcho = intval($_REQUEST['draw']);

		$records = array();
		$records["data"] = array(); 
		foreach ($results->skip($iDisplayStart)->take($iDisplayLength)->get() as $result) {
			if ($type == 1) {

				$records["data"][] =  array(
					'<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline"><input name="id[]" type="checkbox" class="checkboxes" value="'.$result->id.'"/><span></span></label>',
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
					'<span class="ccol-xs-12 col-sm-12 col-md-12 text-center"> 
						<a href="javascript:;" class="btn btn-sm default edit-datatable" data-action="get" data-controller="stock/'.$type.'" data-code="'.$result->id.'"> Edit
		                    <i class="fa fa-edit"></i>
		                </a>
						<a href="javascript:;" class="btn btn-sm red delete-datatable" data-toggle="confirmation" data-popout="true" data-original-title="Are you sure ?" title="" data-controller="stock/'.$type.'" data-action="delete" data-code="'.$result->id.'"> Delete
		                    <i class="fa fa-remove"></i>
		                </a>
	                 </span>',
					);

			} elseif ($type == 2) {
				$records["data"][] =  array(
					'<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline"><input name="id[]" type="checkbox" class="checkboxes" value="'.$result->id.'"/><span></span></label>',
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
					$result->name_to,
					'<span class="ccol-xs-12 col-sm-12 col-md-12 text-center"> 
						<a href="javascript:;" class="btn btn-sm default edit-datatable" data-action="get" data-controller="stock/'.$type.'" data-code="'.$result->id.'"> Edit
		                    <i class="fa fa-edit"></i>
		                </a>
						<a href="javascript:;" class="btn btn-sm red delete-datatable" data-toggle="confirmation" data-popout="true" data-original-title="Are you sure ?" title="" data-controller="stock/'.$type.'" data-action="delete" data-code="'.$result->id.'"> Delete
		                    <i class="fa fa-remove"></i>
		                </a>
	                 </span>',
					);
			}
			
			
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


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request,$type)
	{
		//
		$records = array();

		$data = (count($request->input()) != 0)?$request->input():'';

		$object = (object) $request->input();

		$no = (isset($object->no_transc)) ? $object->no_transc : '' ;
		$date = (isset($object->date_transc)) ? $object->date_transc : '' ;
		$no_bc = (isset($object->no_bc)) ? $object->no_bc : '' ;
		$date_bc = (isset($object->date_bc)) ? $object->date_bc : '' ;
		$code_mat = (isset($object->code_mat)) ? $object->code_mat : '' ;
		$code_company = (isset($object->code_comp)) ? $object->code_comp : '' ;
		$qty = (isset($object->qty)) ? $object->qty : '' ;
		$unit = (isset($object->unit_type)) ? $object->unit_type : '' ;
		$price = (isset($object->price)) ? $object->price : '' ;
		$curr = (isset($object->curr_type)) ? $object->curr_type : '' ;
		$no_inv = (isset($object->no_inv)) ? $object->no_inv : '' ;
		$no_po = (isset($object->no_po)) ? $object->no_po : '' ;
		$no_so = (isset($object->no_so)) ? $object->no_so : '' ;
		$to = (isset($object->stock_to)) ? $object->stock_to : '' ;

		if ($object->no_transc != '') {
			$result = DB::table('stock_master')->insert(array(
						'no' => $no,
						'date' => $date,
						'no_bc' => $no_bc,
						'date_bc' => $date_bc,
						'code_mat' => $code_mat,
						'code_company' => $code_company,
						'qty' => $qty,
						'unit' => $unit,
						'price' => $price,
						'curr' => $curr,
						'no_inv' => $no_inv,
						'no_po' => $no_po,
						'no_so' => $no_so,
						'to' => $to,
						'type' => $type,
						'created_at' => new datetime()
						));
  		}

  		if ($result) {
			$records['status'] = 1;
		} else {
			$records['status'] = 0;
		}

		return response()->json($records);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($type,$id)
	{
		/*if ($type == 1) {
			$arr_select = array('no',DB::raw("DATE_FORMAT(stock_master.date, '%Y-%m-%d') AS date_format"),'no_bc',DB::raw("DATE_FORMAT(stock_master.date_bc, '%Y-%m-%d') AS date_bc_format"),'code_mat','code_company','qty','unit','price','curr','no_inv','no_po','no_so');
		} elseif ($type == 2) {
			$arr_select = array('no',DB::raw("DATE_FORMAT(stock_master.date, '%Y-%m-%d') AS date_format"),'no_bc',DB::raw("DATE_FORMAT(stock_master.date_bc, '%Y-%m-%d') AS date_bc_format"),'code_mat','code_company','qty','unit','to');
		}*/

		if ($type == 1) {
			$arr_select = array('no','stock_master.date','no_bc','stock_master.date_bc','code_mat','code_company','qty','unit','price','curr','no_inv','no_po','no_so');
		} elseif ($type == 2) {
			$arr_select = array('no','stock_master.date','no_bc','stock_master.date_bc','code_mat','code_company','qty','unit','to');
		}

		$results = DB::table('stock_master')
					->select($arr_select)
					->where('id','=' , $id)
					->first();

		$results->date = date('Y-m-d',strtotime($results->date));
		$results->date_bc = date('Y-m-d',strtotime($results->date_bc));

		return response()->json($results);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request,$type,$id)
	{
		//
		$data = (count($request->input()) != 0)?$request->input():'';

		$object = (object) $data;

		// dump($object);
		// dump($data);


		$no = (isset($object->no_transc)) ? $object->no_transc : '' ;
		$date = (isset($object->date_transc)) ? $object->date_transc : '' ;
		$no_bc = (isset($object->no_bc)) ? $object->no_bc : '' ;
		$date_bc = (isset($object->date_bc)) ? $object->date_bc : '' ;
		$code_mat = (isset($object->code_mat)) ? $object->code_mat : '' ;
		$code_company = (isset($object->code_comp)) ? $object->code_comp : '' ;
		$qty = (isset($object->qty)) ? $object->qty : '' ;
		$unit = (isset($object->unit_type)) ? $object->unit_type : '' ;
		$price = (isset($object->price)) ? $object->price : '' ;
		$curr = (isset($object->curr_type)) ? $object->curr_type : '' ;
		$no_inv = (isset($object->no_inv)) ? $object->no_inv : '' ;
		$no_po = (isset($object->no_po)) ? $object->no_po : '' ;
		$no_so = (isset($object->no_so)) ? $object->no_so : '' ;
		$to = (isset($object->stock_to)) ? $object->stock_to : '' ;

		// $set = (!$to) ? array('date' => $date,'no_bc' => $no_bc,'date_bc' => $date_bc,'code_mat' => $code_mat,'code_company' => $code_company,'qty' => $qty,'unit' => $unit,'type' => $type) : array('date' => $date,'no_bc' => $no_bc,'date_bc' => $date_bc,'code_mat' => $code_mat,'code_company' => $code_company,'qty' => $qty,'unit' => $unit,'to' => $to,'type' => $type) ;
		// 
		// 
		// dump($type);
		if ($type == 1) {
			$set = array('date' => $date,'no_bc' => $no_bc,'date_bc' => $date_bc,'code_mat' => $code_mat,'code_company' => $code_company,'qty' => $qty,'unit' => $unit,'type' => $type,'price'=>$price,'curr'=>$curr,'no_inv'=>$no_inv,'no_po'=>$no_po,'no_so'=>$no_so);
			
		} elseif ($type == 2) {
			
			$set = array('date' => $date,'no_bc' => $no_bc,'date_bc' => $date_bc,'code_mat' => $code_mat,'code_company' => $code_company,'qty' => $qty,'unit' => $unit,'type' => $type,'to' => $to);
		}

		$result = DB::table('stock_master')
					->where('no','=',$id)
					->update($set);

		if ($result) {
			$records['status'] = 1;
		} else {
			$records['status'] = 0;
		}

		return response()->json($records);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($type,$id)
	{
		//
		$records = array();

		$delete = DB::table('stock_master')->where('id', '=', $id)->delete();

		if ($delete) {
			$records['status'] = 1;
			$records['toastr'] = array('type'=>'success','message'=>'Data his Deleted.');
		} else {
			$records['status'] = 0;
			$records['toastr'] = array('type'=>'error','message'=>'Data failed to Delete.');
		}

		return response()->json($records);
	}
}
