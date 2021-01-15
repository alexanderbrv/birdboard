<?php

namespace App\Http\Requests;

use App\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;


class ProjectRequest extends FormRequest
{
    private $project;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->method() == "POST") {
            return true;
        }

        $this->setProject();

        return Gate::allows('author-or-member', $this->project);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'       => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'notes'       => 'nullable|string',
        ];
    }

    public function save()
    {
        return tap($this->project)->update($this->validated());
    }

    private function setProject()
    {
        $this->project = Project::findOrFail($this->route('project'));
    }
}
