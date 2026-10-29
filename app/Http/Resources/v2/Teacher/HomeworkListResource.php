<?php

namespace App\Http\Resources\v2\Teacher;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeworkListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $fileUrl = null;
        $rawFiles = is_array($this->file) ? $this->file : json_decode($this->file, true);
        if (is_array($rawFiles) && ! empty($rawFiles)) {
            $firstFile = reset($rawFiles);
            if (! empty($firstFile)) {
                $path = (str_starts_with($firstFile, 'public/') || str_starts_with($firstFile, 'uploads/'))
                    ? $firstFile
                    : 'public/uploads/homeworkcontent/'.$firstFile;
                $fileUrl = (string) assetPath($path);
            }
        } elseif (is_string($this->file) && ! empty($this->file)) {
            $path = (str_starts_with($this->file, 'public/') || str_starts_with($this->file, 'uploads/'))
                ? $this->file
                : 'public/uploads/homeworkcontent/'.$this->file;
            $fileUrl = (string) assetPath($path);
        }

        return [
            'id' => (int) $this->id,
            'subject_name' => (string) @$this->subjects->subject_name,
            'assign_date' => date('Y-m-d', strtotime($this->homework_date)),
            'submission_date' => date('Y-m-d', strtotime($this->submission_date)),
            'evaluation' => (int) $this->evaluated_by,
            'marks' => (float) $this->marks,
            'file' => $fileUrl,
            'class_id' => (int) @$this->class_id,
            'section_id' => (int) @$this->section_id,
            'class_name' => (string) @$this->classes->class_name,
            'section_name' => (string) @$this->sections->section_name,
        ];
    }
}
