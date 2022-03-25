<?php

namespace App\Http\Controllers\Ionic;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VisitController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.verify');
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        $user_id = auth()->user()->id;
        $visits = Visit::where('user_id', $user_id)->get();

        return response()->json($visits);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'date' => 'required|string',
            'persons' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = auth()->user();

        $visit = new Visit([
            'name' => $request->name,
            'date' => $request->date,
            'persons' => $request->persons,
            'user_id' => $user->id
        ]);

        $visit->save();

        return response()->json($visit, 201);
    }

    public function show(Visit $visit): Visit
    {
        return $visit;
    }

    public function update($id, Request $request): \Illuminate\Http\JsonResponse
    {
        $user_id = auth()->user()->id;
        $visit = Visit::where('id', $id)
            ->where('user_id', $user_id)->first();

        if (is_null($visit)) {

            return response()->json(['status' => 'error', 'message' => 'visit not found'], 404);

        } else {

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'date' => 'required|string',
                'persons' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $user = auth()->user();

            $visit->update([
                'name' => $request->name,
                'date' => $request->date,
                'persons' => $request->persons,
                'user_id' => $user->id
            ]);

            return response()->json($visit);
        }
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $user_id = auth()->user()->id;
        $visit = Visit::where('id', $id)
            ->where('user_id', $user_id)->first();

        if (is_null($visit)) {

            return response()->json(['status' => 'error', 'message' => 'visit not found'], 404);

        } else {

            $visit->delete();

            return response()->json(null, 204);
        }
    }
}
