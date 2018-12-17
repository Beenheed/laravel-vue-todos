<?php

namespace App\Repositories;

use App\Models\Todo;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentTodoRepository implements	TodoRepositoryInterface
{

	protected $model;

	/**
     * TodoRepository constructor.
     * @param Todo $todo
     */
	public function __construct(Todo $todo) 
	{
		$this->model = $todo;
	}

    /**
     * List all entries
     * @return mixed
     */
	public function index()
	{
		return $this->model->all();
	}

    /**
     * create new entry
     * @param array $attributes
     * @return mixed
     */
   	public function create(array $attributes)
	{
		return $this->model->create($attributes);
	}

    /**
     * show single entry
     * @param string $id
     * @return mixed
     */
	public function show(string $id)
	{
		return $this->model->findOrFail($id);
	}

    /**
     * update single entry
     * @param string $id, array $attributes
     * @return mixed
     */
	public function update(string $id, array $attributes)
	{
		$record = $this->model->find($id);        
		if (empty($record)) {
            throw new ModelNotFoundException('Record not found with id: ' . $id);
        }
        return $record->update($attributes);
	}

    /**
     * delete single entry
     * @param string $id
     * @return bool
     */
	public function delete(string $id)
	{
        $record = $this->model->find($id);        
        if (empty($record)) {
            throw new ModelNotFoundException('Record not found with id: ' . $id);
        }

		return $record->delete($id);
	}
}
