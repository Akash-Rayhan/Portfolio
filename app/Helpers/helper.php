<?php

use Illuminate\Support\Facades\Storage;

/**
 * @param int $length
 * @return string
 */
function randomNumber($length = 10)
{
    $x = '123456789';
    $c = strlen($x) - 1;
    $response = '';
    for ($i = 0; $i < $length; $i++) {
        $y = rand(0, $c);
        $response .= substr($x, $y, 1);
    }

    return $response;
}

/**
 * @return string
 */
function userResumePath()
{
    return 'storage/resumes/';
}

/**
 * @param $file
 * @param $destinationPath
 * @param null $oldFile
 * @return bool|string
 */
function uploadFile($file, $destinationPath, $oldFile = null)
{
    if ($oldFile != null) {
        deleteFile($destinationPath, $oldFile);
    }

    $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
    $uploaded = Storage::put($destinationPath . $fileName, file_get_contents($file->getRealPath()));
    if ($uploaded == true) {
        return $fileName;
    }
    return false;
}

/**
 * @param $destinationPath
 * @param $fileName
 * @return bool
 */
function deleteFile($destinationPath, $fileName)
{
    if ($fileName != null) {
        try {
            $exists = Storage::exists($destinationPath.'/'.$fileName);

            if (!$exists) {
                return false;
            }
            Storage::delete($destinationPath . $fileName);

            return true;
        } catch (Exception $e) {

            return false;
        }
    }
}

/**
 * @param $destinationPath
 * @param $fileName
 * @return bool
 */
function downloadFile($destinationPath, $fileName){
    if ($fileName != null) {
        try {
            $exists = Storage::exists($destinationPath.'/'.$fileName);

            if (!$exists) {
                return false;
            }

            return Storage::download($destinationPath . $fileName);
        } catch (Exception $e) {

            return false;
        }
    }
}
