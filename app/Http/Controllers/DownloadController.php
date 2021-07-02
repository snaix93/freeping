<?php

namespace App\Http\Controllers;

class DownloadController extends Controller
{
    public function show(string $file)
    {
        switch ($file) {
            case 'pulse.sh':
                return redirect("https://raw.githubusercontent.com/cloudradar-monitoring/omc/main/Linux/pulse/pulse.sh");
            case 'pulse.ps1':
                return redirect("https://raw.githubusercontent.com/cloudradar-monitoring/omc/main/Windows/pulse/pulse.ps1");
            default:
                abort(404);
        }
    }
}
