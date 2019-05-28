<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;
use DB;

class AccountMember extends Model
{
    protected $tbLogin = 'Wifi_Member_Login';
    protected $tbDetail = 'Wifi_Member_Detail';
    protected $tbDevice = 'Wifi_Member_Device';
    protected $connection = 'sqlsrv';

    public function getUserDevices($username)
    {
        $devices = DB::connection($this->connection)->table($this->tbLogin)
            ->join($this->tbDevice, $this->tbDevice.'.ID_LOGIN', '=', $this->tbLogin.'.ID')
            ->where($this->tbLogin.'.USERNAME', $username)
            ->get();

        return $devices->count();
    }

    public function checkMacAddress($username, $mac_address)
    {
        $mac = DB::connection($this->connection)->table($this->tbLogin)
            ->join($this->tbDevice, $this->tbDevice.'.ID_LOGIN', '=', $this->tbLogin.'.ID')
            ->where($this->tbLogin.'.USERNAME', $username)
            ->where($this->tbDevice.'.MAC_ADDRESS', $mac_address)
            ->get();

        return $mac->count();
    }

    public function getUserLastDevice($username)
    {
        $device = DB::connection($this->connection)->table($this->tbLogin)
            ->join($this->tbDevice, $this->tbDevice.'.ID_LOGIN', '=', $this->tbLogin.'.ID')
            ->where($this->tbLogin.'.USERNAME', $username)
            ->orderBy('LOGIN_DATE', 'asc')
            ->first();

        return $device;
    }

    public function getLoginId($username)
    {
        $login = DB::connection($this->connection)->table($this->tbLogin)
            ->where('USERNAME', $username)
            ->first();

        return $login->ID;
    }

    public function saveUserDevice($device) {
        DB::connection($this->connection)->table($this->tbDevice)
            ->insert($device);

        return true;
    }

    public function deleteUserDevice($mac_address)
    {
        $device = DB::connection($this->connection)->table($this->tbDevice)
            ->where('MAC_ADDRESS', $mac_address)
            ->get();

        if( $device->count() != 0 ) {
            DB::connection($this->connection)->table($this->tbDevice)
                ->where('MAC_ADDRESS', $mac_address)
                ->delete();
        }

        return true;
    }

}
