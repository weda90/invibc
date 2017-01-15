<?php

namespace App\Http\Controllers;

/*use Illuminate\Http\Request;

use App\Http\Requests;*/

class ReportController extends Controller
{
    public function index($id){
    	// return 'ok';
    	switch ($id) {
    		case '1':
    			// return $this->bc23();
    			return view('report.bc23');
    			break;
    		case '2':
    			return view('report.bc40');
    			break;
    		case '3':
    			return view('report.bc27o');
    			break;
    		case '4':
    			return view('report.bc27i');
                break;
            case '5':
    			return view('report.bc261');
                break;
            case '6':
    			return view('report.bc262');
                break;
            case '7':
    			return view('report.bc41');
                break;
    		default:
    			return view('report.bc23');
    			break;
    	}
    }
}
