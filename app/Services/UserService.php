<?php

namespace App\Services;

use App\Enums\MessageType;
use App\Events\UserNotification;
use App\Events\UserRegistered;
use App\Events\UserVerified;
use App\Exceptions\InvalidLoginAttemptException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Responses\BaseResponse;
use App\Http\Responses\GenericObjectResponse;
use App\Models\User;
use App\Repositories\Contracts\IUserRepository;
use App\Services\Contracts\IUserService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class UserService extends BaseService implements IUserService
{
    protected readonly IUserRepository $_userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->_userRepository = $userRepository;
    }

    public function register(RegisterRequest $request): BaseResponse
    {
        $response = new BaseResponse();

        DB::beginTransaction();

        try {
            $user = $this->_userRepository->storeUser($request);

            Event::dispatch(new UserRegistered($user));

            $this->addMessage($response, __('message.success.user_registered'), MessageType::SUCCESS);
            $this->setMessageResponse($response, MessageType::SUCCESS, Response::HTTP_OK);

            DB::commit();
        }
        catch (HttpResponseException|QueryException $ex) {
            DB::rollBack();

            throw $ex;
        }
        catch (Exception $ex) {
            DB::rollBack();

            $this->addMessage($response, __('message.error.something_went_wrong'), MessageType::ERROR);
            $this->setMessageResponse($response, MessageType::ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);

            Log::error(__('message.error.something_went_wrong') . ' → ' . $ex->getMessage(), getLoggingContext());
        }

        return $response;
    }

    public function login(LoginRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $identity = (filter_var($request->identity, FILTER_VALIDATE_EMAIL)) ? 'email' : 'username';

            if (!Auth::attempt([$identity => $request->identity, 'password' => $request->password])) throw new InvalidLoginAttemptException();

            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            $data = (object)[
                'id' => $user->id,
                'email' => $user->email,
                'username' => $user->username,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ];

            $this->setGenericObjectResponse($response,
                $data,
                MessageType::SUCCESS,
                Response::HTTP_OK);
        }
        catch (HttpResponseException|InvalidLoginAttemptException $ex) {
            throw $ex;
        }
        catch (Exception $ex) {
            $this->addMessage($response, __('message.error.something_went_wrong'), MessageType::ERROR);
            $this->setMessageResponse($response, MessageType::ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);

            Log::error(__('message.error.something_went_wrong') . ' → ' . $ex->getMessage(), getLoggingContext());
        }

        return $response;
    }

    public function logout(): BaseResponse
    {
        $response = new BaseResponse();

        try {
            if (!Auth::check()) throw new BadRequestException();

            Auth::user()->tokens()->delete();

            $this->addMessage($response, __('message.success.you_have_logged_out'), MessageType::SUCCESS);
            $this->setMessageResponse($response, MessageType::SUCCESS, Response::HTTP_OK);
        }
        catch (HttpResponseException|BadRequestException $ex) {
            throw $ex;
        }
        catch (Exception $ex) {
            $this->addMessage($response, __('message.error.something_went_wrong'), MessageType::ERROR);
            $this->setMessageResponse($response, MessageType::ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);

            Log::error(__('message.error.something_went_wrong') . ' → ' . $ex->getMessage(), getLoggingContext());
        }

        return $response;
    }

    public function getUser(string $id): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $user = $this->_userRepository->findById($id);

            if (!$user) throw new ModelNotFoundException;

            $this->setGenericObjectResponse($response,
                $user,
                MessageType::SUCCESS,
                Response::HTTP_OK);
        }
        catch (HttpResponseException|QueryException|ModelNotFoundException $ex) {
            throw $ex;
        }
        catch (Exception $ex) {
            $this->addMessage($response, __('message.error.something_went_wrong'), MessageType::ERROR);
            $this->setMessageResponse($response, MessageType::ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);

            Log::error(__('message.error.something_went_wrong') . ' → ' . $ex->getMessage(), getLoggingContext());
        }

        return $response;
    }

    public function verify(Request $request): BaseResponse
    {
        $response = new BaseResponse();

        DB::beginTransaction();

        try {
            $user = $this->_userRepository->findById($request->id);

            if (!$user instanceof User) throw new ModelNotFoundException();

            if (!URL::hasValidSignature($request)) throw new UnprocessableEntityHttpException();

            if ($user->hasVerifiedEmail()) throw new UnprocessableEntityHttpException();

            if ($user->markEmailAsVerified()) {
                Event::dispatch(new UserVerified($user));
                Event::dispatch(new UserNotification($user));

                $this->addMessage($response, __('message.success.email_verification_succeed'), MessageType::SUCCESS);
                $this->setMessageResponse($response, MessageType::SUCCESS, Response::HTTP_OK);

                DB::Commit();
            }
            else {
                $this->addMessage($response, __('message.error.email_verification_failed'), MessageType::ERROR);
                $this->setMessageResponse($response, MessageType::ERROR, Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }
        catch (HttpResponseException|ModelNotFoundException|UnprocessableEntityHttpException $ex) {
            DB::rollBack();

            throw $ex;
        }
        catch (Exception $ex) {
            DB::rollBack();

            $this->addMessage($response, __('message.error.something_went_wrong'), MessageType::ERROR);
            $this->setMessageResponse($response, MessageType::ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);

            Log::error(__('message.error.something_went_wrong') . ' → ' . $ex->getMessage(), getLoggingContext());
        }

        return $response;
    }
}
