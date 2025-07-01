<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
 use App\Models\Rating;
class RatingController extends Controller
{
    

public function store(Request $request)
{
    $request->validate([
        'notary_id' => 'required|exists:notaries,id',
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string',
    ]);

    Rating::create([
        'user_id' => auth()->id(),
        'notary_id' => $request->notary_id,
        'rating' => $request->rating,
        'comment' => $request->comment,
    ]);

    return response()->json(['message' => 'Vlerësimi u ruajt me sukses']);
}

}
