<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface ICharacterService
{
    public function create(Request $request);
    public function getStandard(Request $request);
    public function getAll();
    public function getById($id);
    public function update(Request $request,$id);
    public function delete($id);
}
