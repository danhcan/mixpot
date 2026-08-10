<?php

namespace Inovector\Mixpost\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use Inovector\Mixpost\Util;

class SystemStatusController extends Controller
{
    public function __invoke(Request $request): Response
    {
        return Inertia::render('System/Status', [
            'health' => [
                'env' => app()->environment(),
                'debug' => Config::get('app.debug'),
                'last_scheduled_run' => [],
            ],
            'tech' => [
                'cache_driver' => Config::get('cache.default'),
                'base_path' => base_path(),
                'disk' => Config::get('mixpost.disk'),
                'log_channel' => Config::get('mixpost.log_channel') ? Config::get('mixpost.log_channel') : Config::get('logging.default'),
                'user_agent' => $request->userAgent(),
                'ffmpeg_status' => Util::isFFmpegInstalled() ? 'Installed' : 'Not Installed',
                'versions' => [
                    'php' => PHP_VERSION,
                    'laravel' => app()->version(),
                    'mysql' => $this->mysqlVersion(),
                    'mixpost' => \Composer\InstalledVersions::getVersion('inovector/mixpost'),
                ],
            ],
        ]);
    }

    protected function mysqlVersion(): string
    {
        if (! Util::isMysqlDatabase()) {
            return '';
        }

        $results = DB::select('select version() as version');

        return (string) $results[0]->version;
    }
}
