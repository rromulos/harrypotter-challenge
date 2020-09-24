<?php

namespace App\Http\Controllers;

use App\Character;
use App\Services\Interfaces\ICharacterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;

class CharacterController extends Controller
{
    //private $potterApi;
    private $characterService;

    public function __construct(ICharacterService $characterService)
    {
        $this->characterService = $characterService;
    }


    /**
     * Invoke CharacterService to create a new character
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        return $this->characterService->create($request);
    }

    /**
     * Invoke CharacterService to get Data
     *
     * @param Request $request
     * @return JsonResponse
     * @TODO Checks if the parameter is another column instead of house
     */
    public function getStandard(Request $request)
    {
        return $this->characterService->getStandard($request);
    }


    /**
     * Invoke CharacterService to get Character by id
     *
     * @param $id
     * @return JsonResponse
     */
    public function getById($id)
    {
        return $this->characterService->getById($id);
    }

    /**
     * Invoke CharacterService to update a Character
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        return $this->characterService->update($request,$id);
    }

    /**
     * Invoke CharacterService to delete a Character
     *
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        return $this->characterService->delete($id);
    }
}
