<?php

namespace WriteLabel\Http\Requests;

use Auth;
use Gate;
use Siravel\Models\Negocios\Promotion;
use Illuminate\Foundation\Http\FormRequest;

class PromotionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (\Illuminate\Support\Facades\Config::get('app.env') !== 'testing') {
            return Gate::allows('cms', Auth::user());
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return app(Promotion::class)->rules;
    }
}
