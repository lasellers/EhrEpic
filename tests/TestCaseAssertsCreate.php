<?php

namespace Tests;

use App\Models\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\Constraint\IsInstanceOf;

trait TestCaseAssertsCreate
{

    /**
     * Checks if created model was added to table.
     * @param $model
     * @param null $class
     */
    public function assertModelCreated($model, $class = null)
    {
        $this->assertNotNull($model);

        if (is_null($class)) {
            $class = get_class($model);
        }

        $id = is_array($model) ? $model['id'] : $model->id;

        $this->assertGreaterThan(0, $id, "id is not numeric");

        $item = $class::find($id);
        $this->assertNotEmpty($item, "CREATE could not find $class #{$id} in database");
    }

    /**
     * @param $items
     * @param $class
     */
    public function assertModelsCreated(
        $items,
        $class
    ) {
        foreach ($items as $key => $item) {
            $id = $item['id'];
            $model = $class::find($id);
            $this->assertModelCreated($model);
        }
    }

    /**
     * @param $model
     * @param  null  $class
     */
    public function assertModelMade($model, $class = null)
    {
        //
        $this->assertNotNull($model);
    }

}
