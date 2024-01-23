<?php

namespace App\Models;

use CodeIgniter\Model;

class SocialMedia extends Model
{
    protected $table            = 'social_media';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'twitter_url',
        'instagram_url',
        'youtube_url',
        'github_url',
        'tiktok_url',
        'whatsapp_url',
    ];
}
