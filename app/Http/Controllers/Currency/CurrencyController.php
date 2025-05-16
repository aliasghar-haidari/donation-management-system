<?php

namespace App\Http\Controllers\Currency;

use App\Http\Controllers\Controller;
use App\Http\Resources\Currency\CurrencyResource;
use App\Models\Currency\Currency;
use App\Http\Requests\Currency\StoreCurrencyRequest;
use App\Http\Requests\Currency\UpdateCurrencyRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Currency::query();
        $perPage = $request->perPage ?? 10;
        $sortBy = $request->sortBy ?? 'id';
        $sortOrder = $request->sortOrder ?? 'asc';

        $query->orderBy($sortBy, $sortOrder);

        return CurrencyResource::collection($query->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCurrencyRequest $request): JsonResponse
    {
        $currency = Currency::create($request->validated());

        return response()->json([
            'message' => 'Currency created successfully.',
            'data' => new CurrencyResource($currency),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Currency $currency): CurrencyResource
    {
        return new CurrencyResource($currency);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCurrencyRequest $request, Currency $currency): JsonResponse
    {
        $currency->update($request->validated());

        return response()->json([
            'message' => 'Currency updated successfully.',
            'data' => new CurrencyResource($currency),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Currency $currency): JsonResponse
    {
        $currency->delete();

        return response()->json([
            'message' => 'Currency deleted successfully.'
        ]);
    }

    /**
     * Toggle the active status of the currency.
     */
    public function toggle(Currency $currency): JsonResponse
    {
        $currency->is_active = !$currency->is_active;
        $currency->save();

        return response()->json([
            'message' => 'Currency status updated successfully.',
            'data' => new CurrencyResource($currency)
        ]);
    }
}
