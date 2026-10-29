<?php

namespace App\Http\Resources\v2\Teacher;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeworkEvaluationListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

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
            'id' => $this->id,
            'subject_name' => @$this->subjects->subject_name,
            'evaluate_date' => $this->evaluation_date,
            'file' => $fileUrl,
            'marks' => $this->marks,
            'submission_date' => $this->submission_date,
        ];
    }
}
