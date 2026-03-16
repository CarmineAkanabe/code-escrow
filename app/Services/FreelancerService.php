<?php

namespace App\Services;

use App\Models\Freelancer;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class FreelancerService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function registerFreelancer(array $data): Freelancer
    {
        // Used to pass the value of github_username to githubs api
        $response = Http::get('https://api.github.com/users/'  . $data['github_username']  );

        // Based on the response we confirm if the username actually has a github accoount
        if (! $response->successful())
            {
                throw ValidationException::withMessages([
                    'github_username' => ['Github Profile not found, or private']
                ]);
            }
        
        // Extracting info from api if username has an account
        $githubData = $response->json();
        // Based on number of public repos, generate trust score
        $data['trust_score'] = $githubData['public_repos'];
        // Create the freelancer object
        $freelancer = Freelancer::create($data);

        return $freelancer;

    }
}
