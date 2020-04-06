<?php

namespace App\Http\Controllers;

use App\Models\SsoGroupProfileType;
use App\Models\SsoGroupProfileTypeTr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SsoGroupProfileTypeController extends Controller
{

 
  public function index()
  {
    return view('welcome');
  }

  public function get()
  {
    $types = 'sso_group_profile_types';
    $typestr = 'sso_group_profile_type_trs';
    $data =
      DB::table($types)
      ->join($typestr, "$types.id", '=', "$typestr.id")
      ->select( "$typestr.*", "$types.created_at" ,"$types.updated_at")
      ->get();
    return response()->json($data);
  }

  public function store(Request $request)
  {
     $errors = $request->validate([
        'name'=>'required|max:50|unique:sso_group_profile_type_trs' ,
        'description'=>'required|max:255' ,
        'state'=>'required|boolean'
      ]);

      $types = new SsoGroupProfileType();
      $typestr = new SsoGroupProfileTypetr();
  
      $types->created_at = NOW();
      $types->updated_at = NOW();
      $types->gbl_status_id = 1 ; 
      $types->created_by= 1;
      $types->save();
  
      $typestr->id = $types->id;
      $typestr->name = $request['name'];
      $typestr->description = $request['description'];
      $typestr->lang = $request['lang'];
      $typestr->state = $request['state'];
      $typestr->save();
  
      return $typestr;
  }

  public function edit (Request $request)
  {
      $request->validate([
        'name'=>'required|max:50' ,
        'description'=>'required|max:255' ,
        'state'=>'required|boolean'
      ]);

    $typestr = SsoGroupProfileTypetr::find($request['id']);
    $types = SsoGroupProfileType::find($request['id']);

    $types->updated_at = NOW();
    $types->save();

    $typestr->name = $request['name'];
    $typestr->description = $request['description'];
    $typestr->lang = $request['lang'];
    $typestr->state = $request['state'];
    $typestr->save();

    return $request;
  }

  public function delete($id)
  {
    SsoGroupProfileTypetr::destroy($id);
    SsoGroupProfileType::destroy($id);

    return response()->json("delete");
  }
}
