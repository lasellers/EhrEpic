<?php

namespace Tests;

use App\Models\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\Constraint\IsInstanceOf;

trait TestCaseAssertSorted
{
    /**
     * Looks through an items list at a specified key to determine if they are in one of n known correct orders.
     * Note: All compare tests do checks for null and array or object tests in their pre-checks so
     * you can eliminate those tests from your tests proper.
     *
     * Note: If the order doesn't matter, consider using assertPluckEquals.
     *
     * @param $items
     * @param array $orderedIdsArray
     * @param string $key Field used index key, ie, 'id'
     */
    protected function assertIsSorted(
        $items,
        $orderedIdsArray,
        $key = 'id'
    )
    {
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
     * @param string $key
     * @param string $order
     * @param string $type
     */
    protected function assertIsSortedAny(
        $items,
        $key = 'id',
        $order = 'ASC',
        $type = 'string'
    )
    {
        if ($order === 'ASC' && $type === 'numeric') {
            $this->assertIsSortedNumericAsc($items, $key);
        }
        if ($order === 'DESC' && $type === 'numeric') {
            $this->assertIsSortedNumericDesc($items, $key);
        }
        if ($order === 'ASC' && $type === 'string') {
            $this->assertIsSortedStringAsc($items, $key);
        }
        if ($order === 'DESC' && $type === 'string') {
            $this->assertIsSortedStringDesc($items, $key);
        }
    }

    /**
     * @param $items
     * @param string $key
     */
    protected function assertIsSortedNumericAsc(
        $items,
        $key = 'id'
    )
    {
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
     * @param string $key
     */
    protected function assertIsSortedNumericDesc(
        $items,
        $key = 'id'
    )
    {
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
     * @param string $key
     */
    protected function assertIsSortedStringAsc(
        $items,
        $key = 'id'
    )
    {
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
     * @param string $key
     */
    protected function assertIsSortedStringDesc(
        $items,
        $key = 'id'
    )
    {
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

}
