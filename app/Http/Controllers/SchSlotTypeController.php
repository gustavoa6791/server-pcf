<?php
namespace App\Http\Controllers;

use App\Models\SchSlotType;
use Illuminate\Http\Request;
use App\Models\SchSlotTypeTr;
use Illuminate\Support\Facades\DB;

class SchSlotTypeController extends Controller
{
    /**
     * @param $id
     */
    public function find($id)
    {
        $types = 'sch_slot_type';
        $typestr = 'sch_slot_type_tr';

        $data =
        DB::table($types)
            ->join($typestr, "$types.id", '=', "$typestr.id")
            ->where("$types.id", '=', "$id")
            ->where("$typestr.lang", '=', 'es_CO')
            ->select("$typestr.*",
                "$types.created_at",
                "$types.updated_at",
                "$types.gbl_status_id",
                "$types.code",
                "$types.max_assign_allow",
                "$types.duration_default")
            ->get();

        return response()->json($data);
    }

    public function get()
    {
        $types = 'sch_slot_type';
        $typestr = 'sch_slot_type_tr';

        $data =
        DB::table($types)
            ->join($typestr, "$types.id", '=', "$typestr.id")
            ->where("$typestr.lang", '=', 'es_CO')
            ->select("$typestr.*",
                "$types.created_at",
                "$types.updated_at",
                "$types.gbl_status_id",
                "$types.code",
                "$types.max_assign_allow",
                "$types.duration_default")
            ->get();

        return response()->json($data);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        // $errors = $request->validate([
        //     'name' => 'required|max:50|unique:sso_group_profile_type_tr',
        //     'description' => 'required|max:255',
        // ]);

        $types = new SchSlotType();
        $typestr = new SchSlotTypetr();

        $types->created_at = NOW();
        $types->updated_at = NOW();
        $types->gbl_status_id = $request['gbl_status_id'];
        $types->code = $request['code'];
        $types->duration_default = $request['duration_default'];
        $types->max_assign_allow = (int) $request['max_assign_allow'];
        $types->is_multiple_slot = true;
        $types->location_required = true;
        $types->gbl_master_account_id = 1;
        $types->save();

        $typestr->id = $types->id;
        $typestr->short_name = "PCF";
        $typestr->description = $request['description'];
        $typestr->lang = $request['lang'];
        $typestr->save();

        $typestr->gbl_status_id = $request['gbl_status_id'];
        $typestr->duration_default = $request['duration_default'];
        $typestr->max_assign_allow = (int) $request['max_assign_allow'];
        $typestr->code = $request['code'];

        return $typestr;
    }
}
