<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model {

    /**
     * @primaryKey string - primry key column.
     * @dateFormat string - date storage format
     * @guarded string - allow mass assignment except specified
     * @CREATED_AT string - creation date column
     * @UPDATED_AT string - updated date column
     */

    protected $primaryKey = 'message_id';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $fillable = ['from_phone_id', 'to_phone_id', 'message_text', 'message_source', 'message_created', 'message_type', 'image_url', 'audio_url', 'document_url', 'video_url', 'sticker_url'];
    protected $guarded = ['message_id'];
    const CREATED_AT = 'message_created';
    const UPDATED_AT = 'message_updated';

    public function sender()
    {
        return $this->belongsTo(PhoneNumber::class, 'from_phone_id');
    }

    public function receiver()
    {
        return $this->belongsTo(PhoneNumber::class, 'to_phone_id');
    }
}