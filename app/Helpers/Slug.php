<?php namespace App\Helpers;

use Illuminate\Support\Str;

class Slug {
    /**
     * customReplacements
     * Returns an array of custom text replacements for makeSlug
     * @return array
     */
    protected static function customReplacements(): array
    {
        // Array of [ searchText, replacementText ]
        return [
            ['&', '-and-'],
        ];
    }

    /**
     * Generate a URL friendly "slug" from a given string

     * Uses the laravel helper str_slug and adds custom rules
     * @param  string   $string     String to convert to a slug
     * @return string   the converted slug
     */
    public static function makeSlug(string $string, ?string $separator = '-', ?string $language = 'en'): string
    {
        foreach (self::customReplacements() as $x) {
            $string = str_replace($x[0], $x[1], $string);
        }

        $slug = Str::slug($string, $separator, $language); // make the base slug
        return $slug;
    }

    /**
     * Generate a URL friendly "slug" from a given string
     * And check that it doesn't exist in the table specified by a Laravel model
     *
     * @param  Model|string $model      Model or Classname of the model to check for collisions. For Laravel models, use ModelName::class
     * @param  string   $string     String to convert to a slug
     * @param  int      $id         Optional. Set this to the ID if you don't mind getting the same slug as long as the ID is the same.
     * @param  int      $slugCount  Optional. If > 1 a number will be appended to the end of the slug. Updates automatically to avoid collisions.
     * @return string   the converted slug
     */
    public static function makeSlugForModel(Model|string $model, string $string, ?int $id=null, ?int $slugCount=1): string|null
    {
        $maxRecursion = 100; // limit recursions to prevent errors
        $minSlugLength = 1;

        $slug = self::makeSlug($string); // make the base slug

        if (strlen($slug) < $minSlugLength) {
            report("makeSlugForModel failed - String too short: ".$string);
            return null;
        }
        if ($slugCount >= $maxRecursion) {
            $modelName = $model instanceof Model ? $model::class : $model;
            report("makeSlugForModel failed - max recursions reached. Model: ".$modelName." String: ".$string);
            return null;
        }

        if ($slugCount > 1) {
            $slug .= "-" . $slugCount; // add hyphen then the number
        }

        // If no id is passed, we check for any record that has a matching slug
        // If id is passed, we check for a record with a matching slug that ISN'T the same id
        // This avoids the issue of a record matching its own slug and having it change back and forth
        // It also means the function will overwrite the existing slug with a more 'correct' one
        // For example, if the string is 'Name', current slug is 'name-2' and there's no slug 'name', the current slug will be replaced with 'name'
        // If the slug is correct and not a duplicate, this function should return the same slug each time
        if ($id == null) {
            $slugCheck = $model::where('slug', $slug)->get(); // no id; check if slug exists in the model
        } else {
            $slugCheck = $model::where([ // id passed; check all records except the one with that id
                ['slug', $slug],
                ['id', '!=', $id]
            ])->get();
        }
        // If a matching slug was found, we run the check again, one number higher (-2, -3, etc)
        // and keep iterating until we find one that doesn't exist yet
        if($slugCheck->isNotEmpty()){ // slug exists
            $slugCount++;
            $slug = self::makeSlugForModel($model,$string,$id,$slugCount); // call recursively until we reach a slug that doesn't exist
        }

        return $slug;
    }
}
