<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected $model;

    protected $modelClass;

    protected $resourceClass;

    protected $classBasename;

    public function __construct()
    {
        // parent::__construct();
        $this->setModel($this->modelClass);
    }

    /**
     * Display paginated listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listItems($request)
    {
        $items = $this->generateItems($request);

        $list = $items->paginate($request->per_page ?? null);

        return $this->returnResponse($list);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getItems($request)
    {
        $items = $this->generateItems($request);

        if ($request->limit) {
            $items->limit($request->limit);
        }

        $list = $items->get();

        return $this->returnResponse($list);
    }

    public function generateItems(Request $request)
    {
        $items = $this->getModel();
        $filter_class = 'App\\Filters\\' . $this->classBasename . 'Filter';
        $filterable_class = 'Laraditz\\ModelFilter\\Filterable';

        if (
            class_exists($filter_class)
            && collect(class_uses($this->getModel()))->contains($filterable_class)
        ) {
            $items = $items->filter($request->all());
        }

        return $items->latest();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Array  $rules
     * @return \Illuminate\Http\Response
     */
    public function storeItem($request, $rules = [])
    {
        if (method_exists($request, 'validated')) {
            $params = $request->validated();
        } elseif (count($rules) > 0) {
            $params = $request->validate($rules);
        } else {
            $params = $request->all();
        }

        $created = $this->getModel()->create($params);
        $created->refresh();

        if ($this->resourceClass) {
            $created = $this->resourceClass::make($created);
        }

        return response()->json($created, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Model|int $resource
     * @return \Illuminate\Http\Response
     */
    public function showIitem($resource)
    {
        if (is_numeric($resource)) {
            $resource = $this->getModel()->findOrFail($resource);
        }

        return $this->returnResponse($resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Model|int $resource
     * @param  Array  $rules
     * @return \Illuminate\Http\Response
     */
    public function updateItem($request, $resource, $rules = [])
    {
        $params = $this->resourceValidated($request, $rules);

        if (is_numeric($resource)) {
            $resource = $this->getModel()->findOrFail($resource);
        }

        $updated = tap($resource)->update($params);

        if ($updated) {
            return $this->returnResponse($resource);
        }

        return response()->json(['message' => 'Oopss. Something went wrong.'], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Model|int $resource
     * @return \Illuminate\Http\Response
     */
    public function deleteIitem($resource)
    {
        if (is_numeric($resource)) {
            $resource = $this->getModel()->findOrFail($resource);
        }

        if ($resource->delete()) {
            return response()->json(['message' => 'Deleted.']);
        }

        return response()->json(['message' => 'Failed to delete resource.'], 400);
    }

    protected function setModel($modelClass)
    {
        if ($modelClass) {
            $this->model =  new $modelClass;
            $this->classBasename = class_basename($this->model);
        }
    }

    protected function getModel()
    {
        return $this->model;
    }

    private function resourceValidated($request, $rules = [])
    {
        if (method_exists($request, 'validated')) {
            return $request->validated();
        } elseif (count($rules) > 0) {
            return $request->validate($rules);
        } else {
            return $request->all();
        }
    }

    private function resourceData($data)
    {
        if ($this->resourceClass) {
            if ($data instanceof \Illuminate\Pagination\LengthAwarePaginator || $data instanceof \Illuminate\Database\Eloquent\Collection) {
                return $this->resourceClass::collection($data);
            }

            return $this->resourceClass::make($data);
        }

        return $data;
    }

    private function returnResponse($data)
    {
        return response()->json($this->resourceData($data));
    }
}
