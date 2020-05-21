<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchAttentionType;
use App\Models\SchAttentionTypeTr;
use Illuminate\Support\Facades\DB;

class SchAttentionTypeController extends Controller
{
    /**
     * @param $id
     */
    public function delete($id)
    {
        $typesAttentionService = 'sch_attention_type_service';

        DB::table($typesAttentionService)
            ->where("$typesAttentionService.sch_attention_type_id", '=', "$id")
            ->delete();

        SchAttentionTypetr::destroy($id);
        SchAttentionType::destroy($id);

        return response()->json("delete");

    }

    /**
     * @param $id
     */
    public function deleteService($id)
    {
        $typesAttentionService = 'sch_attention_type_service';

        DB::table($typesAttentionService)
            ->where("$typesAttentionService.id", '=', "$id")
            ->delete();

        return response()->json("delete");

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function edit(Request $request)
    {
        $typestr = SchAttentionTypetr::find($request['id']);
        $types = SchAttentionType::find($request['id']);

        $typestr['description'] != $request['description'] ?
        $request->validate(['description' => 'unique:sch_attention_type_tr']) : "";

        $request->validate([
            'description' => 'required|max:250',
        ]);

        $types->updated_at = NOW();
        $types->gbl_status_id = $request['gbl_status_id'];
        $types->template_id = $request['template']['id'];
        $types->save();

        $typestr->description = $request['description'];
        $typestr->information_text = $request['information_text'];
        $typestr->lang = $request['lang'];
        $typestr->save();

        return $request;
    }

    /**
     * @param $id
     */
    public function find($id)
    {
        $types = 'sch_attention_type';
        $typestr = 'sch_attention_type_tr';

        $typesAttentionService = 'sch_attention_type_service';
        $typesService = 'cnt_service_catalog_item';
        $typestemplate = 'ehr_template_vr';
        $typestemplatetr = 'ehr_template_vr_tr';

        $data =
        DB::table($types)
            ->join($typestr, "$types.id", '=', "$typestr.id")
            ->where("$types.sch_slot_type_id", '=', "$id")
            ->where("$typestr.lang", '=', 'es_CO')
            ->select("$typestr.*",
                "$types.created_at",
                "$types.updated_at",
                "$types.gbl_status_id",
                "$types.template_id"
            )
            ->get();

        foreach ($data as $item) {
            $iddata = $item->id;
            $idtemplate = $item->template_id;
            $item->services =
            DB::table($typesAttentionService)
                ->join($typesService, "$typesAttentionService.cnt_service_catalog_item_id", '=', "$typesService.id")
                ->where("$typesAttentionService.sch_attention_type_id", '=', "$iddata")
                ->select(
                    "$typesAttentionService.id",
                    "$typesService.code",
                    "$typesService.description",
                )
                ->get();
            $template =
            DB::table($typestemplate)
                ->join($typestemplatetr, "$typestemplate.id", '=', "$typestemplatetr.id")
                ->where("$typestemplate.id", '=', "$idtemplate")
                ->select(
                    "$typestemplate.id",
                    "$typestemplatetr.title",
                    "$typestemplatetr.description",
                )
                ->get();

            $item->template = $template[0];
        }

        return response()->json($data);
    }

    public function getService()
    {
        $typesService = 'cnt_service_catalog_item';

        $data =
        DB::table($typesService)
            ->select(
                "$typesService.id",
                "$typesService.code",
                "$typesService.description",
            )
            ->orderBy('id')->get();

        return response()->json($data);

    }

    public function getTemplate()
    {
        $types = 'ehr_template_vr';
        $typestr = 'ehr_template_vr_tr';
        $typesgbl = 'gbl_ehr_template';
        $typesgroup = 'ehr_group_template';
        $typesimages = 'ehr_template_vr_images';

        $data =
        DB::table($types)
            ->join($typestr, "$types.id", "=", "$typestr.id")
            ->leftJoin($typesgbl, "$types.id", "=", "$typesgbl.ehr_template_vr_id")
            ->leftJoin($typesgroup, "$typesgbl.ehr_group_template_id", "=", "$typesgroup.id")
            ->select(
                "$types.id",
                "$typestr.title",
                "$typestr.description",
                "$typesgroup.name",
            )->orderBy('id')->get();

        foreach ($data as $item) {
            $iddata = $item->id;
            $item->images =
            DB::table($typesimages)
                ->where("$typesimages.ehr_template_vr_id", '=', "$iddata")
                ->select(
                    "$typesimages.id",
                    "$typesimages.pic_default",
                    "$typesimages.picture",
                )
                ->orderBy('pic_default', 'DESC')->get();
        }

        return response()->json($data);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $types = new SchAttentionType();
        $typestr = new SchAttentionTypetr();

        $request->validate([
            'description' => 'required|max:250|unique:sch_attention_type_tr',
        ]);

        $types->created_at = NOW();
        $types->updated_at = NOW();
        $types->gbl_status_id = $request['gbl_status_id'];
        $types->template_id = $request['template']['id'];
        $types->sch_slot_type_id = $request['idSlot'];
        $types->is_default = true;
        $types->contrib_type_id = "AMB";
        $types->reserve = false;
        $types->save();

        $typestr->id = $types->id;
        $typestr->description = $request['description'];
        $typestr->information_text = $request['information_text'];
        $typestr->lang = $request['lang'];
        $typestr->save();

        $request['id'] = $types->id;
        $request['services'] = [];

        return $request;
    }

    /**
     * @param $id
     * @param Request $request
     */
    public function updateService(
        $id,
        Request $request
    ) {
        $typesAttentionService = 'sch_attention_type_service';
        $typesService = 'cnt_service_catalog_item';

        foreach ($request->services as $item) {
            DB::table($typesAttentionService)
                ->insert([
                    'sch_attention_type_id' => $id,
                    'cnt_service_catalog_item_id' => $item['id'],
                    'gbl_status_id' => "1",
                    'created_at' => NOW(),
                    'updated_at' => NOW(),
                    'created_by' => "1",
                ]);
        }

        $data = [$id, $request->services];

        return $data;

    }

}
