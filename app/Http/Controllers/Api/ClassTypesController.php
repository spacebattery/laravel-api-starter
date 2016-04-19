<?php

namespace App\Http\Controllers\Api;

use DB;
use Response;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateClassTypeRequest;

use App\ClassType;

class ClassTypesController extends Controller
{

    function find(Request $request) {
        $filter = json_decode($request->input('filter'));
        $per_page = $request->input('per_page');
        $table = ClassType::genericFilter($filter)->genericSort($filter);
        $table = $table->paginate($per_page ? $per_page : 15);
        return Response::json($table->appends($request->input()));
    }

    function create(CreateClassTypeRequest $request) {
        $classType = ClassType::create($request->input());
        return Response::json($classType, 201);
    }

}
