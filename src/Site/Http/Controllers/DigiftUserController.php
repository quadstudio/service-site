<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use QuadStudio\Service\Site\Exceptions\Digift\DigiftException;
use QuadStudio\Service\Site\Models\DigiftUser;

class DigiftUserController extends Controller
{


	use AuthorizesRequests;

	/**
	 * @param DigiftUser $digiftUser
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Throwable
	 */
	public function fullUrlToRedirect(DigiftUser $digiftUser)
	{
		try {
			$this->authorize('fullUrlToRedirect', $digiftUser);

			if ($digiftUser->tokenIsExpired()) {
				$digiftUser->refreshToken();
			}

		} catch (AuthorizationException $exception) {
			Session::flash('error', trans('site::digift.error.user.cannotFullUrlToRedirect'));
			return response()->json(['replace' => [
				'#user-digift-bonuses' => view('site::digift_bonus.index')->with('digiftUser', $digiftUser)->render(),
			]], Response::HTTP_OK);
		} catch (GuzzleException $exception) {
			Session::flash('error', trans('site::digift.error.user.guzzle', ['message' => $exception->getMessage()]));
			return response()->json(['replace' => [
				'#user-digift-bonuses' => view('site::digift_bonus.index')->with('digiftUser', $digiftUser)->render(),
			]], Response::HTTP_OK);
		} catch (DigiftException $exception) {
			Session::flash('error', trans('site::digift.error.user.digift', ['message' => $exception->getMessage()]));
			return response()->json(['replace' => [
				'#user-digift-bonuses' => view('site::digift_bonus.index')->with('digiftUser', $digiftUser)->render(),
			]], Response::HTTP_OK);
		}
		return response()->json(['redirect' => $digiftUser->getAttribute('fullUrlToRedirect')], Response::HTTP_OK);
	}

}