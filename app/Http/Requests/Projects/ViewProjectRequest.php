<?php

namespace App\Http\Requests\Projects;

use App\Http\Requests\AbstractFormRequest;

class ViewProjectRequest extends AbstractFormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'id' => ['required'],
        ];
    }
}
