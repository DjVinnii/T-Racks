<?php

namespace App\Helpers;

class RackHelper
{
    // This function sets rowspan/colspan attributes for rack-diagram blade
    // by finding _all_ possible rectangles for each rack unit and then selecting
    // the widest of those with the maximal square.
    public static function markAllSpans(&$rack)
    {
        for ($i = $rack->height; $i > 0; $i--)
            while (self::markBestSpan($rack, $i));
    }

    // This function finds height of solid rectangle of atoms that are all
    // assigned to the same object. Rectangle base is defined by specified
    // template.
    private static function rectHeight($rack, $startRow, $template_idx)
    {
        $height = 0;
        // The first met object_id is used to match all the following IDs.
        $object_id = 0;

        $template[0] = array (TRUE, TRUE, TRUE);
        $template[1] = array (TRUE, TRUE, FALSE);
        $template[2] = array (FALSE, TRUE, TRUE);
        $template[3] = array (TRUE, FALSE, FALSE);
        $template[4] = array (FALSE, TRUE, FALSE);
        $template[5] = array (FALSE, FALSE, TRUE);

        do
        {
            for ($locidx = 0; $locidx < 3; $locidx++)
            {
                // At least one value in template is TRUE, but the following block
                // can meet 'skipped' atoms. Let's ensure there is at least some result
                // after processing the first row.
                if ($template[$template_idx][$locidx])
                {
                    if(
                        isset($rack->rackUnits->where('unit_no', $startRow - $height)->where('position', $locidx)->first()->skipped) ||
                        isset($rack->rackUnits->where('unit_no', $startRow - $height)->where('position', $locidx)->first()->rowspan) ||
                        isset($rack->rackUnits->where('unit_no', $startRow - $height)->where('position', $locidx)->first()->colspan) ||
                        $rack->rackUnits->where('unit_no', $startRow - $height)->where('position', $locidx)->isEmpty()
                    )
                        break 2;
                    if ($object_id == 0)
                        $object_id = $rack->rackUnits->where('unit_no', $startRow - $height)->where('position', $locidx)->first()->hardware_id;
                    if ($object_id != $rack->rackUnits->where('unit_no', $startRow - $height)->where('position', $locidx)->first()->hardware_id)
                        break 2;
                }
            }

            // If the first row can't offer anything, bail out.
            if ($height == 0 && $object_id == 0)
                break;
            $height++;
        }

        while ($startRow - $height > 0);
        return $height;
    }

    // This function marks atoms to be avoided by rectHeight() and assigns rowspan/colspan
    // attributes.
    private static function markSpan(&$rack, $startRow, $maxHeight, $template_idx)
    {
        $template[0] = array (TRUE, TRUE, TRUE);
        $template[1] = array (TRUE, TRUE, FALSE);
        $template[2] = array (FALSE, TRUE, TRUE);
        $template[3] = array (TRUE, FALSE, FALSE);
        $template[4] = array (FALSE, TRUE, FALSE);
        $template[5] = array (FALSE, FALSE, TRUE);

        $templateWidth[0] = 3;
        $templateWidth[1] = 2;
        $templateWidth[2] = 2;
        $templateWidth[3] = 1;
        $templateWidth[4] = 1;
        $templateWidth[5] = 1;

        $colspan = 0;
        for($height = 0; $height < $maxHeight; $height++)
        {
            for($locidx = 0; $locidx < 3; $locidx++)
            {
                if($template[$template_idx][$locidx])
                {
                    // Add colspan/rowspan to the first row met and mark the following ones to skip.
                    // Explicitly show even single-cell spanned atoms, because rectHeight()
                    // is expeciting this data for correct calculation.
                    if ($colspan != 0)
                        $rack->rackUnits->where('unit_no', $startRow - $height)->where('position', $locidx)->first()->skipped = TRUE;
                    else{
                        $colspan = $templateWidth[$template_idx];
                        if($colspan >= 1)
                            $rack->rackUnits->where('unit_no', $startRow - $height)->where('position', $locidx)->first()->colspan = $colspan;
                        if($maxHeight >= 1)
                            $rack->rackUnits->where('unit_no', $startRow - $height)->where('position', $locidx)->first()->rowspan = $maxHeight;
                    }
                }
            }
        }
    }

    // Calculate height of 6 possible span templates (array is presorted by width
    // descending) and mark the best (if any).
    private static function markBestSpan(&$rack, $i)
    {
        $templateWidth[0] = 3;
        $templateWidth[1] = 2;
        $templateWidth[2] = 2;
        $templateWidth[3] = 1;
        $templateWidth[4] = 1;
        $templateWidth[5] = 1;

        $height = array();
        $square = array();

        foreach ($templateWidth as $j => $width)
        {
            $height[$j] = self::rectHeight($rack, $i, $j);
            $square[$j] = $height[$j] * $width;
        }

        // Find the widest rectangle of those with maximal height
        if (0 == $maxsquare = max ($square))
            return FALSE;

        $best_template_index = array_search ($maxsquare, $square);

        // Distribute span marks
        self::markSpan ($rack, $i, $height[$best_template_index], $best_template_index);

        return TRUE;
    }
}
