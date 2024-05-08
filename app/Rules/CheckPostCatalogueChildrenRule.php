<?php

namespace App\Rules;

use App\Models\PostCatalogue;
use Illuminate\Contracts\Validation\Rule;

class CheckPostCatalogueChildrenRule implements Rule
{

    protected $id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
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
     */
    public function passes($attribute, $value)
    {
        return PostCatalogue::isChildrentNode($this->id);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Danh mục này vẫn tồn tại danh mục con';
    }
}
