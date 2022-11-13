<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\CompleteLevel
 *
 * @property int $id
 * @property string $name
 * @property int $value
 * @method static \Illuminate\Database\Eloquent\Builder|CompleteLevel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompleteLevel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompleteLevel query()
 * @method static \Illuminate\Database\Eloquent\Builder|CompleteLevel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompleteLevel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompleteLevel whereValue($value)
 */
	class CompleteLevel extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Entity
 *
 * @property int $id
 * @property string $name
 * @property int|null $parent_entity_id
 * @property int $entity_level_id
 * @property int $supervisor_id
 * @property int $is_root_node
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $employees
 * @property-read int|null $employees_count
 * @property-read \App\Models\EntityLevel|null $entityLevel
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Goal[] $goals
 * @property-read int|null $goals_count
 * @property-read Entity|null $parentEntity
 * @property-read \Illuminate\Database\Eloquent\Collection|Entity[] $subEntities
 * @property-read int|null $sub_entities_count
 * @property-read \App\Models\User $supervisor
 * @method static \Illuminate\Database\Eloquent\Builder|Entity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Entity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Entity query()
 * @method static \Illuminate\Database\Eloquent\Builder|Entity whereEntityLevelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entity whereIsRootNode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entity whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entity whereParentEntityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entity whereSupervisorId($value)
 */
	class Entity extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EntityLevel
 *
 * @property int $id
 * @property string $name
 * @property int|null $parent_entity_level_id
 * @property int $show_to_all
 * @property int $employee_level
 * @property int $show_to_descendants
 * @property int $show_to_direct_descendant
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Entity[] $entities
 * @property-read int|null $entities_count
 * @property-read EntityLevel|null $parentEntityLevel
 * @property-read \Illuminate\Database\Eloquent\Collection|EntityLevel[] $subEntityLevels
 * @property-read int|null $sub_entity_levels_count
 * @method static \Illuminate\Database\Eloquent\Builder|EntityLevel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EntityLevel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EntityLevel query()
 * @method static \Illuminate\Database\Eloquent\Builder|EntityLevel whereEmployeeLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EntityLevel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EntityLevel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EntityLevel whereParentEntityLevelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EntityLevel whereShowToAll($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EntityLevel whereShowToDescendants($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EntityLevel whereShowToDirectDescendant($value)
 */
	class EntityLevel extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Goal
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $comment
 * @property int|null $parent_goal_id
 * @property int $complete_level_id
 * @property int|null $entity_id
 * @property int|null $user_id
 * @property-read \App\Models\CompleteLevel|null $completeLevel
 * @property-read \App\Models\Entity|null $entity
 * @property-read Goal|null $parentGoal
 * @property-read \Illuminate\Database\Eloquent\Collection|Goal[] $subGoals
 * @property-read int|null $sub_goals_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Goal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Goal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Goal query()
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereCompleteLevelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereEntityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereParentGoalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereUserId($value)
 */
	class Goal extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $remember_token
 * @property int|null $entity_id
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $directlySupervisedEmployees
 * @property-read int|null $directly_supervised_employees_count
 * @property-read \App\Models\Entity|null $entity
 * @property-read string $profile_photo_url
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Goal[] $goals
 * @property-read int|null $goals_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Entity[] $supervisedEntities
 * @property-read int|null $supervised_entities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEntityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserInvitation
 *
 * @property int $id
 * @property string $email
 * @property string $invitation_token
 * @property int $used
 * @property string $expire_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|UserInvitation byToken($token)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInvitation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserInvitation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserInvitation permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInvitation query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserInvitation role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInvitation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInvitation whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInvitation whereExpireAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInvitation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInvitation whereInvitationToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInvitation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInvitation whereUsed($value)
 */
	class UserInvitation extends \Eloquent {}
}

