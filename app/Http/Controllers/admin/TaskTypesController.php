<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\TaskTypes;
use Illuminate\Http\JsonResponse;
use App\Services\QueryService;

class TaskTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        // try {
            $limit = $request->get('limit', 25);
            $ascending = (int) $request->get('ascending', 0);
            $orderBy = $request->get('orderBy', '');
            // $user_id = $request->get('user_id', '');
            $search = $request->get('TextSearch', '');
            $columnSearch = $request->get('columnSearch', 'name');           
            $betweenDate = $request->get('updated_at', []);
            $queryService = new QueryService(new TaskTypes());
            $queryService->select = [];
            $queryService->columnSearch =$columnSearch;
            $queryService->withRelationship = [];
            $queryService->search = $search;
            $queryService->betweenDate = $betweenDate;
            $queryService->limit = $limit;
            $queryService->ascending = $ascending;
            $queryService->orderBy = $orderBy;
            // $queryService->getListBy = [['user_id',$user_id]];
            $query = $queryService->queryTable();
            $query = $query->paginate($limit);
            $product = $query->toArray();
            return $this->jsonTable($product);
        // } catch (\Exception $e) {
        //     return $this->jsonError($e);
        // }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
