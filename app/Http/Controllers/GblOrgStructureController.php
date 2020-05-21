<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GblOrgStructure;
use App\Models\GblAdmissionPoint;
use App\Models\GblAttentionPoint;
use App\Models\GblOrgStructureTr;
use Illuminate\Support\Facades\DB;
use App\Models\GblAdmissionPointTr;
use App\Models\GblAttentionPointTr;

class GblOrgStructureController extends Controller
{
    /**
     * @param $id
     */
    public function delete($id)
    {
        $typesAdmissionAttention = 'gbl_admission_attention_point';

        $data = DB::table($typesAdmissionAttention)
            ->join('gbl_attention_point', "$typesAdmissionAttention.gbl_attention_point_id", '=', 'gbl_attention_point.id')
            ->where("gbl_attention_point.gbl_org_structure_id", '=', "$id")
            ->delete();

        GblAttentionPoint::where('gbl_org_structure_id', $id)->delete();
        GblAdmissionPoint::where('gbl_org_structure_id', $id)->delete();
        GblOrgStructure::destroy($id);

        return response()->json("delete");
    }

    /**
     * @param $id
     */
    public function deleteAdmission($id)
    {
        $typesAdmissionAttention = 'gbl_admission_attention_point';

        $data = DB::table($typesAdmissionAttention)
            ->where("$typesAdmissionAttention.gbl_admission_point_id", '=', "$id")
            ->get();

        foreach ($data as $item) {
            DB::table($typesAdmissionAttention)->where('id', '=', $item->id)->delete();
            GblAttentionPoint::destroy($item->gbl_attention_point_id);
        }

        GblAdmissionPoint::destroy($id);

        return response()->json("delete");
    }

    /**
     * @param $id
     */
    public function deleteAttention($id)
    {
        $typesAdmissionAttention = 'gbl_admission_attention_point';

        $data = DB::table($typesAdmissionAttention)
            ->where("$typesAdmissionAttention.gbl_attention_point_id", '=', "$id")
            ->delete();

        GblAttentionPoint::destroy($id);

        return response()->json("delete");
    }

    /**
     * @param Request $request
     */
    public function edit(Request $request)
    {
        $types = GblOrgStructure::find($request['id']);
        $typestr = GblOrgStructureTr::find($request['id']);

        $types['code'] != $request['code'] ?
        $request->validate(['code' => 'unique:gbl_org_structure']) : "";

        $typestr['name'] != $request['name'] ?
        $request->validate(['name' => 'unique:gbl_org_structure_tr']) : "";

        $request->validate([
            'name' => 'required|max:50',
            'code' => 'required|max:10',
            'description' => 'max:250',
        ]);

        $types->updated_at = NOW();
        $types->gbl_status_id = $request['gbl_status_id'];
        $types->code = $request['code'];
        $types->save();

        $typestr->name = $request['name'];
        $typestr->description = $request['description'];
        $typestr->lang = $request['lang'];
        $typestr->save();

        return $request;
    }

    /**
     * @param Request $request
     */
    public function editAdmission(Request $request)
    {
        $types = GblAdmissionPoint::find($request['id']);
        $typestr = GblAdmissionPointTr::find($request['id']);

        $typestr['name'] != $request['name'] ?
        $request->validate(['name' => 'unique:gbl_admission_point_tr']) : "";

        $request->validate([
            'name' => 'required|max:50',
            'description' => 'max:250',
        ]);

        $types->updated_at = NOW();
        $types->gbl_status_id = $request['gbl_status_id'];
        $types->save();

        $typestr->name = $request['name'];
        $typestr->description = $request['description'];
        $typestr->lang = $request['lang'];
        $typestr->save();

        return $request;
    }

    /**
     * @param Request $request
     */
    public function editAttention(Request $request)
    {
        $types = GblAttentionPoint::find($request['id']);
        $typestr = GblAttentionPointTr::find($request['id']);

        $typestr['name'] != $request['name'] ?
        $request->validate(['name' => 'unique:gbl_attention_point_tr']) : "";

        $request->validate([
            'name' => 'required|max:50',
            'description' => 'max:250',
        ]);

        $types->updated_at = NOW();
        $types->gbl_status_id = $request['gbl_status_id'];
        $types->save();

        $typestr->name = $request['name'];
        $typestr->description = $request['description'];
        $typestr->lang = $request['lang'];
        $typestr->save();

        return $request;
    }

