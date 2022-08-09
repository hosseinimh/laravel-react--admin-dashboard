<?php

namespace App\Http\Controllers;

use App\Constants\UploadedFile;
use App\Helpers\Helper;
use App\Models\Post;
use App\Models\Service;
use Illuminate\Http\Request;

class FileUploaderController extends Controller
{
    private $serviceImageStorage;
    private $postThumbnailStorage;
    private $postImageStorage;

    function __construct()
    {
        $this->serviceImageStorage = 'public/storage/services/images';
        $this->postThumbnailStorage = 'public/storage/posts/thumbnails';
        $this->postImageStorage = 'public/storage/posts/images';
    }

    public function uploadServiceImage(Service $service, Request $request)
    {
        $result = ['uploaded' => UploadedFile::NOT_UPLOADED_ERROR, 'uploadedText' => ''];

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if (($fileMimeType = $request->file('image')->getMimeType()) && $fileMimeType === 'image/jpeg' || $fileMimeType === 'image/png') {
                $path = $request->image->store($this->serviceImageStorage);
                Helper::resizeImage(storage_path('app') . '/' . $path, 200);

                if ($path) {
                    @unlink(storage_path('app') . '/' . $this->serviceImageStorage . '/' . $service->image);

                    $data = ['image' => basename($path)];

                    if ($service->update($data)) {
                        $result['uploaded'] = UploadedFile::OK;
                    } else {
                        $result['uploaded'] = UploadedFile::ERROR;
                    }
                } else {
                    $result['uploaded'] = UploadedFile::UPLOAD_ERROR;
                }
            } else {
                $result['uploaded'] = UploadedFile::MIME_TYPE_ERROR;
            }
        } else {
            $result['uploaded'] = UploadedFile::NOT_UPLOADED_ERROR;
        }

        $result['uploadedText'] = $this->getUploadedText($result['uploaded']);

        return $result;
    }

    public function uploadPostThumbnail(Post $post, Request $request)
    {
        $result = ['uploaded' => UploadedFile::NOT_UPLOADED_ERROR, 'uploadedText' => ''];

        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            if (($fileMimeType = $request->file('thumbnail')->getMimeType()) && $fileMimeType === 'image/jpeg' || $fileMimeType === 'image/png') {
                $path = $request->thumbnail->store($this->postThumbnailStorage);
                Helper::resizeImage(storage_path('app') . '/' . $path, 200);

                if ($path) {
                    @unlink(storage_path('app') . '/' . $this->postThumbnailStorage . '/' . $post->thumbnail);

                    $data = ['thumbnail' => basename($path)];

                    if ($post->update($data)) {
                        $result['uploaded'] = UploadedFile::OK;
                    } else {
                        $result['uploaded'] = UploadedFile::ERROR;
                    }
                } else {
                    $result['uploaded'] = UploadedFile::UPLOAD_ERROR;
                }
            } else {
                $result['uploaded'] = UploadedFile::MIME_TYPE_ERROR;
            }
        } else {
            $result['uploaded'] = UploadedFile::NOT_UPLOADED_ERROR;
        }

        $result['uploadedText'] = $this->getUploadedText($result['uploaded']);

        return $result;
    }

    public function uploadPostImage(Post $post, Request $request)
    {
        $result = ['uploaded' => UploadedFile::NOT_UPLOADED_ERROR, 'uploadedText' => ''];

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if (($fileMimeType = $request->file('image')->getMimeType()) && $fileMimeType === 'image/jpeg' || $fileMimeType === 'image/png') {
                $path = $request->image->store($this->postImageStorage);
                Helper::resizeImage(storage_path('app') . '/' . $path, 200);

                if ($path) {
                    @unlink(storage_path('app') . '/' . $this->postImageStorage . '/' . $post->image);

                    $data = ['image' => basename($path)];

                    if ($post->update($data)) {
                        $result['uploaded'] = UploadedFile::OK;
                    } else {
                        $result['uploaded'] = UploadedFile::ERROR;
                    }
                } else {
                    $result['uploaded'] = UploadedFile::UPLOAD_ERROR;
                }
            } else {
                $result['uploaded'] = UploadedFile::MIME_TYPE_ERROR;
            }
        } else {
            $result['uploaded'] = UploadedFile::NOT_UPLOADED_ERROR;
        }

        $result['uploadedText'] = $this->getUploadedText($result['uploaded']);

        return $result;
    }

    private function getUploadedText($uploaded)
    {
        $text = __('general.uploaded_undefined');

        if ($uploaded >= 1 && $uploaded <= 6) {
            $text = __('general.uploaded_' . $uploaded);
        }

        return $text;
    }
}
