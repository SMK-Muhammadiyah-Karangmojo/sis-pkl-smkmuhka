<?php

namespace App\Controllers;

use App\Models\GuruModel;
use App\Models\IdukaModel;
use App\Models\JurusanModel;
use App\Models\KategoriSuratModel;
use App\Models\MajorModel;
use App\Models\MasterCategoryNilaiModel;
use App\Models\MasterDataModel;
use App\Models\MasterNilaiModel;
use App\Models\MentorDetailModel;
use App\Models\NomorSuratModel;
use App\Models\SchoolModel;
use App\Models\student\PresenceModel;
use App\Models\Template\MasterTemplateModel;
use App\Models\TpModel;
use App\Models\UserDetailModel;
use App\Models\UsersModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\YantoDevConfig;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 * @property MajorModel $major
 * @property TpModel $tp
 * @property UsersModel $usersModel
 * @property IdukaModel $idukaModel
 * @property GuruModel $guruModel
 * @property SchoolModel $schoolModel
 * @property YantoDevConfig $config
 * @property UsersModel $users
 * @property UserDetailModel $userDetail
 * @property MasterDataModel $masterData
 * @property MentorDetailModel $mentorDetailModel
 * @property MasterCategoryNilaiModel $masterCategoryNilai
 * @property MasterNilaiModel $masterNilai
 * @property KategoriSuratModel $kategoriSurat
 * @property NomorSuratModel $nomorSuratModel
 * @property MasterTemplateModel $masterTemplateModel
 * @property PresenceModel $presenceModel
 */
class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['pkl_helper'];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
        $this->config = new YantoDevConfig();
        $this->users = new UsersModel();
        $this->idukaModel = new IdukaModel();
        $this->guruModel = new GuruModel();
        $this->schoolModel = new SchoolModel();
        $this->major = new MajorModel();
        $this->tp = new TpModel();
        $this->userDetail = new UserDetailModel();
        $this->masterData = new MasterDataModel();
        $this->mentorDetailModel = new MentorDetailModel();
        $this->masterCategoryNilai = new MasterCategoryNilaiModel();
        $this->masterNilai = new MasterNilaiModel();
        $this->kategoriSurat =  new KategoriSuratModel();
        $this->nomorSuratModel =  new NomorSuratModel();
        $this->masterTemplateModel = new MasterTemplateModel();
        $this->presenceModel = new PresenceModel();
    }
}