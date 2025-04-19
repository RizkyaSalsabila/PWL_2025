<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profil() {
        $breadcrumb = (object) [
            'title' => 'Profil Saya',
            'list'  => ['Home', 'Profil Saya']
        ];

        $page = (object) [
            'title' => 'Profil Pengguna'
        ];

        $user = auth()->user(); // Ambil user yang sedang login
        $activeMenu = 'profil'; // Set menu yang aktif
        

        return view(
            'profil.index', 
            [
                'breadcrumb' => $breadcrumb,
                'page' => $page,
                'user' => $user,
                'activeMenu' => $activeMenu,
            ]
        );
    }

    public function edit() {
        $breadcrumb = (object) [
            'title' => 'Edit Profil',
            'list'  => ['Home', 'Profil', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Profil'
        ];

        $user = Auth::user();

        $activeMenu = 'profil'; // Set menu yang aktif

        return view(
            'profil.edit', 
            [
                'breadcrumb' => $breadcrumb,
                'page' => $page,
                'user' => $user,
                'activeMenu' => $activeMenu,
            
            ]
        );
    }
    
    public function update(Request $request) {
        $request->validate([
            'profile_photo' => 'nullable|image|max:2048', 
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($request->hasFile('profile_photo')) {
            // Hapus foto lama jika ada
            if ($user->profile_photo && $user->profile_photo !== 'profile.jpg' && Storage::disk('public')->exists('profiles/' . $user->profile_photo)) {
                Storage::disk('public')->delete('profiles/' . $user->profile_photo);
            }

            $file = $request->file('profile_photo');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('profiles', $filename, 'public');

            $user->profile_photo = $filename;
            $user->save();
        }

        return redirect()->route('profile.edit')->with('success', 'Profil Anda berhasil diperbarui.');
    }   
}