<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserData;

use App\Jobs\ImportUsersJob;


class UserDataController extends Controller
{
    public function index()
    {
        $users = UserData::latest()->paginate(50);
        return view('users.index', compact('users'));
    }

   public function upload(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:csv,xlsx'
    ]);

    // store on local disk
    $path = $request->file('file')->store('imports', 'local');

    ImportUsersJob::dispatch($path);

    return response()->json([
        'status' => true,
        'message' => 'File uploaded successfully. Import started in background.'
    ]);
}

}

