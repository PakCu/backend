<?php

class Talk extends Ardent {

    /**
    * Fillable columns
    */
    protected $fillable = [
        'user_id',
        'location_id',
        'title',
        'youtube_url',
        'rmtp_url',
        'status',

    ];

    /**
    * These attributes excluded from the model's JSON form.
    * @var array
    */
    protected $hidden = [
    // 'password'
    ];

    /**
    * Validation Rules
    */
    private static $_rules = [
        'store' => [
            'user_id' => 'required',
            'location_id' => 'required',
            'title' => 'required',
            // 'youtube_url' => 'required',
            // 'rmtp_url' => 'required',
            // 'status' => 'required',

        ],
        'update' => [
            'user_id' => 'required',
            'location_id' => 'required',
            'title' => 'required',
            // 'youtube_url' => 'required',
            // 'rmtp_url' => 'required',
            // 'status' => 'required',

        ]
    ];

    public static $rules = [];

    public static function setRules($name)
    {
        self::$rules = self::$_rules[$name];
    }

    /**
    * ACL
    */

    public static function canList() 
    {
        return (Auth::user() && Auth::user()->ability(['Admin', 'Talk Admin'], ['Talk:list']));
    }

    public static function canCreate() 
    {
        return (Auth::user() && Auth::user()->ability(['Admin', 'Talk Admin'], ['Talk:create']));
    }

    public function canShow()
    {
        $user = Auth::user();
        if(Auth::user() && Auth::user()->ability(['Admin', 'Talk Admin'], ['Talk:show']))
            return true;
        return false;
    }

    public function canUpdate() 
    {
        $user = Auth::user();
        if(Auth::user() && Auth::user()->ability(['Admin', 'Talk Admin'], ['Talk:edit']))
            return true;
        return false;
    }

    public function canDelete() 
    {
        $user = Auth::user();
        if(Auth::user() && Auth::user()->ability(['Admin', 'Talk Admin'], ['Talk:delete']))
            return true;
        return false;
    }

    /**
    * Relationships
    */
   
    // public function status()
    // {
    //     return $this->belongsTo('Status');
    // }


    /**
    * Model Helpers
    */
   
    public static function options()
    {
        return self::lists('name', 'id');
    }
   
    public static function findWhere($name)
    {
        return self::where('name', $name)->first();
    }

    /**
    * Decorators
    */

    public function getNameAttribute($value)
    {
        return $value;
    }

    /**
    * Boot Method
    */

    public static function boot()
    {
        parent::boot();

        self::creating(function($talk){
            $talk->status = 'Awaiting Pairing';
        });

        // self::updated(function(){
        //     Cache::tags('Talk')->flush();
        // });

        // self::deleted(function(){
        //     Cache::tags('Talk')->flush();
        // });
    }
}
