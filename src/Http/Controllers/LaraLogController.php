<?php

namespace MoriTiza\LaraLog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class LaraLogController extends Controller
{
    private $singleLogs = array();
    private $dailyLogs = array();
    private $dailyLogsFiles = array();

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->singleLogsHandler();
        $this->dailyLogsHandler();

        $singleLogs = array_reverse($this->singleLogs);
        $dailyLogs = array_reverse($this->dailyLogs);

        $logQuery = $request->input('log');

        if (isset($logQuery) && (! is_null($logQuery)) && array_key_exists($logQuery, $this->dailyLogs)) {
            $currentLog = $logQuery;
        } elseif (file_exists(storage_path('logs/laravel.log'))) {
            $currentLog = 'laravel';
        } elseif (count($dailyLogs) > 0) {
            $currentLog = array_key_first($dailyLogs);
        }

        if ($currentLog === 'laravel') {
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $logsCollection = collect($singleLogs);
            $perPage = 5;
            $currentPageItems = $logsCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
            $paginatedSingleLogs = new LengthAwarePaginator($currentPageItems , count($logsCollection), $perPage);
            $paginatedSingleLogs->setPath($request->url());
        } else {
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $logsCollection = collect(array_reverse($dailyLogs[$logQuery]));
            $perPage = 5;
            $currentPageItems = $logsCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
            $paginatedDailyLogs = new LengthAwarePaginator($currentPageItems , count($logsCollection), $perPage);
            $paginatedDailyLogs->setPath('logs?log=' . $currentLog);
        }

        if (isset($paginatedDailyLogs)) {
            return view('laralog::logs', compact('singleLogs', 'dailyLogs', 'currentLog', 'paginatedDailyLogs'));
        }

        return view('laralog::logs', compact('singleLogs', 'dailyLogs', 'currentLog', 'paginatedSingleLogs'));
    }

    private function singleLogsHandler()
    {
        if (file_exists(storage_path('logs/laravel.log'))) {
            $contents = file(storage_path('logs/laravel.log'));

            foreach ($contents as $key => $value) {
                $this->singleLogs[] = trim(preg_replace('/\s\s+/', ' ', $value));
            }

            $this->deleteAdditionalSingleLogs();
        }
    }

    private function dailyLogsHandler()
    {
        $files = scandir(storage_path('logs'));

        foreach ($files as $key => $value) {
            if (preg_match("/^laravel-20(1[9]|2[0-9])-(0[1-9]|1[0,1,2])-(0[1-9]|1[0-9]|2[0-9]|3[0,1])['.']log$/", $value)) {
                $this->dailyLogsFiles[] = $value;
            }
        }

        if (count($this->dailyLogsFiles) > 0) {
            foreach ($this->dailyLogsFiles as $key => $value) {

                $dailyLogsKey = substr($value, 8, 10);
                $this->dailyLogs[$dailyLogsKey] = array();

                $contents = file(storage_path('logs/' . $value));

                foreach ($contents as $contentsKey => $contentsValue) {
                    $this->dailyLogs[$dailyLogsKey][] = trim(preg_replace('/\s\s+/', ' ', $contentsValue));
                }

                $this->dailyLogs[$dailyLogsKey] = $this->deleteAdditionalDailyLogs($this->dailyLogs[$dailyLogsKey]);
            }
        }


    }

    private function deleteAdditionalSingleLogs()
    {
        foreach ($this->singleLogs as $key => $value) {
            if ($value === trim('[stacktrace]') || $value === trim('"}') || trim($value) == null || preg_match('/^#[0-9]+[\' \']/', $value) || preg_match('/^\[previous exception\] \[object\]/', $value)) {
                unset($this->singleLogs[$key]);
            }
       }
    }

    private function deleteAdditionalDailyLogs($dailyLogs)
    {
        foreach ($dailyLogs as $key => $value) {
            if ($value === trim('[stacktrace]') || $value === trim('"}') || trim($value) == null || preg_match('/^#[0-9]+[\' \']/', $value) || preg_match('/^\[previous exception\] \[object\]/', $value)) {
                unset($dailyLogs[$key]);
            }
        }

        return $dailyLogs;
    }
}
