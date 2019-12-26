<?php

namespace QuadStudio\Service\Site\Http\Controllers\Api;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Events\Digift\ExceptionEvent;
use QuadStudio\Service\Site\Exceptions\Digift\DigiftException;
use QuadStudio\Service\Site\Filters\DigiftBonus\DigiftBonusChangeBalanceFilter;
use QuadStudio\Service\Site\Filters\DigiftBonus\DigiftUserProfileFilter;
use QuadStudio\Service\Site\Http\Requests\Api\DigiftRequest;
use QuadStudio\Service\Site\Models\DigiftBonus;
use QuadStudio\Service\Site\Models\DigiftUser;
use QuadStudio\Service\Site\Repositories\DigiftBonusRepository;
use QuadStudio\Service\Site\Repositories\DigiftUserRepository;

class DigiftController extends Controller
{

	/**
	 * @var DigiftBonusRepository
	 */
	private $digiftBonuses;
	/**
	 * @var DigiftUserRepository
	 */
	private $digiftUsers;

	/**
	 * DigiftBonusController constructor.
	 *
	 * @param DigiftBonusRepository $digiftBonuses
	 * @param DigiftUserRepository $digiftUsers
	 */
	public function __construct(
		DigiftBonusRepository $digiftBonuses,
		DigiftUserRepository $digiftUsers
	)
	{
		$this->digiftBonuses = $digiftBonuses;
		$this->digiftUsers = $digiftUsers;
	}

	/**
	 * Получить списание бонуса из Дигифт
	 *
	 * @param DigiftRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function storeExpense(DigiftRequest $request)
	{
		$request->store();

		return response()->json(trans('site::digift_expense.success'), Response::HTTP_OK);
	}

	/**
	 * Отправить все бонусы в Дигифт
	 *
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 */
	public function changeBalance()
	{

		$this->digiftBonuses->applyFilter(new DigiftBonusChangeBalanceFilter());

		if ($this->digiftBonuses->count() == 0) {
			return response()->json(trans('site::digift_expense.success'), Response::HTTP_OK);
		}

		try {
			/** @var DigiftBonus $digiftBonus */
			foreach ($this->digiftBonuses->all() as $digiftBonus) {
				$digiftBonus->changeBalance();
			}
		} catch (GuzzleException $e) {
			event(new ExceptionEvent(__FUNCTION__, trans('site::digift.error.admin.guzzle', ['message' => $e->getMessage()])));
		} catch (DigiftException $e) {
			event(new ExceptionEvent(__FUNCTION__, trans('site::digift.error.admin.digift', ['message' => $e->getMessage()])));
		} catch (\Exception $e) {
			event(new ExceptionEvent(__FUNCTION__, trans('site::digift.error.admin.unknown', ['message' => $e->getMessage()])));
		} finally {
			return response()->redirectToRoute('api.digift.changeBalance');
		}
	}

	/**
	 * Сверить баланс всех пользователей Дигифт
	 *
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 */
	public function profile()
	{

		$this->digiftUsers->applyFilter(new DigiftUserProfileFilter());

		if ($this->digiftUsers->count() == 0) {
			return response()->json(trans('site::digift_expense.success'), Response::HTTP_OK);
		}

		try {
			/** @var DigiftUser $digiftUser */
			foreach ($this->digiftUsers->all() as $digiftUser) {
				$digiftUser->profile();
			}
		} catch (GuzzleException $e) {
			event(new ExceptionEvent(__FUNCTION__, trans('site::digift.error.admin.guzzle', ['message' => $e->getMessage()])));
		} catch (DigiftException $e) {
			event(new ExceptionEvent(__FUNCTION__, trans('site::digift.error.admin.digift', ['message' => $e->getMessage()])));
		} catch (\Exception $e) {
			event(new ExceptionEvent(__FUNCTION__, trans('site::digift.error.admin.unknown', ['message' => $e->getMessage()])));
		} finally {
			return response()->redirectToRoute('api.digift.profile');
		}
	}

}