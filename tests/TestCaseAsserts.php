<?php

namespace Tests;

use App\Models\BaseModel;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\Constraint\IsInstanceOf;

trait TestCaseAsserts
{
    /**
     * Similar to assertKeysPresent, but not model-aware
     * @param $keys
     * @param $item
     */
    protected function assertArrayHasKeys($keys, $item)
    {
        $item = $this->responseToArray($item);
        foreach ($keys as $index => $key) {
            $this->assertArrayHasKey($key, $item);
        }
    }

    /**
     * Loops through an interable and checks if each row has an array with specified key name.
     * @param $keys
     * @param $items
     */
    protected function assertArrayHasKeysInRows($keys, $items)
    {
        foreach ($items as $item) {
            $item = $this->responseToArray($item);
            foreach ($keys as $index => $key) {
                $this->assertArrayHasKey($key, $item);
            }
        }
    }

    /**
     * @param $keys
     * @param $item
     */
    protected function assertArrayHasKeysWithArrayOrObject($keys, $item)
    {
        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $item, __METHOD__ . ": key $key in " . print_r($item, true));
            $this->assertTrue(
                is_array($item[$key]) || is_object($item[$key]),
                __METHOD__ . ": is array or object key '$key' in " . print_r($item[$key], true)
            );
        }
    }

    protected function assertIsDateString($dateString, $format = 'Y-m-d')
    {
        $date = \DateTime::createFromFormat($format, $dateString);
        if (trim($dateString) === "") {
            $this->fail("Blank date string");
        }
        $this->assertTrue($date && $date->format($format) === $dateString, "Invalid date string: $dateString");
    }

    /**
     * @param $response
     */
    public function assertError($response)
    {
        $response = $this->responseToArray($response);
        $this->assertTrue(
            array_key_exists('error', $response)
            || array_key_exists('errors', $response)
        );
    }

    /**
     * Normally called from Integration/Models
     * @param $class
     * @param  array  $attributes
     * @param  bool  $isMethodName
     */
    protected function assertAttributesExist($class, $attributes = [], $isMethodName = true)
    {
        //
        $model = factory($class)->make([
        ]);
        $methodNames = [];
        foreach ($attributes as $attribute) {
            if (!$isMethodName) {
                $pascalCaseName = ucwords(camel_case($attribute));
                $method = "get{$pascalCaseName}Attribute";
            } else {
                $method = $attribute;
            }
            $methodNames[] = $method;

            $this->assertTrue(
                method_exists($model, $method),
                __METHOD__ . ": Failed asserting method_exists for $class:$method"
            );
        }
        //
        $methods = get_class_methods($class);
        foreach ($methods as $method) {
            if (!in_array($method, [
                    'getAttribute',
                    'getReadOnlyAttribute',
                    'getDeletableAttribute',
                    'getIsChildAttribute'
                ]) && preg_match(
                    '/^get/',
                    $method
                ) && preg_match('/Attribute$/', $method)) {
                if (!in_array($method, $methodNames)) {
                    $this->fail(__METHOD__ . ": Attribute $method found that is not in known list");
                }
            }
        }
    }

    /**
     * @param $class
     * @param $items
     */
    protected function assertIsArrayInRows($items)
    {
        $this->assertIsIterable($items);
        foreach ($items as $item) {
            $this->assertIsArray($item);
        }
    }

    /**
     * Like built-in instanceof but for rows
     * @param $class
     * @param $items
     */
    protected function assertInstanceOfInRows($class, $items)
    {
        $this->assertIsIterable($items);
        foreach ($items as $item) {
            $this->assertInstanceOf($class, $item);
        }
    }

    public function assertInstanceOfHas($items, $defs)
    {
        foreach ($items as $item => $class) {
            $this->assertInstanceOf($class, $item);
        }
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

    /**
     * Checks if model is altered.
     * @param $model
     * @param  null  $class
     */
    public function assertIsAltered($model, $class = null)
    {
        $this->assertIsSoftAltered($model, $class);
    }

    /**
     * Checks if model is altered.
     * @param $model
     * @param  null  $class
     */
    public function assertIsSoftAltered($model, $class = null)
    {
        //
        if (is_null($class) && is_object($model)) {
            $class = get_class($model);
        }

        $id = $this->getIdFromModel($model);

        $currentModel = $class::where("id", $id)->get();
        $this->assertCount(1, $currentModel, __METHOD__ . ": No row $class #{$id} in database");
        $this->assertEquals(
            BaseModel::ALTERED_SOFT,
            $currentModel[0]->altered,
            __METHOD__ . ": Not SOFT ALTERED $class #{$id} in database"
        );
    }


    /**
     * Checks if the number of returned rounds is between min and max inclusive. If min or max is given
     * as a null then that lower or upper bound is ignored. See assertCount for an exact count match.
     * Note: All compare tests do checks for null and array or object tests in their pre-checks so
     * you can eliminate those tests from your tests proper.
     * @param $items
     * @param  int|null  $min_count
     * @param  int|null  $max_count
     */
    public function assertMinMaxCount(
        $items,
        $min_count = null,
        $max_count = null
    ) {
        $this->assertNotNull($items);

        $this->assertTrue(!is_string($items));

        $items_count = count($items);

        if (!is_null($min_count)) {
            $this->assertGreaterThanOrEqual((int)$min_count, $items_count);
        }

        if (!is_null($max_count)) {
            $this->assertLessThanOrEqual((int)$max_count, $items_count);
        }
    }

    /**
     * Checks the expected key/value pairs again the given row data.
     * Note: All compare tests do checks for null and array or object tests in their pre-checks so
     * you can eliminate those tests from your tests proper.
     * @param $expectedKeys
     * @param $actualKeys
     * @param  array  $filters
     * @param  array  $transforms
     * @param  null  $class
     */
    protected function assertRowEquals(
        $expectedKeys,
        $actualKeys,
        $filters = [],
        $transforms = [],
        $class = null
    ) {
        $this->assertNotNull($expectedKeys);
        $this->assertNotNull($actualKeys);

        if (!is_array($expectedKeys) && !is_object($expectedKeys)) {
            $this->fail(__METHOD__ . ": expectedKeys must be array|collection");
        }
        if (!is_array($actualKeys) && !is_object($actualKeys)) {
            $this->fail(__METHOD__ . ": actualKeys must be array|collection");
        }

        $expectedKeys = $this->responseToArray($expectedKeys);
        $expectedKeys = $this->filterKeys($expectedKeys, $filters, $class);

        $actualKeys = $this->responseToArray($actualKeys);
        $actualKeys = $this->filterKeys($actualKeys, $filters, $class);

        try {
            $expectedKeys = $this->filterKeys($expectedKeys, TestFilterData::TEST_FILTER_WITHOUT_NONSCALAR);
            if (is_object($actualKeys)) {
                $expectedKeys = $this->removeDates($actualKeys, $expectedKeys);
            } else {
                $expectedKeys = $this->removeDates($expectedKeys, $expectedKeys);
            }

            foreach ($expectedKeys as $key => $value) {
                $this->assertTrue(
                    array_key_exists($key, $actualKeys),
                    __METHOD__ . ": Expected key '$key' not found in actual keys: " . self::print_r_depth(
                        $actualKeys,
                        true
                    ) . " Expected Keys: " . self::print_r_depth(
                        $expectedKeys,
                        3
                    )
                );

                if (!is_array($actualKeys[$key])) {
                    $this->assertEquals(
                        $value,
                        $actualKeys[$key],
                        __METHOD__ . ": Expected value $value for key '$key' not found: " . self::print_r_depth(
                            $actualKeys,
                            true
                        ) . " Expected Keys: " . self::print_r_depth(
                            $expectedKeys,
                            3
                        )
                    );
                }
            }
        } catch (\InvalidArgumentException $e) {
            $this->fail(__METHOD__ . ": Error: " . $e->getCode() . " " . ($e->getMessage()));
        }
    }

    /**
     * Checks the expected key/value pairs again the given row data as to whether it is NOT equal.
     * Note: All compare tests do checks for null and array or object tests in their pre-checks so
     * you can eliminate those tests from your tests proper.
     * @param $expectedKeys
     * @param $actualKeys
     * @param  array  $filters
     * @param  null  $class
     */
    protected function assertKeysNotEqual(
        $expectedKeys,
        $actualKeys,
        $filters = [],
        $class = null
    ) {
        $this->assertNotNull($expectedKeys);
        $this->assertNotNull($actualKeys);

        $this->assertIsIterable($expectedKeys, __METHOD__ . ": expectedKeys must be array|collection");
        $this->assertIsIterable($actualKeys, __METHOD__ . ": actualKeys must be array|collection");

        $expectedKeys = $this->responseToArray($expectedKeys);
        $expectedKeys = $this->filterKeys($expectedKeys, $filters, $class);
        $expectedKeys = $this->filterKeys($expectedKeys, TestFilterData::TEST_FILTER_WITHOUT_NONSCALAR);

        $actualKeys = $this->responseToArray($actualKeys);

        try {
            foreach ($expectedKeys as $key => $value) {
                $this->assertTrue(
                    array_key_exists($key, $actualKeys),
                    __METHOD__ . ": Expected key '$key' not found in: " . self::print_r_depth(
                        $actualKeys,
                        true
                    ) . " Expected Keys: " . self::print_r_depth(
                        $expectedKeys,
                        true
                    )
                );

                $this->assertNotEquals(
                    $value,
                    $actualKeys[$key],
                    __METHOD__ . ": Expected value '$value' for '$key'' not found in actual keys: " . self::print_r_depth(
                        $actualKeys,
                        true
                    ) . " Expected Keys: " . self::print_r_depth(
                        $expectedKeys,
                        true
                    )
                );
            }
        } catch (\InvalidArgumentException $e) {
            $this->fail(__METHOD__ . ": Error: " . $e->getCode() . " " . ($e->getMessage()));
        }
    }

    /**
     * Same as assertRowEqual, but given data is an array of rows that are each tested.
     * Note: All compare tests do checks for null and array or object tests in their pre-checks so
     * you can eliminate those tests from your tests proper.
     * @param  array  $expectedKeysRows
     * @param  array  $actualKeys
     * @param  array  $filters
     * @param  null  $class
     */
    protected function assertRowEqualsInRows(
        $expectedKeysRows = [],
        $actualKeys = [],
        $filters = [],
        $class = null
    ) {
        $this->assertNotNull($expectedKeysRows);
        $this->assertNotNull($actualKeys);

        $expectedKeysRows = $this->responseToArray($expectedKeysRows);
        $actualKeys = $this->responseToArray($actualKeys);

        if (count($expectedKeysRows) > 0) {
            $this->assertGreaterThanOrEqual(0, count($expectedKeysRows));
            $this->assertEquals(
                count($expectedKeysRows),
                count($actualKeys),
                __METHOD__ . ': The count of the keys between expected and actual differs: Expected:' . self::print_r_depth(
                    $expectedKeysRows,
                    true
                ) . " Actual:" . self::print_r_depth(
                    $actualKeys,
                    true
                )
            );
            foreach ($expectedKeysRows as $rowId => $actual) {
                $expected = $actualKeys[$rowId];
                // if (is_object($actual)) {
                if (is_a($actual, Model::class)) {
                    $actual = $actual->getAttributes();
                }

                $this->assertRowEquals($expected, $actual, $filters, $class);
            }
        }
    }

    /**
     * Same as assertKeysPresent, but the given data is an array of rows. Each row is tested.
     * Note: All compare tests do checks for null and array or object tests in their pre-checks so
     * you can eliminate those tests from your tests proper.
     * Note: *PresentInRows expectedKeys should be a row only, not a rows
     * @param $expectedKeysOrClass
     * @param $actualKeysRows
     * @param  array  $filters
     * @param  array  $transforms
     */
    protected function assertKeysPresentInRows(
        $expectedKeysOrClass,
        $actualKeysRows,
        $filters = [],
        $transforms = []
    ) {
        $this->assertNotNull($expectedKeysOrClass);
        $this->assertNotNull($actualKeysRows);

        $this->assertGreaterThanOrEqual(0, count($actualKeysRows));

        //
        foreach ($actualKeysRows as $keyId => $actualKeys) {
            $this->assertKeysPresent($expectedKeysOrClass, $actualKeys, $filters, $transforms);
        }
    }

    /**
     * Checks if the expected keys are present in the row data.
     * Note: All compare tests do checks for null and array or object tests in their pre-checks so
     * you can eliminate those tests from your tests proper.
     * @param $expectedKeysOrClass
     * @param $actualKeys
     * @param  array  $filters
     * @param  array  $transforms
     */
    protected function assertKeysPresent(
        $expectedKeysOrClass,
        $actualKeys,
        $filters = [],
        $transforms = []
    ) {
        $this->assertNotNull($expectedKeysOrClass);
        $this->assertNotNull($actualKeys);

        if (is_object($actualKeys) && is_string($expectedKeysOrClass)) {
            $this->assertInstanceOf($expectedKeysOrClass, $actualKeys);
        }

        $expectedKeys = $this->responseToArrayOrModelArray($expectedKeysOrClass);

        $expectedKeys = $this->filterKeys($expectedKeys, $filters);
        $expectedKeys = $this->filterKeys($expectedKeys, TestFilterData::TEST_FILTER_WITHOUT_NONSCALAR);
        $expectedKeys = $this->keysOnly($expectedKeys);

        $actualKeys = $this->responseToArray($actualKeys);

        $expectedKeys = $this->transformKeys($expectedKeys, $transforms);
        $actualKeys = $this->transformKeys($actualKeys, $transforms);

        try {
            foreach ($expectedKeys as $key => $value) {
                $this->assertTrue(
                    array_key_exists($key, $actualKeys),
                    __METHOD__ . ": Expected key '$key' not found in: Actual Keys:" . self::print_r_depth(
                        $actualKeys,
                        true
                    ) . " Expected Keys: " . self::print_r_depth(
                        $expectedKeys,
                        true
                    )
                );
            }
        } catch (\InvalidArgumentException $e) {
            $this->fail(__METHOD__ . ": Error: " . $e->getCode() . " " . ($e->getMessage()));
        }
    }

    /**
     * Checks if the expected values are found in the given row data.
     * Note: All compare tests do checks for null and array or object tests in their pre-checks so
     * you can eliminate those tests from your tests proper.
     * @param $expectedKeys
     * @param $actualKeys
     * @param $filters
     */
    protected function assertValuesPresent(
        $expectedKeys,
        $actualKeys,
        $filters = []
    ) {
        $this->assertNotNull($expectedKeys);
        $this->assertNotNull($actualKeys);

        $expectedKeys = $this->responseToArrayOrModelArray($expectedKeys);
        $expectedKeys = $this->filterKeys($expectedKeys, $filters);
        $expectedKeys = $this->keysOnly($expectedKeys);

        $actualKeys = $this->responseToArray($actualKeys);

        try {
            foreach ($expectedKeys as $key => $value) {
                if (is_array($value)) {
                    unset($expectedKeys[$key]);
                }
            }

            foreach ($expectedKeys as $key => $value) {
                $this->assertTrue(
                    in_array($value, $actualKeys),
                    __METHOD__ . ": Expected value '$value' not found in: " . self::print_r_depth(
                        $actualKeys,
                        true
                    ) . " Expected Values: " . self::print_r_depth(
                        $expectedKeys,
                        true
                    )
                );
            }
        } catch (\InvalidArgumentException $e) {
            $this->fail(__METHOD__ . ": Error: " . $e->getCode() . " " . ($e->getMessage()));
        }
    }

    /**
     * Compares an array of values to a single matching value or a list of possible matching values
     * @param $items
     * @param $matchingValue
     */
    protected function assertArrayEquals(
        $items,
        $matchingValue
    ) {
        $this->assertIsArray($items);
        $this->assertIsIterable($items);

        $matchingValues = $this->idsToArray($matchingValue);

        //$items = $this->rowsToArray($items);
        foreach ($items as $item) {
            $this->assertContains(
                $item,
                $matchingValues,
                __METHOD__ . ": Did not find " . $item . " in [" . implode(",", $matchingValues) . "]"
            );
        }
    }

    /**
     * Checks every row to see if the key column value equals the expected value.
     * For example: To check if every row had a location_id of 9, we could write
     * $this->assertPluckEquals($items,'location_id',9);
     *
     * Note: If the order matters, consider using assertIsSorted.
     * Note: All compare tests do checks for null and array or object tests in their pre-checks so
     * you can eliminate those tests from your tests proper.
     * @param $items
     * @param  string  $key
     * @param $matchingValue
     * @param  null  $relation
     */
    protected function assertPluckEquals(
        $items,
        string $key,
        $matchingValue,
        $relation = null
    ) {
        $this->assertNotNull($items);
        $this->assertIsIterable($items);

        $matchingValues = $this->idsToArray($matchingValue);

        $items = $this->rowsToArray($items);

        foreach ($items as $item) {
            if (is_null($relation)) {
                $this->assertContains(
                    $item[$key],
                    $matchingValues,
                    __METHOD__ . ": Did not find '" . $item[$key] . "' in [" . implode(",", $matchingValues) . "]"
                );
            } else {
                $this->assertContains(
                    $item[$relation][$key],
                    $matchingValues,
                    __METHOD__ . ": Did not find '" . $item[$relation][$key] . "' in [" . implode(",", $matchingValues) . "]"
                );
            }
        }
    }

    /**
     * See assertPluckEquals
     * @param $items
     * @param $key
     * @param $matchingValue
     * @param  null  $relation
     */
    protected function assertPluckNotEquals(
        $items,
        string $key,
        $matchingValue,
        $relation = null
    ) {
        $this->assertNotNull($items);
        $this->assertIsIterable($items);

        $matchingValues = $this->idsToArray($matchingValue);

        $items = $this->rowsToArray($items);
        foreach ($items as $item) {
            if (is_null($relation)) {
                $this->assertNotContains($item[$key], $matchingValues);
            } else {
                $this->assertNotContains($item[$relation][$key], $matchingValues);
            }
        }
    }

    /**
     * @param $items
     * @param $key
     * @param $matchingValue
     * @param  null  $relation
     * @param  string  $format
     * @param  string  $itemFormat
     */
    protected function assertPluckDateEquals(
        $items,
        $key,
        $matchingValue,
        $relation = null,
        $format = "Y-m-d",
        $itemFormat = "Y-m-d"
    ) {
        $this->assertNotNull($items);
        $this->assertIsIterable($items);
        $this->assertIsDateString($matchingValue, $format);

        $matchingDate = Carbon::createFromFormat($format, $matchingValue)->toDateString();

        $items = $this->rowsToArray($items);
        foreach ($items as $item) {
            if (is_null($relation)) {
                $this->assertIsDateString($item[$key], $itemFormat);
                $itemDate = Carbon::createFromFormat($itemFormat, $item[$key])->toDateString();

                $this->assertEquals(
                    $itemDate,
                    $matchingDate,
                    __METHOD__ . ": Did not find " . $item[$key] . " in $matchingValue"
                );
            } else {
                $this->assertIsDateString($item[$relation][$key], $itemFormat);
                $itemDate = Carbon::createFromFormat($itemFormat, $item[$relation][$key])->toDateString();

                $this->assertEquals(
                    $itemDate,
                    $matchingDate,
                    __METHOD__ . ": Did not find " . $item[$relation][$key] . " in $matchingValue"
                );
            }
        }
    }

    /**
     * @param $items
     * @param $key
     * @param $matchingValue
     * @param $matchingValue2
     * @param  null  $relation
     * @param  string  $format
     * @param  string  $itemFormat
     */
    protected function assertPluckDateRange(
        $items,
        $key,
        $matchingValue,
        $matchingValue2,
        $relation = null,
        $format = "Y-m-d",
        $itemFormat = "Y-m-d"
    ) {
        $this->assertPluckDateGreaterThanOrEquals($items, $key, $matchingValue, $relation, $format, $itemFormat);
        $this->assertPluckDateLessThanOrEquals($items, $key, $matchingValue2, $relation, $format, $itemFormat);
    }

    /**
     * @param $items
     * @param $key
     * @param $matchingValue
     * @param  null  $relation
     * @param  string  $format
     * @param  string  $itemFormat
     */
    protected function assertPluckDateGreaterThanOrEquals(
        $items,
        $key,
        $matchingValue,
        $relation = null,
        $format = "Y-m-d",
        $itemFormat = "Y-m-d"
    ) {
        $this->assertNotNull($items);
        $this->assertIsIterable($items);
        $this->assertIsDateString($matchingValue, $format);

        $matchingDate = Carbon::createFromFormat($format, $matchingValue)->toDateString();

        $items = $this->rowsToArray($items);
        foreach ($items as $item) {
            if (is_null($relation)) {
                $itemDate = $this->toDateFormat($item[$key], $itemFormat);

                $this->assertGreaterThanOrEqual(
                    $itemDate,
                    $matchingDate,
                    __METHOD__ . ": Did not find " . $item[$key] . " in $matchingValue"
                );
            } else {
                $this->assertIsDateString($item[$relation][$key], $itemFormat);
                $itemDate = Carbon::createFromFormat($itemFormat, $item[$relation][$key])->toDateString();

                $this->assertGreaterThanOrEqual(
                    $itemDate,
                    $matchingDate,
                    __METHOD__ . ": Did not find " . $item[$relation][$key] . " in $matchingValue"
                );
            }
        }
    }

    /**
     * @param $items
     * @param $key
     * @param $matchingValue
     * @param  null  $relation
     * @param  string  $format
     * @param  string  $itemFormat
     */
    protected function assertPluckDateLessThanOrEquals(
        $items,
        $key,
        $matchingValue,
        $relation = null,
        $format = "Y-m-d",
        $itemFormat = "Y-m-d"
    ) {
        $this->assertNotNull($items);
        $this->assertIsIterable($items);
        $this->assertIsDateString($matchingValue);

        $matchingDate = Carbon::createFromFormat($format, $matchingValue)->toDateString();

        foreach ($items as $item) {
            if (is_null($relation)) {
                $itemDate = $this->toDateFormat($item[$key], $itemFormat);

                $this->assertLessThanOrEqual(
                    $itemDate,
                    $matchingDate,
                    __METHOD__ . ": Did not find " . $item[$key] . " in $matchingValue"
                );
            } else {
                $this->assertIsDateString($item[$relation][$key], $itemFormat);
                $itemDate = Carbon::createFromFormat($itemFormat, $item[$relation][$key])->toDateString();

                $this->assertLessThanOrEqual(
                    $itemDate,
                    $matchingDate,
                    __METHOD__ . ": Did not find " . $item[$relation][$key] . " in $matchingValue"
                );
            }
        }
    }

    /**
     * @param $date
     * @param  string  $format
     * @return string
     */
    protected function toDateFormat(
        $date,
        $format = "Y-m-d"
    ) {
        if (is_object($date) && get_class($date) === \Illuminate\Support\Carbon::class) {
            $toDate = $date->toDateString();
        } else {
            $toDate = Carbon::createFromFormat($format, $date)->toDateString();
        }
        return $toDate;
    }

    /**
     * Like assertPluckEquals but is looking for 1+ matches -- they don't all have to match.
     * @param $items
     * @param $key
     * @param $matchingValue
     * @param  null  $relation
     * @param  int  $min
     */
    protected function assertPluckFind(
        $items,
        $key,
        $matchingValue,
        $relation = null,
        $min = 1
    ) {
        $this->assertNotNull($items);
        $this->assertIsIterable($items);

        $find = 0;
        $matchingValues = $this->idsToArray($matchingValue);
        foreach ($items as $item) {
            if (is_subclass_of($item, BaseModel::class)) {
                $item = $item->toArray();
            } elseif (is_object($item)) {
                $item = (array)$item;
            }
            if (is_null($relation)) {
                if (in_array($item[$key], $matchingValues)) {
                    $find++;
                }
            } else {
                if (in_array($item[$key][$relation], $matchingValues)) {
                    $find++;
                }
            }
        }
        $this->assertTrue($find >= $min);
    }

    /**
     * @param $items
     * @param $key
     * @param $matchingValue
     * @param  null  $relation
     */
    protected function assertPluckNotFind(
        $items,
        $key,
        $matchingValue,
        $relation = null
    ) {
        $this->assertNotNull($items);
        $this->assertIsIterable($items);

        $find = 0;
        $matchingValues = $this->idsToArray($matchingValue);
        foreach ($items as $item) {
            if (is_subclass_of($item, BaseModel::class)) {
                $item = $item->toArray();
            } elseif (is_object($item)) {
                $item = (array)$item;
            }
            if (is_null($relation)) {
                if (in_array($item[$key], $matchingValues)) {
                    $find++;
                }
            } else {
                if (in_array($item[$key][$relation], $matchingValues)) {
                    $find++;
                }
            }
        }
        $this->assertTrue($find == 0);
    }

    /**
     * Looks through an items list at a specified key to determine if they are in one of n known correct orders.
     * Note: All compare tests do checks for null and array or object tests in their pre-checks so
     * you can eliminate those tests from your tests proper.
     *
     * Note: If the order doesn't matter, consider using assertPluckEquals.
     *
     * @param $items
     * @param  array  $orderedIdsArray
     * @param  string  $key  Field used index key, ie, 'id'
     */
    protected function assertIsSorted(
        $items,
        $orderedIdsArray,
        $key = 'id'
    ) {
        $this->assertNotNull($items);
        $this->assertIsIterable($items);

        foreach ($orderedIdsArray as $index => $orderedIds) {
            $this->assertEquals(
                count($orderedIds),
                count($items),
                __METHOD__ . ": Failed: Array count, Index $index"
            );
        }

        $items = $this->limitIdsInRows($items, $orderedIdsArray[0], $key);

        // extract key from complex array into list
        $itemsArray = [];
        foreach ($items as $index => $item) {
            if (in_array($item[$key], $orderedIdsArray[0])) {
                $itemsArray[$index] = $item[$key];
            };
        }

        // check order
        $orderedIds = [];
        $diff = [];
        foreach ($orderedIdsArray as $index => $orderedIds) {
            $diff = array_diff_assoc($orderedIds, $itemsArray);
            if (empty($diff)) {
                return;
            }
        }

        $this->fail(
            __METHOD__ . ": Failed: Expected order=" . print_r(
                $orderedIds,
                true
            ) . " All expected order=" . print_r($orderedIdsArray, true)
            . " Actual items=" . print_r($itemsArray, true)
            . " difference=" . print_r($diff, true)
        );
    }

    /**
     * @param $items
     * @param  string  $key
     * @param  string  $order
     * @param  string  $type
     */
    protected function assertIsSortedAny(
        $items,
        $key = 'id',
        $order = 'ASC',
        $type = 'string'
    ) {
        if ($order == 'ASC' && $type == 'numeric') {
            $this->assertIsSortedNumericAsc($items, $key);
        }
        if ($order == 'DESC' && $type == 'numeric') {
            $this->assertIsSortedNumericDesc($items, $key);
        }
        if ($order == 'ASC' && $type == 'string') {
            $this->assertIsSortedStringAsc($items, $key);
        }
        if ($order == 'DESC' && $type == 'string') {
            $this->assertIsSortedStringDesc($items, $key);
        }
    }

    /**
     * @param $items
     * @param  string  $key
     */
    protected function assertIsSortedNumericAsc(
        $items,
        $key = 'id'
    ) {
        $this->assertNotNull($items);
        $this->assertIsIterable($items);

        foreach ($items as $index => $item) {
            if ($index > 0) {
                $a = $items[$index - 1][$key];
                $b = $items[$index][$key];
                $this->assertLessThanOrEqual(
                    $b,
                    $a,
                    __METHOD__ . ": Failed: " . $a . " <= " . $b
                );
            }
        }
    }

    /**
     * @param $items
     * @param  string  $key
     */
    protected function assertIsSortedNumericDesc(
        $items,
        $key = 'id'
    ) {
        $this->assertNotNull($items);
        $this->assertIsIterable($items);

        foreach ($items as $index => $item) {
            if ($index > 0) {
                $a = $items[$index - 1][$key];
                $b = $items[$index][$key];
                $this->assertGreaterThanOrEqual(
                    $b,
                    $a,
                    __METHOD__ . ": Failed: " . $a . " >= " . $b
                );
            }
        }
    }

    /**
     * @param $items
     * @param  string  $key
     */
    protected function assertIsSortedStringAsc(
        $items,
        $key = 'id'
    ) {
        $this->assertNotNull($items);
        $this->assertIsIterable($items);

        foreach ($items as $index => $item) {
            if ($index > 0) {
                $a = $items[$index - 1][$key];
                $b = $items[$index][$key];
                $test = strcasecmp($a, $b);
                $this->assertLessThanOrEqual(
                    0,
                    $test,
                    __METHOD__ . ": Failed: " . $a . " <= " . $b
                );
            }
        }
    }

    /**
     * @param $items
     * @param  string  $key
     */
    protected function assertIsSortedStringDesc(
        $items,
        $key = 'id'
    ) {
        $this->assertNotNull($items);
        $this->assertIsIterable($items);

        foreach ($items as $index => $item) {
            if ($index > 0) {
                $a = $items[$index - 1][$key];
                $b = $items[$index][$key];
                $test = strcasecmp($a, $b);
                $this->assertGreaterThanOrEqual(
                    0,
                    $test,
                    __METHOD__ . ": Failed: " . $a . " >= " . $b
                );
            }
        }
    }

    /**
     * @param $items
     * @param  string  $column
     */
    protected function assertPluckNotNullInRows($items, $column = 'id')
    {
        $this->assertNotNull($items);
        $this->assertIsIterable($items);

        $items = $this->rowsToArray($items);
        foreach ($items as $item) {
            $this->assertNotNull($item[$column]);
        }
    }

    /**
     * @param $response
     */
    public function assertResponseOptions(
        $response
    ) {
        $response->assertStatus(200, "OPTIONS pre-flight is invalid");
        $this->assertTrue($response->getContent() === "", __METHOD__ . ": OPTIONS pre-flight content is invalid");
        $this->assertRequiredHeadersAsExpected($response);
    }

    /**
     * @param $response
     */
    public function assertResponseHead(
        $response
    ) {
        $response->assertStatus(200, "HEAD is invalid");
        $this->assertTrue($response->getContent() === "", __METHOD__ . ": HEAD content is invalid");
        $this->assertRequiredHeadersAsExpected($response);
    }

    /**
     * @param $result
     * @param $mock
     * @param $class
     */
    public function assertUnitReturnThis($result, $mock, $class)
    {
        $a = explode("\\", $class);
        $className = $a[count($a) - 1];
        $this->assertContains($className, get_class($result));
        $this->assertContains(get_class($mock), get_class($result));
    }

    /**
     * @param $response
     */
    public function assertRequiredHeadersAsExpected(
        $response
    ) {
        $requiredResponseHeaders = [
            'Cache-Control',
            'Content-Type',
            'Date',
            //'Access-Control-Allow-Origin', //TODO
            //'Vary', //TODO
        ];
        foreach ($requiredResponseHeaders as $header) {
            $this->assertTrue(
                $response->headers->has($header),
                "Does not return header '$header''"
            );
        }
    }

    /**
     * @param $items
     * @param  string  $column
     */
    public function assertArrayNumericAsc(
        $items,
        $column = "id"
    ) {
        $id = $items[0][$column];
        foreach ($items as $item) {
            $this->assertGreaterThanOrEqual($id, $item[$column]);
            $id = $item[$column];
        }
    }

    /**
     * @param $items
     * @param  string  $column
     */
    public function assertArrayNumericDesc(
        $items,
        $column = "id"
    ) {
        $id = $items[0][$column];
        foreach ($items as $item) {
            $this->assertLessThanOrEqual($id, $item[$column]);
            $id = $item[$column];
        }
    }

    /**
     * @param $items
     * @param  string  $column
     */
    public function assertArrayStringAsc(
        $items,
        $column = "id"
    ) {
        $string = $items[0][$column];
        foreach ($items as $item) {
            $lexical = strcasecmp($string, $item[$column]);
            $this->assertLessThanOrEqual(0, $lexical);
            $string = $item[$column];
        }
    }

    /**
     * @param $items
     * @param  string  $column
     */
    public function assertArrayStringDesc(
        $items,
        $column = "id"
    ) {
        $string = $items[0][$column];
        foreach ($items as $item) {
            $lexical = strcasecmp($string, $item[$column]);
            $this->assertGreaterThanOrEqual(0, $lexical);
            $string = $item[$column];
        }
    }

    /**
     * @param $item
     * @param  $value
     * @return bool
     */
    protected function assertIncludes(
        $item,
        $value
    ) {
        $this->assertNotNull($item);

        if (is_string($value)) {
            $values = [$value];
        } else {
            $values = (array)$value;
        }

        foreach ($values as $value) {
            if ($value == $item) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $items
     * @param $value
     */
    protected function assertEqualsInRows($items, $key, $value)
    {
        $this->assertIsIterable($items);
        foreach ($items as $item) {
            $this->assertEquals($value, $item[$key]);
        }
    }
}
