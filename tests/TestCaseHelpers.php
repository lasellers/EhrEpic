<?php

namespace Tests;

use App\Models\BaseModel;
use Closure;
use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\Exception;
use ReflectionFunction;

/**
 * Trait TestCaseHelpers
 * @package Tests
 *
 */
trait TestCaseHelpers
{
    /**
     * This code is used over and over in many filters. Keep it DRY.
     * @param $ids
     * @return array
     */
    public function idsToArray($ids)
    {
        if (!is_array($ids)) {
            return explode(",", $ids);
        }
        return $ids;
    }

    /**
     * Converts each row to an array, if not already.
     * @param $items
     * @return mixed
     */
    protected function rowsToArray($items)
    {
        if (is_object($items) && (get_class($items) === 'Illuminate\Support\Collection' ||
                get_class($items) === 'Illuminate\Database\Eloquent\Collection')) {
            $items = $items->toArray();
        } elseif (!is_array($items)) {
            $items = (array)$items;
        }

        foreach ($items as $index => $item) {
            if (is_subclass_of($item, BaseModel::class)) {
                $items[$index] = $item->toArray();
            } elseif (is_object($item)) {
                $items[$index] = (array)$item;
            }
        }

        return $items;
    }

    /**
     * Removes all rows that do not have specified ids. This is used to strip out rows that we did
     * not specifically create for a test. This is often used where we are pulling data from a function
     * that has no exact way to limit data that is returned to specific ids, or where we do not wish
     * to expressly test it's filtering of ids. Often done immediately after the data is returned.
     * Note: All compare tests do checks for null and array or object tests in their pre-checks so
     * you can eliminate those tests from your tests proper.
     * @param $items
     * @param $ids
     * @param string $key
     * @param int $index
     * @return array
     */
    protected function limitIdsInRows(
        $items,
        $ids,
        $key = 'id',
        $index = 0
    )
    {
        self::assertNotNull($items);
        self::assertIsIterable($items);

        $newItems = [];
        foreach ($items as $item) {
            if (in_array($item[$key], $ids, true)) {
                $newItems[$index++] = $item;
            };
        }
        return $newItems;
    }

    /**
     * @param $class
     * @param bool $autoload
     * @return array
     */
    protected function classUsesDeep($class, $autoload = true)
    {
        $traits = [];

        // Get traits of all parent classes
        do {
            $traits = array_merge(class_uses($class, $autoload), $traits);
        } while ($class = get_parent_class($class));

        // Get traits of all parent traits
        $traitsToSearch = $traits;
        while (!empty($traitsToSearch)) {
            $newTraits = class_uses(array_pop($traitsToSearch), $autoload);
            $traits = array_merge($newTraits, $traits);
            $traitsToSearch = array_merge($newTraits, $traitsToSearch);
        };

        foreach ($traits as $trait => $same) {
            $traits = array_merge(class_uses($trait, $autoload), $traits);
        }

        return array_unique($traits);
    }

    /**
     * @param bool $flag
     */
    protected function disableTriggers($flag = true)
    {
        DB::connection()->unprepared("SET @disableTriggers = " . ($flag ? 1 : 0) . "");
    }

    /**
     * @param int $depth
     */
    protected function setSpRecursionDepth($depth = 25)
    {
        DB::connection()->unprepared("SET max_sp_recursion_depth=$depth");
    }

    /**
     * @param string $connection
     * @param int $flag
     */
    protected function setChecks($flag = 1)
    {
        DB::connection()->unprepared("SET UNIQUE_CHECKS = {$flag}");
        DB::connection()->unprepared("SET FOREIGN_KEY_CHECKS = {$flag}");
    }

    /**
     * @param $array
     * @return mixed
     */
    public function getIdFromResponseArray($array)
    {
        $this->assertArrayHasKey('id', $array);
        $this->assertGreaterThanOrEqual(0, $array['id']);
        return $array['id'];
    }

