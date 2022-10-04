<?php

namespace App\Http\Controllers\Auth;

use App\Events\BidderCreated;
use App\Events\CandidateCreated;
use App\Events\UserLoggedIn;
use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\Register\RegisterBidderRequest;
use App\Http\Requests\Register\RegisterCandidateRequest;
use App\Http\Resources\UserResource;
use App\TuChance\Models\SocialLogin;
use App\TuChance\Models\User;
use Facebook\Facebook;
use Google_Client;
use Google_Service_Oauth2;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;

class RegisterController extends Controller
{
    /**
     * Auth factory
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * User model
     * @var \App\TuChance\Models\User
     */
    protected $users;

    /**
     * Auth factory
     * @var \App\TuChance\Models\SocialLogin
     */
    protected $social_logins;

    /**
     * Create a new controller instance
     * @param  \Illuminate\Contracts\Auth\Factory $auth
     * @param  \App\TuChance\Models\SocialLogin   $social_logins
     * @param  \App\TuChance\Models\User          $users
     * @return void
     */
    public function __construct(
        Factory $auth,
        User $users,
        SocialLogin $social_logins
    ) {
        $this->auth          = $auth;
        $this->social_logins = $social_logins;
        $this->users         = $users;
    }

    /**
     * Register bidder account
     * @param  \App\Http\Requests\Account\RegisterBidderRequest $request
     * @return \App\Http\Resources\UserResource
     */
    public function bidder(RegisterBidderRequest $request)
    {
        return $this->respondWithUser($request, 'bidder');
    }

    /**
     * Register candidate account
     * @param  \App\Http\Requests\Account\RegisterCandidateRequest $request
     * @return \App\Http\Resources\UserResource
     */
    public function candidate(RegisterCandidateRequest $request)
    {
        return $this->respondWithUser($request, 'candidate');
    }
    /**
     * Get social login for given network
     * @param  \App\TuChance\Models\SocialLogin  $social
     * @param  \Illuminate\Http\Request          $request
     * @return \App\TuChance\Models\SocialLogin|null
     */
    public function getSocialLogin(Request $request)
    {
        if (!$request->has('network')) {
            return null;
        }

        $social = $this->social_logins
            ->firstOrNew([
                'network'    => $request->get('network'),
                'network_id' => $request->get('id'),
            ]);

        if ($social->exists) {
            return false;
        }

        if ($social->network == 'facebook') {
            return $this->facebook($social, $request);
        }

        if ($social->network == 'google') {
            return $this->google($social, $request);
        }

        return null;
    }

    /**
     * Validate Facebook token and return social profile if found
     * @param  \App\TuChance\Models\SocialLogin  $social
     * @param  \Illuminate\Http\Request          $request
     * @return \App\TuChance\Models\SocialLogin|null
     */
    public function facebook(SocialLogin $social, Request $request)
    {
        $facebook = app(Facebook::class);
        $facebook->setDefaultAccessToken($request->get('access_token'));
        $profile = $facebook->get('/me?fields=email,id,name')->getGraphUser();

        if ($profile->getId()) {
            return $social;
        }

        return null;
    }

    /**
     * Validate Google token and return social profile if found
     * @param  \App\TuChance\Models\SocialLogin  $social
     * @param  \Illuminate\Http\Request          $request
     * @return \App\TuChance\Models\SocialLogin|null
     */
    public function google(SocialLogin $social, Request $request)
    {
        $client = app(Google_Client::class);
        $oauth2 = app(Google_Service_Oauth2::class);
        $client->setAccessToken($request->get('access_token'));
        $profile = $oauth2->userinfo->get();

        if ($profile->id) {
            return $social;
        }

        return null;
    }

    /**
     * Respond a fresh instance of the authenticated user
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null               $role
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithUser(Request $request, $role = null)
    {
        $relations    = ['country', 'state', 'city', 'tags', 'avatar'];
        $social_login = $this->getSocialLogin($request);

        if ($social_login === false) {
            return new JsonResponse(['error' => 'duplicate_user'], 401);
        }

        if (in_array($role, ['bidder', 'candidate'])) {
            array_push($relations, $role);

            $data             = $request->except($role, 'password');
            $data['password'] = bcrypt($request->get('password'));

            $user    = $this->users->create($data);
            $profile = $user->{$role}()->create(array_merge(
                $request->get($role, []),
                array_only($data, ['country_id', 'state_id', 'city_id'])
            ));

            $avatar = $this->cropImage($user, 'avatar', $request);

            if ($social_login) {
                $social_login->user()->associate($user);
                $social_login->save();
            }

            if ($role == 'bidder') {
                $categories = array_get(
                    $request->get($role, []),
                    'categories',
                    []
                );

                if (is_array($categories)) {
                    $category_ids = collect($categories)->pluck('id');
                    $profile->categories()->sync($category_ids);
                }

                event(new BidderCreated($profile));
            } else {
                event(new CandidateCreated($profile));
            }

            event(new UserRegistered($user));

            $user->assignRole($role);
        } else {
            throw new InvalidArgumentException('Invalid role');
        }

        $user->tags()->sync($request->get('tag_ids', []));

        event(new UserLoggedIn($user));

        return new JsonResponse([
            'access_token' => $this->auth->fromUser($user),
            'token_type'   => 'bearer',
            'expires_in'   => $this->auth->factory()->getTTL() * 60,
            'user'         => new UserResource($user->fresh($relations)),
        ]);
    }
}
