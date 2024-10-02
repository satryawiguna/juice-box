<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public function setCreatedInfo(string $created_by): void
    {
        $this->setAttribute('created_by', $created_by);
        $this->setAttribute('created_at', Carbon::now()->toDateTimeString());
    }

    public function setUpdatedInfo(string $updated_by): void
    {
        $this->setAttribute('updated_by', $updated_by);
        $this->setAttribute('updated_at', Carbon::now()->toDateTimeString());
    }
}
