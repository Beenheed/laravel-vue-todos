<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use App\Http\Requests\TodoRequest;
use Illuminate\Http\JsonResponse;
// use Illuminate\Database\Eloquent\ModelNotFoundException;

class TodosApiController extends Controller 
{
    protected $todo;

    public function __construct(TodoRepositoryInterface $todo) {
        $this->todo = $todo;
    }

    /**
     * list all database entries
     *
     * @return json
     */
    public function index() {

        return $this->todo->index();
    }

    /**
     * Store all the data request in the database
     *
     * @param TodoRequest $request
     * @return json
     */
    public function store(TodoRequest $request) {

        return $this->todo->create($request->all());
    }

    /**
     * show one entry by id
     *
     * @param uuid $id
     * @return json
     */
    public function show($id) {

        return $this->todo->show($id);
    }

    /**
     * update one entry by id
     *
     * @param TodoRequest $request uuid $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TodoRequest $request, $id) {
        try {
            $this->todo->update($id, $request->all());
            return new JsonResponse(['message' => 'todo updated'], 200);
        } catch (Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()], $e->getStatusCode());
        }
    }

    /**
     * delete one entry by id
     *
     * @param uuid $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id) {
        try {
            $this->todo->delete($id);
            return new JsonResponse(['message' => 'todo deleted'], 200);
        } catch (Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()], $e->getStatusCode());
        }        
    }
}
