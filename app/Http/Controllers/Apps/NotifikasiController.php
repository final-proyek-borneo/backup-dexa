<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\NotificationDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class NotifikasiController extends Controller
{
    public function handleNotificationClick(Request $request){
        $validator = Validator::make($request->all(), [
            'fc_notificationcode' => 'required',
            'fv_url' => 'required',
        ]);
    
        if ($validator->fails()) {
            // Jika validasi gagal
            return response()->json([
                'status' => 400,
                'message' => 'Invalid request data',
                'errors' => $validator->errors(),
            ]);
        }

            $updated = NotificationDetail::where('fc_notificationcode', $request->fc_notificationcode)
            ->where('fc_userid', auth()->user()->fc_userid)
            ->where('fc_branch', auth()->user()->fc_branch)
            ->update([
                'fd_watchingdate' => Carbon::now(),
            ]);
    
            if($updated){
                // Jika pembaruan berhasil
                return response()->json([
                    'status' => 200,
                    'message' => 'Notification clicked',
                    'link' => $request->fv_url
                ]);
            }
        // Jika pembaruan gagal atau data tidak ditemukan
        return response()->json([
            'status' => 400,
            'message' => 'Failed to update notification',
        ]);
        // dd($request);
    }
}