    public function get()
    {
        $types = 'gbl_org_structure';
        $typestr = 'gbl_org_structure_tr';
        $typesadm = 'gbl_admission_point';
        $typesadmtr = 'gbl_admission_point_tr';
        $typesate = 'gbl_attention_point';
        $typesatetr = 'gbl_attention_point_tr';
        $typesadmate = 'gbl_admission_attention_point';
        $typesallow = 'gbl_org_structure_allow';
        $typesaccount = 'gbl_account_user';
        $typesuser = 'gbl_user';
        $typesentity = 'gbl_entity';

        $data =
        DB::table($types)
            ->join($typestr, "$types.id", '=', "$typestr.id")
            ->where("$typestr.lang", '=', 'es_CO')
            ->select("$typestr.*", "$types.code", "$types.created_at", "$types.updated_at", "$types.gbl_status_id")
            ->orderBy('id')
            ->get();

        foreach ($data as $item) {
            $iddata = $item->id;

            $item->admission =
            DB::table($typesadm)
                ->join($typesadmtr, "$typesadm.id", '=', "$typesadmtr.id")
                ->where("$typesadmtr.lang", '=', 'es_CO')
                ->where("$typesadm.gbl_org_structure_id", '=', "$iddata")
                ->select("$typesadmtr.*", "$typesadm.created_at", "$typesadm.updated_at", "$typesadm.gbl_status_id", "$typesadm.gbl_org_structure_id")
                ->orderBy('id')
                ->get();

            foreach ($item->admission as $itemAdm) {
                $iddata = $itemAdm->id;
                $itemAdm->attention =
                DB::table($typesate)
                    ->join($typesatetr, "$typesate.id", '=', "$typesatetr.id")
                    ->join($typesadmate, "$typesate.id", '=', "$typesadmate.gbl_attention_point_id")
                    ->where("$typesatetr.lang", '=', 'es_CO')
                    ->where("$typesadmate.gbl_admission_point_id", '=', "$iddata")
                    ->select("$typesatetr.*", "$typesate.created_at", "$typesate.updated_at", "$typesate.gbl_status_id", "$typesate.gbl_org_structure_id", "$typesadmate.gbl_admission_point_id")
                    ->orderBy('id')
                    ->get();
            }

        }

        foreach ($data as $item) {
            $iddata = $item->id;
            $item->permission =
            DB::table($typesallow)
                ->where('gbl_org_structure_id', $iddata)
                ->join($typesaccount, "$typesallow.gbl_account_user_id", '=', "$typesaccount.id")
                ->join($typesuser, "$typesaccount.gbl_user_id", '=', "$typesuser.id")
                ->join($typesentity, "$typesaccount.gbl_entity_id", '=', "$typesentity.id")
                ->select("$typesuser.id", "$typesuser.username", "$typesentity.id", "$typesentity.entity_name")
                ->get();
        }

        return response()->json($data);
    }

    public function getPermission()
    {
        $typesaccount = 'gbl_account_user';
        $typesuser = 'gbl_user';
        $typesentity = 'gbl_entity';

        $data =
        DB::table($typesaccount)
            ->join($typesuser, "$typesaccount.gbl_user_id", '=', "$typesuser.id")
            ->join($typesentity, "$typesaccount.gbl_entity_id", '=', "$typesentity.id")
            ->select("$typesaccount.id as gbl_account_user_id", "$typesuser.username", "$typesentity.entity_name")
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
            'name' => 'required|max:50|unique:gbl_org_structure_tr',
            'code' => 'required|max:10|unique:gbl_org_structure',
            'description' => 'max:250',
        ]);

        $types = new GblOrgStructure();
        $typestr = new GblOrgStructuretr();

        $types->created_at = NOW();
        $types->updated_at = NOW();
        $types->gbl_status_id = $request['gbl_status_id'];
        $types->gbl_master_account_id = 1;
        $types->code = $request['code'];
        $types->save();

        $typestr->id = $types->id;
        $typestr->name = $request['name'];
        $typestr->description = $request['description'];
        $typestr->lang = $request['lang'];

        $typestr->save();

        $request['id'] = $types->id;

        return $request;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function storeAdmission(Request $request)
    {
        $errors = $request->validate([
            'name' => 'required|max:50|unique:gbl_admission_point_tr',
            'description' => 'max:250',
        ]);

        $types = new GblAdmissionPoint();
        $typestr = new GblAdmissionPointTr();

        $types->created_at = NOW();
        $types->updated_at = NOW();
        $types->gbl_status_id = $request['gbl_status_id'];
        $types->gbl_org_structure_id = $request['gbl_org_structure_id'];
        $types->save();

        $typestr->id = $types->id;
        $typestr->name = $request['name'];
        $typestr->description = $request['description'];
        $typestr->lang = $request['lang'];
        $typestr->save();

        $request['id'] = $types->id;

        return $request;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function storeAttention(Request $request)
    {
        $errors = $request->validate([
            'name' => 'required|max:50|unique:gbl_attention_point_tr',
            'description' => 'max:250',
        ]);

        $types = new GblAttentionPoint();
        $typestr = new GblAttentionPointTr();
        $typesAdmAtt = 'gbl_admission_attention_point';

        $types->created_at = NOW();
        $types->updated_at = NOW();
        $types->gbl_org_structure_id = $request['gbl_org_structure_id'];
        $types->gbl_status_id = $request['gbl_status_id'];
        $types->gbl_attention_point_type_id = 1;
        $types->save();

        $typestr->id = $types->id;
        $typestr->name = $request['name'];
        $typestr->description = $request['description'];
        $typestr->lang = $request['lang'];
        $typestr->save();

        $request['id'] = $types->id;

        DB::table($typesAdmAtt)->insert([
            'gbl_admission_point_id' => $request['gbl_admission_point_id'],
            'gbl_attention_point_id' => $types->id,
            'gbl_status_id' => 1,
        ]);

        return $request;
    }

}
