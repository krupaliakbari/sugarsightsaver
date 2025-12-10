<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'description'
    ];

    /**
     * Get a setting value by key
     */
    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }

        // Cast value based on type
        switch ($setting->type) {
            case 'integer':
                return (int) $setting->value;
            case 'boolean':
                return (bool) $setting->value;
            case 'json':
                return json_decode($setting->value, true);
            default:
                return $setting->value;
        }
    }

    /**
     * Set a setting value
     */
    public static function set($key, $value, $type = 'string', $description = null)
    {
        $setting = static::where('key', $key)->first();
        
        if (!$setting) {
            $setting = new static();
            $setting->key = $key;
            $setting->type = $type;
            $setting->description = $description;
        }

        // Convert value based on type
        switch ($type) {
            case 'integer':
                $setting->value = (string) $value;
                break;
            case 'boolean':
                $setting->value = $value ? '1' : '0';
                break;
            case 'json':
                $setting->value = json_encode($value);
                break;
            default:
                $setting->value = (string) $value;
        }

        $setting->save();
        return $setting;
    }

    /**
     * Get all settings as key-value array
     */
    public static function getAll()
    {
        $settings = static::all();
        $result = [];
        
        foreach ($settings as $setting) {
            $result[$setting->key] = self::get($setting->key);
        }
        
        return $result;
    }

    /**
     * Get SMTP settings specifically
     */
    public static function getSmtpSettings()
    {
        return [
            'smtp_host' => self::get('smtp_host', ''),
            'smtp_port' => self::get('smtp_port', 587),
            'smtp_username' => self::get('smtp_username', ''),
            'smtp_password' => self::get('smtp_password', ''),
            'smtp_encryption' => self::get('smtp_encryption', 'tls'),
            'site_email' => self::get('site_email', 'admin@sugarsight.com'),
            'site_name' => self::get('site_name', 'Sugar Sight Saver'),
        ];
    }
}