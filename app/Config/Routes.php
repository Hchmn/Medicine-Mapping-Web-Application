<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
/*
 *-------------------------------------------------
 * Pharmacy route
 *-------------------------------------------------
 */
$routes->get('/', 'Home::index');
$routes->get('/register', 'Register::register');
$routes->get('/authentication', 'Authentication::Authentication');
$routes->get('/dashboard','Dashboard::dashboard');
$routes->get('/addmedicine','AddMedicine::add_medicine');
$routes->get('/inbox','Inbox::inbox');
$routes->get('/logs', 'Logs::logs');
$routes->get('/settings','Settings::settings');
$routes->get('/pharmacists','Pharmacists::pharmacists');

$routes->post('/dashboard/medicine/update','Dashboard::changeMedicineAvailability');
$routes->get('/inbox/(:num)','Inbox::getConversation/$1');
$routes->post("/inbox/send/message",'Inbox::sendMessage');
$routes->get('/inbox/get/messages/(:num)', 'Inbox::getMessages/$1');
$routes->post("/inbox/send/message/img","Inbox::uploadImage");
$routes->post("/addmedicine/filter","AddMedicine::filter_medicine");
$routes->post("/register/submit","Register::submitForm");
/*
 *-------------------------------------------------
 * Admin route
 *-------------------------------------------------
 */

$routes->get("/login", 'AdminController::index');
$routes->get("/admin/dashboard", "AdminController::dashboard");

$routes->get("/privacy","Home::privacy");

$routes->get("/admin/log", "AdminController::activityLog");

$routes->get("/admin/medicine", "AdminController::medicine");
$routes->add("/admin/medicine/(:num)", "AdminController::viewMedicine/$1");
$routes->post("/admin/medicine/update", "AdminController::updateMedicine");
$routes->post("/admin/medicine/add", "AdminController::addMedicine");

$routes->add("/admin/medicine/form","AdminController::medicineForm");
$routes->post("/admin/medicine/form/add", "AdminController::addMedicineForm");

$routes->add("/admin/medicine/drug_classification","AdminController::drugClassification");
$routes->post("/admin/medicine/drug_classification/add","AdminController::addDrugClassification");

$routes->get("/admin/pharmacy", "AdminController::pharmacy");
$routes->add("/admin/pharmacy/(:num)", "AdminController::viewPharmacy/$1");
$routes->add("/admin/pharmacy/to_verify", "AdminController::toVerifyPharmacy");
$routes->post("/verify/pharmacy","AdminController::verifyPharmacy");

$routes->get("/admin/announcement", "AdminController::announcement");
$routes->get("/admin/announcement/archives", "AdminController::announcementArchive");
$routes->post("/admin/announcement/new", "AdminController::newAnnouncement");

$routes->get("/announcement/(:num)", "Announcement::index/$1");

$routes->post("/verify/credentials","AdminController::verifyCredentials");
/*
 *-------------------------------------------------
 * Api
 *-------------------------------------------------
 */
 // Get Section
$routes->get('/api/get/medicine/all', 'ApiMedicine::GetAll');

$routes->get('/api/get/pharmacy/all','ApiPharmacy::GetAll');

$routes->get('/api/get/medicine/filter','ApiMedicine::FilterMedicine');

$routes->get('/api/get/GeneralClassifications','ApiMedicine::GetGeneralClassification');

$routes->get('/api/get/MedicineForms','ApiMedicine::GetMedicineForm');

// Post
$routes->post('/api/add/tred/medicine','ApiMedicine::AddTrendMedicine');

$routes->post('/api/get/medicine/average_price','ApiMedicine::GetAveragePrice');

$routes->post('/api/get/medicine/offer/pharmacies', 'ApiMedicine::GetPharmacies');

$routes->post('/api/get/user','ApiPatient::GetUserCredentials');

$routes->post('/api/new/user','ApiPatient::CreateNewPatient');

$routes->post('/api/get/chat','ApiPatient::GetConversation');

$routes->post('/api/send/message','ApiMessage::NewMessage');

$routes->post('/api/send/image','ApiMessage::uploadImage');

$routes->post('/api/get/pharmacy/inventory','ApiPharmacy::GetInventory');

$routes->get('/api/get/announcement','Announcement::get');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
