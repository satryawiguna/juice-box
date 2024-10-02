<?php

namespace App\Repositories;

use App\Http\Requests\RegisterRequest;
use App\Models\BaseModel;
use App\Models\Permission;
use App\Models\Policy;
use App\Models\Profile;
use App\Models\User;
use App\Repositories\Contracts\IUserRepository;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository implements IUserRepository
{
    protected readonly Profile $_profile;
    protected readonly Permission $_permission;
    protected readonly Policy $_policy;

    public function __construct(User       $user,
                                Profile    $profile,
                                Permission $permission,
                                Policy     $policy)
    {
        parent::__construct($user);

        $this->_profile = $profile;
        $this->_permission = $permission;
        $this->_policy = $policy;
    }

    public function storeUser(RegisterRequest $request): BaseModel
    {
        $user = $this->_model;

        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $this->setAuditableInformationFromRequest($user, $request);

        $user->save();

        $this->_profile->first_name = $request->first_name;
        $this->_profile->last_name = $request->last_name;
        $this->_profile->mobile_phone = $request->mobile_phone;

        $this->setAuditableInformationFromRequest($this->_profile, $request);

        $user->profile()->save($this->_profile);

        $permission = $this->_permission
            ->where('slug', 'user')
            ->first();

        $user->permissions()->attach([$permission->id]);

        $policy = $this->_policy
            ->where('slug', 'member-group')
            ->first();

        $user->policies()->attach([$policy->id]);

        return $user->refresh();
    }
}
