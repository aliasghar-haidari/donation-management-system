<?php

namespace App\Http\Controllers\Donor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Donor\StoreDonorRequest;
use App\Http\Requests\Donor\UpdateDonorRequest;
use App\Http\Resources\Donor\DonorResource;
use App\Models\Donor\Donor;
use Illuminate\Http\Request;

class DonorController extends Controller
{
    public function index(Request $request)
    {
        $query = Donor::query();
        $perPage = $request->perPage ?? 10;
        $sortBy = $request->sortBy ?? 'id';
        $sortOrder = $request->sortOrder ?? 'desc';

        $query->orderBy($sortBy, $sortOrder);

        return DonorResource::collection($query->paginate($perPage));
    }

    public function store(StoreDonorRequest $request)
    {
        $donor = Donor::create($request->validated());

        return response()->json([
            'message' => 'Donor created successfully.',
            'data' => new DonorResource($donor)
        ], 201);
    }

    public function show(Donor $donor)
    {
        return new DonorResource($donor);
    }

    public function update(UpdateDonorRequest $request, Donor $donor)
    {
        $donor->update($request->validated());

        return response()->json([
            'message' => 'Donor updated successfully.',
            'data' => new DonorResource($donor)
        ]);
    }

    public function destroy(Donor $donor)
    {
        $donor->delete();

        return response()->json([
            'message' => 'Donor deleted successfully.'
        ], 204);
    }
}
