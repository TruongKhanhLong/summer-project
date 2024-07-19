<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    public function getData($taxCode)
    {
        $client = new Client();
        $url = "https://api.vietqr.io/v2/business/{$taxCode}";

        try {
            // Make the request
            $response = $client->request('GET', $url);
            $data = json_decode($response->getBody()->getContents(), true);

            // Check if response data is valid
            if (isset($data['code']) && $data['code'] !== '00') {
                return response()->json(['error' => $data['desc']], 400);
            }

            // Return JSON response
            return response()->json($data);

        } catch (\GuzzleHttp\Exception\RequestException $e) {
            // Log the detailed error message
            Log::error('Guzzle request failed: ' . $e->getMessage());

            // Return a more specific error message
            return response()->json(['error' => 'API request failed: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            // Log the detailed error message
            Log::error('An unexpected error occurred: ' . $e->getMessage());

            // Return a more specific error message
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }
    }
}
