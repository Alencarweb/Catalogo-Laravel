<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConfigController extends Controller
{
    public function index()
    {
        $configPath = public_path('conf/info.json');
        $data = [];

        if (file_exists($configPath)) {
            $json = file_get_contents($configPath);
            $data = json_decode($json, true);
        }

        return view('admin.config.index', compact('data'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'info' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = [];

        if ($request->hasFile('logo')) {
            $logoName = 'logo.png';
            $request->file('logo')->move(public_path('conf'), $logoName);
            $data['logo'] = 'conf/' . $logoName;
        } else {
            // Manter a logo antiga se existir
            $existing = json_decode(file_get_contents(public_path('conf/info.json')), true);
            if ($existing && isset($existing['logo'])) {
                $data['logo'] = $existing['logo'];
            }
        }

        $data['info'] = $request->input('info');

        file_put_contents(public_path('conf/info.json'), json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return redirect()->back()->with('success', 'Configurações salvas com sucesso.');
    }
}
