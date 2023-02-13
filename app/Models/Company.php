<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\Conversion\Conversion;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Company extends Model implements HasMedia
{
    use HasFactory;
    use HasMediaTrait;

    protected $with = [
        'industry'
    ];

    protected $appends = [
        'logo_url'
    ];

    protected $fillable = [
        'industry_id',
        'name',
        'website',
        'location',
        'primary_email',
        'description',
        'tin_number',
        'logo',
        'ajiriwa_balance',
        'hires_per_year',
        'source',
        'type',
        'original_user',
        'page_views',
        'slug'
    ];

    public function getLogoUrlAttribute(){
        $media_id = $this->logo;
        if($media_id){
            return asset(Media::find($media_id)->getUrl());
        }
        return asset('/images/logo-placeholder-image.png');
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'original_user')/* ->select("name", "role", "email", "phone") */;
    }

    public function industry(){
        return $this->hasOne(Industry::class, 'id', 'industry_id');
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('logo');

        // you can define as many collections as needed
        $this->addMediaCollection('cover');
    }

    public function verification(){
        return $this->hasOne(CompanyVerification::class, 'company_id', 'id');
    }

    public function verification_attempt(){
        return $this->hasOne(VerificationAttempt::class, 'company_id', 'id');
    }

    public function verification_rejected(){
        return $this->hasOneThrough(CompanyVerificationRejection::class, VerificationAttempt::class, 'company_id', 'attempt_id', 'id', 'id');
    }

    /*public function media()
    {
        // TODO: Implement media() method.
    }

    public function addMedia($file)
    {
        // TODO: Implement addMedia() method.
    }

    public function copyMedia($file)
    {
        // TODO: Implement copyMedia() method.
    }

    public function hasMedia(string $collectionMedia = ''): bool
    {
        // TODO: Implement hasMedia() method.
    }

    public function getMedia(string $collectionName = 'default', $filters = [])
    {
        // TODO: Implement getMedia() method.
    }

    public function clearMediaCollection(string $collectionName = 'default')
    {
        // TODO: Implement clearMediaCollection() method.
    }

    public function clearMediaCollectionExcept(string $collectionName = 'default', $excludedMedia = [])
    {
        // TODO: Implement clearMediaCollectionExcept() method.
    }

    public function shouldDeletePreservingMedia()
    {
        // TODO: Implement shouldDeletePreservingMedia() method.
    }

    public function loadMedia(string $collectionName)
    {
        // TODO: Implement loadMedia() method.
    }

    public function addMediaConversion(string $name): Conversion
    {
        // TODO: Implement addMediaConversion() method.
    }

    public function registerMediaConversions(Media $media = null)
    {
        // TODO: Implement registerMediaConversions() method.
    }

    public function registerMediaCollections()
    {
        // TODO: Implement registerMediaCollections() method.
    }

    public function registerAllMediaConversions()
    {
        // TODO: Implement registerAllMediaConversions() method.
    }*/
}
