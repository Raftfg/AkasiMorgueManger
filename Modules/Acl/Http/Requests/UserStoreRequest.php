<?php

namespace Modules\Acl\Http\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends UserRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return user_api()->isPermission("create $this->entite");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $rules = $this->reglesCommunes();
        return $rules;
    }

}
