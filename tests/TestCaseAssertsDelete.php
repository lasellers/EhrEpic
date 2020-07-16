<?php

namespace Tests;

use App\Models\BaseModel;

trait TestCaseAssertsDelete
{
    /**
     * Deletes model from database and checks if this happened as expected.
     * @param $model
     * @param null $class
     * @param int|null $id
     */
    public function deleteAndAssertDeleted($model, $class = null, int $id = null)
    {
        // if the model is null we just silently return -- if a method we are
        // testing deletes a model, we sometimes will set it to null so that the teardown
        // calling deleteAndAssertDeleted can be ignored.
        if (is_null($model)) {
            return;
        }

        //
        if (is_null($class) && is_array($model)) {
            $this->fail(__METHOD__ . ": Parameter failure: model:" . print_r(
                    $model,
                    true
                ) . " class:" . print_r($class, true));
        }

        //
        if (is_object($model) && is_null($class)) {
            $class = get_class($model);
        } elseif (!is_string($class)) {
            $this->assertTrue(false, __METHOD__ . ": class " . print_r($class, true) . " unusable");
        }

        if (empty($id)) {
            $id = $this->getIdFromModel($model);
        }

        if (empty($id)) {
            $this->assertTrue(false, __METHOD__ . ": No primary key for $class");
            return;
        }

        //
        if (!class_exists($class)) {
            $this->fail(__METHOD__ . ": Class '$class' does not exist");
            return;
        }

        $model = $class::find($id);
        $this->assertNotEmpty($model, __METHOD__ . ": Could not find {$class} #{$id} in database");
        //determine if hard or soft delete should be done.
        $traits = $this->classUsesDeep($class);
        if ((in_array('Illuminate\Database\Eloquent\SoftDeletes', $traits, true))) {
            $deleteType = self::DELETE_TYPE_SOFT;
        } else {
            $deleteType = self::DELETE_TYPE_HARD;
        }

        if ($deleteType == self::DELETE_TYPE_SOFT) {
            // if the model has a soft delete type then after a delete the row should still exist but have a
            // deleted == BaseModel::DELETED_SOFT
            // soft
            $result = $model->delete();
            $this->assertEquals(1, $result, __METHOD__ . ": Soft delete of {$class} #{$id} failed");
            $model->refresh();

            $this->assertNotNull(
                $model->deleted_at,
                __METHOD__ . ": Not marked soft deleted for $class #{$id} in database"
            );
            $result = $model->forceDelete();
        } else {
            //hard
            $result = $model->delete();
            //$model::destroy($model->id);
            $this->assertEquals(1, $result, __METHOD__ . ": Hard delete of {$class} #{$id} failed");
            $model->refresh();
            $deleted = $class::where("id", $id)->get();
            $this->assertCount(
                0,
                $deleted,
                __METHOD__ . ": Did not remove {$class} #{$id} from database ($deleteType)"
            );
        }
    }

    /**
     * @param $items
     * @param null $class
     */
    public function deleteItemsAndAssertDeleted(
        $items,
        $class = null
    )
    {
        foreach ($items as $key => $item) {
            $id = $item['id'];
            $model = $class::find($id);
            $this->deleteAndAssertDeleted($model, $class);
        }
    }

    /**
     * Checks if model is deleted. Typically used to verify triggers have deleted models.
     * @param $model
     * @param null $class
     * alias assertIsDeleted
     */
    public function assertIsDeleted(
        $model,
        $class = null
    )
    {
        //
        $class = $this->getClassFromModel($model, $class);
        $id = $this->getIdFromModel($model);

        $currentModel = $class::where("id", $id)->get();
        $this->assertCount(0, $currentModel, __METHOD__ . ": Not DELETED by trigger/SP $class #{$id} from database");
    }

    /**
     * Checks if model is soft deleted.
     * @param $model
     * @param null $class
     */
    public function assertIsSoftDeleted($model, $class = null)
    {
        //
        $class = $this->getClassFromModel($model, $class);
        $id = $this->getIdFromModel($model);

        $currentModel = $class::where("id", $id)->get();
        $this->assertGreaterThanOrEqual(
            1,
            count($currentModel),
            __METHOD__ . ": No record in database $class #{$id} while looking for DELETED SOFT record"
        );

        $this->assertEquals(
            BaseModel::DELETED_SOFT,
            $currentModel[0]->deleted,
            __METHOD__ . ": Record in database $class #{$id} not marked DELETED SOFT"
        );
    }

    /**
     * Checks if model is hard deleted.
     * @param $model
     * @param null $class
     */
    public function assertIsHardDeleted($model, $class = null)
    {
        //
        $class = $this->getClassFromModel($model, $class);
        $id = $this->getIdFromModel($model);

        $currentModel = $class::where("id", $id)->get();
        $this->assertEquals(
            0,
            count($currentModel),
            __METHOD__ . ": Record found in database $class #{$id} while looking for HARD DELETED record"
        );
    }

    /**
     * Checks if model is not hard deleted.
     * @param $model
     * @param  null  $class
     */
    public function assertIsNotHardDeleted($model, $class = null)
    {
        //
        $class = $this->getClassFromModel($model, $class);
        $id = $this->getIdFromModel($model);

        $currentModel = $class::where("id", $id)->get();
        $this->assertNotEquals(
            0,
            count($currentModel),
            __METHOD__ . ": Record not found in database $class #{$id} while checking is not a HARD DELETED record"
        );
    }

}
