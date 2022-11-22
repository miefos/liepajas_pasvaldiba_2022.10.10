<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Fortify\PasswordValidationRules;
use App\Http\Controllers\Controller;
use App\Http\Requests\InviteUserRequest;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Mail\RegistrationInvitationMail;
use App\Models\Entity;
use App\Models\User;
use App\Models\UserInvitation;
use Carbon\Carbon;
use http\Env\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    use PasswordValidationRules;

    public function index()
    {
        abort_if(Gate::denies('user_read'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // possibly this could be improved (performance-wise)
        $users = User::all();
        $users->each(function ($user) {
            $user->roles = $user->roles()->pluck('id');
        });

        $listings = [
            'roles' => Role::all('id', 'name'),
            'entities' => Entity::all('id', 'name')
        ];

        return Inertia::render('Users/index', [
            'users' => $users,
            'listings' => $listings
        ]);
    }

    /**
        Invite valid for 24h
        email prefilled
        roles prefilled
     */
    public function invite(InviteUserRequest $request)
    {
        $userInvitation = new UserInvitation();
        $userInvitation->email = $request->input('email');
        $userInvitation->expire_at = Carbon::now()->addDay();
        $userInvitation->assignNewToken();
        $userInvitation->syncRoles($request->input('roles', []));
        $userInvitation->entity_id = intval($request->input('entity_id'));

        $userInvitation->save();

        Mail::to($userInvitation->email)->send(new RegistrationInvitationMail($userInvitation->invitation_token));

        return back()->success('Ielūgums nosūtīts');
    }

    /**
        This should be available only with token
     */
    public function create(\Illuminate\Http\Request $request)
    {
        $token = $request->query('token');
        $invitation = UserInvitation::with('roles')->byToken($token);

        return Inertia::render('Auth/Register', [
            'invitation' => $invitation
        ]);
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $input = $request->all();
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'password' => $this->passwordRules(),
            'token' => ['required', Rule::exists('user_invitations', 'invitation_token')->where(function ($query) {
                return $query->where('used', false);
            })]
        ], ['token.required' => 'Reģistrācijas saite nav derīga.', 'token.exists' => 'Reģistrācijas saite nav derīga (2).', ])->validate();

        $invitation = UserInvitation::byToken($request->input('token'));

        $input['roles'] = $invitation->roles()->pluck('id')->toArray();
        $input['email'] = $invitation->email;
        $input['entity_id'] = $invitation->entity_id;

        Validator::make($input, [
            'email' => ['required', 'unique:users', 'email', 'max:255'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['integer', 'exists:roles,id'],
            'entity_id' => ['exists:entities,id']
        ])->validate();

        $user = new User;
        $user->email = $invitation->email;
        $user->name = $request->input('name');
        $user->password = Hash::make($input['password']);
        $user->entity_id = $invitation->entity_id;

        $user->syncRoles($input['roles']);

        $user->save();

        $invitation->used = true;
        $invitation->save();

        return redirect('/');
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_read'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::pluck('title', 'id');

        $user->load('roles');

        return view('admin.users.edit', compact('roles', 'user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        return back()->success(__('common.success.updated'));
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($errMsg = $user->userIsNotDeletable())
            return back()->danger($errMsg);

        $user->delete();

        return back()->success(__('common.success.deleted'));
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        $users = User::whereIn('id', request('ids'));
        $usersArr = $users->get();
        foreach ($usersArr as $user) {
            if ($errMsg = $user->userIsNotDeletable())
                return back()->danger($errMsg);
        }

        $users->delete();

        return back()->success(__('common.success.massDeleted'));
    }
}
