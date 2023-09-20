<?php

namespace App\Interfaces;

interface NewsRepositoryInterface 
{
    public function store($input);
    public function update($id, $input);
    public function delete($id);
    public function index($page, $limit);
    public function show($id);
}