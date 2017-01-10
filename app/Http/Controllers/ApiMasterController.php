<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use DateTime;
use Illuminate\Support\Facades\Auth;

class ApiMasterController extends Controller
{
	// API Master Masterial
	// ==========================================
    public function material_index(Request $request){

    	// dump($request->session()->token());

    	// return 'Api Material Master index.';
    	// 
		$data = (count($request->input()) != 0)?$request->input():'';

		if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
			foreach ($data['id'] as $id) {
				if ($data['customActionName'] == 'delete') {
					$this->material_destroy($id);
				}
			}
			$customActionStatus = "OK";
			$customActionMessage = "Deleted successfully has been completed. Well done!";
		}

		$order = (isset($data['order'][0]))?$data['order'][0]:1;

		$list_columns = array('material_master.code','material_master.name','material_master.color','material_master.size','material_type.name');

		$results = DB::table('material_master')
					->select('material_master.code','material_master.name','material_master.color','material_master.size','material_type.name as name_type')
					->leftJoin('material_type','material_master.type','=','material_type.id');

		// results for filtering
		$results = (isset($data['filter_mat_code']) AND $data['filter_mat_code'] != '') ? $results->where('material_master.code','=',$data['filter_mat_code']) : $results ;

		// results for ordering
		$results = (isset($order['column']) AND $order['column'] <= count($list_columns)) ? $results->orderBy($list_columns[$order['column']-1],$order['dir']) : $results ;

		// results for ajax select2
		$results = (isset($data['q'])) ? $results->where('material_master.code','LIKE','%'.$data['q'].'%'): $results ;


		$iTotalRecords = count($results->get());
		$iDisplayLength = (isset($_REQUEST['length']))?intval($_REQUEST['length']):10;
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
		$iDisplayStart = (isset($_REQUEST['start']))?intval($_REQUEST['start']):0;
		// $iDisplayStart = intval($_REQUEST['start']);
		$sEcho = (isset($_REQUEST['draw']))?intval($_REQUEST['draw']):1;
		// $sEcho = intval($_REQUEST['draw']);

		$records = array();
		$records["data"] = array();
		$records["items"] = array();
		foreach ($results->skip($iDisplayStart)->take($iDisplayLength)->get() as $result) {
			if (!isset($data['q'])) {
				$records["data"][] =  array(
					'<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline"><input name="id[]" type="checkbox" class="checkboxes" value="'.$result->code.'"/><span></span></label>',
					'<a href="javascript:;" class="detail-datatable"> 
						'.$result->code.'
	                </a>',
					$result->name,
					$result->color,
					'<span class="pull-right">'.number_format($result->size, 0, ',', '.').'</span>',
					$result->name_type,

					'<span class="ccol-xs-12 col-sm-12 col-md-12 text-center"> 
						<a href="javascript:;" class="btn btn-sm default edit-datatable" data-action="get" data-controller="material" data-code="'.$result->code.'"> Edit
		                    <i class="fa fa-edit"></i>
		                </a>
						<a href="javascript:;" class="btn btn-sm red delete-datatable" data-toggle="confirmation" data-popout="true" data-original-title="Are you sure ?" title="" data-controller="material" data-action="delete" data-code="'.$result->code.'"> Delete
		                    <i class="fa fa-remove"></i>
		                </a>
	                 </span>',
					);			
			} else {
				$records["items"][] = array('id'=> $result->code, 'text'=>$result->code);
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

    public function material_show($code){
    	$results = DB::table('material_master')
					->select('code', 'name', 'color', 'size', 'type')
					->where('code','=' , $code)
					->first();

		return response()->json($results);
    }

    public function material_store(Request $request){
    	$records = array();

  		$data = $request->input();

  		// dump(DateTime());

		// $object = (object) Input::all();

  		if ($data['code'] != '' AND $data['name'] != '' AND $data['type'] != '') {
			$result = DB::table('material_master')->insert(array(
						'code' => $data['code'],
						'name' => $data['name'],
						'color' => $data['color'],
						'size' => $data['size'],
						'type' => $data['type'],
						'created_by' => Auth::user()->username,
						'created_at' => new DateTime()
						));
  		}
		
		if ($result) {
			$records['status'] = 1;
		} else {
			$records['status'] = 0;
		}

		return response()->json($records);
    }

    public function material_update(Request $request, $code){
    	
  		$data = $request->input();

  		$records = array();

		$update = DB::table('material_master')
					->where('code','=',$code)
					->update(array(
						'name'=>$data['name'],
						'color'=> $data['color'],
						'size' => $data['size'],
						'type' => $data['type'],
						));

		if ($update) {
			$records['status'] = 1;
		} else {
			$records['status'] = 0;
		}

		return response()->json($records);

    }

    public function material_destroy($code){
    	// return 'Api Material Master destroy.';
    	$records = array();

		$delete = DB::table('material_master')->where('code', '=', $code)->delete();

		if ($delete) {
			$records['status'] = 1;
			$records['toastr'] = array('type'=>'success','message'=>'Data his Deleted.');
		} else {
			$records['status'] = 0;
			$records['toastr'] = array('type'=>'error','message'=>'Data failed to Delete.');
		}

		return response()->json($records);
    }

    

    // API Master Company
    // =============================================
    public function company(Request $request){
    	return 'Api company Master.';
    }
}
