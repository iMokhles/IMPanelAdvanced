<?php

namespace App\Http\Controllers\Backpack;

use Backpack\LogManager\app\Classes\LogViewer;
use Illuminate\Routing\Controller;

class LogController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Lists all log files.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->data['files'] = LogViewer::getFiles(true, true);
        $this->data['title'] = trans('backpack::logmanager.log_manager');

        return view('backpack.logs', $this->data);
    }

    /**
     * Previews a log file.
     *
     * @throws \Exception
     */
    public function preview($file_name)
    {
        LogViewer::setFile(base64_decode($file_name));

        $logs = LogViewer::all();

        if (count($logs) <= 0) {
            abort(404, trans('backpack::logmanager.log_file_doesnt_exist'));
        }

        $this->data['logs'] = $logs;
        $this->data['title'] = trans('backpack::logmanager.preview').' '.trans('backpack::logmanager.logs');
        $this->data['file_name'] = base64_decode($file_name);

        return view('backpack.log_item', $this->data);
    }

    /**
     * Downloads a log file.
     *
     * @param $file_name
     *
     * @throws \Exception
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($file_name)
    {
        return response()->download(LogViewer::pathToLogFile(base64_decode($file_name)));
    }

    /**
     * Deletes a log file.
     *
     * @param $file_name
     *
     * @throws \Exception
     *
     * @return string
     */
    public function delete($file_name)
    {
        if (app('files')->delete(LogViewer::pathToLogFile(base64_decode($file_name)))) {
            return 'success';
        }

        abort(404, trans('backpack::logmanager.log_file_doesnt_exist'));
    }
}
