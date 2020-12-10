<?php

namespace Sparkinzy\Dcat\Kindeditor\Http\Controllers;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileController
{

    protected $file_name = 'file';

    public function handle(Request $request)
    {
        try {
            $file = $request->file($this->file_name);
            $dir = trim($request->get('dir'), '/');
            $disk = $this->disk();

            $newName = $this->generateNewName($file);

            $disk->putFileAs($dir, $file, $newName);

            return $this->sendSuccessResponse($disk->url("{$dir}/$newName"));
        }catch (\Exception $exception){
            return $this->sendErrorResponse($exception->getMessage());
        }

    }

    protected function generateNewName(UploadedFile $file)
    {
        return uniqid(md5($file->getClientOriginalName())).'.'.$file->getClientOriginalExtension();
    }

    /**
     * @return \Illuminate\Contracts\Filesystem\Filesystem|FilesystemAdapter
     */
    protected function disk()
    {
        $disk = request()->get('disk') ?: config('admin.upload.disk');

        return Storage::disk($disk);
    }

    public function sendSuccessResponse($url)
    {
        return response()->json([
            'error' => 0,
            'url'   => $url,
        ]);
    }

    public function sendErrorResponse($message)
    {
        return response()->json([
            'error'   => 1,
            'message' => $message,
        ]);
    }

}
