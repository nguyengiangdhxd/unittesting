<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Exceptions\HttpResponseException as Exception;

class UserController extends Controller{
	/**
	* function for create user
	* @param $request
	* retun json
	**/
	public function create(Request $request){
		try{
			$rules = [
		        'name' => 'required|max:50',
		        'mobile_no' => 'required|numeric|digits_between:10,15'
		    ];
		    /**
		    * Perform validation
		    **/
		    $validator = Validator::make($request->all(), $rules);
		    /**
		    * If validation fails and return error response
		    * else perform user creation operation
		    **/
		    if($validator->fails()) {
		    	return $this->jsonResponse('error', 'Validation Field', null, $validator->errors(), 422);
			}else {
		    	$name = isset($request->name) ? $request->name : '';
				$mobile_no = isset($request->mobile_no) ? $request->mobile_no : '';
				$user = User::create(['name'=> $name, 'mobile_no' => $mobile_no]);
				/**
				* return success json response after user created successfully
				**/
				return $this->jsonResponse('success', 'User Successfuly Registered', $user, null, 200);
			}    
		}catch ( \Illuminate\Database\QueryException $e) {
			app('log')->info(print_r($e->getMessage(),1));	
   			return $this->jsonResponse('error', 'Database Related Issue', null, null, 400);
   		}catch(\Exception $e){
   			app('log')->info(print_r($e->getMessage(),1));
   			return $this->jsonResponse('error', 'Error while saving the data', null, null, 400);
		} 
	}
	/**
	* Form the jsonReponse
	* @param status, message, data, error and statusCode
	* return json
	**/
	public function jsonResponse($status, $message, $data, $error, $statusCode){
		return response()->json(['status'=>$status,'message'=> $message,'data' =>$data,'error'=> $error,'code'=> $statusCode]);
	}
}
?>