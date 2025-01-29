<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterCms extends Model
{
    use HasFactory;

    protected $fillable = [
        'footer_description',
        'website_name',
        'address',
        'email',
        'phone',
        'business_phone',
        'newsletter_title',
    ];

    public function footerSocialLinks()
    {
        return $this->hasMany(FooterSocialLink::class);
    }

}
