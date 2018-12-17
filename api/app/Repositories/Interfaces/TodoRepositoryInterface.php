<?php

namespace App\Repositories\Interfaces;

interface TodoRepositoryInterface
{
    public function index();

    public function create(array $attributes);

    public function show(string $id);

    public function update(string $id, array $attributes);

    public function delete(string $id);
}