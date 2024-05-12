<?php

namespace App\Http\Controllers;

use App\Models\Vip;
use Illuminate\Http\Request;

class VipController extends Controller
{
    public function toggleVipStatus(Request $request)
    {
        $user = $request->user();
        $vip = Vip::firstOrCreate(['user_id' => $user->id]);
        $vip->status = !$vip->status;
        $vip->save();

        return redirect()->back()->with('message', 'VIP status changed successfully!');
    }
}

