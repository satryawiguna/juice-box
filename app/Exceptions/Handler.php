<?php

namespace App\Exceptions;

use App\Enums\MessageType;
use App\Http\Responses\GenericResponse;
use App\Traits\JsonResponseHandler;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use JsonResponseHandler;


    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function report(Throwable $ex)
    {
        if ($ex instanceof InvalidLoginAttemptException) {
            Log::info(__('message.info.invalid_login_attempt') . ' → ' . $ex->getMessage(), getLoggingContext());
        }

        if ($ex instanceof UnauthorizedException) {
            Log::info(__('message.info.unauthorized') . ' → ' . $ex->getMessage(), getLoggingContext());
        }

        if ($ex instanceof ModelNotFoundException) {
            Log::error(__('message.error.model_not_found') . ' → ' . $ex->getMessage(), getLoggingContext());
        }

        if ($ex instanceof QueryException) {
            Log::error(__('message.error.invalid_query') . ' → ' . $ex->getMessage(), getLoggingContext());
        }

        if ($ex instanceof EmailHasBeenVerifiedException) {
            Log::info(__('message.error.email_has_been_verified') . ' → ' . $ex->getMessage(), getLoggingContext());
        }

        if ($ex instanceof BadRequestException) {
            Log::error(__('message.error.bad_request') . ' → ' . $ex->getMessage(), getLoggingContext());
        }

        if ($ex instanceof UnprocessableEntityHttpException) {
            Log::warning(__('message.error.unprocessable_entity_content') . ' → ' . $ex->getMessage(), getLoggingContext());
        }

        if ($ex instanceof RequestException) {
            if ($ex->hasResponse()) {
                $responseBody = $ex->getResponse()->getBody()->getContents();

                Log::error(__('message.error.invalid_request') . ' → ' . $responseBody, getLoggingContext());
            }
            else {
                Log::error(__('message.error.invalid_request') . ' → ' . $ex->getMessage(), getLoggingContext());
            }
        }

        parent::report($ex);
    }

    public function render($request, Throwable $ex)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $response = new GenericResponse();

            if ($ex instanceof InvalidLoginAttemptException) {
                $this->addMessage($response, __('message.info.invalid_login_attempt'), MessageType::INFO);
                $this->setMessageResponse($response, MessageType::INFO, Response::HTTP_UNAUTHORIZED);

                return $this->getInfoLatestJsonResponse($response);
            }

            if ($ex instanceof UnauthorizedException) {
                $this->addMessage($response, __('message.info.unauthorized'), MessageType::INFO);
                $this->setMessageResponse($response, MessageType::INFO, Response::HTTP_UNAUTHORIZED);

                return $this->getInfoLatestJsonResponse($response);
            }

            if ($ex instanceof ModelNotFoundException) {
                $this->addMessage($response, __('message.error.model_not_found'), MessageType::WARNING);
                $this->setMessageResponse($response, MessageType::WARNING, Response::HTTP_NOT_FOUND);

                return $this->getWarningLatestJsonResponse($response);
            }

            if ($ex instanceof QueryException) {
                $this->addMessage($response, __('message.error.invalid_query'), MessageType::ERROR);
                $this->setMessageResponse($response, MessageType::ERROR, Response::HTTP_BAD_REQUEST);

                return $this->getErrorLatestJsonResponse($response);
            }

            if ($ex instanceof EmailHasBeenVerifiedException) {
                $this->addMessage($response, __('message.error.email_has_been_verified'), MessageType::INFO);
                $this->setMessageResponse($response, MessageType::INFO, Response::HTTP_OK);

                return $this->getInfoLatestJsonResponse($response);
            }

            if ($ex instanceof BadRequestException) {
                $this->addMessage($response, __('message.error.bad_request'), MessageType::ERROR);
                $this->setMessageResponse($response, MessageType::ERROR, Response::HTTP_BAD_REQUEST);

                return $this->getErrorLatestJsonResponse($response);
            }

            if ($ex instanceof UnprocessableEntityHttpException) {
                $this->addMessage($response, __('message.error.unprocessable_entity_content'), MessageType::WARNING);
                $this->setMessageResponse($response, MessageType::WARNING, Response::HTTP_UNPROCESSABLE_ENTITY);

                return $this->getWarningLatestJsonResponse($response);
            }

            if ($ex instanceof RequestException) {
                if ($ex->hasResponse()) {
                    $statusCode = $ex->getResponse()->getStatusCode();

                    $this->addMessage($response, __('message.error.invalid_request'), MessageType::ERROR);
                    $this->setMessageResponse($response, MessageType::ERROR, $statusCode);
                }
                else {
                    $this->addMessage($response, $ex->getMessage(), MessageType::ERROR);
                    $this->setMessageResponse($response, MessageType::ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
                }

                return $this->getErrorLatestJsonResponse($response);
            }
        }

        return parent::render($request, $ex);
    }
}
