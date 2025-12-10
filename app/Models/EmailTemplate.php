<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'template_key',
        'name',
        'subject',
        'body',
        'description',
        'variables',
        'is_active',
    ];

    protected $casts = [
        'variables' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get template by key
     */
    public static function getByKey($key)
    {
        return static::where('template_key', $key)
            ->where('is_active', true)
            ->first();
    }

    /**
     * Replace variables in template
     */
    public function replaceVariables($data = [])
    {
        $subject = $this->subject;
        $body = $this->body;

        foreach ($data as $key => $value) {
            $subject = str_replace('{' . $key . '}', $value, $subject);
            $subject = str_replace('{# ' . $key . ' #}', $value, $subject);
            $body = str_replace('{' . $key . '}', $value, $body);
            $body = str_replace('{# ' . $key . ' #}', $value, $body);
        }

        return [
            'subject' => $subject,
            'body' => $body,
        ];
    }
}
