<?php

namespace App\Services;

use App\Character;
use App\Services\Interfaces\ICharacterService;
use App\Services\Interfaces\IPotterApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class CharacterService implements ICharacterService
{
    private $potterApiService;

    public function __construct(IPotterApiService $potterApiService)
    {
        $this->potterApiService = $potterApiService;
    }

    /**
     * Validates the request
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function validator(Request $request)
    {
        $rules = [
            'name'  => 'min:3|max:50',
            'role' => 'min:3|max:50',
            'school'   => 'min:3|max:100',
            'patronus'   => 'min:1|max:50'
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }
        return response()->json([],200);
    }

    /**
     * Creates new character
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $validator = $this->validator($request);
        if($validator->status() == 400){
            return $validator;
        }
        if(!empty($request->house)){
            $houseData = $this->getHouseData($request->house); //5a05da69d45bd0a11bd5e06f
            if($this->isAFailedHouseResponse($houseData) === true){
                return response()->json('The informed house is invalid', 200);
            }
        }
        $character = Character::create($request->all());
        return response()->json($character, 201);
    }

    /**
     * Directs the request to the according method based on parameter
     *
     * @param Request $request
     * @return JsonResponse
     * @TODO Checks if the parameter is another column instead of house
     */
    public function getStandard(Request $request)
    {
        if ($request->has('house')) {
            return $this->getByHouse($request->house);
        }
        return $this->getAll();
    }

    /**
     * Get all characters
     *
     * @return JsonResponse
     */
    public function getAll()
    {
        return response()->json(Character::get(),200);
    }

    /**
     * Get character based on id parameter
     *
     * @param $id
     * @return JsonResponse
     */
    public function getById($id)
    {
        $character = Character::find($id);
        if(!$character){
            return response()->json(["message" => "Character not found"],404);
        }
        return response()->json($character,200);
    }

    /**
     * Get a character based on house property
     *
     * @param string $house
     * @return JsonResponse
     */
    public function getByHouse($house)
    {
        if(empty($house)){
            return response()->json(["message" => "house data is empty"],404);
        }
        $character = Character::where('house','=',$house)->get();
        if(!$character){
            return response()->json(["message" => "No data found"],404);
        }
        return response()->json($character,200);
    }

    /**
     * Updates a character
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $character = Character::find($id);
        if(is_null($character)){
            return response()->json(["message" => "Character not found"],404);
        }
        if(!empty($request->house)){
            $houseData = $this->getHouseData($request->house); //5a05da69d45bd0a11bd5e06f
            if($this->isAFailedHouseResponse($houseData) === true){
                return response()->json('The informed house is invalid', 200);
            }
        }
        $validator = $this->validator($request);
        if($validator->status() == 400){
            return $validator;
        }
        $character->update($request->all());
        return response()->json($character,200);
    }

    /**
     * Delete a character
     *
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $character = Character::find($id);
        if(is_null($character)){
            return response()->json(["message" => "Character not found"],404);
        }
        $character->delete();
        return response()->json(null,204);
    }

    /**
     * Consumes the potterAPi in order to get the house data.
     *
     * @param $house
     * @return mixed
     */
    public function getHouseData(string $house)
    {
        $response = $this->potterApiService->getHouseData($house);
        if($response->failed()){
            $response = $this->potterApiService->getHouseData($house);
        }
        return json_decode($response,true); //5a05da69d45bd0a11bd5e06f
    }

    /**
     * Validates the house data return from potterApi
     * Depends on the data passed to parameter to the potterApi the return is different. In case of not found
     * the result can be an empty or a handled message
     *
     * @param array $houseData
     * @return bool|mixed
     */
    public function isAFailedHouseResponse(array $houseData)
    {
        return $houseData[0] ?? true;
    }
}
