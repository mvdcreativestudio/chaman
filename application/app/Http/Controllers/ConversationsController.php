<?php

namespace App\Http\Controllers;

use App\Models\SumeriaSetting;
use App\Models\Franchise;
use App\Http\Controllers\WhatsApp;
use App\Models\PhoneNumber;
use App\Models\Message;
use Illuminate\Http\Request;

class ConversationsController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $userFranchise = $user->franchise;
    
        if (!$userFranchise) {
            return view('pages.conversations.conversations')->with('error', 'No tienes una franquicia asociada.');
        }
    
        $phoneNumber = $userFranchise->phoneNumber;
    
        if (!$phoneNumber) {
            return view('pages.conversations.conversations')->with('error', 'Tu franquicia no tiene un número de teléfono asociado.');
        }
    
        $chats = $phoneNumber->getLastMessagesForChats();
    
        return view('pages.conversations.conversations', compact('chats'));
    }    
    

    public function fetchMessages(Request $request)
    {
        $user = auth()->user();
        $userFranchise = $user->franchise;
        if (!$userFranchise || !$userFranchise->phoneNumber) {
            return response()->json(['error' => 'Número de teléfono no asociado.'], 404);
        }
    
        $contactPhoneNumber = $request->input('phone_number');
        
        // Comprobación adicional: Verificar que los IDs sean válidos y no iguales
        if (!$contactPhoneNumber || $contactPhoneNumber == $userFranchise->phoneNumber->id) {
            return response()->json(['error' => 'Número de teléfono inválido.'], 400);
        }
    
        $messages = Message::where(function ($query) use ($userFranchise, $contactPhoneNumber) {
                                    $query->where('from_phone_id', $userFranchise->phoneNumber->id)
                                          ->where('to_phone_id', $contactPhoneNumber);
                                })
                                ->orWhere(function ($query) use ($userFranchise, $contactPhoneNumber) {
                                    $query->where('from_phone_id', $contactPhoneNumber)
                                          ->where('to_phone_id', $userFranchise->phoneNumber->id);
                                })
                                ->with(['sender', 'receiver'])
                                ->orderBy('message_created', 'asc')
                                ->get();
    
        return response()->json(['messages' => $messages]);
    }    

    public function settings()
    {
        $whatsAppController = new WhatsApp();
        $whatsAppAccounts = $whatsAppController->getWhatsAppBusinessData();
        
        $meta_business_id = SumeriaSetting::where('setting_name', 'meta_business_id')->value('setting_value');
        $token = SumeriaSetting::where('setting_name', 'admin_token')->value('setting_value');
    
        // Obtener todos los IDs de teléfono asociados con franquicias
        $associatedPhoneIds = PhoneNumber::where('is_franchise', true)->pluck('phone_id')->toArray();
    
        // Obtener franquicias que no tienen un número de teléfono asociado
        $franchises = Franchise::whereDoesntHave('phoneNumber')->get();
    
        foreach ($whatsAppAccounts as $key => $account) {
            foreach ($account['phone_numbers'] as $phoneKey => $phone) {
                if (in_array($phone['id'], $associatedPhoneIds)) {
                    $phoneNumber = PhoneNumber::where('phone_id', $phone['id'])->first();
                    $franchise = $phoneNumber->franchise;
                    $whatsAppAccounts[$key]['phone_numbers'][$phoneKey]['franchise'] = $franchise;
                } else {
                    $whatsAppAccounts[$key]['phone_numbers'][$phoneKey]['franchise'] = null;
                }
            }
        }
    
        return view('pages.conversations.settings', compact('whatsAppAccounts', 'meta_business_id', 'token', 'franchises'));
    }
    
    
}
