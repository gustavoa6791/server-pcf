<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SsoGroupProfileType;
use App\Models\SsoGroupProfileTypeTr;

class SsoGroupProfileTypeController extends Controller
{
    /**
     * @param $id
     */
    public function delete($id)
    {
        SsoGroupProfileTypetr::destroy($id);
        SsoGroupProfileType::destroy($id);

        return response()->json("delete");
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function edit(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'description' => 'required|max:255',

        ]);

        $typestr = SsoGroupProfileTypetr::find($request['id']);
        $types = SsoGroupProfileType::find($request['id']);

        $types->gbl_status_id = $request['status_description'] == 'Activo' ? 1 : 0;
        $types->updated_at = NOW();
        $types->save();

        $typestr->name = $request['name'];
        $typestr->description = $request['description'];
        $typestr->lang = $request['lang'];
        $typestr->save();

        $typestr->status_description = $request['status_description'];

        return $request;
    }

    public function get()
    {
        $types = 'sso_group_profile_types';
        $typestr = 'sso_group_profile_type_trs';
        $status = 'gbl_status';
        $statustr = 'gbl_status_tr';
        $data =
        DB::table($types)
            ->join($typestr, "$types.id", '=', "$typestr.id")
            ->join($status, "$status.id", '=', "$types.gbl_status_id")
            ->join($statustr, "$status.id", '=', "$statustr.id")
            ->select("$typestr.*", "$types.created_at", "$types.updated_at", "$statustr.status_description")
            ->get();

        return response()->json($data);
    }

    public function index()
    {
        return view('welcome');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $errors = $request->validate([
            'name' => 'required|max:50|unique:sso_group_profile_type_trs',
            'description' => 'required|max:255',

        ]);

        $types = new SsoGroupProfileType();
        $typestr = new SsoGroupProfileTypetr();

        $types->created_at = NOW();
        $types->updated_at = NOW();
        $types->gbl_status_id = $request['status_description'] == 'Activo' ? 1 : 0;
        $types->created_by = 1;
        $types->save();

        $typestr->id = $types->id;
        $typestr->name = $request['name'];
        $typestr->description = $request['description'];
        $typestr->lang = $request['lang'];

        $typestr->save();

        $typestr->status_description = $request['status_description'];

        return $typestr;
    }
}
