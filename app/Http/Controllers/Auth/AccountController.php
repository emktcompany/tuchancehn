<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\UpdateAdminRequest;
use App\Http\Requests\Account\UpdateBidderRequest;
use App\Http\Requests\Account\UpdateCandidateRequest;
use App\Http\Resources\UserResource;
use App\TuChance\Models\User;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Auth factory
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new controller instance
     * @return void
     */
    public function __construct(Factory $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Update bidder account
     * @param  \App\Http\Requests\Account\UpdateBidderRequest $request
     * @return \App\Http\Resources\UserResource
     */
    public function bidder(UpdateBidderRequest $request)
    {
        return $this->respondWithUser($request, 'bidder');
    }

    /**
     * Update candidate account
     * @param  \App\Http\Requests\Account\UpdateCandidateRequest $request
     * @return \App\Http\Resources\UserResource
     */
    public function candidate(UpdateCandidateRequest $request)
    {
        return $this->respondWithUser($request, 'candidate');
    }

    /**
     * Update candidate account
     * @param  \App\Http\Requests\Account\UpdateAdminRequest $request
     * @return \App\Http\Resources\UserResource
     */
    public function admin(UpdateAdminRequest $request)
    {
        return $this->respondWithUser($request);
    }

    /**
     * Respond a fresh instance of the authenticated user
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null               $role
     * @return \App\Http\Resources\UserResource
     */
    protected function respondWithUser(Request $request, $role = null)
    {
        $relations = ['country', 'state', 'city', 'tags', 'avatar'];

        $user = $this->auth->user();

        $avatar = $this->cropImage($user, 'avatar', $request);

        $data = $request->except('password');

        if (
            $request->has('password') &&
            $password = $request->get('password')
        ) {
            $data['password'] = bcrypt($request->get('password'));
        }

        if (in_array($role, ['bidder', 'candidate'])) {
            array_push($relations, $role);

            $user->fill(array_except($data, $role));
            $user->load($role);

            $profile = $user->getRelation($role);

            if ($profile) {
                $profile->fill(array_merge(
                    $request->get($role, []),
                    array_only($data, ['country_id', 'state_id', 'city_id'])
                ));
                $profile->save();
            }

            if ($role == 'candidate' && $profile) {
                $skills = array_get($request->get($role, []), 'skills', []);

                if (is_array($skills)) {
                    $skill_ids = collect($skills)->pluck('id')
                        ->flip()
                        ->map(function ($weight) {
                            return compact('weight');
                        });
                    $profile->skills()->sync($skill_ids);
                }

                $this->attachFile($profile, 'cv', $request);

                array_push($relations, 'candidate.cv');
            }

            if ($role == 'bidder' && $profile) {
                $categories = array_get(
                    $request->get($role, []),
                    'categories',
                    []
                );

                if (is_array($categories)) {
                    $category_ids = collect($categories)->pluck('id');
                    $profile->categories()->sync($category_ids);
                }
            }
        } else {
            $user->fill($data);
        }

        $user->save();
        $user->tags()->sync($request->get('tag_ids', []));

        return new UserResource($user->fresh($relations));
    }
}
