<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use QuadStudio\Service\Site\Exceptions\Certificate\CertificateException;
use QuadStudio\Service\Site\Http\Requests\CertificateRequest;
use QuadStudio\Service\Site\Models\Certificate;
use QuadStudio\Service\Site\Pdf\CertificatePdf;
use QuadStudio\Service\Site\Site\Imports\GoogleSheet\CertificateExcel;

class CertificateController extends Controller
{

	use AuthorizesRequests;

	/**
	 * @param CertificateRequest $request
	 * @param CertificateExcel $excel
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(CertificateRequest $request, CertificateExcel $excel)
	{
		try {
			$type = 'success';
			$message = trans('site::certificate.created');
			$excel->parse($request->input('email'));
		} catch (\Google_Exception $exception) {
			$type = 'error';
			$message = trans('site::certificate.error.google');
		} catch (CertificateException $exception) {
			$type = 'error';
			$message = $exception->getMessage();
		} catch (\Exception $exception) {
			$type = 'error';
			$message = trans('site::certificate.error.unhandled');
		} finally {
			return redirect()->route('home')->with($type, $message);
		}

	}

	public function show(Certificate $certificate)
	{
		try {
			$this->authorize('view', $certificate);
		} catch (AuthorizationException $e) {
			return redirect()->route('home')->with('error', trans('site::certificate.error.unauthorized'));
		}

		return (new CertificatePdf())->setModel($certificate)->render();

	}

}