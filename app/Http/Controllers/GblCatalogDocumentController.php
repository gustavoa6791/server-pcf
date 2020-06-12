<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GblCatalogDocument;
use Illuminate\Support\Facades\DB;
use App\Models\GblCatalogDocumentTr;
use App\Models\GblCatalogDocumentPrint;

class GblCatalogDocumentController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function edit(Request $request)
    {
        $typestr = SsoGroupProfileTypetr::find($request['id']);
        $types = SsoGroupProfileType::find($request['id']);

        $typestr['name'] != $request['name'] ?
        $request->validate(['name' => 'unique:sso_group_profile_type_tr']) : "";

        $request->validate([
            'name' => 'required|max:50',
            'description' => 'max:255',
        ]);

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
        $types = "gbl_catalog_document";
        $typestr = "gbl_catalog_document_tr";
        $typestype = "gbl_document_type";
        $typestypetr = "gbl_document_type_tr";
        $typesprint = "gbl_catalog_document_print";

        $data =
        DB::table($types)
            ->join($typestr, "$types.id", "=", "$typestr.id")
            ->where("$typestr.lang", "es_CO")
            ->join($typestype, "$types.gbl_document_type_id", "=", "$typestype.id")
            ->join($typestypetr, "$typestype.id", "=", "$typestypetr.id")
            ->where("$typestypetr.lang", "es_CO")
            ->join($typesprint, "$types.id", "=", "$typesprint.id")
            ->select(
                "$typestr.*",
                "$types.prefix",
                "$types.suffix",
                "$types.gbl_document_type_id",
                "$types.gbl_status_id",
                "$types.created_at",
                "$types.updated_at",
                "$types.num_digits",
                "$typestypetr.name as gbl_document_type_name",
                "$typesprint.type",
                "$typesprint.method",
            )
            ->orderBy('id')
            ->get();

        return response()->json($data);
    }

    public function getDocumentType()
    {
        $typestype = "gbl_document_type";
        $typestypetr = "gbl_document_type_tr";

        $data =
        DB::table($typestype)
            ->join($typestypetr, "$typestype.id", "=", "$typestypetr.id")
            ->where("$typestypetr.lang", "es_CO")
            ->select(
                "$typestypetr.id as gbl_document_type_id",
                "$typestypetr.name as gbl_document_type_name",
            )
            ->orderBy('gbl_document_type_id')
            ->get();

        return response()->json($data);

    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        $errors = $request->validate([

        ]);

        $types = new GblCatalogDocument();
        $typestr = new GblCatalogDocumentTr();
        $typesprint = new GblCatalogDocumentPrint();

        $types->created_at = NOW();
        $types->updated_at = NOW();
        $types->created_by = 1;
        $types->gbl_master_account_id = 1;
        $types->is_accounting = false;
        $types->acc_auto = false;
        $types->gbl_document_type_id = $request['gbl_document_type_id'];
        $types->gbl_status_id = $request['gbl_status_id'];
        $types->num_digits = $request['num_digits'];
        $types->prefix = $request['prefix'];
        $types->suffix = $request['suffix'];
        $types->save();

        $typestr->id = $types->id;
        $typestr->description = $request['description'];
        $typestr->lang = $request['lang'];
        $typestr->save();

        $typesprint->id = $types->id;
        $typesprint->type = $request['type'];
        $typesprint->method = $request['method'];
        $typesprint->save();

        $request['id'] = $types->id;

        return response()->json($request);
    }
}
