<?php

namespace App\Http\Controllers\Donor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Donor\StoreDonationCategoryRequest;
use App\Http\Requests\Donor\UpdateDonationCategoryRequest;
use App\Http\Resources\Donor\DonationCategoryResource;
use App\Models\Donor\DonationCategory;
use Illuminate\Http\Request;

class DonationCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DonationCategory::query();
        $perPage = $request->perPage ?? 10;
        $sortBy = $request->sortBy ?? 'id';
        $sortOrder = $request->sortOrder ?? 'desc';

        $query->orderBy($sortBy, $sortOrder);

        return DonationCategoryResource::collection($query->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDonationCategoryRequest $request)
    {
        $donationCategory = DonationCategory::create($request->validated());

        return response()->json([
            'message' => 'Donation category created successfully.',
            'data' => new DonationCategoryResource($donationCategory)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(DonationCategory $donationCategory)
    {
        return new DonationCategoryResource($donationCategory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDonationCategoryRequest $request, DonationCategory $donationCategory)
    {
        $donationCategory->update($request->validated());

        return response()->json([
            'message' => 'Donation category updated successfully.',
            'data' => new DonationCategoryResource($donationCategory)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DonationCategory $donationCategory)
    {
        $donationCategory->delete();

        return response()->json([
            'message' => 'Donation category deleted successfully.'
        ], 204);
    }
}