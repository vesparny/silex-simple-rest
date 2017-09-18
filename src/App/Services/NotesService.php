<?php

namespace App\Services;

class NotesService extends BaseService
{
    public function getOne($id)
    {
        return $this->db->fetchAssoc("SELECT * FROM notes WHERE id=?", [(int) $id]);
    }

    public function getAll()
    {
        return $this->db->fetchAll("SELECT * FROM notes");
    }

    public function save($note)
    {
        $this->db->insert("notes", $note);
        return $this->db->lastInsertId();
    }

    public function update($id, $note)
    {
        return $this->db->update('notes', $note, ['id' => $id]);
    }

    public function delete($id)
    {
        return $this->db->delete("notes", array("id" => $id));
    }
}