    /**
     * @param \PHPUnit\Framework\MockObject\MockObject|\Mockery\MockInterface $query
     * @return \PHPUnit\Framework\Constraint\Callback|\Mockery\Matcher\Closure
     */
    protected function assertQueryCallback(Closure $expectations)
    {
        $query = $this->buildExpectedQueryMock($expectations);
        call_user_func($expectations, $query);
        $assertion = function ($tested_callback) use ($query) {
            call_user_func($tested_callback, $query);
            return true;
        };
        // Mockery is supported, but might not be actually required in the project,
        // so we have to rely on raw string classnames rather than Mockery::class.
        return is_a($query, 'Mockery\\MockInterface')
            ? call_user_func('Mockery::on', $assertion)
            : self::callback($assertion);
    }

    /**
     * @param Closure $expectations
     * @return mixed
     * @throws \ReflectionException
     * //return \Mockery\MockInterface|MockObject
     */
    protected function buildExpectedQueryMock(Closure $expectations)
    {
        $ref = new ReflectionFunction($expectations);
        $expected_mock = $ref->getParameters()[0] ?? null;
        return $expected_mock !== null && (string)$expected_mock->getType() === 'Mockery\\MockInterface'
            ? call_user_func('Mockery::mock')
            : $this->createMixinMock(Builder::class, QueryBuilder::class);
    }

    /**
     * @param $data
     * @param int $level
     * @return string
     */
    public static function print_r_depth($data, $level = 3)
    {
        static $innerLevel = 1;
        static $tabLevel = 1;
        $self = __FUNCTION__;
        $type = gettype($data);
        $tabs = str_repeat('    ', $tabLevel);
        $quoteTabes = str_repeat('    ', $tabLevel - 1);
        $output = '';
        $elements = array();
        $recursiveType = array('object', 'array');
        // Recursive
        if (in_array($type, $recursiveType)) {
            // If type is object, try to get properties by Reflection.
            if ($type === 'object') {
                $output = get_class($data) . ' ' . ucfirst($type);
                $ref = new \ReflectionObject($data);
                $properties = $ref->getProperties();
                foreach ($properties as $property) {
                    $property->setAccessible(true);
                    $pType = $property->getName();
                    if ($property->isProtected()) {
                        $pType .= ":protected";
                    } elseif ($property->isPrivate()) {
                        $pType .= ":" . $property->class . ":private";
                    }
                    if ($property->isStatic()) {
                        $pType .= ":static";
                    }
                    $elements[$pType] = $property->getValue($data);
                }
            } // If type is array, just return it's value.
            elseif ($type === 'array') {
                $output = ucfirst($type);
                $elements = $data;
            }
            // Start dumping data
            if ($level == 0 || $innerLevel < $level) {
                // Start recursive print
                $output .= "\n{$quoteTabes}(";
                foreach ($elements as $key => $element) {
                    $output .= "\n{$tabs}[{$key}] => ";
                    // Increment level
                    $tabLevel = $tabLevel + 2;
                    $innerLevel++;
                    $output .= in_array(gettype($element), $recursiveType) ? $self($element, $level) : $element;
                    // Decrement level
                    $tabLevel = $tabLevel - 2;
                    $innerLevel--;
                }
                $output .= "\n{$quoteTabes})\n";
            } else {
                $output .= "\n{$quoteTabes}*MAX LEVEL*\n";
            }
        } else {
            $output = $data;
        }
        return $output;
    }

    /**
     * @param $model
     * @return mixed
     */
    private function getIdFromModel($model)
    {
        if (is_integer($model)) {
            return $model;
        }
        return is_array($model) ? $model['id'] : $model->id;
    }

    /**
     * @param $model
     * @param $class
     * @return string
     */
    private function getClassFromModel($model, $class)
    {
        if (is_null($class) && is_object($model)) {
            $class = get_class($model);
        }
        return $class;
    }

}
