<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Settings;

class SettingsController extends Controller
{
    public function index()
    {
        $lsms_setting_data = Settings::latest()->first();
        $zones_array = array();
        $timestamp = time();
        foreach(timezone_identifiers_list() as $key => $zone) {
            date_default_timezone_set($zone);
            $zones_array[$key]['zone'] = $zone;
            $zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
        }
        return view('settings.index', compact('lsms_setting_data', 'zones_array'));
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        //return redirect()->back()->with('not_permitted', 'This feature is disable for demo!');
        $this->validate($request, [
            'site_logo' => 'image|mimes:jpg,jpeg,png,gif|max:100000',
        ]);
        $data = $request->except('site_logo');
        //writting mail info in .env file
        $path = '.env';
        $searchArray = array('APP_TIMEZONE='.env('APP_TIMEZONE'));
        $replaceArray = array('APP_TIMEZONE='.$data['timezone']);

        file_put_contents($path, str_replace($searchArray, $replaceArray, file_get_contents($path)));
        
        $searchArray = array('MAIL_HOST='.env('MAIL_HOST'), 'MAIL_PORT='.env('MAIL_PORT'), 'MAIL_FROM_ADDRESS='.env('MAIL_FROM_ADDRESS'), 'MAIL_FROM_NAME='.env('MAIL_FROM_NAME'), 'MAIL_USERNAME='.env('MAIL_USERNAME'), 'MAIL_PASSWORD='.env('MAIL_PASSWORD'), 'MAIL_ENCRYPTION='.env('MAIL_ENCRYPTION'));

        $replaceArray = array('MAIL_HOST='.$data['mail_host'], 'MAIL_PORT='.$data['port'], 'MAIL_FROM_ADDRESS='.$data['mail_address'], 'MAIL_FROM_NAME='.$data['mail_name'], 'MAIL_USERNAME='.$data['mail_address'], 'MAIL_PASSWORD='.$data['password'], 'MAIL_ENCRYPTION='.$data['encryption']);
        
        file_put_contents($path, str_replace($searchArray, $replaceArray, file_get_contents($path)));
        //

        $settings = Settings::firstOrNew(['id' => 1]);
        $settings->id = 1;
        $settings->site_title = $data['site_title'];
        $settings->mail_host = $data['mail_host'];
        $settings->port = $data['port'];
        $settings->mail_address = $data['mail_address'];
        $settings->mail_name = $data['mail_name'];
        $settings->username = $data['mail_address'];
        $settings->password = $data['password'];
        $settings->encryption = $data['encryption'];
        $settings->currency = $data['currency'];
        $logo = $request->site_logo;
        if ($logo) {
            $logoName = $logo->getClientOriginalName();
            $logo->move('public/logo', $logoName);
            $settings->site_logo = $logoName;
        }
        $settings->save();
        return redirect('settings')->with('message', 'Data inserted successfully');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
