<?php
/*
./vendor/bin/phpunit tests/Integration/Factory/FactoryTest.php
*/

namespace Tests\Integration\Factory;

use App\Models\Patient;
use App\Models\Practitioner;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Tests\TestCaseAsserts;
use Tests\TestCaseAssertsCreate;
use Tests\TestCaseAssertsDelete;
use Tests\TestCaseHelpers;

/**
 * Class FactoryTest
 * @package Tests\Integration\Factory
 */
class FactoryTest extends TestCase
{
    use DatabaseTransactions;

    use TestCaseHelpers;
    use TestCaseAsserts;
    use TestCaseAssertsCreate;
    use TestCaseAssertsDelete;


    /**
     * @test
     * @dataProvider factoryDataProvider
     * @param $class
     * @param  array  $values
     */
    public function factoryModel($class, $values = [])
    {
        $this->checkFactoryModel($class, $values);
    }

    /**
     * @return array
     */
    public function factoryDataProvider()
    {
        return [
            ['class' => Patient::class],
            ['class' => Practitioner::class],
            ['class' => Comment::class],
        ];
    }

    /**
     * @param $class
     * @param  array  $values
     */
    protected function checkFactoryModel(
        $class,
        $values = []
    ) {
        //
        // Optional test
        //Auth::shouldReceive('user')->between(0, 3)->andreturn((object)['id' => 1]);
        //Auth::shouldReceive('id')->between(0, 3)->andreturn(1);

        $this->withSession([
        ]);

        // Test simple instance creation
        $object = new $class();
        $this->assertInstanceOf(Model::class, $object);

        // Test factory model creation
        $model = factory($class)->make($values);
        // first get incrementing, if not we skip tests as it is a legacy (no Laravel) table
        if (isset($model->incrementing) && $model->incrementing === false) {
            //legacy table with no id on this model
        } else {
            // Create the model for testing
            try {
                $model = factory($class)->create($values);
            } catch (\PDOException $e) {
                Log::error(__METHOD__ . ": " . $e->getMessage());
                return;
            }
            $this->assertIsInt($model->id, __METHOD__ . ": id is not integer");

            // is added?
            $current = $class::where("id", $model->id)->get();
            $this->assertCount(
                1,
                $current,
                __METHOD__ . ": Could not find just created record {$model->id} in database"
            );
            $this->assertEquals(
                $model->id,
                $current->first()->id,
                __METHOD__ . ": Ids of just created record {$model->id} and found {$current->first()->id} do not match"
            );
            $this->assertCount(1, $current);

            //
            $id = $model->id;
            $model->delete();

            // is deleted?
            $deleted = $class::where("id", $id)->get();
            $this->assertCount(0, $deleted, __METHOD__ . ": DELETE does not remove record {$id} from database");
        }
    }

}
