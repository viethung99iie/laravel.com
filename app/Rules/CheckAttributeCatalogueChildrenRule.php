<?php

namespace App\Rules;

use App\Models\AttributeCatalogue;
use Closure;
use Illuminate\Contracts\Validation\Rule;

class CheckAttributeCatalogueChildrenRule implements Rule
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
        return AttributeCatalogue::isNodeCheck($this->id);

    }
    public function message()
    {
        return 'Danh mục này vẫn tồn tại danh mục con';
    }
}
