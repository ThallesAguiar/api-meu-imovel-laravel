<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\RealStateRequest;
use App\Models\RealState;

class RealStateController extends Controller
{

    private $realState;

    public function __construct(RealState $realState)
    {
        $this->realState = $realState;
    }


    public function index()
    {
        $realState =  $this->realState->paginate(10);

        return response()->json($realState, 200);
    }


    public function store(RealStateRequest $request)
    {
        $data = $request->all();
        // return response()->json($data);

        try {

            $realState = $this->realState->create($data); // Mass Asignment:  inserção de dados em massa. Precisa do $fillable do model

            if (isset($data['categories']) && count($data['categories'])) {
                $realState->categories()->sync($data['categories']); //sync faz a sincronia com o Model Category
            }

            return response()->json(
                [
                    'data' => [
                        'msg' => 'Imóvel cadastrado com sucesso!',
                    ]
                ],
                200
            );
        } catch (\Exception $e) {

            $message = new ApiMessages($e->getMessage());

            return response()->json($message->getMessage(), 401, ['Accept' => 'application/json']);
        }
    }


    public function show($id)
    {
        try {
            $realState = $this->realState->findOrFail($id);

            return response()->json(
                [
                    'data' => $realState
                ],
                200
            );
        } catch (\Exception $e) {

            $message = new ApiMessages($e->getMessage());

            return response()->json($message->getMessage(), 401, ['Accept' => 'application/json']);
        }
    }


    public function update(RealStateRequest $request, $id)
    {
        $data = $request->all();

        try {

            $realState = $this->realState->findOrFail($id);
            $realState->update($data);

            if (isset($data['categories']) && count($data['categories'])) {
                $realState->categories()->sync($data['categories']); //sync faz a sincronia com o Model Category
            }

            return response()->json(
                [
                    'data' => [
                        'msg' => 'Imóvel atualizado com sucesso!',
                    ]
                ],
                200
            );
        } catch (\Exception $e) {

            $message = new ApiMessages($e->getMessage());

            return response()->json($message->getMessage(), 401, ['Accept' => 'application/json']);
        }
    }


    public function destroy($id)
    {

        try {
            $realState = $this->realState->findOrFail($id);
            $realState->delete($realState);

            return response()->json(
                [
                    'data' => [
                        'msg' => 'Imóvel removido com sucesso!',
                    ]
                ],
                200
            );
        } catch (\Exception $e) {

            $message = new ApiMessages($e->getMessage());

            return response()->json($message->getMessage(), 401, ['Accept' => 'application/json']);
        }
    }
}
