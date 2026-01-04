<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\ConfirmsPasswords;
use Livewire\Component;

class ManagePasskeys extends Component
{
    use ConfirmsPasswords;

    public function delete($id)
    {
        $this->ensurePasswordIsConfirmed();
        
        Auth::user()->webauthnCredentials()->where('id', $id)->delete();
        
        $this->dispatch('passkey-deleted');
    }

    public function render()
    {
        return view('profile.manage-passkeys', [
            'keys' => Auth::user()->webauthnCredentials()->latest()->get(),
        ]);
    }
}
