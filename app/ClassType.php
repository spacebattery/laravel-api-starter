<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Definition(
 *   definition="PaginatedClassType",
 *   @SWG\Property(
 *     property="total",
 *     type="integer",
 *     format="int64"
 *   ),
 *   @SWG\Property(
 *     property="per_page",
 *     type="integer",
 *     format="int64"
 *   ),
 *   @SWG\Property(
 *     property="current_page",
 *     type="integer",
 *     format="int64"
 *   ),
 *   @SWG\Property(
 *     property="last_page",
 *     type="integer",
 *     format="int64"
 *   ),
 *   @SWG\Property(
 *     property="name",
 *     type="string",
 *     minLength=3
 *   )
 * )
 */

/**
 * @SWG\Definition(
 *   definition="ClassType",
 *   required={"name"},
 *   @SWG\Property(
 *     property="id",
 *     type="integer",
 *     format="int64"
 *   ),
 *   @SWG\Property(
 *     property="name",
 *     type="string",
 *     minLength=3
 *   )
 * )
 */
class ClassType extends Model
{
    use Filterable, Sortable;

    protected $fillable = ['name'];
}
