<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

use Psr\Log\LoggerInterface;

use CodeIgniter\API\ResponseTrait;

// models path
use \App\Models\Chat;
use \App\Models\ChatLine;

use \App\Models\Contact;
use \App\Models\ContactDetails;

use \App\Models\DrugClassification;
use \App\Models\GeneralClassification;

use \App\Models\GenericName;

use \App\Models\ImageFile;

use \App\Models\Medicine;
use \App\Models\MedicineClassification;
use \App\Models\MedicineForm;
use \App\Models\MedicineGenericName;
use \App\Models\MedicineTrend;

use \App\Models\Patient;

use \App\Models\Pharmacist;
use \App\Models\Pharmacy;
use \App\Models\PharmaDocuments;
use \App\Models\PharmaInventory;
use \App\Models\PharmaLog;

use \App\Models\AdminModel;
use \App\Models\AdminActivityLogModel;

use \App\Models\Announcement;

class BaseController extends Controller
{
	use ResponseTrait;
	/**
	 * Instance of the main Request object.
	 *
	 * @var IncomingRequest|CLIRequest
	 */
	protected $request;

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['url'];

	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.: $this->session = \Config\Services::session();
		// preload models
		$this->chatModel = new Chat();
		$this->chatLineModel = new ChatLine();

		$this->contactModel = new Contact();
		$this->contactDetailsModel = new ContactDetails();

		$this->drugClassificationModel = new DrugClassification();
		$this->generalClassificationModel = new GeneralClassification();

		$this->genericNameModel = new GenericName();

		$this->imageFileModel = new ImageFile();

		$this->medicineModel = new Medicine();
		$this->medicineClassificationModel = new MedicineClassification();
		$this->medicineFormModel = new MedicineForm();
		$this->medicineGenericNameModel = new MedicineGenericName();
		$this->medicineTrendModel = new MedicineTrend();

		$this->patientModel = new Patient();

		$this->pharmacistModel = new Pharmacist();
		$this->pharmacyModel = new Pharmacy();
		$this->pharmacyDocumentsModel = new PharmaDocuments();
		$this->pharmacyInventoryModel = new PharmaInventory();
		$this->pharmacyLogsModel = new PharmaLog();

		$this->adminModel = new AdminModel();
		$this->adminActivityLogModel = new AdminActivityLogModel();

		$this->announcementModel = new Announcement();

		// preload services
		$this->session = \Config\Services::session();
		$this->uri = service('uri');
		$this->time = new Time();
		$this->queryBuilder	= \Config\Database::connect();

	}

	public function sendEmail($fromEmail, $fromName, $toEmail, $toName, $subject, $message){
        $emailService = \Config\Services::email();
        $emailService->setFrom($fromEmail, $fromName);
        $emailService->setTo($toEmail, $toName);
        $emailService->setSubject($subject);
        $emailService->setMessage($message);//your message here

        $emailService->send();
	}
}
