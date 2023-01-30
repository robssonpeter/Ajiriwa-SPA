<?php


namespace App\Custom;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class SEOTools
{
    public static function makeUrlString ($urlString) {
        return htmlentities($urlString, ENT_QUOTES, 'UTF-8'); 
    }

    public static function makeIso8601TimeStamp ($dateTime) {
        if (!$dateTime) {
            $dateTime = date('Y-m-d H:i:s');
        }
        if (is_numeric(substr($dateTime, 11, 1))) {
            $isoTS = substr($dateTime, 0, 10) ."T" 
                     .substr($dateTime, 11, 8) ."+00:00";
        }
        else {
            $isoTS = substr($dateTime, 0, 10);
        }
        return $isoTS;
    }

    public static function makeUrlTag ($url, $modifiedDateTime, $changeFrequency, $priority) {
        GLOBAL $newLine;
        GLOBAL $indent;
        GLOBAL $isoLastModifiedSite;
        $urlOpen = "$indent<url>$newLine";
        $urlValue = "";
        $urlClose = "$indent</url>$newLine";
        $locOpen = "$indent$indent<loc>";
        $locValue = "";
        $locClose = "</loc>$newLine";
        $lastmodOpen = "$indent$indent<lastmod>";
        $lastmodValue = "";
        $lastmodClose = "</lastmod>$newLine";
        $changefreqOpen = "$indent$indent<changefreq>";
        $changefreqValue = "";
        $changefreqClose = "</changefreq>$newLine";
        $priorityOpen = "$indent$indent<priority>";
        $priorityValue = "";
        $priorityClose = "</priority>$newLine";
    
        $urlTag	= $urlOpen;
        $urlValue     = $locOpen .self::makeUrlString("$url") .$locClose;
        if ($modifiedDateTime) {
         $urlValue .= $lastmodOpen .self::makeIso8601TimeStamp($modifiedDateTime) .$lastmodClose; 
         if (!$isoLastModifiedSite) { // last modification of web site
             $isoLastModifiedSite = self::makeIso8601TimeStamp($modifiedDateTime); 
         } 
        }
        if ($changeFrequency) {
         $urlValue .= $changefreqOpen .$changeFrequency .$changefreqClose; 
        }
        if ($priority) {
         $urlValue .= $priorityOpen .$priority .$priorityClose; 
        }
        $urlTag .= $urlValue;
        $urlTag .= $urlClose;
        return $urlTag;
    }
}
