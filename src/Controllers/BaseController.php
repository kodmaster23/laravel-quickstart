<?php

namespace Kodmaster23\LaravelQuickStart\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Kodmaster23\LaravelQuickStart\Interfaces\Manager;
use Kodmaster23\LaravelQuickStart\Interfaces\Repository;

class BaseController
{
    
    
    public $presenter = JsonResource::class;
    /**
     * @var Repository
     */
    private $repository;
    /**
     * @var Manager
     */
    private $manager;

    public function __construct(Repository $repository, Manager $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->repository->setFilters($request->all());
        return $this->presenter::collection($this->repository->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $sanitized_request = $request->all();
        $result = $this->manager->storeOrUpdate($sanitized_request);
        return new $this->presenter($result);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $result = $this->repository->find($id, ['sector']);
        return new $this->presenter($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $sanitized_request = $request->all();
        $result = $this->manager->storeOrUpdate($sanitized_request, $id);
        return new $this->presenter($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $result = $result = $this->manager->destroy($id);;
        return response()->json($result, 200);
    }


}