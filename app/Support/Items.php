<?php


namespace App\Support;


use App\Data\ItemComparison;

class Items
{
    /**
     * Compare two item lists and identify new items and items that has been removed
     * @param array $recentItems
     * @param array $previousItems
     * @return ItemComparison
     */
    public static function compare(array $recentItems, array $previousItems):ItemComparison
    {
        $new = null;
        $gone = null;
        foreach ($recentItems as $recentItem) {
            if (!in_array($recentItem, $previousItems)) {
                $new[] = $recentItem;
            }
        }
        foreach ($previousItems as $previousItem) {
            if (!in_array($previousItem, $recentItems)) {
                $gone[] = $previousItem;
            }
        }

        return ItemComparison::fromComparison($new, $gone);
    }
}
