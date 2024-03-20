<?php

namespace Modules\Acl\Http\Requests;

use Illuminate\Validation\Rule;

class UserUpdateRequest extends UserRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return user_api()->isPermission("update $this->entite");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $uuid = request()->route($this->nom_param_route);
        $rules = $this->reglesCommunes();
        $rules['email'] = [
            'bail',
            'required',
            'email',
            Rule::unique($this->nom_table)->ignore($uuid, 'uuid'),
        ];
        $rules['password'] = [
            'sometimes',
            'nullable',
            'string',
            'min:8',
        ];
        $rules['confirm_password'] = [
            'sometimes',
            'nullable',
            'string',
            'same:password',
            'min:8',
        ];
        return $rules;
    }

}
