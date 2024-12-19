<?php

namespace App\Controllers;

use App\Libraries\Bot\BotDiscord;
use App\Libraries\IApplicationConstant;
use App\Libraries\MinioService;
use App\Libraries\ResponseBuilder;
use App\Libraries\Validation\FormValidation;
use App\Models\ClassModel;
use App\Models\DataLaporanSiswaModal;
use App\Models\DetailIdukaModel;
use App\Models\GuruModel;
use App\Models\IdukaModel;
use App\Models\KategoriSuratModel;
use App\Models\MajorModel;
use App\Models\MasterCategoryNilaiModel;
use App\Models\MasterDataModel;
use App\Models\MasterLaporanModal;
use App\Models\MasterNilaiModel;
use App\Models\MentorDetailModel;
use App\Models\NomorSuratModel;
use App\Models\SchoolModel;
use App\Models\student\PresenceModel;
use App\Models\Template\MasterTemplateModel;
use App\Models\TpModel;
use App\Models\TutorModel;
use App\Models\UserDetailModel;
use App\Models\UsersModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Session\Session;
use Config\Services;
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
 */
abstract class BaseController extends Controller
{
    public UsersModel $users;
    public IdukaModel $idukaModel;
    public GuruModel $guruModel;
    public SchoolModel $schoolModel;
    public MajorModel $major;
    public TpModel $tp;
    public UserDetailModel $userDetail;
    public MasterDataModel $masterData;
    public MentorDetailModel $mentorDetailModel;
    public MasterCategoryNilaiModel $masterCategoryNilai;
    public MasterNilaiModel $masterNilai;
    public KategoriSuratModel $kategoriSurat;
    public NomorSuratModel $nomorSuratModel;
    public MasterTemplateModel $masterTemplateModel;
    public PresenceModel $presenceModel;
    public Session $session;
    public ResponseBuilder $responseBuilder;
    public ClassModel $class;
    public BotDiscord $botDiscord;
    public MasterLaporanModal $masterLaporan;
    public DataLaporanSiswaModal $laporanSiswa;
    public FormValidation $formValidation;
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
     * @var list<string>
     */
    protected $helpers = ["pkl_helper"];
    public TutorModel $tutorModel;
    public IApplicationConstant $applicationConstant;
    public MinioService $minioService;
    public DetailIdukaModel $detailIdukaModel;

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param LoggerInterface $logger
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger): void
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        /**
         * this import all model
         */
        $this->applicationConstant = new IApplicationConstant();
        $this->minioService = new MinioService();
        $this->session = Services::session();
        $this->responseBuilder = new ResponseBuilder();
        $this->botDiscord = new BotDiscord();
        $this->users = new UsersModel();
        $this->idukaModel = new IdukaModel();
        $this->detailIdukaModel = new DetailIdukaModel();
        $this->guruModel = new GuruModel();
        $this->schoolModel = new SchoolModel();
        $this->major = new MajorModel();
        $this->tp = new TpModel();
        $this->userDetail = new UserDetailModel();
        $this->masterData = new MasterDataModel();
        $this->mentorDetailModel = new MentorDetailModel();
        $this->masterCategoryNilai = new MasterCategoryNilaiModel();
        $this->masterNilai = new MasterNilaiModel();
        $this->kategoriSurat = new KategoriSuratModel();
        $this->nomorSuratModel = new NomorSuratModel();
        $this->masterTemplateModel = new MasterTemplateModel();
        $this->presenceModel = new PresenceModel();
        $this->class = new ClassModel();
        $this->masterLaporan = new MasterLaporanModal();
        $this->laporanSiswa = new DataLaporanSiswaModal();
        $this->formValidation = new FormValidation();
        $this->tutorModel = new TutorModel();
//        $this->IApplicationConstant = new IApplicationConstantConfig();
    }
}
