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
    public function deleteService($id)
    {
        $typesAttentionService = 'sch_attention_type_service';

        DB::table($typesAttentionService)
            ->where("$typesAttentionService.id", '=', "$id")
            ->delete();

        return response()->json("delete");

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

        $data =
            json_decode(DB::table($types)
                ->join($typestr, "$types.id", '=', "$typestr.id")
                ->where("$types.sch_slot_type_id", '=', "$id")
                ->where("$typestr.lang", '=', 'es_CO')
                ->select("$typestr.*",
                    "$types.created_at",
                    "$types.updated_at",
                    "$types.gbl_status_id",
                )
                ->get()->toJson(), true);

        for ($i = 0; $i < count($data); $i++) {
            $iddata = $data[$i]['id'];
            $data[$i]['services'] =
            DB::table($typesAttentionService)
                ->join($typesService, "$typesAttentionService.cnt_service_catalog_item_id", '=', "$typesService.id")
                ->where("$typesAttentionService.sch_attention_type_id", '=', "$iddata")
                ->select(
                    "$typesAttentionService.id",
                    "$typesService.code",
                    "$typesService.description",
                )
                ->get();
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
            ->get();

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

        $types->created_at = NOW();
        $types->updated_at = NOW();
        $types->gbl_status_id = $request['gbl_status_id'];
        $types->sch_slot_type_id = $request['idSlot'];
        $types->is_default = true;
        $types->template_id = "1";
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

        for ($i = 0; $i < count($request['services']); $i++) {
            DB::table($typesAttentionService)
                ->insert([
                    'sch_attention_type_id' => $id,
                    'cnt_service_catalog_item_id' => $request['services'][$i]['id'],
                    'gbl_status_id' => "1",
                    'created_at' => NOW(),
                    'updated_at' => NOW(),
                    'created_by' => "1",

                ]);
        }

        $data = [$id, $request['services']];

        return $data;

    }

}
