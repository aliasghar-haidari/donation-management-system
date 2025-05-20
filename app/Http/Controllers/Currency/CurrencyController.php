<?php

namespace App\Http\Controllers\Currency;

use App\Http\Controllers\Controller;
use App\Http\Resources\Currency\CurrencyResource;
use App\Http\Services\Account\AccountService;
use App\Models\Company\Company;
use App\Models\Currency\Currency;
use App\Http\Requests\Currency\StoreCurrencyRequest;
use App\Http\Requests\Currency\UpdateCurrencyRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function __construct(protected AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

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
     * Activate the currency.
     */
    public function activate(Currency $currency): JsonResponse
    {
        if ($currency->is_active) {
            return response()->json([
                'message' => 'Currency is already activated.'
            ], 400);
        }

        $currency->is_active = true;
        $currency->save();

        $this->accountService->createDefaultAccountsByCurrencyId($currency->id);

        return response()->json([
            'message' => 'Currency activated successfully.',
            'data' => new CurrencyResource($currency)
        ]);
    }
}
