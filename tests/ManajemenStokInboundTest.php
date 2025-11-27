<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../app/modules/manajemen_stok_inbound/controllers/Manajemen_stok_inbound.php';
require_once __DIR__ . '/../app/modules/manajemen_stok_inbound/models/Model.php';

class ManajemenStokInboundTest extends TestCase
{
    private $controller;

    protected function setUp(): void
    {
        // Prepare controller with stubbed CI dependencies
        $this->controller = new Manajemen_stok_inbound();

        // Inject common CI properties used by the controller
        $this->controller->load = new LoaderStub();
        $this->controller->input = new InputStub();
        $this->controller->session = new SessionStub();
        $this->controller->alus_auth = new AlusAuthStub();
        $this->controller->security = new SecurityStub();

        // Inject model mock
        $this->controller->Alus_items = $this->createMock(Model::class);
        // Also provide Stok_model property used by proses_ekspor
        $this->controller->Stok_model = $this->createMock(Model::class);
    }

    // Behaviors:
    // 1) index should redirect to login when not logged in
    public function testIndexRedirectsWhenNotLoggedIn()
    {
        $this->controller->alus_auth->set_logged_in(false);
        $result = $this->controller->index();
        $this->assertEquals(['redirect', 'admin/login', 'refresh'], $result);
    }

    // 2) index should load list when logged in and set data
    public function testIndexLoadsWhenLoggedIn()
    {
        $this->controller->alus_auth->set_logged_in(true);
        $this->controller->Alus_items->expects($this->once())
            ->method('get_all_stok')
            ->willReturn([ (object)['lot_number' => 'LOT1'] ]);
        // Capture that view() is called without throwing
        $this->controller->load = new class extends LoaderStub {
            public $views = [];
            public function view($view, $data = []) { $this->views[] = [$view, $data]; return true; }
        };
        $this->controller->index();
        $this->assertNotEmpty($this->controller->load->views);
        $this->assertSame('index', $this->controller->load->views[1][0]);
        $this->assertArrayHasKey('stok', $this->controller->load->views[1][1]);
    }

    // 3) add should validate quantity > 0 and numeric; with invalid input, show form
    public function testAddShowsFormOnValidationFail()
    {
        // Provide minimal form_validation stub
        $this->controller->form_validation = new class {
            public function set_rules() {}
            public function run() { return false; }
        };
        // Capture views
        $this->controller->load = new class extends LoaderStub {
            public $views = [];
            public function view($view, $data = []) { $this->views[] = [$view, $data]; return true; }
        };
        $this->controller->add();
        $this->assertSame('stok/add', $this->controller->load->views[1][0]);
    }

    // 4) add should save on valid data and redirect index with flash success
    public function testAddSavesOnValidData()
    {
        $this->controller->form_validation = new class {
            public function set_rules() {}
            public function run() { return true; }
        };
        $this->controller->input->setPost([
            'lot_number' => 'lot-123',
            'komoditas' => 'TUNA',
            'sumber_asal' => 'PELAGIC',
            'stok_tersedia_kg' => '10.5',
            'tanggal_kadaluarsa' => '2030-01-01',
            'status_kualitas' => 'A'
        ]);
        $this->controller->Alus_items->expects($this->once())
            ->method('add_stok')
            ->with($this->callback(function($payload){
                return $payload['lot_number'] === 'LOT-123' // uppercase
                    && $payload['stok_dialokasikan_kg'] === 0.00;
            }))
            ->willReturn(true);
        $result = $this->controller->add();
        $this->assertArrayHasKey('success', $this->controller->session->flashdata);
        $this->assertEquals(['redirect','index',''], $result);
    }

    // 5) proses_ekspor should fail if qty <= 0 and set flash error
    public function testProsesEksporRejectsNonPositiveQty()
    {
        $ok = $this->controller->proses_ekspor('LOT1', 0);
        $this->assertFalse($ok);
        $this->assertArrayHasKey('error', $this->controller->session->flashdata);
    }

    // 6) proses_ekspor should return true when model updates ok
    public function testProsesEksporCallsModelAndReturnsTrue()
    {
        $this->controller->Stok_model->expects($this->once())
            ->method('update_stok_outbound')
            ->with('LOT1', 5.0)
            ->willReturn(true);
        $ok = $this->controller->proses_ekspor('LOT1', 5);
        $this->assertTrue($ok);
    }

    // 7) proses_ekspor should set flash error when model fails
    public function testProsesEksporSetsErrorWhenModelFails()
    {
        $this->controller->Stok_model->expects($this->once())
            ->method('update_stok_outbound')
            ->with('LOT1', 5.0)
            ->willReturn(false);
        $ok = $this->controller->proses_ekspor('LOT1', 5);
        $this->assertFalse($ok);
        $this->assertArrayHasKey('error', $this->controller->session->flashdata);
    }
}
