<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEvidenceRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'evidence_type' => 'required|in:photo,video,document',
            'file' => ['required','file','max:10240'], // further validated by mime in after validation
            'description' => 'nullable|string|max:1000',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->hasFile('file')) {
                $type = $this->input('evidence_type');
                $file = $this->file('file');
                if ($type === 'photo' && !in_array($file->getClientOriginalExtension(), ['jpg','jpeg','png'])) {
                    $validator->errors()->add('file', 'Foto harus berekstensi jpg, jpeg, atau png.');
                }
                if ($type === 'video' && $file->getClientOriginalExtension() !== 'mp4') {
                    $validator->errors()->add('file', 'Video harus berformat mp4.');
                }
                if ($type === 'document' && $file->getClientOriginalExtension() !== 'pdf') {
                    $validator->errors()->add('file', 'Dokumen harus berformat PDF.');
                }
            }
        });
    }
}
