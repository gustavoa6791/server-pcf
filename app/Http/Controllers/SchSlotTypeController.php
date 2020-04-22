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
    public function delete($id)
    {
        $typesrm = 'sch_slot_type_reminder';
        $typesAttention = 'sch_attention_type';
        $typesAttentionTr = 'sch_attention_type_tr';
        $typesAttentionServices = 'sch_attention_type_service';

        DB::table($typesrm)
            ->where("$typesrm.id", '=', "$id")
            ->delete();
        DB::table($typesAttentionTr)
            ->join("$typesAttention", "$typesAttentionTr.id", '=', "$typesAttention.id")
            ->where("$typesAttention.sch_slot_type_id", '=', "$id")
            ->delete();
        DB::table($typesAttentionServices)
            ->join("$typesAttention", "$typesAttentionServices.sch_attention_type_id", '=', "$typesAttention.id")
            ->where("$typesAttention.sch_slot_type_id", '=', "$id")
            ->delete();
        DB::table($typesAttention)
            ->where("$typesAttention.sch_slot_type_id", '=', "$id")
            ->delete();

        SchSlotTypetr::destroy($id);
        SchSlotType::destroy($id);

        return response()->json("delete");

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function edit(Request $request)
    {
        // $request->validate([
        //     'name' => 'required|max:50',
        //     'description' => 'required|max:255',

        // ]);

        $typestr = SchSlotTypetr::find($request['id']);
        $types = SchSlotType::find($request['id']);
        $typesrm = 'sch_slot_type_reminder';

        $types->updated_at = NOW();
        $types->gbl_status_id = $request['gbl_status_id'];
        $types->code = $request['code'];
        $types->duration_default = $request['duration_default'];
        $types->max_assign_allow = (int) $request['max_assign_allow'];
        $types->is_multiple_slot = true;
        $types->location_required = true;
        $types->gbl_master_account_id = 1;
        $types->save();

        $typestr->short_name = "PCF";
        $typestr->description = $request['description'];
        $typestr->lang = $request['lang'];
        $typestr->save();

        DB::table($typesrm)
            ->where('id', $request['id'])
            ->update([
                'reminder_email' => $request['reminder_email'],
            ]
            );

        $typestr->gbl_status_id = $request['gbl_status_id'];
        $typestr->duration_default = $request['duration_default'];
        $typestr->max_assign_allow = (int) $request['max_assign_allow'];
        $typestr->code = $request['code'];
        $typestr->reminder_email = $request['reminder_email'];

        return $typestr;
    }

    /**
     * @param $id
     */
    public function find($id)
    {
        $types = 'sch_slot_type';
        $typestr = 'sch_slot_type_tr';
        $typesrm = 'sch_slot_type_reminder';
        $typesplan = 'cnt_plan';
        $typesgbl = 'gbl_entity';

        $data =
        DB::table($types)
            ->join($typestr, "$types.id", '=', "$typestr.id")
            ->join($typesrm, "$types.id", '=', "$typesrm.id")
            ->leftJoin($typesplan, "$types.cnt_plan_default_id", '=', "$typesplan.id")
            ->leftJoin($typesgbl, "$typesplan.cnt_insurance_entity_id", '=', "$typesgbl.id")
            ->where("$types.id", '=', "$id")
            ->where("$typestr.lang", '=', 'es_CO')
            ->select("$typestr.*",
                "$types.created_at",
                "$types.updated_at",
                "$types.gbl_status_id",
                "$types.code",
                "$types.max_assign_allow",
                "$types.duration_default",
                "$types.limit_attention",
                "$typesrm.reminder_email",
                "$typesplan.plan_name",
                "$typesgbl.entity_name",
            )
            ->get();

        return response()->json($data);
    }

    public function get()
    {
        $types = 'sch_slot_type';
        $typestr = 'sch_slot_type_tr';
        $typesrm = 'sch_slot_type_reminder';
        $typesplan = 'cnt_plan';
        $typesgbl = 'gbl_entity';

        $data =
        DB::table($types)
            ->join($typestr, "$types.id", '=', "$typestr.id")
            ->join($typesrm, "$types.id", '=', "$typesrm.id")
            ->leftJoin($typesplan, "$types.cnt_plan_default_id", '=', "$typesplan.id")
            ->leftJoin($typesgbl, "$typesplan.cnt_insurance_entity_id", '=', "$typesgbl.id")
            ->where("$typestr.lang", '=', 'es_CO')
            ->select("$typestr.*",
                "$types.created_at",
                "$types.updated_at",
                "$types.gbl_status_id",
                "$types.code",
                "$types.max_assign_allow",
                "$types.duration_default",
                "$types.limit_attention",
                "$typesrm.reminder_email",
                "$typesplan.plan_name",
                "$typesgbl.entity_name",

            )
            ->orderBy('id')->get();

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
        $typesrm = 'sch_slot_type_reminder';

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

        DB::table($typesrm)
            ->insert([
                'reminder_email' => $request['reminder_email'],
                'id' => $types->id,
            ]
            );

        $request['id'] = $types->id;

        return $request;
    }
}
