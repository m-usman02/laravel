<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UniqueUserName implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $table;
    protected $column;
    public function __construct($table, $column)
    {
        $this->table = $table;
        $this->column = $column;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $check = \DB::table($this->table)->where($this->column,$value)->exists();
        if($check){
            return false;
        }        
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Name already exists.';
    }
}
