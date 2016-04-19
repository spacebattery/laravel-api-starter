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

    /**
     * @SWG\Get(
     *   path="/classTypes",
     *   tags={"ClassType"},
     *   summary="Find all instances of the model matched by filter from the data source.",
     *   operationId="ClassTypesController.find",
     *   consumes={"application/json"},
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     name="data",
     *     in="body",
     *     description="Model instance data",
     *     required=true,
     *     @SWG\Schema(
     *       required={"id"},
     *       ref="#/definitions/ClassType"
     *     )
     *   ),
     *   @SWG\Response(
     *      response="200",
     *      description="Success",
     *      @SWG\Schema(
     *          type="array",
     *          @SWG\Items(ref="#/definitions/PaginatedClassType")
     *      )
     *   )
     * )
     */
    function find(Request $request) {
        $filter = json_decode($request->input('filter'));
        $per_page = $request->input('per_page');
        $table = ClassType::genericFilter($filter)->genericSort($filter);
        $table = $table->paginate($per_page ? $per_page : 15);
        return Response::json($table->appends($request->input()));
    }

    /**
     * @SWG\Post(
     *   path="/classTypes",
     *   tags={"ClassType"},
     *   summary="Create a new instance of the model and persist it into the data source.",
     *   operationId="ClassTypesController.create",
     *   consumes={"application/json"},
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     name="data",
     *     in="body",
     *     description="Model instance data",
     *     required=true,
     *     @SWG\Schema(
     *       required={"id"},
     *       ref="#/definitions/ClassType"
     *     )
     *   ),
     *   @SWG\Response(
     *      response="201",
     *      description="Created",
     *      @SWG\Schema(ref="#/definitions/ClassType")
     *   ),
     *   @SWG\Response(
     *      response="422",
     *      description="Invalid input",
     *      @SWG\Schema(ref="#/definitions/errors/CreateClassTypeRequest")
     *   )
     * )
     */
    function create(CreateClassTypeRequest $request) {
        $classType = ClassType::create($request->input());
        return Response::json($classType, 201);
    }

}
