<?php

namespace App\Http\Controllers\BiznetWifi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use App\RadiusAPI;
use App\Database\AccountMember;
use App\Http\Resources\DevicesResource;

class AccountMemberController extends Controller
{
    use RadiusAPI;

    public function datadevice( Request $request, AccountMember $model, $customerid )
    {
        $devices = $model->userDeviceList($customerid);

        $data = [
            'total' => $devices->count(),
            'data' => $devices
        ];

        return response()->json($data);
    }

    public function destroy( Request $request, AccountMember $model, $customerid, $mac )
    {
        $this->delete_radcheck( '182.253.238.66:8080', $mac );
        $model->deleteUserDevice($customerid, $mac);

        return response()->json([ 'statusText' => strtoupper( $mac ) . ' berhasil dihapus.' ], 200);
    }
}
