<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SumeriaSetting;
use App\Models\Franchise;
use App\Http\Controllers\WhatsApp;
use App\Models\FranchisePhone;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;

class ConversationsController extends Controller
{
    public function show()
    {
        return view('pages.conversations.conversations');
    }

    public function settings()
    {
        $whatsAppController = new WhatsApp();
        $whatsAppAccounts = $whatsAppController->getWhatsAppBusinessData();
        
        $meta_business_id = SumeriaSetting::where('setting_name', 'meta_business_id')->value('setting_value');
        $token = SumeriaSetting::where('setting_name', 'admin_token')->value('setting_value');
    
        $associatedPhoneIds = FranchisePhone::pluck('phone_id')->toArray();
    
        $franchises = Franchise::whereNotIn('id', FranchisePhone::pluck('franchise_id'))->get();
    
        foreach ($whatsAppAccounts as $key => $account) {
            foreach ($account['phone_numbers'] as $phoneKey => $phone) {
                if (in_array($phone['id'], $associatedPhoneIds)) {
                    $franchise = FranchisePhone::where('phone_id', $phone['id'])->first()->franchise;
                    $whatsAppAccounts[$key]['phone_numbers'][$phoneKey]['franchise'] = $franchise;
                } else {
                    $whatsAppAccounts[$key]['phone_numbers'][$phoneKey]['franchise'] = null;
                }
            }
        }
    
        return view('pages.conversations.settings', compact('whatsAppAccounts', 'meta_business_id', 'token', 'franchises'));
    }
    
}
