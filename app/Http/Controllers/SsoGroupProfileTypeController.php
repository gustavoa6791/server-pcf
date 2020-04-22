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
        $profile = 'sso_type_group_profile';

        DB::table($profile)
            ->where("$profile.sso_group_profile_type_id", '=', "$id")
            ->delete();

        SsoGroupProfileTypetr::destroy($id);
        SsoGroupProfileType::destroy($id);

        return response()->json("delete");

    }

    /**
     * @param $id
     */
    public function deleteVerify($id)
    {
        $profile = 'sso_type_group_profile';

        $data =
        DB::table($profile)
            ->where("$profile.sso_group_profile_type_id", '=', "$id")
            ->select("$profile.*")
            ->get();

        if (count($data) > 0) {
            foreach ($data as $value) {
                if ($value->gbl_status_id == "1") {
                    return response()->json("perfil.activo");
                }

            }

            return response()->json("perfil.noActivo");
        }

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

        $types->gbl_status_id = $request['gbl_status_id'];
        $types->updated_at = NOW();
        $types->save();

        $typestr->name = $request['name'];
        $typestr->description = $request['description'];
        $typestr->lang = $request['lang'];
        $typestr->save();

        return $request;
    }

    public function get()
    {
        $types = 'sso_group_profile_type';
        $typestr = 'sso_group_profile_type_tr';

        $data =
        DB::table($types)
            ->join($typestr, "$types.id", '=', "$typestr.id")
            ->select("$typestr.*", "$types.created_at", "$types.updated_at", "$types.gbl_status_id")
            ->orderBy('id')
            ->get();

        return response()->json($data);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $errors = $request->validate([
            'name' => 'required|max:50|unique:sso_group_profile_type_tr',
            'description' => 'required|max:255',
        ]);

        $types = new SsoGroupProfileType();
        $typestr = new SsoGroupProfileTypetr();

        $types->created_at = NOW();
        $types->updated_at = NOW();
        $types->gbl_status_id = $request['gbl_status_id'];
        $types->created_by = 1;
        $types->save();

        $typestr->id = $types->id;
        $typestr->name = $request['name'];
        $typestr->description = $request['description'];
        $typestr->lang = $request['lang'];

        $typestr->save();

        $typestr->gbl_status_id = $request['gbl_status_id'];

        return $typestr;
    }

}
