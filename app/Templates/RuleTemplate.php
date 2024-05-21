<?php

namespace App\Rules;

use App\MoCheck{Module};
use Closure;
use Illuminate\Contracts\Validation\Rule;

class Check{Module}ChildrenRule implements Rule
{

    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function passes($attribute, $value)
    {
        reCheck{Module}::isNodeCheck($this->id);

    }
    public function message()
    {
        return 'Danh mục này vẫn tồn tại danh mục con';
    }
}
