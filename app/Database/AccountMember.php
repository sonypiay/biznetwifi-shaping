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

    public function deleteUserDevice($username, $mac_address)
    {
        $device = DB::connection($this->connection)->table($this->tbDevice)
            ->join($this->tbLogin, $this->tbLogin.'.ID', '=', $this->tbDevice.'.ID_LOGIN')
            ->where($this->tbDevice.'.MAC_ADDRESS', $mac_address)
            ->where($this->tbLogin.'.USERNAME', $username)
            ->select($this->tbDevice.'.ID')
            ->first();

        if( $device ) {
            DB::connection($this->connection)->table($this->tbDevice)
                ->where('ID', $device->ID)
                ->delete();
        }

        return true;
    }

    public function userDeviceList($username)
    {
        $devices = DB::connection($this->connection)->table($this->tbLogin)
            ->join($this->tbDevice, $this->tbDevice.'.ID_LOGIN', '=', $this->tbLogin.'.ID')
            ->where($this->tbLogin.'.USERNAME', $username)
            ->select($this->tbLogin.'.USERNAME', $this->tbDevice.'.MAC_ADDRESS', $this->tbDevice.'.DEVICE_AGENT', DB::raw('CONVERT(VARCHAR, ' .$this->tbDevice .'.LOGIN_DATE, 100) AS LOGIN_DATE'))
            ->orderBy($this->tbDevice.'.LOGIN_DATE', 'DESC')
            ->get();

        return $devices;
    }
}
