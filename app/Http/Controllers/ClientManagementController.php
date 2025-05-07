<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ClientManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $client = Client::paginate(3);
        $nextClientId = $this->generateClientId();
        return view('client')->with([
            'client' => $client,
            'nextClientId' => $nextClientId
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Generate a unique client ID based on the format C-YY-Count
     */
    private function generateClientId()
    {
        $currentYear = Carbon::now()->format('y'); // Gets last two digits of current year
        
        // Count clients created in the current year
        $clientCount = Client::whereYear('created_at', Carbon::now()->year)->count();
        
        // Format: C-YY-Count (Count starts at 1, so add 1 to the current count)
        $clientId = 'C-' . $currentYear . '-' . ($clientCount + 1);
        
        return $clientId;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fname' => 'required|min:2|max:50',
            'mname' => 'nullable|min:2|max:50', 
            'lname' => 'required|min:2|max:50',
            'address' => 'required|min:2|max:50',
            'contactno' => 'required|digits_between:7,15',
            'client_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Use the provided client ID that was generated and shown on the form
        $clientId = $request->input('clientId');
        
        // In case the provided client ID is missing or invalid, generate a new one
        if (!$clientId) {
            $clientId = $this->generateClientId();
        }

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('client_image')) {
            $image = $request->file('client_image');
            $imageName = $clientId . '_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/clients'), $imageName);
            $imagePath = 'images/clients/' . $imageName;
        }

        $client = Client::create([
            'clientId' => $clientId,
            'fname' => $request->input('fname'),
            'mname' => $request->input('mname'),
            'lname' => $request->input('lname'),
            'address' => $request->input('address'),
            'contactno' => $request->input('contactno'),
            'image_path' => $imagePath,
        ]);

        Log::info("Client {$client->clientId} created with the following details: " . 
        "Name: {$client->fname} {$client->mname} {$client->lname}, " . 
        "Address: {$client->address}, Contact: {$client->contactno}");
    
        return redirect('/client')->with('success', 'Client added successfully with ID: ' . $clientId);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = Client::find($id);
        return view("showClient")->with("client",$client);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $client = Client::findOrFail($id);

        $request->validate([
            'fname' => 'required|min:2|max:50',
            'mname' => 'nullable|min:2|max:50', 
            'lname' => 'required|min:2|max:50',
            'address' => 'required|min:2|max:50',
            'contactno' => 'required|digits_between:7,15',
            'client_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Store old values
        $old = $client->only(['fname', 'mname', 'lname', 'address', 'contactno', 'image_path']);

        // Handle image upload
        $imagePath = $client->image_path; // Default to current image path
        if ($request->hasFile('client_image')) {
            // Delete old image if it exists
            if ($client->image_path && file_exists(public_path($client->image_path))) {
                unlink(public_path($client->image_path));
            }
            
            // Upload new image
            $image = $request->file('client_image');
            $imageName = $client->clientId . '_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/clients'), $imageName);
            $imagePath = 'images/clients/' . $imageName;
        }

        // Update
        $client->update([
            'clientId' => $request->clientId, // Keep the existing client ID
            'fname' => $request->fname,
            'mname' => $request->mname,
            'lname' => $request->lname,
            'address' => $request->address,
            'contactno' => $request->contactno,
            'image_path' => $imagePath,
        ]);

        // Compare and log changes
        $changes = [];
        foreach ($old as $field => $oldValue) {
            $newValue = $field === 'image_path' ? $imagePath : $request->$field;
            if ($oldValue !== $newValue) {
                if ($field === 'image_path') {
                    $changes[] = "image was updated";
                } else {
                    $changes[] = "$field: from $oldValue to $newValue";
                }
            }
        }

        if (!empty($changes)) {
            Log::info("Client {$client->clientId} updated with the following changes: " . implode(', ', $changes));
        }

        return redirect('/client')->with('success', "Client {$client->clientId} updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::find($id);
    
        if (!$client) {
            return redirect()->back()->with('error', 'Client not found.');
        }

        Log::info("Client {$client->clientId} deleted.");

        $client->delete();
        return redirect('/client')->with('success', 'Client deleted successfully.');
    }

    public function checkClientId($clientId)
    {
        $exists = Client::where('clientId', $clientId)->exists();
        return response()->json(['exists' => $exists]);
    }
    
    public function getNextClientId()
    {
        $nextClientId = $this->generateClientId();
        return response()->json(['nextClientId' => $nextClientId]);
    }

    function maintenance() {
        return view('maintenance');
    }
}