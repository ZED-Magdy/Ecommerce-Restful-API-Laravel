<?php

namespace App\Triats;

use App\Models\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait Imageable {

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images(){
        return $this->morphMany('App\Models\Image','imageable');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAvatarAttribute(){
        if($this->relationLoaded('images')){
            return $this->images->where('imageable_type',__CLASS__)
                                ->where('imageable_id',$this->getKey())
                                ->where('type','avatar')->first();
        }
        return $this->images()->where('imageable_type',__CLASS__)
                              ->where('imageable_id',$this->getKey())
                              ->where('type','avatar')->first();
    }

    /**
     *
     * @param UploadedFile[] $uploadedFile
     * @param string $storage
     * @param boolean $update
     * @return bool
     */
    public function addImages(array $uploadedFiles, string $storage = "public", bool $update = false){
        if($update){
            $this->deleteImages();
        }
        foreach($uploadedFiles as $uploadedFile){
            $url = $this->saveImageFile($uploadedFile,$storage);
            $this->createImage($url);
        }
    }

    /**
     *
     * @param UploadedFile $uploadedFile
     * @param string $storage
     * @param boolean $update
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function addAvatar(UploadedFile $uploadedFile, string $storage = "public", bool $update = false)
    {
        $url = $this->saveImageFile($uploadedFile,$storage);
        if(!$update){
            return $this->createImage($url,"avatar");
        }
        $oldImage = $this->avatar->url;
        $image = $this->avatar->update([
            'url' => $url
        ]);
        $this->deleteImageFile($oldImage);
        return $image;
    }

    /**
     *
     * @param string $url
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function createImage(string $url, string $type = null){
        $image = new Image;
        $image->url = $url;
        $image->type = $type;
        $image = $this->images()->save($image);
        return $image;
    }

    /**
     *
     * @param UploadedFile $uploadedFile
     * @param string $storage
     * @return string $url
     */
    public function saveImageFile(UploadedFile $uploadedFile, string $storage){
        $ext = $uploadedFile->getClientOriginalExtension();
        $name = uniqid('',true).'.'.$ext;
        $path = '/images/'.$name;
        Storage::disk($storage)->put($path,file_get_contents($uploadedFile));
        $url = Storage::disk($storage)->url($path);
        return $url;
    }

    /**
     *
     * @return bool
     */
    public function deleteImages(){
        if($this->relationLoaded('images')){
            foreach ($this->images as $image) {
                $this->deleteImageFile($image->url);
                $image->delete();
            }
        }
        else{
            foreach ($this->images() as $image) {
                $this->deleteImageFile($image->url);
                $image->delete();
            }
        }
        return true;
    }

    /**
     *
     * @param string $url
     * @return bool
     */
    private function deleteImageFile(string $url){
        return Storage::delete($url);
    }
}