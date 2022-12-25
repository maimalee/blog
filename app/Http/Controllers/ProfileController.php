<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function profileImage(Request $request)
    {
        if ($request->isMethod('post')){
            $request->validate([
                'img' => 'required|image|mimes:jpg,jpeg,png|max:250',
            ]);

            $imageUpload = $request->file('img');
            $imageName =  time() . '.' . $imageUpload->extension();

            $file = $imageUpload->move(public_path('images'), $imageName);

            try {
                $user = Auth()->user();
                $user->update(['profile' => $file->getFilename()]);
                return redirect()->route('home')
                    ->with('message', 'Profile Photo Added Successfully')
                    ->with('image', $imageName);

            }catch (Exception $exception){
                Log::critical($exception);
                return back()
                    ->with('message' , 'Error Adding The Image');
            }
        }
        return view('profile.image');
   }
}
