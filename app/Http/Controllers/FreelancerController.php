<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FreelancerService;
use App\Http\Requests\FreelancerRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\FreelancerResource;
use App\Models\Freelancer;

class FreelancerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $freelancers = Freelancer::with('gigs')->get();

        return FreelancerResource::collection($freelancers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FreelancerRequest $request, FreelancerService $service):JsonResponse
    {
        try {

            $validatedData = $request->validated();

            $freelancer = $service->registerFreelancer($validatedData);

            return response()->json([
                'message' => 'Freelancer Registered Successfully',
                'data' => $freelancer
            ]);

        } catch (\Exception $exc) {
             // Handle errors from the service
            return response()->json([
                    'error' => $exc->getMessage()
                ], 422);
        }
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
