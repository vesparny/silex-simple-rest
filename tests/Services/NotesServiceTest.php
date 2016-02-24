<?php

namespace Tests\Services;
use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use App\Services\NotesService;


class NotesServiceTest extends \PHPUnit_Framework_TestCase
{

    private $noteService;

    public function setUp()
    {
        $rest = new \App\Rest('dev');
        $app  = $rest->api;
        $this->noteService = new NotesService($app["db"]);

        $stmt = $app["db"]->prepare("CREATE TABLE notes (id INTEGER PRIMARY KEY AUTOINCREMENT,note VARCHAR NOT NULL)");
        $stmt->execute();
    }

    public function testGetAll()
    {
        $data = $this->noteService->getAll();
        $this->assertNotNull($data);
    }

    function testSave()
    {
        $note = array("note" => "arny");
        $data = $this->noteService->save($note);
        $data = $this->noteService->getAll();
        $this->assertEquals(1, count($data));
    }

    function testUpdate()
    {
        $note = array("note" => "arny1");
        $this->noteService->save($note);
        $note = array("note" => "arny2");
        $this->noteService->update(1, $note);
        $data = $this->noteService->getAll();
        $this->assertEquals("arny2", $data[0]["note"]);

    }

    function testDelete()
    {
        $note = array("note" => "arny1");
        $this->noteService->save($note);
        $this->noteService->delete(1);
        $data = $this->noteService->getAll();
        $this->assertEquals(0, count($data));
    }

}
