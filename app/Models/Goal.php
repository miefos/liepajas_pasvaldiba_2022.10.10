<?php

namespace App\Models;

use App\Services\GoalService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;
use Symfony\Component\HttpFoundation\Response;

class Goal extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    public $timestamps = false;

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected array $auditInclude = [
        'complete_level_id',
        'approved'
    ];

    protected $guarded = [];

    public function parentGoal () {
        return $this->belongsTo(Goal::class, 'parent_goal_id')->withoutGlobalScope('authorizeGoal');
    }

    public function subGoals () {
        return $this->hasMany(Goal::class, 'parent_goal_id');
    }

    public function completeLevel () {
        return $this->belongsTo(CompleteLevel::class);
    }

    public function entity() {
        return $this->belongsTo(Entity::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function editableByCurrentUser() {
        return GoalService::editableByCurrentUser($this);
    }

    public function approvableByCurrentUser() {
        return GoalService::approvableByCurrentUser($this);
    }

    public function getApprovedAttribute() {
        return (int) $this->attributes['approved'];
    }

    public function shouldBeBold()
    {
        return GoalService::isFirstLevelGoal($this);
    }

    protected static function booted() {
        static::addGlobalScope('authorizeGoal', function (Builder $builder) {
            return GoalService::authorizeAccessingGoal($builder);
        });
    }
}
