<?php

namespace App\Http\Controllers\Donor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Donor\StoreDonationCauseRequest;
use App\Http\Requests\Donor\UpdateDonationCauseRequest;
use App\Http\Resources\Donor\DonationCauseResource;
use App\Models\Donor\DonationCause;
use Illuminate\Http\Request;

class DonationCauseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DonationCause::query();
        $perPage = $request->perPage ?? 10;
        $sortBy = $request->sortBy ?? 'id';
        $sortOrder = $request->sortOrder ?? 'desc';

        $query->orderBy($sortBy, $sortOrder);

        return DonationCauseResource::collection($query->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDonationCauseRequest $request)
    {
        $donationCause = DonationCause::create($request->validated());

        return response()->json([
            'message' => 'Donation category created successfully.',
            'data' => new DonationCauseResource($donationCause)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(DonationCause $dDonationCause)
    {
        return new DonationCauseResource($dDonationCause);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDonationCauseRequest $request, DonationCause $donationCause)
    {
        $donationCause->update($request->validated());

        return response()->json([
            'message' => 'Donation category updated successfully.',
            'data' => new DonationCauseResource($donationCause)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DonationCause $donationCause)
    {
        $donationCause->delete();

        return response()->json([
            'message' => 'Donation category deleted successfully.'
        ], 204);
    }
}