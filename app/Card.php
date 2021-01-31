<?php

namespace App;

use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Card extends Model
{
    const ASSETS_FOLDER = 'cards/';
    const ASSETS_SEED_FOLDER = 'app/seeds/cards/';

    const MODELS_FOLDER = 'Cards\\';

    protected $fillable = [
        'cardable_type',
        'cardable_id'
    ];

    protected static function boot() :void
    {
        parent::boot();

        static::deleting(function($card) {
            $card->cardable_type::destroy($card->id);
        });
    }

    public function cardable() {
        return $this->morphTo();
    }

    public function collection() {
        return $this->belongsTo('App\Collection');
    }

    public function images() {
        return $this->hasMany('App\Image');
    }

    public function answers() {
        return $this->hasMany('App\Answer');
    }

    public static function types() {
        return collect(File::allFiles(app_path(self::MODELS_FOLDER)))
                ->map(function($type) {
                    $className = Str::before($type->getFileName(), '.php');

                    if (Card::existCardType($className)) {
                        return [
                            'name' => Str::title(str_replace('_', ' ', Str::snake($className))),
                            'value' => $className
                        ];
                    }
                });
    }

    public function saveCardAsset($file) {
        if ($file !== null) {
            self::createAssetDirectory();
            return Storage::disk('public')->putFile($this->getAssetDirectory(), $file);
        }

        return null;
    }

    public function deleteCardAssets() {
        return Storage::disk('public')->deleteDirectory($this->getAssetDirectory());
    }

    public static function getNamespace() {
        return Container::getInstance()
            ->getNamespace().Card::MODELS_FOLDER;
    }

    public static function existCardType(String $model) {
        return class_exists(self::getNamespace().$model);
    }

    private static function createAssetDirectory() {
        if (!Storage::disk('public')->exists(self::ASSETS_FOLDER)) {
            Storage::disk('public')->makeDirectory(self::ASSETS_FOLDER);
        }
    }

    private function getAssetDirectory() {
        return self::ASSETS_FOLDER . $this->id;
    }
}
