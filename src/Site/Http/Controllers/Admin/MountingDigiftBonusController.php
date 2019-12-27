<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use QuadStudio\Service\Site\Http\Requests\Admin\DigiftBonusRequest;
use QuadStudio\Service\Site\Models\Mounting;
use QuadStudio\Service\Site\Models\User;
use QuadStudio\Service\Site\Exceptions\Digift\DigiftException;

class MountingDigiftBonusController extends Controller
{

	/**
	 * @param Mounting $mounting
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Throwable
	 */
	public function store(Mounting $mounting)
	{

		try {
			/** @var User $user */
			$user = $mounting->user;
			$user->makeDigiftUser();
			$mounting->digiftBonus()->create([
				'user_id' => $user->digiftUser->id,
				'operationValue' => $mounting->total,
			]);
			Session::flash('success', trans('site::digift_bonus.rollbackSuccess'));
		} catch (GuzzleException $e) {
			Session::flash('error', trans('site::digift.error.admin.guzzle', ['message' => $e->getMessage()]));
		} catch (DigiftException $e) {
			Session::flash('error', trans('site::digift.error.admin.digift', ['message' => $e->getMessage()]));
		} catch (\Exception $e) {
			Session::flash('error', trans('site::digift.error.admin.unknown', ['message' => $e->getMessage()]));
		} finally {
			return response()->json(['replace' => [
				'#digift-bonus' => view('site::admin.digift_bonus.user')->with('bonusable', $mounting)->render(),
			]], Response::HTTP_OK);
		}


	}

	/**
	 * @param  DigiftBonusRequest $request
	 * @param Mounting $mounting
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store_mounting(DigiftBonusRequest $request, Mounting $mounting)
	{
		$type = 'success';
		$message = trans('site::digift_bonus.created');
		try {
			$request->store_mounting($mounting);
		} catch (\Exception $exception) {
			$type = 'error';
			$message = $exception->getMessage();
		} finally {
			return redirect()->route('admin.mountings.show', $mounting)->with($type, $message);
		}


	}


}