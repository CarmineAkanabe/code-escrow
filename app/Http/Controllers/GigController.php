<?php

namespace App\Http\Controllers;

use App\Http\Requests\GigRequest;
use App\Http\Resources\GigResource;
use App\Services\GigManagementService;
use Illuminate\Http\Request;
use App\Models\Gig;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\JsonResponse;

class GigController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        // This formats the requested data in a more paginated style
        $gigs = Gig::with(['freelancer', 'transaction']) // Eager loading relationships
                    ->paginate(10);
        // The resource serializes (aranges the data in an understandable way for external users)
        return GigResource::collection($gigs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GigRequest $request, GigManagementService $service): JsonResponse
    {
        // We check for validation first before calling the service
        $validatedData = $request->validated();
        // We call the service to store the data to the DB
        $gig = $service->createGig($validatedData);
        // We give a json response on the operation of gig
        return response()->json($gig);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
