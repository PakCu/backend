<?php

class Location extends Ardent {

    /**
    * Fillable columns
    */
    protected $fillable = [
        'device_hash',
        'name',

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
            'device_hash' => 'required',
            'name' => 'required',

        ],
        'update' => [
            'device_hash' => 'required',
            'name' => 'required',

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
        return (Auth::user() && Auth::user()->ability(['Admin', 'Location Admin'], ['Location:list']));
    }

    public static function canCreate() 
    {
        return (Auth::user() && Auth::user()->ability(['Admin', 'Location Admin'], ['Location:create']));
    }

    public function canShow()
    {
        $user = Auth::user();
        if(Auth::user() && Auth::user()->ability(['Admin', 'Location Admin'], ['Location:show']))
            return true;
        return false;
    }

    public function canUpdate() 
    {
        $user = Auth::user();
        if(Auth::user() && Auth::user()->ability(['Admin', 'Location Admin'], ['Location:edit']))
            return true;
        return false;
    }

    public function canDelete() 
    {
        $user = Auth::user();
        if(Auth::user() && Auth::user()->ability(['Admin', 'Location Admin'], ['Location:delete']))
            return true;
        return false;
    }

    /**
    * Relationships
    */
   
    public function talks()
    {
        return $this->hasMany('Talk');
    }


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

        // self::created(function(){
        //     Cache::tags('Location')->flush();
        // });

        // self::updated(function(){
        //     Cache::tags('Location')->flush();
        // });

        // self::deleted(function(){
        //     Cache::tags('Location')->flush();
        // });
    }
}
