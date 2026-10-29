<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SmHomeworkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        if (isset($this->lmsHomeworkCompleted->complete_status) && ($this->lmsHomeworkCompleted->complete_status === 'C')) {
            $status = 'Completed';
        } else {
            $status = 'Incompleted';
        }
        $rawFiles = is_array($this->file) ? $this->file : json_decode($this->file, true);
        $files = [];
        if (is_array($rawFiles)) {
            foreach ($rawFiles as $f) {
                if (! empty($f)) {
                    $path = (str_starts_with($f, 'public/') || str_starts_with($f, 'uploads/'))
                        ? $f
                        : 'public/uploads/homeworkcontent/'.$f;
                    $files[] = assetPath($path);
                }
            }
        } elseif (is_string($this->file) && ! empty($this->file)) {
            $path = (str_starts_with($this->file, 'public/') || str_starts_with($this->file, 'uploads/'))
                ? $this->file
                : 'public/uploads/homeworkcontent/'.$this->file;
            $files[] = assetPath($path);
        }

        return [
            'id' => (int) $this->id,
            'created_at' => date('Y-m-d', strtotime($this->created_at)),
            'submission_date' => (string) $this->submission_date,
            'evaluation_date' => (string) $this->evaluation_date,
            'status' => (string) @$status,
            'marks' => (float) $this->marks,
            'subject' => (string) @$this->subjects->subject_name,
            'file' => isset($files[0]) ? $files[0] : '',
            'obtain_marks' => (float) $this?->lmsHomeworkCompleted?->marks,
        ];
    }
}
