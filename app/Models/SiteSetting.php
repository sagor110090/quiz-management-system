<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
	use HasFactory;

    public $timestamps = true;

    protected $table = 'site_settings';

    protected $fillable = ['website_name','website_logo','website_favicon'];

    //website logo
    public function getWebsiteLogoAttribute()
    {
        return 'image/logo.jpeg';
    }


}
