<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEntryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // semua user yang login boleh submit form ini
    }

    public function rules(): array
    {
        return [
            'tanggal' => 'required|date',
            'entries' => 'required|array',
            'entries.*.aktivitas' => 'nullable|in:LOW,MEDIUM,HIGH',
            'entries.*.tindakan' => 'nullable|string|max:255',
            'entries.*.hasil' => 'nullable|string|max:255',
            'entries.*.catatan' => 'nullable|string|max:500',
            'entries.*.gambar' => 'nullable|image|max:2048', // max 2MB, harus gambar
        ];
    }

    public function messages(): array
    {
        return [
            'tanggal.required' => 'Tanggal wajib dipilih.',
            'entries.*.gambar.image' => 'File yang diupload harus berupa gambar.',
            'entries.*.gambar.max' => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}