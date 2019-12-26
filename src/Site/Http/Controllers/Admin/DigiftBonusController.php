<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use QuadStudio\Service\Site\Models\DigiftBonus;
use QuadStudio\Service\Site\Exceptions\Digift\DigiftException;

class DigiftBonusController extends Controller
{


	/**
	 * @param DigiftBonus $digiftBonus
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Throwable
	 */
	public function changeBalance(DigiftBonus $digiftBonus)
	{

		try {
			$digiftBonus->changeBalance();
			Session::flash('success', trans('site::digift_bonus.changeBalanceSuccess'));
		} catch (GuzzleException $e) {
			Session::flash('error', trans('site::digift.error.admin.guzzle', ['message' => $e->getMessage()]));
		} catch (DigiftException $e) {
			Session::flash('error', trans('site::digift.error.admin.digift', ['message' => $e->getMessage()]));
		} catch (\Exception $e) {
			Session::flash('error', trans('site::digift.error.admin.unknown', ['message' => $e->getMessage()]));
		} finally {
			return response()->json(['replace' => [
				'#digift-bonus' => view('site::admin.digift_bonus.index')->with('bonusable', $digiftBonus->fresh()->bonusable)->render(),
			]], Response::HTTP_OK);
		}
	}

	/**
	 * @param DigiftBonus $digiftBonus
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Throwable
	 */
	public function rollbackBalanceChange(DigiftBonus $digiftBonus)
	{

		try {
			$digiftBonus->rollbackBalanceChange();
			Session::flash('success', trans('site::digift_bonus.rollbackBalanceChangeSuccess'));
		} catch (GuzzleException $e) {
			Session::flash('error', trans('site::digift.error.admin.guzzle', ['message' => $e->getMessage()]));
		} catch (DigiftException $e) {
			Session::flash('error', trans('site::digift.error.admin.digift', ['message' => $e->getMessage()]));
		} catch (\Exception $e) {
			Session::flash('error', trans('site::digift.error.admin.unknown', ['message' => $e->getMessage()]));
		} finally {
			return response()->json(['replace' => [
				'#digift-bonus' => view('site::admin.digift_bonus.index')->with('bonusable', $digiftBonus->fresh()->bonusable)->render(),
			]], Response::HTTP_OK);
		}
	}

}