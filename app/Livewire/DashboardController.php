<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Component
{
    public function render()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return view('livewire.admin.dashboard');
        }

        // default ke mahasiswa
        return view('livewire.users.dashboard');
    }
}