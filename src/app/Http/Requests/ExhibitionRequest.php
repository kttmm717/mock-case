<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'content' => 'required|max:255',
            'image' => 'required|mimes:jpeg,png',
            'categories' => 'required',
            'condition_id' => 'required',
            'price' => 'required|integer|min:0'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'content.required' => '商品の説明を入力してください',
            'content.max' => '商品の説明は255字以内で入力してください',
            'image.required' => '商品画像をアップロードしてください',
            'image.mimes' => '商品画像は拡張子が.jpegもしくは.pngの形式でアップロードしてください',
            'categories.required' => 'カテゴリーを選択してください',
            'condition_id.required' => '商品の状態を選択してください',
            'price.required' => '商品の価格を入力してください',
            'price.integer' => '商品の価格は数値型で入力してください',
            'price.min' => '商品の価格は0円以上で入力してください'
        ];
    }
}
