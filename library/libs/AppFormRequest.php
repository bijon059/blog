<?php
namespace library\libs;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AppFormRequest extends FormRequest
{
    public function rules() {
        $rules=$this->AppRules();
        $keys=$this->request->keys();
        if ($this->method() == 'PATCH')
        {
           return  array_filter($rules,function($k)use($keys){
                return in_array($k,$keys);
            },ARRAY_FILTER_USE_KEY);
        }else{
            return $rules;
        }
    }
    public function AppRules(){
        return [];
    }
    public function failedValidation(Validator $validator)
    {
        $api=new ApiResponse();
        $api->setStatus(false,422);
        foreach ( $validator->errors()->getMessages() as $errors ) {
            foreach ( $errors as $error ) {
                addError( $error );
            }
        }
        throw new HttpResponseException($api->display());
    }


}
